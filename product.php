<?php
include("dbconnection.php");        //included to ensure db connection is valid
session_start();      //this is needed to start the session
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';
//fetching existing profile photo
if(isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
    $SQL = "SELECT Profile_IMG_DIR FROM users WHERE id = ?";
    $stmt = mysqli_prepare($db_Conn, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        if(mysqli_num_rows($result) > 0){
            $profileImg = $row['Profile_IMG_DIR'];
        }
    }

}
//get product id from the URL
$productID = 0;     //initialize to 0
if(isset($_GET['id'])){
    //going to cast it as an int to ensure its a number
    $productID = (int)$_GET['id'];
}else if($productID < 1){
    //die("ID not found");
    $_SESSION['error'] = "Product ID not found";  //using session to store error message
    header("Location: index.php");  
    exit;  
}

//prepare the SQL statement to fetch product details
$sql = "SELECT * FROM products WHERE ProductID = ?";
$stmt = mysqli_prepare($db_Conn, $sql);
if(!$stmt){
    //die(mysqli_error($db_Conn));
    $_SESSION['error'] = "Error in SQL Prepare Statement: " . mysqli_error($db_Conn);       //this would maybe confuse user, so using now for debug
    header("Location: index.php");
    exit;
}

//bind the product ID parameter to the SQL statement
mysqli_stmt_bind_param($stmt, "i", $productID);

//execute the SQL statement
mysqli_stmt_execute($stmt);

//fetch the result
$result = mysqli_stmt_get_result($stmt);
if(!$result){
    $_SESSION['error'] = "Error in SQL Result Statement: " . mysqli_error($db_Conn);
    header("Location: index.php");
    exit;
}

//check if a product was found
if(mysqli_num_rows($result) === 0){
    //die("Product not found");
    $_SESSION['error'] = "Product not found";
    header("Location: index.php");
    exit;
}
//fetch the product details
$product = mysqli_fetch_assoc($result);
$productReviewAverage = '';
//need to fetch reviews for seller
//should probs get sellers info also
$query = "SELECT SUM(Rating) AS SumRating, COUNT(Rating) AS TotalRatings FROM reviews WHERE ProductID = ?";
$stmt = mysqli_prepare($db_Conn, $query);
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);
$reviewResult = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($reviewResult);
$totalReviews = $row['TotalRatings'];
$sumReviews = $row['SumRating'];
if($totalReviews > 0){
    $productReviewAverage =$sumReviews/$totalReviews;
}

