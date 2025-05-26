<?php
session_start();    //enusre user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">       <!-- for social media icons -->
    <title>My Account</title>
</head>
<body>
    <div class="headerStrip">
        <header>
            <div class="headerTop">
                <h1>My Account</h1>
                <button class="hamburgerBtn"><span class="material-symbols-outlined">Menu</span></button>
            </div>
            <div class="homeStrip">
                <a href="index.php">Home</a>
            <div class="searchWrapper">
                <input class="searchBar" type="text" placeholder="Search...">
                <button type="submit"><img src="images/icons8-search-16.png"></button>
            </div>
<!--Adding php here for username in the Account list https://www.php.net/manual/en/control-structures.alternative-syntax.php  for control structures within php and html-->
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <span>Hi <?php echo $_SESSION["FirstName"]; ?></span>   <!--this will show the user name-->
                <a href="logout.php" class="btnLogout">Logout</a>       <!--this is the logout button that will log the user out and redirect them to the home page-->
                <script>
                    document.getElementById("btnShowLogin").style.display = "none";      //this will hide the login button when the user is logged in
                </script>
            <?php else: ?>
                <span>Hi Guest</span>   <!--guest username when not logged in-->
                <a href="#" class="btnShowLogin">Login</a>       <!--only shown when user is not logged in-->
            <?php endif; ?>      <!--ends the if statement for php-->
            <a class="active" href="account.php">Account</a>
            <a href="#">Cart</a>
            </div>
        </header>
    </div>
    <div class="accountOrders">
        <h2>Orders</h2>
        <ul>
            <li><a href="#">Orders</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">Product Reviews</a></li>
            <li><a href="#">My Listings</a></li>
        </ul>
    </div>
    <div class="accountDetails">
        <h2>Account Details</h2>
        <ul>
            <li><a href="#">Edit Account</a></li>
            <li><a href="#">Security Settings</a></li>
            <li><a href="#">Address Book</a></li>
            <li><a href="#">Newsletter Subscriptions</a></li>        
        </ul>
    </div>
    <div class="accountSupport">
        <h2>Support</h2>
        <ul>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Help Center</a></li>
        </ul>
    </div>
<div class="footerContainer">
    <footer>
        <p>2025 Travis Musson. All rights reserved.</p>
        <p><a href="mailto:travismusson@gmail.com">travismusson@gmail.com</a></p>
        <picture>
            <a href = "https://www.instagram.com/travismusson/"><i class="fa fa-brands fa-instagram fa-lg"></i>
            </a>
            <a href = "https://www.facebook.com/travis.musson.7"><i class="fa fa-brands fa-facebook fa-lg"></i> 
            </a>
            <a href = "https://www.linkedin.com/in/travis-musson-a5a30a298"><i class="fa fa-brands fa-linkedin fa-lg"></i>
            </a>
        </picture>
    </footer>
</div>
    <script src="script.js"></script>     <!--link to the javascript file for the hamburger menu--> 

</body>
</html>