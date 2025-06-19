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
if (isset($_POST['productID'])) {
    $productID = $_POST['productID'];
    //delete reviews for this product first
    $stmt = mysqli_prepare($db_Conn, "DELETE FROM reviews WHERE ProductID = ?");
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    //needa delete orders with product?
    
    //delete product from product table
    $stmt = mysqli_prepare($db_Conn, "DELETE FROM products WHERE ProductID = ?");
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);

    $_SESSION['error'] = "Product deleted.";        //temp debug
}
header("Location: index.php");
exit;

?>