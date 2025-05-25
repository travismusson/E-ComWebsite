//assign variables using query selector
let homeStrip = document.querySelector(".homeStrip")
let categoryMenu = document.querySelector(".autoHideCat");
let dropdownButton = document.querySelector(".btn_DropDown");
//containers for the different sections
let latestDealsContainer = document.querySelector(".latestDealsContainer");
let topSellersContainer = document.querySelector(".topSellersContainer");
let popularCategoriesContainer = document.querySelector(".popularCategoriesContainer");
let bestCarDealsContainer = document.querySelector(".bestCarDealsContainer");
//changing scroll to have their unique variables to allow for scrolling between different containers
let latestDealsScrollLeft = document.querySelector(".latestDealsScrollLeft");
let latestDealsScrollRight = document.querySelector(".latestDealsScrollRight");
let topSellersScrollLeft = document.querySelector(".topSellersScrollLeft");
let topSellersScrollRight = document.querySelector(".topSellersScrollRight");
let popularCategoriesScrollLeft = document.querySelector(".popularCategoriesScrollLeft");
let popularCategoriesScrollRight = document.querySelector(".popularCategoriesScrollRight");
let bestCarDealsScrollLeft = document.querySelector(".bestCarDealsScrollLeft");
let bestCarDealsScrollRight = document.querySelector(".bestCarDealsScrollRight");
//containers for items in the different sections
let latestDeals = document.querySelector(".latestDeals");
let topSellers = document.querySelector(".topSellers");
let popularCategories = document.querySelector(".popularCategories");
let bestCarDeals = document.querySelector(".bestCarDeals");
//login variables
let loginContainer = document.querySelector(".loginContainer");
let showLoginButton = document.querySelector(".homeStrip .btnShowLogin");
let loginButton = document.querySelector(".btnLogin button");
let closeLoginButton = document.querySelector(".loginContainer .material-symbols-outlined");
let alreadyRegistered = document.querySelector(".showLogin");
//register variables
let registerContainer = document.querySelector(".registerContainer");
let showRegisterButton = document.querySelector(".showRegister");
let registerButton = document.querySelector(".btnRegister button");
let closeRegisterButton = document.querySelector(".registerContainer .material-symbols-outlined");
//blur variable
let blurOverlay = document.querySelector(".blurOverlay");
//hamburger for mobile view and header strip for resizing
let mobileMenu = document.querySelector(".hamburgerBtn");
let headerStrip = document.querySelectorAll(".headerStrip");
// Track whether the menu was toggled by a click
let menuIsToggled = false;
let mobileMenuIsToggled = false;
//let homeStripWidth = document.getElementById(".homestrip").innerHTML = screen.width;      //issue     --fixed
//variables to clear data, this is just a ref so we can clear it
let loginEmail = document.getElementById("loginEmail");
let loginPassword = document.getElementById("loginPassword");
let registerFirstName = document.getElementById("registerFirstName");
let registerLastName = document.getElementById("registerLastName");
let registerEmail = document.getElementById("registerEmail");
let registerPassword = document.getElementById("registerPassword");
let loginEmailError = document.getElementById("emailErrorField");       //i know this isnt great naming conventions
let loginPasswordError = document.getElementById("passwordErrorField");
let registerEmailError = document.getElementById("emailError");
let registerPasswordError = document.getElementById("passwordError");
let registerFirstNameError = document.getElementById("firstNameError");
let registerLastNameError = document.getElementById("lastNameError");

 
//events
dropdownButton.addEventListener("click", function () {
    //https://www.youtube.com/watch?v=atS_A9HHAVo&ab_channel=BroCode        --ternary operator usage
    menuIsToggled = !menuIsToggled;
    //categoryMenu.style.display = menuIsToggled ? "block" : "none";        //removed for jerky movements //refactor
    categoryMenu.style.opacity = menuIsToggled ? "1" : "0";     //uses a ternary operator to set opacity and visibility accordingly might revert back to if elses for consistency and less complexity (thought id just showcase and test usecase)
    categoryMenu.style.visibility = menuIsToggled ? "visible" : "hidden";  
    // Move Latest Deals when menu is open
    latestDealsContainer.style.transform = menuIsToggled ? "translateY(200px)" : "translateY(0)";
    //move scroll buttons when category menu is open
});

