<?php
session_start();
$productID = $_POST['product_id'];
$quantity = 1; // You can extend this to allow custom quantities

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_SESSION['cart'][$productID])) {
    $_SESSION['cart'][$productID] += $quantity;
} else {
    $_SESSION['cart'][$productID] = $quantity;
}
header("Location: usercart.php");
exit;
?>