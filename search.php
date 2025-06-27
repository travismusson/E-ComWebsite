<?php
include ("dbconnection.php");
session_start();    //enusre user is logged in
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';
//get filtered categories from db

//refactoring this
//set default value
$categoryResult = null;      //initialize variable to hold results
$headerTitle = "Search Results";     //default header title
//searchbar functionality
if(isset($_GET['searchBar']) && !empty($_GET['searchBar'])){     //checking if search bar is set and not empty
    $search = $_GET['searchBar'];     //getting the search term from the search bar
    $query = "SELECT * FROM products WHERE Name LIKE ?";        //sql search query we are looking for names in this case
    $search = "%$search%";  //adding wildcards for search   https://www.w3schools.com/sql/sql_wildcards.asp
    $stmt = mysqli_prepare($db_Conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $search);
    mysqli_stmt_execute($stmt);
    $categoryResult = mysqli_stmt_get_result($stmt);        //reusing the same variable to hold the results)
}
//check if category is set in the url
elseif(isset($_GET['category']) && !empty($_GET['category'])){
    $category = $_GET['category'];     //getting the category from the url
    $query = "SELECT * FROM products WHERE Category = ?";
    $stmt = mysqli_prepare($db_Conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $category);
    mysqli_stmt_execute($stmt);
    $categoryResult = mysqli_stmt_get_result($stmt);
    $headerTitle = "Products in $category";     //set header title for category
}
//check if view is set in the url
elseif(isset($_GET['view']) && $_GET['view'] === 'latest'){
    $query = "SELECT * FROM products ORDER BY ProductID DESC";
    $stmt = mysqli_prepare($db_Conn, $query);
    mysqli_stmt_execute($stmt);
    $categoryResult = mysqli_stmt_get_result($stmt);        //get results from prepared statement
    $headerTitle = "Latest Deals";     //set header title for latest deals
} else {
    echo "No search term provided.";    //unseen just for logs
    header("Location: index.php");     //if no search term is provided, redirect to home page
    exit;
}
//fetching existing profile photo
if(isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
    $SQL = "SELECT Profile_IMG_DIR FROM users WHERE id = ?";
    $stmt = mysqli_prepare($db_Conn, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $profileResult = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($profileResult)){
        if(mysqli_num_rows($profileResult) > 0){
            $profileImg = $row['Profile_IMG_DIR'];
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">       <!-- for social media icons -->
    <script defer src="https://cloud.umami.is/script.js" data-website-id="9415a47e-d40f-4dd5-a813-f4c68ef3d995"></script>     <!-- for website tracking info -->
    <title>TravsList | Search Products</title>
</head>
<body>
    <div class="headerStrip">
        <header>
            <div class="headerTop">
                <a href="index.php">
                    <img src="images/logo.png" alt="TravsList Logo" class="siteLogo">
                </a>
                <a href="index.php">
                    <h1>TravsList a C2C E-Commerce Website!</h1>
                </a>
                <button class="hamburgerBtn"><span class="material-symbols-outlined">Menu</span></button>
            </div>
            <div class="homeStrip">
                <a href="index.php">Home</a>
            <div class="searchWrapper">
                <!--this is the search bar that will allow users to search for products-->
                <form action="search.php" method="get">     <!--this will allow the user to search for products by category or name-->
                    <input class="searchBar" type="text" name="searchBar" placeholder="Search...">
                    <button type="submit" value="search"><img src="images/icons8-search-16.png"></button>
                </form>
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
            <a href="usercart.php">Cart</a>
            </div>
        </header>
    </div>

<div class="searchContainer">
        </div class="searchHeader">
                <h2><?php echo $headerTitle ?></h2>
        </div>
<!-- need to display search results   Its Working just need some styling-->
        <div class = "searchResults">
            <?php if(isset($categoryResult) && mysqli_num_rows($categoryResult) > 0){           //if populated and set
                while($row = mysqli_fetch_assoc($categoryResult)){
                    ?>
                    <div class="productItem">   <!-- same process as used in product.php-->
                        <a href = "product.php?id=<?php echo $row['ProductID']; ?>">
                            <img src="./images/<?php echo $row['Product_IMG_DIR']; ?>" alt="<?php echo $row['Name']?>">     <!-- need to add htmlspecialchars but just testing for now -->
                            <div><?php echo $row['Name']; ?></div>          <!--temp-->
                            <div><?php echo $row['Price']; ?></div>
                        </a>
                    </div>
                    <?php
                }
            }else{
                echo "No Products found in this search category!";
            }  
            ?>  
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
            <a href="#" onclick="alert('An Email will be Sent to you for Password Reset')">Forgot Your Password?</a><br>
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
                <a href="#" onclick="alert('An Email will be Sent to you for Password Reset')">Forgot Your Password?</a><br>
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
<script src="validate.js"></script>
</body>
</html>
