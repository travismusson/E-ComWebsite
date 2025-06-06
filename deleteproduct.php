<?php
session_start();
include("dbconnection.php");
if (!isset($_SESSION['User_Level']) || !$_SESSION['User_Level']) {
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
    //delete product from product table
    $stmt = mysqli_prepare($db_Conn, "DELETE FROM products WHERE ProductID = ?");
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);

    $_SESSION['error'] = "Product deleted.";        //temp debug
}
header("Location: index.php");
exit;
?>