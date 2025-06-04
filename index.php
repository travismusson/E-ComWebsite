<!--converted to index.php from index.html-->
<?php
session_start();        //session start for session handling
include("dbconnection.php");    //added in to allow for dynamic product loading and db connection       
//check if user is logged in
// Set background color early to prevent white flashes
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';    //came to conclusion this was best way of keeping background color
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){      //this checks if the user is logged in -- might remove this as i used it within the actual html code using control structures
    echo "Welcome ".$_SESSION["FirstName"]." ".$_SESSION["LastName"]." <br>";      //this will show the user their name at the top of the page this is nice but i need to move it to the account list item      --decided on keeping this at top of page i think its quite nice.
    /*echo "<script>
        document.querySelector('.homeStrip').innerHTML += 'Welcome ".$_SESSION["FirstName"]." ".$_SESSION["LastName"]."';   
        
    </script>";//gonna add this to the home strip*/
    /* refactor
    //needa create a logout button here
    //this will be a button that will log the user out and redirect them to the home page
    //this is working but it still showing at the top of the page i need to move it to the account list item
    //this is a form that will log the user out
    //i think i need to add this to the list but encapsulate it in php
    
    echo "<form action='logout.php' method='post'>
            <button type='submit' class='btnLogout'>Logout</button>
        </form>";
    */

}

?>
<!--adding error handleing using session variables and control statements -- not working looking for fix --fixed!! -->
<?php if(isset($_SESSION["error"])):  ?>      <!--this checks if there is an error message set in the session -->
    <script>
    alert('<?php echo $_SESSION["error"]; ?>');
    </script>
    <?php unset($_SESSION["error"]);      //this will unset the error message so it does not show again
endif; ?>
<!--going to keep for now, might be a better way in doing this will maybe reach out to sir-->
<?php if(isset($_SESSION["addProductError"])):  ?>      <!--added this unique session variable for specific handling within add product page --testing -- result: it shows both email invalid and my unique error thinking im going to keep this to ensure user knows where they went wrong?-->
    <script>
    alert('<?php echo $_SESSION["addProductError"]; ?>');
    </script>
    <?php unset($_SESSION["addProductError"]);      
endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">   testing some classess framework - very cool plug nd play element but doesnt align with my website idea -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">     was testing bootstrap but its too late to incorperate it but for future projects i might look to use it and not suffer through all the styling ive been doing haha-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>E-commerce Platform</title> 
</head>
<body>
<div class="headerStrip">
    <header>
        <div class="headerTop">
        <h1>Travis Musson's C2C E-Commerce Website!</h1>
        <!--Hidden Hamburger for mobile view-->
        <button class="hamburgerBtn"><span class="material-symbols-outlined">Menu</span></button>
        </div>
        <div class="homeStrip">
            <a class="active" href="index.php">Home</a>
            <div class="searchWrapper">
                <input class="searchBar" type="text" placeholder="Search...">
                <button type="submit"><img src="images/icons8-search-16.png"></button>
            </div>
<!--Adding php here for username in the Account list https://www.php.net/manual/en/control-structures.alternative-syntax.php  for control structures within php and html-->
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <span>Hi <?php echo $_SESSION["FirstName"]; ?></span>   <!--this will show the user name-->
                <a href="logout.php" class="btnLogout">Logout</a>       <!--this is the logout button that will log the user out and redirect them to the home page-->
                <!-- Refactor for now 
                <script>
                    document.getElementById("btnShowLogin").style.display = "none";      //this will hide the login button when the user is logged in     //looking at scripts im getting an error here as it is being hidden
                </script> 
                -->
            <?php else: ?>
                <span>Hi Guest</span>   <!--guest username when not logged in-->
                <a href="#" class="btnShowLogin">Login</a>       <!--only shown when user is not logged in-->
            <?php endif; ?>      <!--ends the if statement for php-->
            <a href="accountdashboard.php">Account</a>
            <a href="#">Cart</a>
        </div>
    </header>
    <div class= "headerBtnContainer">
    <div class="directAddProduct">
        <button onclick="location.href='addproduct.php'">Add Product</button>     <!--this is the add product button that will redirect the user to the add product page-->
    </div>
    <div class="dropCategory"> <!-- need to update to actuall category menu -->
        <button class="btn_DropDown">Shop by Category</button>
        <div class = "autoHideCat">
            <ul>
                <li><div class="catItems"><span class="material-symbols-outlined">iron</span><a href="#">Appliances</a></div></li>
                <li><div class="catItems"><span class="material-symbols-outlined">book_5</span><a href="#">Books</a></div></li>
                <li><div class="catItems"><span class="material-symbols-outlined">apparel</span><a href="#">Clothing</a></div></li>
                <li><div class="catItems"><span class="material-symbols-outlined">computer</span><a href="#">Electronics</a></div></li>    
                <li><div class="catItems"><span class="material-symbols-outlined">tv_gen</span><a href="#">Entertainment</a></div></li>                 
                <li><div class="catItems"><span class="material-symbols-outlined">chair</span><a href="#">Furniture & Outdoor</a></div></li>
                <li><div class="catItems"><span class="material-symbols-outlined">sports_esports</span><a href="#">Gaming</a></div></li>
                <li><div class="catItems"><span class="material-symbols-outlined">child_care</span><a href="#">Kiddies</a></div></li>  
                <li><div class="catItems"><span class="material-symbols-outlined">kettle</span><a href="#">Kitchen</a></div></li> 
            </ul>
        </div>
    </div>
    </div>
