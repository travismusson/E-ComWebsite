<?php
session_start();
include("dbconnection.php");
if (!isset($_SESSION["User_Level"]) || $_SESSION["User_Level"] !== 1) {
    $_SESSION["error"] = "Unauthorized access.";
    header("Location: index.php");
    exit;
}
if (isset($_POST['userID'])) {
    $userID = (int)$_POST['userID'];
    // Prevent admin from deleting themselves
    if ($userID !== $_SESSION['id']) {
        // Delete products by this user first
        $stmt = mysqli_prepare($db_Conn, "DELETE FROM products WHERE SellerID = ?");
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        // Now delete the user
        $stmt = mysqli_prepare($db_Conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);

        $_SESSION["error"] = "User and their products deleted.";
    } else {
        $_SESSION["error"] = "You cannot delete your own account.";
    }
}
header("Location: userlist.php");
exit;
?>