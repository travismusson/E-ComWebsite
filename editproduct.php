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

//needa get product id and fetch details for current product
if(isset($_POST['productID'])){     //check to see if set
    $productID = $_POST['productID'];
    $sqlProductFetch = "SELECT * FROM products WHERE ProductID=?";
    $stmt = mysqli_prepare($db_Conn, $sqlProductFetch);
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        if(mysqli_num_rows($result) > 0){
            $currentProductData = $row;
        }else{
            echo "No Product Found!";       //temp debug
        }
    }
}else{
    echo "Not a valid product!";     //temp for debug
}

//debug     https://stackoverflow.com/questions/3331613/how-to-print-all-session-variables-currently-set
/*
echo "<pre>";
var_dump($_SESSION);
var_dump($currentProductData);
echo "</pre>";
*/
/*if (!isset($_SESSION["User_Level"]) || $_SESSION["User_Level"] !== 1 || !isset($_SESSION['id']) || $_SESSION['id'] !== $currentProductData['SellerID']){     //double checking if not admin and if id is set and equal to seller id of product nah not getting in with this code --fixed potentially
    //header("Location: index.php");        //temp removed for debug
    //exit;
}*/

//refactored above logic
if(!isset($_SESSION['User_Level']) || !$currentProductData || ($_SESSION['User_Level'] !== 1 && $_SESSION['id'] !== $currentProductData['SellerID'])){
    header("Location: index.php");
    $_SESSION['error'] = "Invalid Access";
    exit;
}

//handling post for edit
if(isset($_POST['editProduct'])){
    //checking if everything is valid
    if(isset($_POST['productName']) && $_POST['productName'] !== ' '){
        $productName = $_POST['productName'];           //getting the product name from the form
    }
    if(isset($_POST['productDescription']) && $_POST['productDescription'] !== ' '){
        $productDescription = $_POST['productDescription']; //getting the product description from the form
    }
    if(isset($_POST['productPrice']) && $_POST['productPrice'] !== ' '){
        $productPrice = $_POST['productPrice'];         //getting the product price from the form
    }
    if(isset($_POST['productCategory']) && $_POST['productCategory'] !== ' '){
    $productCategory = $_POST['productCategory'];   //getting the product category from the form
    }
    if(isset($_POST['productCategory']) && $_POST['productCategory'] !== ' '){
    $productStockQuantity = $_POST['productStockQuantity']; //getting the product stock quantity from the form
    }
    
    //check if image is uploaded or new image
    if(isset($_FILES['productImage']) && $_FILES['productImage']['size'] > 0){         //!empty not working reading up for file handling
        $fileName = $_FILES['productImage']['name'];       //getting the file name from the form
        $fileTmpName = $_FILES['productImage']['tmp_name']; //getting the temporary file name
        $folder = "images/".$fileName;
        move_uploaded_file($fileTmpName, $folder);
        //https://www.w3schools.com/sql/sql_update.asp
    }else{
        //use existing image
        $fileName = $currentProductData['Product_IMG_DIR'];
    }
        $sql = "UPDATE products SET Name=?, Description = ?, Price=?, Category=?, StockQuantity=?, Product_IMG_DIR=? WHERE ProductID=?";
        $stmt = mysqli_prepare($db_Conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsisi", $productName, $productDescription,$productPrice, $productCategory, $productStockQuantity, $fileName, $productID);
        mysqli_stmt_execute($stmt);
        header("Location: product.php?id=".$productID);
        exit;
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
    <title>TravsList | Edit Product</title>
</head>
<body>
    <div class="headerStrip">       <!-- standardized header strip for all pages -->
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
            <a href="usercart.php">Cart</a>
            </div>
        </header>
    </div>
    <div class="editProductContainer">
        <div class="text">
            Add Product 
        </div>
            <div class="editProduct">
                <form action = "editproduct.php" method="post" enctype="multipart/form-data"> <!--enctype is used to allow file uploads https://www.w3schools.com/php/php_file_upload.asp-->
                    <input type="hidden" name="productID" value="<?php echo $currentProductData['ProductID'];?>">       <!--ensured to track product id when editing-->
                    <div class="data">
                        <label for="productName">Product Name:</label>
                        <input type="text" id="productName" name="productName" value="<?php echo $currentProductData['Name']; ?>">
                    </div>
                    <div class="data">
                        <label for="productDescription">Product Description:</label>
                        <textarea id="productDescription" name="productDescription"><?php echo $currentProductData['Description']; ?></textarea>
                    </div>
                    <div class="data">
                        <label for="productPrice">Product Price:</label>
                        <input type="number" id="productPrice" name="productPrice" step="0.01" value="<?php echo $currentProductData['Price']; ?>">        <!--step is used to allow for more accessibility-->
                    </div>
                    <div class="data">      <!-- gonna replace this with select dropdown -->
                        <label for="productCategory">Product Category:</label>
                        <!--<input type="text" id="productCategory" name="productCategory" required>        maybe going to add dynamically here by server admin in future? linking through DB or something-->
                        <select id="productCategory" name="productCategory" required>       <!-- not sure how to preselect from the db here will read up on it-->
                            <option value="" disabled selected>Select Category</option>     <!-- default option to prompt user to select a category, disable makes it not selectable by user, however selected attribute after allows it to be selected -->
                            <option value="Appliances">Appliances</option>
                            <option value="Gaming">Gaming</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Home & Garden">Home & Garden</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Kitchen">Kitchen</option>
                            <option value="Books">Books</option>
                            <option value="Kiddies">Kiddies</option>
                            <option value="Vehicle">Vehicle</option>
                        </select>
                    </div>
                    <div class="data">
                        <label for="productStockQuantity">Product Stock Quantity:</label>
                        <input type="number" id="productStockQuantity" name="productStockQuantity" value="<?php echo $currentProductData['StockQuantity'];?>">
                    </div>
                    <!--
                    <div class="data">
                        <label for="productDateAdded">Product Date Added:</label>       might remove this and auto generate it on server side  yeh i decided to auto generate it on server side
                        <input type="datetime-local" id="productDateAdded" name="productDateAdded" required>
                    </div>
                    -->     
                    <div class="data">
                        <label for="productImage">Product Image:</label>
                        <input type="file" id="productImage" name="productImage" accept="image/*">
                    </div>
                    <div class="btnEditProduct">
                        <button type="submit" name="editProduct">Edit Product</button>
                    </div>
                    <a href="product.php?id=<?php echo $productID?>">Back</a>
                </form>
            </div>
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
<script src="scripts.js"></script> <!--linking to the script.js file for the hamburger menu-->
<script src="validate.js"></script>
</body>
</html>