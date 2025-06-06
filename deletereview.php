<?php
session_start();
include("dbconnection.php");
if (!isset($_SESSION['User_Level']) || !$_SESSION['User_Level']) {
    $_SESSION['error'] = "Unauthorized access.";
    header("Location: index.php");
    exit;
}
if (isset($_POST['reviewID'])) {
    $reviewID = $_POST['reviewID'];
    $stmt = mysqli_prepare($db_Conn, "DELETE FROM reviews WHERE ReviewID = ?");     //deletes review
    mysqli_stmt_bind_param($stmt, "i", $reviewID);
    mysqli_stmt_execute($stmt);
    $_SESSION['error'] = "Review deleted.";     //temp debug        might keep for the admin to know
}
header("Location: index.php");
exit;
?>