</div>

<!--Need to implement mobile view incorperation     might refactor instead of duplicating menu i might just adajust when screensize is small-->
<!--        Temp refactor to test
<div class="mobileOverlay">
    <div class="mobileContainer">
        <div class = "mobileHeaderStrip">        
            <h2>Navigation</h2>
            <button class="closeMobileNav">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="mobileItems">
            <a class="active" href="#">Home</a>
            <div class = "mobileSearchWrapper">
                <input class="mobileSearchBar" type="text" placeholder="Search...">
                <button type="submit"><img src="images/icons8-search-16.png"></button>
            </div>
            <a href="#">Account</a>
            <a href="#" class="btnShowLogin">Login</a>
            <a href="#">Cart</a>
        </div>
    </div>
</div>
-->
<!-- needa implement a means of linking items to a product page-->
<div class="latestDealsContainer">
        <h2>Latest Deals</h2>
        <a href="#">View All</a>
        <button class="latestDealsScrollLeft">&lt;</button>
            <div class="latestDeals">
                <!--refactored span encapsulating every div item-->
                <!-- these are hardcoded for now -->
                
                <!-- <div class="dealsItem"><a href="product.php?id=1"><img src="images/pexels-garrettmorrow-1649771.jpg" alt="HifiHeadphones"><b>R2000</b><br>ATH M50s Headphones</a></div>      need to find out how to dynamically link products to product page and update accordingly but i feel like this is maybe out of scope?  -- will look in morning-->
            <!--<div class="dealsItem"><a href="product.php?id=2"><img src="images/pexels-kaip-1082810.jpg" alt="ps4controller"><b>R450</b><br>Ps4 Controller</a></div>
                <div class="dealsItem"><a href="product.php?id=3"><img src="images/pexels-thebstudio-947885.jpg" alt="glasses"><b>R250</b><br>Aviator Glasses</a></div>
                <div class="dealsItem">Test</div>
                <div class="dealsItem">Test</div>
                <div class="dealsItem">Test</div>
                <div class="dealsItem">Test</div>
                <div class="dealsItem">Test</div>
                <div class="dealsItem">Test</div>
            -->
                <?php //dynamically adds products to the dealsItem divs
                $query = "SELECT ProductID, Name, Price, Description, Product_IMG_DIR FROM products ORDER BY ProductID DESC";    //selecting the product from the products table    --need to update to reverse this to show the latest product added first
                $result = mysqli_query($db_Conn, $query);
                //if(!$result){
                //    $_SESSION['error'] = "Error in SQL Result Statement: " . mysqli_error($db_Conn);
                //    header("Location: index.php");
                //    exit;
                

                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        //now we need to display the products in the dealsItem divs
                        ?>
                        <div class="dealsItem">
                            <a href="product.php?id=<?php echo $row['ProductID']; ?>">
                                <img src="./images/<?php echo $row['Product_IMG_DIR']; ?>" alt = "<?php echo $row['Name']; ?>">
                                <b>R <?php echo $row['Price'];?></b><br>
                                <?php echo $row['Name']; ?>
                            </a>
                        </div>
                        <?php
                    }
                }       //getting an error here the and i think its coz i didnt add db connection?      --fixed
                ?>

           </div>
        <button class="latestDealsScrollRight">&gt;</button>