//fetch seller info
$sellerName = '';
$sellerID = $product['SellerID'];
$querySeller = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($db_Conn, $querySeller);
mysqli_stmt_bind_param($stmt, "i", $sellerID);
mysqli_stmt_execute($stmt);
$sellerResult = mysqli_stmt_get_result($stmt);
if($sellerResult){
    while($row = mysqli_fetch_assoc($sellerResult)){
        $sellerName = $row['FirstName']. ' '. $row['LastName'];
        $sellerProfilePhoto = $row['Profile_IMG_DIR'];
    }
}
//fetching reviews, after some research looks like i need to store into an array and just foreach all reviews out?      --finally working goodness
$allReviews = [];       //array for reviews
$query = "SELECT * FROM reviews WHERE ProductID = ?";       //query for review where id matches the product id
$stmt = mysqli_prepare($db_Conn, $query);
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);
$reviewsResult = mysqli_stmt_get_result($stmt);
while($review = mysqli_fetch_assoc($reviewsResult)){    //while loop for going thorugh results
    $buyerID = $review['BuyerID'];      //assigns the buyer id to the current review in loop
    $buyerQuery = "SELECT FirstName, LastName FROM users WHERE id = ?";     //another query to lookup the buyers name and last name
    $buyerStmt = mysqli_prepare($db_Conn, $buyerQuery);
    mysqli_stmt_bind_param($buyerStmt, "i", $buyerID);
    mysqli_stmt_execute($buyerStmt);
    $buyerResult = mysqli_stmt_get_result($buyerStmt);
    if($buyerResult && $row = mysqli_fetch_assoc($buyerResult)){
        $buyerName = $row['FirstName']. ' '. $row['LastName'];      //stores buyers name in var
    }else{
        $buyerName = "Unknown";
    }
    $review['BuyerName'] = $buyerName;      //asigns buyername to the review var
    $allReviews[] = $review;    //stores review into array
}
//need to find a way to also show reviewer maybe just do a sql query in user db where id matches buyer id?
/* refactor gonna put it in the review section maybe?
$buyerID = $review['BuyerID'];      //issue only using last review as the reviewer. its late i needa sleep on this
$buyerQuery ="SELECT FirstName, LastName FROM users WHERE id = ?";
$stmt = mysqli_prepare($db_Conn, $buyerQuery);
mysqli_stmt_bind_param($stmt, 'i', $buyerID);
mysqli_stmt_execute($stmt);
$buyerResult = mysqli_stmt_get_result($stmt);
if($buyerResult){
    while($row = mysqli_fetch_assoc($buyerResult)){
        $buyerName = $row['FirstName']. ' '. $row['LastName'];
    }
}
*/
//needa add review submit:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputReview'], $_POST['inputRating'], $_POST['productID'])) {        //checks all the necessary info, also checks if its a post request to ensure its comming from our form, also ensures all the relant info is in the post req
    if (isset($_SESSION['id'])) {       //double checking if user is logged in
        $buyerID = $_SESSION['id'];     //assigns a new var for the buyerID
        $productID = $_POST['productID'];      
        $comment = $_POST['inputReview'];
        $rating = $_POST['inputRating'];

        if ($productID && $comment && $rating >= 1 && $rating <= 5) {       //checks to see if product id is valid, comment is valid, and rating is between 1 and 5
            $query = "INSERT INTO reviews (BuyerID, ProductID, Rating, Comment, ReviewDate) VALUES (?, ?, ?, ?, NOW())";        //insert query uses date NOW() function to utilize present time
            $stmt = mysqli_prepare($db_Conn, $query);
            mysqli_stmt_bind_param($stmt, "iiis", $buyerID, $productID, $rating, $comment);
            mysqli_stmt_execute($stmt);
            header("Location: product.php?id=" . $productID);    //Redirect to avoid form resubmission on refresh
            exit;
        }
    } else {
        // Not logged in
        $_SESSION['error'] = "You must be logged in to leave a review.";
        header("Location: index.php");
        exit;
    }
}

//needa do the  deltion of reviews:
//for debug
if(isset($_SESSION["User_Level"]) && $_SESSION["User_Level"] === 1){        //https://www.youtube.com/watch?v=xTHJ4gGycb0 as ref he used more indepth function page and define user level but ima just do this for now.
    echo "Admin!";       //debug
} else{
   // echo "Normal user!";        //debug  !WORKING now i need to add functionality
};




//now its html time
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Name']); ?></title>     <!-- allows user to keep track of product name in the title bar, think this is a really neat idea i noticed from takealot, uses control structures in php to echo current viewing product -->
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">       <!-- for social media icons -->
</head>
<body>
    <div class="headerStrip">       <!-- standardized header strip for all pages -->
        <header>
            <div class="headerTop">
                <h1>Travis Musson's C2C E-Commerce Website!</h1>
                <button class="hamburgerBtn"><span class="material-symbols-outlined">Menu</span></button>
            </div>
            <div class="homeStrip">
                <a href="index.php">Home</a>
            <div class="searchWrapper">
                <input class="searchBar" type="text" placeholder="Search...">
                <button type="submit"><img src="images/icons8-search-16.png"></button>
            </div>
