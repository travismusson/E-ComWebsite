<?php
session_start();
include("dbconnection.php");

//getting seller id
$productID = $_POST['productID'];
$sql = "SELECT SellerID FROM products WHERE ProductID = ?";
$stmt = mysqli_prepare($db_Conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        if(mysqli_num_rows($result) > 0){
            $currentProductData = $row;
        }
    }
/*     //debug
echo "<pre>";
var_dump($_SESSION);
var_dump($_POST);
var_dump($currentProductData);
echo "</pre>";
*/

if (!isset($_SESSION['User_Level']) || ($_SESSION['User_Level'] !== 1 && $_SESSION['id'] !== $currentProductData['SellerID'])) {          //gonna need to add seller info here too      //added now testing
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: index.php");
    exit;
}
if (isset($_POST['productID'])) {       //needa refactor for consistency across website instead of this quick way       --done
    $productID = $_POST['productID'];
    //delete reviews for this product first
    $sqlReviewDelete = "DELETE FROM reviews WHERE ProductID = ?";
    $reviewStmt = mysqli_prepare($db_Conn, $sqlReviewDelete);
    mysqli_stmt_bind_param($reviewStmt, "i", $productID);
    mysqli_stmt_execute($reviewStmt);
    //needa delete orders with product?     //not sure if this is best practice
    $sqlOrderDelete = "DELETE FROM orderdetails WHERE ProductID = ?";
    $orderStmt = mysqli_prepare($db_Conn, $sqlOrderDelete);
    mysqli_stmt_bind_param($orderStmt, "i", $productID);
    mysqli_stmt_execute($orderStmt);
    //delete orders from orders table
    $sqlOrderDelete = "DELETE FROM orders WHERE ProductID = ?";
    $orderStmt = mysqli_prepare($db_Conn, $sqlOrderDelete);
    mysqli_stmt_bind_param($orderStmt, "i", $productID);
    mysqli_stmt_execute($orderStmt);
    //delete product from product table
    $sqlProductDelete = "DELETE FROM products WHERE ProductID = ?";
    $productStmt = mysqli_prepare($db_Conn, $sqlProductDelete);
    mysqli_stmt_bind_param($productStmt, "i", $productID);
    mysqli_stmt_execute($productStmt);

    $_SESSION['error'] = "Product deleted.";        //temp debug
}
header("Location: index.php");
exit;

?>