</div>
<!-- going to add a section for top sellers, and then a section of some categories that are popular, and maybe a section for featured products -->
<div class="topSellersContainer">
    <h2>Top Sellers</h2>
    <a href="#">View All</a>
    <button class="topSellersScrollLeft">&lt;</button>
        <div class="topSellers">            
            <div class="sellersItem"><img src="images/pexels-karoldach-377711.jpg" alt="HifiHeadphoneStore"><b>From R5000</b><br>HifiHeadphoneStore</div>
            <div class="sellersItem"><img src="images/pexels-roman-odintsov-12719133.jpg" alt="XboxStore"><b>From R800</b><br>XboxStore</div>
            <div class="sellersItem"><img src="images/pexels-paggiarofrancesco-704241.jpg" alt="Glasses"><b>From R250</b><br>SunniesStore</div>
            <div class="sellersItem"><img src="images/pexels-mart-production-7679798.jpg" alt="Jackets"><b>From R400</b><br>Jackets_R_Us</div>
            <div class="sellersItem"><img src="images/pexels-drew-williams-1285451-3568521.jpg" alt="Gadgets"><b>From R500</b><br>GadgetStore</div>
            <div class="sellersItem"><img src="images/pexels-pixabay-267320.jpg" alt="Handmade Loafer Store"><b>From R450</b><br>Handmade Loafer Store</div>
        </div>
    <button class="topSellersScrollRight">&gt;</button>
</div>
<div class="popularCategoriesContainer">
    <h2>Popular Categories</h2>
    <a href="#">View All</a>
    <button class="popularCategoriesScrollLeft">&lt;</button>
        <div class="popularCategories">         
            <div class="categoryItem"><img src="images/pexels-david-yohanes-97693-1450903.jpg" alt="Appliances">Appliances</div>
            <div class="categoryItem"><img src="images/pexels-garrettmorrow-682933.jpg" alt="Gaming">Gaming</div>
            <div class="categoryItem"><img src="images/pexels-jpgata-11118543.jpg" alt="Outdoor Furniture">Furniture & Outdoor</div>
            <div class="categoryItem"><img src="images/pexels-fecundap6-350417.jpg" alt="Kitchen">Kitchen</div>
            <div class="categoryItem"><img src="images/pexels-jmark-2726370.jpg" alt="Entertainment">Entertainment</div>
            <div class="categoryItem"><img src="images/pexels-cottonbro-3661243.jpg" alt="Kids Toys">Kiddies</div>
        </div>
    <button class="popularCategoriesScrollRight">&gt;</button>
</div>
<div class="bestCarDealsContainer">     <!-- this is essentially a feature section can be interchanged when needed-->
    <h2>Best Car Deals</h2>
    <a href="#">View All</a>
    <button class="bestCarDealsScrollLeft">&lt;</button>
        <div class="bestCarDeals">
            <div class="carItem"><img src="images/pexels-bradley-de-melo-742237632-19165516.jpg" alt="2008 Volkswagen GTI"><b>R 200 000</b><br>2008 Volkswagen GTI</div>
            <div class="carItem"><img src="images/pexels-framesbyambro-14776719.jpg" alt="2018 BMW 320D MSPORT Auto"><b>R 180 000</b><br>2018 BMW 320D MSPORT Auto</div>
            <div class="carItem"><img src="images/pexels-lenzatic-17157308.jpg" alt="2017 Ford Maverick"><b>R 210 000</b><br>2017 Ford Maverick</div>
            <div class="carItem"><img src="images/pexels-introspectivedsgn-17519357.jpg" alt="2019 Toyota 4 Runner"><b>R 275 000</b><br>2019 Toyota 4 Runner</div>
            <div class="carItem"><img src="images/pexels-iwan-wasyl-3786626-5625482.jpg" alt="2009 Volkswagen TSI"><b>R 120 000</b><br>2009 Volkswagen TSI</div>
            <div class="carItem"><img src="images/pexels-gasparzaldo-8671336.jpg" alt="1999 Toyota Hilux 2.4"><b>R 80 000</b><br>1999 Toyota Hilux 2.4</div>
            <div class="carItem"><img src="" alt=""><b></b><br>Test</div>
        </div>
    <button class="bestCarDealsScrollRight">&gt;</button>
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

<div class="cartContainer">
    <div></div>

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
<script src="scripts.js"></script>
<script src="validate.js"></script>
</body>
</html>