<!--Adding php here for username in the Account list https://www.php.net/manual/en/control-structures.alternative-syntax.php  for control structures within php and html-->
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <span>Hi <?php echo $_SESSION["FirstName"]; ?></span>   <!--this will show the user name-->
                <img src="<?php echo "./images/$profileImg";?>" alt="Profile Photo" class="profilePhoto">
                <a href="logout.php" class="btnLogout">Logout</a>       <!--this is the logout button that will log the user out and redirect them to the home page-->
                <!--<script>
                    document.getElementById("btnShowLogin").style.display = "none";      //this will hide the login button when the user is logged in
                </script>-->
            <?php else: ?>
                <span>Hi Guest</span>   <!--guest username when not logged in-->
                <a href="#" class="btnShowLogin">Login</a>       <!--only shown when user is not logged in-->
            <?php endif; ?>      <!--ends the if statement for php-->
            <a href="accountdashboard.php">Account</a>
            <a href="#">Cart</a>
            </div>
        </header>
    </div>
    <div class=sellerInfoHeader>
        <h2><?php echo $sellerName?> Product</h2>
        <img src="<?php echo "./images/$sellerProfilePhoto";?>" alt="Seller Profile Photo" class="sellerProfilePhoto">
    </div>
    <div class="productDetails">
        <h2>Product Details</h2>
            <h1><?php echo htmlspecialchars($product['Name']); ?></h1>
            <!--<img src="" alt="Temp Image"></img>      Placeholder for product image as i havnt added images to the db yet or figured out how to do it yet gonna do some research now --come to the conclusion im going to have to implement another php file for uploading products to the product table and then pull the img dir from the products table ref https://www.youtube.com/watch?v=1NiJcZrPHvA&ab_channel=CleverTechie   -->
            <div id="displayImage">
                <?php
                    //$query = "SELECT * FROM products";      //currently displaying all products, need to change this to only display the product with the current productID
                    $query = "SELECT Product_IMG_DIR FROM products WHERE ProductID = ?";    //working and using a prepared statement just incase
                    $stmt = mysqli_prepare($db_Conn, $query);   
                    if(!$stmt){
                        //die("SQL statement failed: " . mysqli_error($db_Conn));
                        $_SESSION['error'] = "Error in SQL Prepare Statement: " . mysqli_error($db_Conn);
                        header("Location: index.php");
                        exit;
                    }
                    mysqli_stmt_bind_param($stmt, "i", $productID);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$result){
                        $_SESSION['error'] = "Error in SQL Result Statement: " . mysqli_error($db_Conn);
                        header("Location: index.php");
                        exit;
                    }else{
                        while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <img src = "./images/<?php echo $row['Product_IMG_DIR']; ?>">
                        <?php
                    }//end while loop
                    }   
                    
        ?>
        </div>
            <div class="productItem"><h4>Description:</h4> <?php echo nl2br(htmlspecialchars($product['Description'])); ?></div>     <!--using nl2br to convert new lines to <br> tags https://www.php.net/manual/en/function.nl2br.php-->
            <div class="productItem"><h4>Price:</h4> R <?php echo htmlspecialchars($product['Price']); ?></div>
            <div class="productItem"><h4>Category:</h4> <?php echo htmlspecialchars($product['Category']); ?></div>
            <div class="productItem"><h4>Stock:</h4> <?php echo htmlspecialchars($product['StockQuantity']); ?></div>
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                <button type="submit" value="cart">Add to Cart</button>
            </form>
            <a href="index.php">Back to Products</a>
                <?php if(isset($_SESSION["User_Level"]) && $_SESSION["User_Level"] === 1): ?>       <!--WORKING-->
                    <form action="deleteproduct.php" method ="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">        <!-- cool prebuilt alert functionality https://www.w3schools.com/jsref/met_win_confirm.asp-->
                        <input type="hidden" name="productID" value="<?php echo $product['ProductID']; ?>">
                            <button type="submit" class="btnDelete">Delete Product</button>
                    </form>
                <?php endif; ?>  
    </div>
    <div class="reviewSection">
        <h2>Reviews</h2>
            <!--need to fetch reviews from db for product-->
           <!--Refactored--> 
           <?php if($productReviewAverage){
                echo "A Total of $totalReviews reviews have been made, with an Average of $productReviewAverage";
           }else{
                echo "No Reviews have been made for this product.<br>Be the first write a review!";
           }?>
           <div class="writeReview">
                <form action="" method="post">
                    <label for="inputReview">Write A Review:</label><br>
                    <input name="inputReview" id="inputReview" placeholder="Leave a review..."><br>
                    <label for="inputRating">Rating:</label><br>
                    <select name="inputRating" id="selectRating">
                        <option value ="" disabled="disabled">Select a Rating out of 5</option>
                        <option value ="1">1</option>
                        <option value ="2">2</option>
                        <option value ="3">3</option>
                        <option value ="4">4</option>
                        <option value ="5">5</option>
                    </select>
                    <div class="btnSubmitReview">
                        <input type="hidden" name="productID" value="<?php echo $productID; ?>">        <!--not best practice i assume? but was getting an error and managed to find this: https://www.w3schools.com/tags/att_input_type_hidden.asp  which says devs utilize it and allows me to usse it in the post to check for product id  -->
                        <button type="submit">Submit Review</button>        <!--not submitting-->
                    </div>
                </form>
           </div>
        
        <div class="reviewList">
            <?php if(count($allReviews) > 0): ?>
        <?php foreach($allReviews as $review): ?>
            <div class="reviewItem">
                <b>Reviewer:</b> <?php echo htmlspecialchars($buyerName); ?><br>
                <b>Rating:</b> <?php echo htmlspecialchars($review['Rating']); ?>/5<br>
                <b>Comment:</b> <?php echo nl2br(htmlspecialchars($review['Comment'])); ?><br>
                <b>Date:</b> <?php echo htmlspecialchars($review['ReviewDate']); ?><br>
            </div>
            <?php if(isset($_SESSION["User_Level"]) && $_SESSION["User_Level"] === 1): ?>       <!--WORKING-->
                <form action="deletereview.php" method ="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">        <!-- cool prebuilt alert functionality https://www.w3schools.com/jsref/met_win_confirm.asp-->
                    <input type="hidden" name="reviewID" value="<?php echo $review['ReviewID']; ?>">
                    <button type="submit" class="btnDelete">Delete Review</button>
                </form>
            <?php endif; ?> 
        <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet for this product.</p>
        <?php endif; ?>
        </div>
        </div>   
    </div>