// Hover logic to reveal menu & move Latest Deals
dropdownButton.addEventListener("mouseover", function () {
    //categoryMenu.style.display = "block";         //removed for jerky movements
    if(!menuIsToggled){         //ensures no more overiding the click event causing incosistencies before
        categoryMenu.style.opacity = "1";
        categoryMenu.style.visibility = "visible";
        latestDealsContainer.style.transform = "translateY(200px)";
        topSellersContainer.style.transform = "translateY(200px)";
        popularCategoriesContainer.style.transform = "translateY(200px)";
        bestCarDealsContainer.style.transform = "translateY(200px)";
    }
});

categoryMenu.addEventListener("mouseover", function () {
    //categoryMenu.style.display = "block";     //refactor
    if(!menuIsToggled){         //ensures no more overiding the click event causing incosistencies before
        categoryMenu.style.opacity = "1";
        categoryMenu.style.visibility = "visible";
        latestDealsContainer.style.transform = "translateY(200px)";
        topSellersContainer.style.transform = "translateY(200px)";
        popularCategoriesContainer.style.transform = "translateY(200px)";
        bestCarDealsContainer.style.transform = "translateY(200px)";
    }
});

// Hide menu & reset Latest Deals position when mouse leaves both elements
dropdownButton.addEventListener("mouseout", function () {
    if (!menuIsToggled) {
        //categoryMenu.style.display = "none";      //refactor
        categoryMenu.style.opacity = "0";
        categoryMenu.style.visibility = "hidden"; 
        latestDealsContainer.style.transform = "translateY(0)";
        topSellersContainer.style.transform = "translateY(0)";
        popularCategoriesContainer.style.transform = "translateY(0)";
        bestCarDealsContainer.style.transform = "translateY(0)";
    }
});

categoryMenu.addEventListener("mouseout", function () {
    if (!menuIsToggled) {
        //categoryMenu.style.display = "none";      //refactor
        categoryMenu.style.opacity = "0";
        categoryMenu.style.visibility = "hidden";    
        latestDealsContainer.style.transform = "translateY(0)";
        topSellersContainer.style.transform = "translateY(0)";
        popularCategoriesContainer.style.transform = "translateY(0)";
        bestCarDealsContainer.style.transform = "translateY(0)";
    }
});

latestDealsScrollLeft.addEventListener("click", function(){
    latestDeals.scrollBy({left: -200, behavior: "smooth"});
});

latestDealsScrollRight.addEventListener("click", function(){
    latestDeals.scrollBy({left: 200, behavior: "smooth"});
});

//need to ensure that the other containers are also scrollable      //probs need to use specific classes for each scroll?       --fixed by making unique variables for each scroll
topSellersScrollLeft.addEventListener("click", function(){
    topSellers.scrollBy({left: -200, behavior: "smooth"});
});

topSellersScrollRight.addEventListener("click", function(){
    topSellers.scrollBy({left: 200, behavior: "smooth"});
});

popularCategoriesScrollLeft.addEventListener("click", function(){
    popularCategories.scrollBy({left: -200, behavior: "smooth"});
});

popularCategoriesScrollRight.addEventListener("click", function(){
    popularCategories.scrollBy({left: 200, behavior: "smooth"});
});
bestCarDealsScrollLeft.addEventListener("click", function(){
    bestCarDeals.scrollBy({left: -200, behavior: "smooth"});
});
bestCarDealsScrollRight.addEventListener("click", function(){
    bestCarDeals.scrollBy({left: 200, behavior: "smooth"});
});

//login functionality
//show login container
showLoginButton.addEventListener("click",function(){
    if(loginContainer.style.display === "none" || loginContainer.style.display === ""){
        loginContainer.style.display = "flex";
        blurOverlay.style.display = "block";
    }else{
        loginContainer.style.display = "none";  //hides container again
        blurOverlay.style.display = "none";
    }
    
});
//hide login container
closeLoginButton.addEventListener("click",function(){
    loginContainer.style.display = "none";
    blurOverlay.style.display = "none";
    //clearing text fields      
    //i think this makes it more neater idk, i feel as on one hand its nice to know that the last time you entered was incorrect but
    //on the other i think this makes it look neater.
    loginEmail.value = "";
    loginPassword.value = "";
    loginEmailError.innerHTML = "";
    loginPasswordError.innerHTML = "";
});
//2nd showlogin button (not great but needed for register form)
alreadyRegistered.addEventListener("click", function(){
    registerContainer.style.display="none";
    loginContainer.style.display = "flex";
    blurOverlay.style.display = "block";
})


