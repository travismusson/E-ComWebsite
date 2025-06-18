<?php
session_start();        //session start for session handling
include("dbconnection.php");    //added in to allow for dynamic product loading and db connection       
//check if user is logged in
// Set background color early to prevent white flashes
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';
//fetching existing profile photo
if(isset($_SESSION['id'])){
    $userID = $_SESSION['id'];
    $SQL = "SELECT Profile_IMG_DIR FROM users WHERE id = ?";
    $stmt = mysqli_prepare($db_Conn, $SQL);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($result)){
        if(mysqli_num_rows($result) > 0){
            $profileImg = $row['Profile_IMG_DIR'];
        }
    }

}

//first wanna see what prints to post
/*
echo "<pre>";
var_dump($_SESSION);
var_dump($_POST);
echo "</pre>";
*/

//needa add handling for the post of the product update and deletion from cart
if(isset($_POST['updateItem']) && isset($_POST['productQty'])){
    //var
    $productID = $_POST['productID'];
    $productQty = $_POST['productQty'];
    //maybe needa check to see if there is enough stock of the product.
    //fetching current stock
    $sql = "SELECT StockQuantity FROM products WHERE ProductID = ?";
    $stmt = mysqli_prepare($db_Conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if($productQty > 0){    //just incase
        if($row && $productQty <= $row['StockQuantity']){   //if row is populated and the productqty user inputs is equalt to or less than the stock quantity
             $_SESSION['cart'][$productID] = $productQty;     //set the new quantity
        }else{
            $_SESSION['error'] = "Seller does not have the request quantity of stock available";
            header("Location: index.php");
            exit;
        }
       
    }
}
if(isset($_POST['removeItem'])){
    //var
    $productID = $_POST['productID'];
    unset($_SESSION['cart'][$productID]);   //unsets the cart at the product id -- basically removes from cart

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">       <!-- for social media icons -->
    <script defer src="https://cloud.umami.is/script.js" data-website-id="9415a47e-d40f-4dd5-a813-f4c68ef3d995"></script>     <!-- for website tracking info -->
    <title>TravsList | Search Products</title>
</head>
<body>
    <div class="headerStrip">
        <header>
            <div class="headerTop">
                <a href="index.php">
                    <img src="images/logo.png" alt="TravsList Logo" class="siteLogo">     <!-- having an issue on my phone on prod   fixed was a cache issue-->
                </a>
                <a href="index.php">
                    <h1>TravsList a C2C E-Commerce Website!</h1>
                </a>
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
                <img src="<?php echo "./images/$profileImg";?>" alt="Profile Photo" class="profilePhoto">
                <a href="logout.php" class="btnLogout">Logout</a>       <!--this is the logout button that will log the user out and redirect them to the home page-->
                <!--<script>
                    document.getElementById("btnShowLogin").style.display = "none";      //this will hide the login button when the user is logged in
                </script>-->
            <?php else: ?>
                <span>Hi Guest</span>   <!--guest username when not logged in-->
                <a href="#" class="btnShowLogin">Login</a>       <!--only shown when user is not logged in-->
            <?php endif; ?>      <!--ends the if statement for php-->
            <a href="accountdashboard.php">Account</a>
            <a href="usercart.php" class="active">Cart</a>
            </div>
        </header>
    </div>

<div class="cartContainer">
    <div class="cartHeader">
        <h2>Account Cart</h2>
        <p>Add Orders to your account to checkout and proceed with Payment!</p>
    </div>
    <div class="cartList">
        <?php
        if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])){       //checks to see if cart isset
            $cart = $_SESSION["cart"];
            $total = 0;
            foreach($cart as $productID => $qty){        //foreach item in the cart session array productID will take key using lamda and Qty will take value
                $stmt = mysqli_prepare($db_Conn, "SELECT * FROM products WHERE ProductID = ?");
                mysqli_stmt_bind_param($stmt, "i", $productID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $subtotal = $row["Price"] * $qty;       //math to x the qty by the price to get a subtotal
                    $total += $subtotal;        //increment the total for each item
                    ?>
                    <div class="cartItem"> 
                        <h2><?php echo $row["Name"];?></h2>
                        <img src="./images/<?php echo $row["Product_IMG_DIR"];?>"></img>
                        <p> <?php echo $row["Name"]. " x $qty - R". $subtotal;?></p>
                        <div class="updateCartItem">
                            <form action="usercart.php" method="POST" class="updateCartForm">
                                <div class="cartInput">
                                    <input type="hidden" name="productID" value="<?php echo $productID;?>">
                                    <p>Qty:</p>
                                    <input type="number" name="productQty" value="<?php echo $qty;?>" step="1" min="1" max = "<?php echo $row['StockQuantity'];?>">     <!--ensures it steps by 1 and min value is 1 unless they wanna remove it, testing max with stock quant-->
                                </div>
                                <div class="cartBtn">
                                    <button type="submit" name="updateItem" value="update">Update</button>
                                    <button type="submit" name="removeItem" value="remove" class="removeBtnCart">Remove</button>        <!--removed this coz im adding update also //onsubmit="return confirm('Are you sure you want to remove this product from your cart?')"-->
                                </div> 
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="cartTotal">
                <b>Total: R <?php echo $total ?></b>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <form action="checkout.php" method="POST">
                    <button type="submit" value="checkout">Checkout</button>
                </form>
                <?php else: ?>
                    <br><a href="#" class="btnShowLogin">Please Login to Checkout</a>
                <?php endif ?>
            </div>
            <?php
        } else {
            echo "Your Cart is Empty!";
        }
?>
</div>
    </div>
</div>




<div class="blurOverlay"></div>
<div class="loginContainer">
    <span class="material-symbols-outlined" for="login">close</span>
    <div class="text">
        Login Form
    </div>
    <form action="login.php" method="post" onsubmit="return ValidateLogin()">
        <div class="data">
            <label for="loginEmail">Email Address</label>
            <input type="email" placeholder="test@email.com" id="loginEmail" name="loginEmail" required>        <!--Regarding the name, im not sure if its better to use standardized just email instead of each email being acquanted to the various forms ie login and register, so im going with this approach for easier debugging-->
            <span id="emailErrorField" class="error"></span>
        </div>
        <div class="data">
            <label for="loginPassword">Password</label>
            <input type="password" placeholder="Enter Password Here..." id="loginPassword" name="loginPassword" required>
            <span id="passwordErrorField" class="error"></span>
        </div>
        <div class="forgotPass">
            <a href="#">Forgot Your Password?</a><br>
        </div>
        <div class="registerAccount">
            <label>Not Registered? <a href="#" class="showRegister">Create an Account</a></label>
        </div>
        <div class="btnLogin">
            <button type="submit" value="login">Login</button>  <!--needs value to parse data, not sure if it is necesarry to have a standardized name (ie "Go") or if this is ok-->
        </div>
    </form>
</div>
<div class="registerContainer">
    <span class="material-symbols-outlined" for="register">close</span>
    <div class="text">Register an Account</div>
        <form action="register.php" method="post" onsubmit="return ValidateRegister()">
            <div class="data">
                <label for="registerFirstName">First Name</label>
                <input type="text" placeholder="Bob" id="registerFirstName" name="registerFirstName" required>
                <span id="firstNameError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerLastName">Last Name</label>
                <input type="text" placeholder="Bobson" id="registerLastName" name="registerLastName" required>
                <span id="lastNameError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerEmail">Email Address</label>
                <input type="email" placeholder="test@email.com" id="registerEmail" name="registerEmail" required>
                <span id="emailError" class="error"></span>
            </div>
            <div class="data">
                <label for="registerPassword">Password</label>
                <input type="password" placeholder="Enter Password Here..." id="registerPassword" name="registerPassword" required>
                <span id="passwordError" class="error"></span>
            </div>
            <div class="forgotPass">
                <a href="#">Forgot Your Password?</a><br>
            </div>
            <div class="loginAccount">
                <label>Already Registered? <a href="#" class="showLogin">Login Here</a></label>
            </div>
            <div class="btnRegister">
                <button type="submit" value="register">Register</button>        <!--needs value to parse data-->
            </div>
        </form>
</div>



<div class="footerContainer">
    <footer>
        <p>2025 Travis Musson. All rights reserved.</p>
        <p><a href="mailto:travismusson@gmail.com">travismusson@gmail.com</a></p>
        <picture>
            <a href = "https://www.instagram.com/travismusson/"><i class="fa fa-brands fa-instagram fa-lg"></i></a>
            <a href = "https://www.facebook.com/travis.musson.7"><i class="fa fa-brands fa-facebook fa-lg"></i></a>
            <a href = "https://www.linkedin.com/in/travis-musson-a5a30a298"><i class="fa fa-brands fa-linkedin fa-lg"></i></a>
            <a href = "https://github.com/travismusson"><i class = "fa fa-brands fa-github fa-lg"></i><a>
        </picture>
    </footer>
</div>
<script src="scripts.js"></script>     <!--link to the javascript file for the hamburger menu--> 
<script src="validate.js"></script>
</body>
</html>

