<?php
session_start();
include("dbconnection.php");

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





//profile image handeling
if(isset($_POST['addImage'])){
    //var
    $fileName = $_FILES['profileImage']['name']; //getting file name
    $fileTmpName = $_FILES['profileImage']['tmp_name'];
    $folder = "images/".$fileName;
    $userID = $_SESSION['id'];      //dont think i need this here
    $sql = "UPDATE users SET Profile_IMG_DIR = ? WHERE id = ?"; 
    $stmt = mysqli_prepare($db_Conn, $sql);
    if(!$stmt){
        $_SESSION['error'] = "Error in SQL Prepare Statement: " . mysqli_error($db_Conn);
        header("Location: index.php");
        exit;
    }
    mysqli_stmt_bind_param($stmt, "si", $fileName, $userID);
    if(mysqli_stmt_execute($stmt)){
        if(move_uploaded_file($fileTmpName, $folder)){
            echo "Profile Photo added sucessfully";
            header("Location: accounttabs.php");
            exit;
        }else{
            echo "Error moving uploaded file."; //debug
            $_SESSION['error'] = "Error moving uploaded file.";
            header("Location: index.php"); //redirect to index page if file move fails
            exit;
        }
    }


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
    <title>TravsList | Orders</title>
</head>
<body>
<div class="headerStrip">
        <header>
            <div class="headerTop">
                <a href="index.php">
                    <img src="images/logo.png" alt="TravsList Logo" class="siteLogo">
                </a>
                <a href="index.php">
                    <h1>TravsList a C2C E-Commerce Website!</h1>
                </a>
                <button class="hamburgerBtn"><span class="material-symbols-outlined">Menu</span></button>
            </div>
            <div class="homeStrip">
                <a href="index.php">Home</a>
            <div class="searchWrapper">
                <!--this is the search bar that will allow users to search for products-->
                <form action="search.php" method="get">     <!--this will allow the user to search for products by category or name-->
                    <input class="searchBar" type="text" name="searchBar" placeholder="Search...">
                    <button type="submit" value="search"><img src="images/icons8-search-16.png"></button>
                </form>
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
            <a class="active" href="accountdashboard.php">Account</a>
            <a href="usercart.php">Cart</a>
            </div>
        </header>
</div>
<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
<div class="btnSideNavOpen">
    <button type="button">Toggle Side Menu</button>
</div>

<div class="accountSideNavContainer">
    <div class="accountSideNavHeader">
        <div class="accountSideNavHeading">My Account</div>
        <div class="btnSideNavClose">
            <button type="button">X</button>
        </div>   
    </div>
        <div class="accountSideNavSection">
            <div class="accountSideNavHeading">Orders</div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#ordersTab">Orders</a></div>           <!-- converted to tabs  https://www.youtube.com/watch?v=5L6h_MrNvsk -->
            <div class="accountSideNavData"><a href="#" data-tab-target="#returnsTab">Returns</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#reviewsTab">Product Reviews</a></div>
        </div>
        <div class="accountSideNavSection">
            <div class="accountSideNavHeading">Account Details</div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#editAccountTab">Edit Account</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#editSecurityTab">Security Settings</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#addressSettingsTab">Address Settings</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#newsletterSubscriptionsTab">Newsletter Subscriptions</a></div>
        </div>
        <div class="accountSideNavSection">
            <div class="accountSideNavHeading">Support</div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#supportTab">Contact Us</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#FAQTab">FAQs</a></div>
            <div class="accountSideNavData"><a href="#" data-tab-target="#helpCenterTab">Help Center</a></div>
        </div>
</div>
<!-- refactoring into a tab section ref: https://www.youtube.com/watch?v=fI9VM5zzpu8   comeback to fix things-->
<div class="tabContent" id="ordersTab">
<div class="ordersContainer">
    <div class="orderHeader">
        <h2>Order History</h2>
        <p>View your past orders and their details.</p>
    </div>
    <div class="orderList">
        <?php
        // Fetch orders from the database
        $userId = $_SESSION['id'];
        $query = "SELECT * FROM orders WHERE BuyerID = ?";
        $stmt = mysqli_prepare($db_Conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            while($order = mysqli_fetch_assoc($result)) { ?>
                <div class='orderItem'>
                <h3>Order ID: <?php echo htmlspecialchars($order['OrderID']) ?></h3>
                <p>Date: <?php echo htmlspecialchars($order['OrderDate']) ?></p>
                <p>Total: R<?php echo htmlspecialchars($order['TotalPrice']) ?></p>
                <a href="orderdetails.php?orderid=<?php echo $order['OrderID'] ?>">View Details</a>
            </div>
            <?php
            }
        } else {
            echo "<p>No orders found.</p>";
        }
        ?>
    </div>
</div>
</div>
<div class="tabContent" id="returnsTab">
<div class="returnsContainer">
    <div class="orderHeader">
        <h2>Returns</h2>
        <p>Manage your product returns and view return status.</p>
    </div>
    <div class="orderList">
        <?php
        // Fetch returns from the database
        $query = "SELECT * FROM returns WHERE BuyerID = ?";
        $stmt = mysqli_prepare($db_Conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            while($return = mysqli_fetch_assoc($result)) { ?>
                <div class='returnItem'>
                <h3>Return ID: <?php echo htmlspecialchars($return['ReturnID']) ?></h3>
                <p>Date: <?php echo htmlspecialchars($return['ReturnDate']) ?></p>
                <p>Status:<?php echo htmlspecialchars($return['ReturnStatus']) ?></p>
                <a href="returndetails.php?returnid=<?php echo htmlspecialchars($return['ReturnID']) ?>">View Details</a>
                </div>
            <?php
            }
        } else {
            echo "<p>No returns found.</p>";
        }
        ?>
    </div>
</div>
</div>
<div class="tabContent" id="reviewsTab">
<div class="reviewsContainer">
    <div class="orderHeader">
        <h2>Product Reviews</h2>
        <p>View and manage your product reviews.</p>
    </div>
    <div class="orderList">
        <?php
        // Fetch product reviews from the database
        $query = "SELECT * FROM reviews WHERE BuyerID = ?";     //was causing issue in prod
        $stmt = mysqli_prepare($db_Conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            while($review = mysqli_fetch_assoc($result)) { ?>
                <div class='reviewTabItem'>
                    <h3>Review ID: <?php echo htmlspecialchars($review['ReviewID']); ?></h3>
                    <p>Product ID: <?php echo htmlspecialchars($review['ProductID']); ?></p>
                    <p>Rating: <?php echo htmlspecialchars($review['Rating']); ?></p>
                    <p>Comment: <?php echo htmlspecialchars($review['Comment']); ?></p>
                    <a href="editreview.php?reviewid=<?php echo htmlspecialchars($review['ReviewID']); ?>">Edit Review</a>
                </div>
            <?php
            }
        } else {
            echo "<p>No reviews found.</p>";
        }
        ?>
    </div>
</div>
</div>
<div class="tabContent" id="editAccountTab">
    <div class="editAccountContainer">
        <div class="accountHeader">
            <h2>Edit Account</h2>
            <p>Update your account information.</p>
        </div>
        <div class="accountList">
        <form action="updateaccount.php" method="POST" id="updateAccountDetails" enctype="multipart/form-data">
            <div class="nameSection">
                <h4 for="tempName">Your Name:</h4>
                <div class="inputRow">
                    <label id="tempName"><?php echo htmlspecialchars($_SESSION['FirstName'] . ' ' . $_SESSION['LastName']); ?></label>
                    <input type="text" id="inputFirstName" name="inputFirstName" value="<?php echo htmlspecialchars($_SESSION['FirstName']); ?>">
                    <input type="text" id="inputLastName" name="inputLastName" value="<?php echo htmlspecialchars($_SESSION['LastName']); ?>">
                <div class="btnRow">
                    <button type="button" id= "btnEditName" class="btnEditButton" onclick="editName()">Edit</button>
                    <button type="button" id= "btnSaveName" class="btnEditButton" onclick="saveName()">Save</button>
                    <button type="button" id= "btnCancelName" class="btnEditButton" onclick="cancelName()">Cancel</button>
                </div>
                </div>
            </div>
            <div class="emailSection">
                <h4 for="tempEmail">Email:</label></h4>
                <div class="inputRow">
                    <label id="tempEmail"><?php echo htmlspecialchars($_SESSION['Email']); ?></label>
                    <input type="email" id="inputEmail" name="inputEmail" value="<?php echo htmlspecialchars($_SESSION['Email']); ?>">
                <div class="btnRow">
                    <button type="button" id= "btnEditEmail" class="btnEditButton" onclick="editEmail()">Edit</button>
                    <button type="button" id= "btnSaveEmail" class="btnEditButton" onclick="saveEmail()">Save</button>
                    <button type="button" id= "btnCancelEmail" class="btnEditButton" onclick="cancelEmail()">Cancel</button>
                </div>
                </div>
            </div>
            <div class="editProfilePhoto">
                <h4>Profile Image</h4>
                <div class="inputRow">
                    <img src="<?php echo "./images/$profileImg";?>" alt="Profile Photo" class="updateProfilePhoto">        <!--displays profile photo-->           
                    <input type="file" id="profileImage" name="profileImage" accept="image/*">
                </div>
            </div>
            <button type="submit" name = "addImage" class="btnUpdateAccount">Update Account</button>
        </form>
    </div>
    </div>
</div>
<div class="tabContent" id="editSecurityTab">
    <div class="editSecurityContainer">
        <div class="accountHeader">
            <h2>Edit Security Settings</h2>
            <p>Update your security settings.</p>
        </div>
        <div class="accountList">
        <form action="updateaccount.php" method="POST" id="updateSecurity">
            <div class="2factorSection">
                <h4 for="tempFactor">2 Factor Authentication:</h4>
                <div class="inputRow">
                    <label id="tempFactor">Enabled</label>
                    <select id="select2Factor">
                        <option value ="" disabled="disabled">Select an Option</option>
                        <option value="Enabled">Enabled</option>
                        <option value="Disabled">Disabled</option>
                    </select>
                    <div class="btnRow">
                        <button type="button" id= "btnEdit2Factor" class="btnEditButton" onclick="edit2Factor()">Edit</button>
                        <button type="button" id= "btnSave2Factor" class="btnEditButton" onclick="save2Factor()">Save</button>
                        <button type="button" id= "btnCancel2Factor" class="btnEditButton" onclick="cancel2Factor()">Cancel</button>
                    </div>
                </div>                
            </div>
            <div class="passwordSection">
                <h4 for="inputPassword">Password:</h4>
                <div class="inputRow">
                    <label id="tempPassword">*******</label>
                    <input type="password" id="inputPassword" value="" placeholder="Password">       <!-- not gonna store password here rather gonna just make the update -->
                <!--<input type="checkbox" onclick="toggleVisibility()">Show Password</input>-->
                <div class="btnRow">
                    <button type="button" id= "btnEditPassword" class="btnEditButton" onclick="editPassword()">Edit</button>
                    <button type="button" id= "btnSavePassword" class="btnEditButton" onclick="savePassword()">Save</button>
                    <button type="button" id= "btnCancelPassword" class="btnEditButton" onclick="cancelPassword()">Cancel</button>
                </div>
                </div>
            </div>
            <button type="submit" class="btnUpdateAccount">Update Account</button>
        </form>
    </div>
    </div>
</div>
<div class="tabContent" id="addressSettingsTab">
    <div class="editAddressSettings">
        <div class="addressHeader">
            <h2>Edit Address Settings</h2>
            <p>Comming Soon!</p>
        </div>
    </div>
</div>
<div class="tabContent" id="newsletterSubscriptionsTab">
    <div class="editNewsletterSubscriptions">
        <div class="newsletterHeader">
            <h2>Edit Newsletter Subscriptions</h2>
            <p>Comming Soon!</p>
        </div>
    </div>
</div>
<div class="tabContent" id="supportTab">
    <div class="viewSupport">
        <div class="supportHeader">
            <h2>Contact Us!</h2>
            <h4 for="contactEmail">Email:</h4>
        <p id="contactEmail"><a href="mailto:travismusson@gmail.com">travismusson@gmail.com</a></p>
        </div>
    </div>
</div>
<div class="tabContent" id="FAQTab">
    <div class="FAQContainer">
        <div class="FAQHeader">
            <h2>Frequently Asked Questions</h2>
            <p>Comming Soon!</p>
        </div>
    </div>
</div>
<div class="tabContent" id="helpCenterTab">
    <div class="helpCenterContainer">
        <div class="helpCenterHeader">
            <h2>Help Center</h2>
            <p>Comming Soon!</p>
        </div>
    </div>
</div>





<?php else: ?>
    <div class="loginPrompt">
        <h2>Please log in to view your account details.</h2>
        <!--<script>   issue here. gonna rely on user to manually login for now
            document.querySelector('.blurOverlay').style.display = 'block';  // Show the blur overlay
            document.querySelector('.loginContainer').style.display = 'flex';  // Show the login container
        </script>-->
    </div>
<?php endif; ?> <!-- End of logged-in check -->




<!--Login Content -->
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
            <a href="#" onclick="alert('An Email will be Sent to you for Password Reset')">Forgot Your Password?</a><br>
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
                <a href="#" onclick="alert('An Email will be Sent to you for Password Reset')">Forgot Your Password?</a><br>
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
<!--https://github.com/travismusson-->
<script src="scripts.js"></script>
<script src="validate.js"></script>
</body>
</html>