//register functionality
//show register container
showRegisterButton.addEventListener("click",function(){
    if(registerContainer.style.display ==="none" || registerContainer.style.display ===""){
        registerContainer.style.display = "flex";
        blurOverlay.style.display = "block";
        //needa hide the login
        loginContainer.style.display = "none";
    }else{
        registerContainer.style.display = "none";
        blurOverlay.style.display = "none";
    }
});
closeRegisterButton.addEventListener("click",function(){
    registerContainer.style.display = "none";
    blurOverlay.style.display = "none";
    //clearing text fields
    registerFirstName.value = "";
    registerLastName.value = "";
    registerEmail.value = "";
    registerPassword.value = "";
    registerEmailError.innerHTML = "";
    registerPasswordError.innerHTML = "";
    registerFirstNameError.innerHTML = "";
    registerLastNameError.innerHTML = "";
});

//blur functionality
//added this for user ease to minimize everything by clickthing the blur effect
blurOverlay.addEventListener("click",function(){
    registerContainer.style.display = "none";
    loginContainer.style.display = "none";
    blurOverlay.style.display = "none";
});
//mobile menu functionality

//im spending too much time on this it works for preloaded screensizes, however if user does change the screensize manually it will hide the menu

mobileMenu.addEventListener("click", function(){        
    mobileMenuIsToggled = !mobileMenuIsToggled;
    //could use ternary oeprator here aswell but as mentioned before i just showcased its usecase and learned from it
    if(mobileMenuIsToggled){
        homeStrip.style.opacity = "1";
        homeStrip.style.visibility = "visible";
        homeStrip.style.height = "auto"
        categoryMenu.style.top = "480px"        //works to an extent
    }else{
        homeStrip.style.opacity = "0";
        homeStrip.style.visibility = "hidden";
        homeStrip.style.height = "0"
        categoryMenu.style.top = "250px"        //this works but still icant check for if the user resizes the windows      
    }   
});

//needa change the category to adjust to the above


//this is working, ive blindly stumbled into the solution, im aware of the duplicate essentially 1 controls when screen is resized and the other controls drop down location when mobile hamburger is toggled (so ultimately this is working)
window.addEventListener("resize", function(){
    let screenWidth = this.window.innerWidth;       //this seemed to be the deciding factor, checks current width of the screen size

    if(screenWidth > 624){
        homeStrip.style.opacity = "1";
        homeStrip.style.visibility = "visible";
        homeStrip.style.height = "auto"
        categoryMenu.style.top = "250px"        //works to an extent        had to manually align this and went through a various amount of values
    }else{
        if (!mobileMenuIsToggled) {
            homeStrip.style.opacity = "0";
            homeStrip.style.visibility = "hidden";
            homeStrip.style.height = "0";
            categoryMenu.style.top = "250px"           //arrived at this value
        }
    }
})


//this isnt working so im gonna refactor
/*
window.addEventListener("resize", function(){       //testing resize event listener from w3 schools     //still not working
    if(homeStrip.style.width > "560px"){        //maybe i shouldnt measure the object width but screen width?   //needa do more research
         if(mobileMenuIsToggled){
        homeStrip.style.opacity = "1";
        homeStrip.style.visibility = "visible";
        homeStrip.style.height = "auto"
        //homeStrip.style.transition = "all 0.5s ease-in-out"
        //homeStrip.style.transform = "translateY(200px)";      not workin
        //headerStrip.style.transform = "translateY(200px)";
    }else{
        homeStrip.style.opacity = "0";
        homeStrip.style.visibility = "hidden";
        homeStrip.style.height = "0"
        //homeStrip.style.transition = "all 0.5s ease-in-out"
        //headerStrip.style.height = "0px"
    }   
}
})
*/
/*
if(homeStripWidth > 624){
    mobileMenuIsToggled = false;
}

*/



