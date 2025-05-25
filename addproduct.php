<?php
include("dbconnection.php");        //included to ensure db connection is valid
session_start();      //this is needed to start the session
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    // User is logged in, proceed with adding product
} else {
    // User is not logged in, redirect to login page or show an error
    $_SESSION["addProductError"] = "You must be logged in to add a product.";     //this is being overwritten if i try to access this page without being logged in by the error message in the login.php file so i might need to utilize unique error messages in session variable
    header("Location: login.php");
    exit;
}
//https://www.geeksforgeeks.org/how-to-upload-image-into-database-and-display-it-using-php/
if(isset($_POST['addProduct'])){
    //variables
    $productName = $_POST['productName'];           //getting the product name from the form
    $productDescription = $_POST['productDescription']; //getting the product description from the form
    $productPrice = $_POST['productPrice'];         //getting the product price from the form
    $productCategory = $_POST['productCategory'];   //getting the product category from the form
    $productStockQuantity = $_POST['productStockQuantity']; //getting the product stock quantity from the form
    $productDateAdded = $_POST['productDateAdded']; //getting the product date added from the form
    
    //not sure if this is correct
    $fileName = $_FILES['productImage']['name'];       //getting the file name from the form
    $fileTmpName = $_FILES['productImage']['tmp_name']; //getting the temporary file name
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

    //bind the parameters to the SQL statement
    mysqli_stmt_bind_param($stmt, "ssdsissi", $productName, $productDescription, $productPrice, $productCategory, $productStockQuantity, $productDateAdded, $fileName, $sellerID);      //updated to only include filename to store in db
    
    //execute the SQL statement
    if(mysqli_stmt_execute($stmt)){
        //get new product ID as this wasnt working before
        $productID = mysqli_insert_id($db_Conn); //get the last inserted ID
        //move the uploaded file to the designated folder
        if(move_uploaded_file($fileTmpName, $folder)){      //this isnt working at the moment. okay it now is working
            echo "Product added successfully."; //debug
            header("Location: product.php?id=" . $productID); //redirect to the product page after successful addition
            exit; 
        } else {
            echo "Error moving uploaded file."; //debug
            $_SESSION['error'] = "Error moving uploaded file.";
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
    <title>Add Product</title>
</head>
<body>
    <div class="headerStrip">       <!-- standardized header strip for all pages -->
        <header>
            <div class="headerTop">
                <h1>My Account</h1>
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
                    <div class="data">
                        <label for="productCategory">Product Category:</label>
                        <input type="text" id="productCategory" name="productCategory" required>
                    </div>
                    <div class="data">
                        <label for="productStockQuantity">Product Stock Quantity:</label>
                        <input type="number" id="productStockQuantity" name="productStockQuantity" required>
                    </div>
                    <div class="data">
                        <label for="productDateAdded">Product Date Added:</label>
                        <input type="datetime-local" id="productDateAdded" name="productDateAdded" required>
                    </div>
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


</body>
</html>