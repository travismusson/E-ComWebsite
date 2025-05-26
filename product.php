<?php
include("dbconnection.php");        //included to ensure db connection is valid
session_start();      //this is needed to start the session
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';
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
//now its html time
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Name']); ?></title>     <!-- allows user to keep track of product name in the title bar, think this is a really neat idea i noticed from takealot, uses control structures in php to echo current viewing product -->
    <link rel="stylesheet" href="style.css">
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
                <a href="logout.php" class="btnLogout">Logout</a>       <!--this is the logout button that will log the user out and redirect them to the home page-->
                <script>
                    document.getElementById("btnShowLogin").style.display = "none";      //this will hide the login button when the user is logged in
                </script>
            <?php else: ?>
                <span>Hi Guest</span>   <!--guest username when not logged in-->
                <a href="#" class="btnShowLogin">Login</a>       <!--only shown when user is not logged in-->
            <?php endif; ?>      <!--ends the if statement for php-->
            <a href="account.php">Account</a>
            <a href="#">Cart</a>
            </div>
        </header>
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
                        while($data = mysqli_fetch_assoc($result)){
                        ?>
                            <img src = "./images/<?php echo $data['Product_IMG_DIR']; ?>">
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
    </div>
    <div class="footerContainer">
    <footer>
        <p>2025 Travis Musson. All rights reserved.</p>
        <p><a href="mailto:travismusson@gmail.com">travismusson@gmail.com</a></p>
        <picture>
            <a href = "https://www.instagram.com/travismusson/"><i class="fa fa-brands fa-instagram fa-lg"></i>
            </a>
            <a href = "https://www.facebook.com/travis.musson.7"><i class="fa fa-brands fa-facebook fa-lg"></i> 
            </a>
            <a href = "https://www.linkedin.com/in/travis-musson-a5a30a298"><i class="fa fa-brands fa-linkedin fa-lg"></i>
            </a>
        </picture>
    </footer>
</div>
</body>
</html>
