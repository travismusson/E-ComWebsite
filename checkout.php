<?php
session_start();
include("dbconnection.php");
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
//viewing cart print just to make sure
/*      //debug
echo "<pre>";
var_dump($_SESSION);
var_dump($_SESSION['cart']);
echo "</pre>";
*/
//needa implement a recalculation of the product price to display

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($cart) {
    //needa get total and subtotal again
    //default var
    $total = 0;
    $productPrices = [];   //also needa store the product prices within an array
    foreach ($cart as $productID => $qty) { 
        $sqlFetchPrice = "SELECT Price FROM products WHERE ProductID = ?";      //fetching the price from db 
        $fetchStmt = mysqli_prepare($db_Conn, $sqlFetchPrice);
        mysqli_stmt_bind_param($fetchStmt, "i", $productID);
        mysqli_stmt_execute($fetchStmt);
        $result = mysqli_stmt_get_result($fetchStmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $price = $row["Price"];
            $productPrices[$productID] = $price;    //store price within the array
            $subtotal = $price * $qty;       
            $total += $subtotal;
        }
    }
    $userID = $_SESSION['id'];
    $insertOrderSql = "INSERT INTO orders (BuyerID, OrderDate, TotalPrice) VALUES (?, NOW(), ?)";
    $orderStmt = mysqli_prepare($db_Conn, $insertOrderSql);
    mysqli_stmt_bind_param($orderStmt, "id", $userID, $total);
    mysqli_stmt_execute($orderStmt);
    $orderID = mysqli_insert_id($db_Conn);

    foreach ($cart as $productID => $qty) {
        $price = $productPrices[$productID];
        $subtotal = $price * $qty;
        $insertDetailSql ="INSERT INTO orderdetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)";
        $detailStmt = mysqli_prepare($db_Conn, $insertDetailSql);
        mysqli_stmt_bind_param($detailStmt, "iiid", $orderID, $productID, $qty, $subtotal);
        mysqli_stmt_execute($detailStmt);

        //update the stock - the binded qty amount on the order to reduce the stock of the product
        $updateSql = "UPDATE products SET StockQuantity = StockQuantity - ? WHERE ProductID = ?";        
        $updateStmt = mysqli_prepare($db_Conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ii", $qty, $productID);
        mysqli_stmt_execute($updateStmt);
        //this works but my checks to adding to cart arnt working
    }
    unset($_SESSION['cart']);
    header("Location: paymentgateway.php?orderID=$orderID");
    exit;
}
header("Location: usercart.php");
exit;

?>