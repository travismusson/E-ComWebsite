<?php
session_start();
$productID = $_POST['product_id'];
$quantity = 1; // You can extend this to allow custom quantities

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];     //empties the cart
}
if (isset($_SESSION['cart'][$productID])) {     //checks to see if cart and product id are set
    $_SESSION['cart'][$productID] += $quantity;     //increment the cart if the product exists
} else {
    $_SESSION['cart'][$productID] = $quantity;      //if the product doesnt exist within the cart, add it
}
header("Location: usercart.php");
exit;
?>