<div class="blurOverlay"></div>
<div class="loginContainer">
    <span class="material-symbols-outlined" for="login">close</span>
    <div class="text">
        Login Form
    </div>
    <form action="login.php" method="post" onsubmit="return ValidateLogin()">
        <div class="data">
            <label for="loginEmail">Email Address</label>
            <input type="email" placeholder="test@email.com" id="loginEmail" name="loginEmail" required>        <!--Regarding the name, im not sure if its better to use standardized just email instead of each email being acquanted to the various forms ie login and register, so im going with this approach for easier debugging-->
            <span id="emailErrorField" class="error"></span>
        </div>
        <div class="data">
            <label for="loginPassword">Password</label>
            <input type="password" placeholder="Enter Password Here..." id="loginPassword" name="loginPassword" required>
            <span id="passwordErrorField" class="error"></span>
        </div>
        <div class="forgotPass">
            <a href="#">Forgot Your Password?</a><br>
        </div>
        <div class="registerAccount">
            <label>Not Registered? <a href="#" class="showRegister">Create an Account</a></label>
        </div>
        <div class="btnLogin">
            <button type="submit" value="login">Login</button>  <!--needs value to parse data, not sure if it is necesarry to have a standardized name (ie "Go") or if this is ok-->
        </div>
    </form>
</div>
<div class="registerContainer">
    <span class="material-symbols-outlined" for="register">close</span>
    <div class="text">Register an Account</div>
        <form action="register.php" method="post" onsubmit="return ValidateRegister()">
            <div class="data">
                <label for="registerFirstName">First Name</label>
                <input type="text" placeholder="Bob" id="registerFirstName" name="registerFirstName" required>
                <span id="firstNameError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerLastName">Last Name</label>
                <input type="text" placeholder="Bobson" id="registerLastName" name="registerLastName" required>
                <span id="lastNameError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerEmail">Email Address</label>
                <input type="email" placeholder="test@email.com" id="registerEmail" name="registerEmail" required>
                <span id="emailError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerPassword">Password</label>
                <input type="password" placeholder="Enter Password Here..." id="registerPassword" name="registerPassword" required>
                <span id="passwordError" class="error"></span>
            </div>
            <div class="forgotPass">
                <a href="#">Forgot Your Password?</a><br>
            </div>
            <div class="loginAccount">
                <label>Already Registered? <a href="#" class="showLogin">Login Here</a></label>
            </div>
            <div class="btnRegister">
                <button type="submit" value="register">Register</button>        <!--needs value to parse data-->
            </div>
        </form>
</div>






    <div class="footerContainer">
    <footer>
        <p>2025 Travis Musson. All rights reserved.</p>
        <p><a href="mailto:travismusson@gmail.com">travismusson@gmail.com</a></p>
        <picture>
            <a href = "https://www.instagram.com/travismusson/"><i class="fa fa-brands fa-instagram fa-lg"></i></a>
            <a href = "https://www.facebook.com/travis.musson.7"><i class="fa fa-brands fa-facebook fa-lg"></i></a>
            <a href = "https://www.linkedin.com/in/travis-musson-a5a30a298"><i class="fa fa-brands fa-linkedin fa-lg"></i></a>
            <a href = "https://github.com/travismusson"><i class = "fa fa-brands fa-github fa-lg"></i><a>
        </picture>
    </footer>
</div>
<script src="scripts.js"></script>     <!--link to the javascript file for the hamburger menu--> 
</body>
</html>
