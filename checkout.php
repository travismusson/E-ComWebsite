<?php
session_start();
include("dbconnection.php");
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if ($cart) {
    $userID = $_SESSION['id'];
    $stmt = mysqli_prepare($db_Conn, "INSERT INTO orders (BuyerID, OrderDate) VALUES (?, NOW())");
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $orderID = mysqli_insert_id($db_Conn);

    foreach ($cart as $productID => $qty) {
        $stmt = mysqli_prepare($db_Conn, "INSERT INTO orderdetails (OrderID, ProductID, Quantity) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iii", $orderID, $productID, $qty);
        mysqli_stmt_execute($stmt);
    }
    unset($_SESSION['cart']);
    header("Location: paymentgateway.php?orderID=$orderID");
    exit;
}
header("Location: usercart.php");
exit;
?>