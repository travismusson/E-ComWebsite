<?php
include("dbconnection.php");        //included to ensure db connection is valid
session_start();      //this is needed to start the session
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // User is logged in, proceed with adding product
} else {
    // User is not logged in, redirect to login page or show an error
    $_SESSION["addProductError"] = "You must be logged in to add a product.";     //this is being overwritten if i try to access this page without being logged in by the error message in the login.php file so i might need to utilize unique error messages in session variable
    header("Location: index.php");
    exit;
}
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

//https://www.geeksforgeeks.org/how-to-upload-image-into-database-and-display-it-using-php/
if(isset($_POST['addProduct'])){
    //variables
    $productName = $_POST['productName'];           //getting the product name from the form
    $productDescription = $_POST['productDescription']; //getting the product description from the form
    $productPrice = $_POST['productPrice'];         //getting the product price from the form
    $productCategory = $_POST['productCategory'];   //getting the product category from the form
    $productStockQuantity = $_POST['productStockQuantity']; //getting the product stock quantity from the form
    //$productDateAdded = $_POST['productDateAdded']; //getting the product date added from the form // gonna auto generate this
    $productDateAdded = date('Y-m-d H:i:s'); // auto generate current date and time ref stackoverflow --workin perfectly
    //not sure if this is correct
    $fileName = $_FILES['productImage']['name'];       //getting the file name from the form
    $fileTmpName = $_FILES['productImage']['tmp_name']; //getting the temporary file name
    $defaultImage = "default_product.jpg";      //default product name incase no file is uploaded
    $folder = "images/".$fileName; 
    $sellerID = $_SESSION["id"];    //assigns current logged in user id to the sellerID variable

    $sql = "INSERT INTO products (Name, Description, Price, Category, StockQuantity, DateAdded, Product_IMG_DIR, SellerID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db_Conn, $sql);
    if(!$stmt){
        //die("SQL statement failed: " . mysqli_error($db_Conn));
        $_SESSION['error'] = "Error in SQL Prepare Statement: " . mysqli_error($db_Conn);
        header("Location: index.php");
        exit;
    }

    if(empty($fileName)){
        $fileName = $defaultImage;
    }

    //bind the parameters to the SQL statement
    mysqli_stmt_bind_param($stmt, "ssdsissi", $productName, $productDescription, $productPrice, $productCategory, $productStockQuantity, $productDateAdded, $fileName, $sellerID);      //updated to only include filename to store in db
    
    //execute the SQL statement
    if(mysqli_stmt_execute($stmt)){
        //get new product ID as this wasnt working before
        $productID = mysqli_insert_id($db_Conn); //get the last inserted ID
        //move the uploaded file to the designated folder
        if(move_uploaded_file($fileTmpName, $folder)){      //this isnt working at the moment. okay it now is working
            //echo "File added successfully."; //debug
            header("Location: product.php?id=" . $productID); //redirect to the product page after successful addition
            exit; 
        } else {
            //echo "Error moving uploaded file."; //debug 
            $_SESSION['error'] = "No File Uploaded, a default image was appointed";     //so ima refactor this to add a default image
            header("Location: index.php"); //redirect to index page if file move fails
            exit;
        }
    } else {
        echo "Error adding product: " . mysqli_error($db_Conn); //debug
        $_SESSION['error'] = "Error adding product: " . mysqli_error($db_Conn);
        header("Location: index.php"); //redirect to index page if SQL execution fails
        exit;
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
    <title>TravsList | Add Product</title>
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
    <div class="addProductContainer">
        <div class="text">
            Add Product 
        </div>
            <div class="addProduct">
                <form action = "addproduct.php" method="post" enctype="multipart/form-data"> <!--enctype is used to allow file uploads https://www.w3schools.com/php/php_file_upload.asp-->
                    <div class="data">
                        <label for="productName">Product Name:</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>
                    <div class="data">
                        <label for="productDescription">Product Description:</label>
                        <textarea id="productDescription" name="productDescription" required></textarea>
                    </div>
                    <div class="data">
                        <label for="productPrice">Product Price:</label>
                        <input type="number" id="productPrice" name="productPrice" step="0.01" required>        <!--step is used to allow for more accessibility-->
                    </div>
                    <div class="data">      <!-- gonna replace this with select dropdown -->
                        <label for="productCategory">Product Category:</label>
                        <!--<input type="text" id="productCategory" name="productCategory" required>        maybe going to add dynamically here by server admin in future? linking through DB or something-->
                        <select id="productCategory" name="productCategory" required>
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
                        <input type="number" id="productStockQuantity" name="productStockQuantity" required>
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
                    <div class="btnAddProduct">
                        <button type="submit" name="addProduct">Add Product</button>
                    </div>
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