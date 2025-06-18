<?php
session_start();
include("dbconnection.php");
$productID = $_POST['product_id'];
$quantity = 1; // hardcoded for now but will implement a button to change
//needa check the current stock and prod details before adding to stock, also needa check if stock is empty
$sql = "SELECT StockQuantity FROM products WHERE ProductID = ?";
$stmt = mysqli_prepare($db_Conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
if($product['StockQuantity'] <= 0){
    $_SESSION['error'] = "Product is out of stock please wait for the seller to restock";
    header("Location: product.php?id=".$productID);
    exit;
}
if (isset($_SESSION['cart'][$productID])) {
    $currentQty = $_SESSION['cart'][$productID];  // product already in cart
} else {
    $currentQty = 0;  // product not yet in cart
}
// Check if adding would exceed stock
if ($currentQty + $quantity > $product['StockQuantity']) {
    $_SESSION['error'] = "You cannot add more than the available stock to your cart.";
    header("Location: product.php?id=".$productID);
    exit;
}

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

