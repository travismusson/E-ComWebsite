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
//let showLoginButton = document.querySelector(".homeStrip .btnShowLogin");       //issue, not showing on other pages, need to fix this
let showLoginButtons = document.querySelectorAll(".btnShowLogin"); //to ensure that the login button is shown on all pages, not just the home page
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
let headerStrip = document.querySelector(".headerStrip");
let lastScrollY = window.scrollY;       //https://www.youtube.com/watch?v=Q_XZk5Vnujw for the ref
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
//moving the footer with the category menu
let footer = document.querySelector(".footerContainer");        //not working
//now that im actually thinking about it would it not be easier to just move the entire body?
//let body = document.querySelector("body");
//weird things happening on zooms with html height
//let html = document.querySelector("html");
//after some research i figured i should maybe test moving the contents margins instead of using transforms

//side nav variables
let btn_NavOpen = document.querySelector(".btnSideNavOpen button");
let btn_NavClose = document.querySelector(".btnSideNavClose button");
let accountSideNavContainer = document.querySelector(".accountSideNavContainer");
//let orderContainer = document.querySelector(".orderContainer");
let navToggle = false;
//adding tabs  https://www.youtube.com/watch?v=fI9VM5zzpu8   || https://www.youtube.com/watch?v=5L6h_MrNvsk || https://www.youtube.com/watch?v=JZa1qMXIiU0 as ref
const tabs = document.querySelectorAll(".accountSideNavData a[data-tab-target]"); // contains all the tabs
const tabContents = document.querySelectorAll(".tabContent"); // contains all the tab contents

//editing user details variables:
let inputPassword = document.getElementById("inputPassword");
let tempPassword = document.getElementById("tempPassword");
let btnEditPassword = document.getElementById("btnEditPassword");
let btnSavePassword = document.getElementById("btnSavePassword");
let btnCancelPassword = document.getElementById("btnCancelPassword");
//2factor edit var
let select2Factor = document.getElementById("select2Factor");
let tempFactor = document.getElementById("tempFactor");
let btnEdit2Factor = document.getElementById("btnEdit2Factor");
let btnSave2Factor = document.getElementById("btnSave2Factor");
let btnCancel2Factor = document.getElementById("btnCancel2Factor");
//name edit
let inputFirstName = document.getElementById("inputFirstName");
let inputLastName = document.getElementById("inputLastName");
let tempName = document.getElementById("tempName");
let btnEditName = document.getElementById("btnEditName");
let btnSaveName = document.getElementById("btnSaveName");
let btnCancelName = document.getElementById("btnCancelName");
//temp initialization
let originalFirstName = "";
let originalLastName = "";
//email var
let inputEmail = document.getElementById("inputEmail");
let tempEmail = document.getElementById("tempEmail");
let btnEditEmail = document.getElementById("btnEditEmail");
let btnSaveEmail = document.getElementById("btnSaveEmail");
let btnCancelEmail = document.getElementById("btnCancelEmail");
//temp
let originalEmail = "";


if (tabs.length > 0) {
    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            // Remove active from all tabs and contents
            tabs.forEach(t => t.classList.remove("active"));
            tabContents.forEach(tabContent => tabContent.classList.remove("active"));

            // Add active to clicked tab and its content
            tab.classList.add("active");
            const target = document.querySelector(tab.dataset.tabTarget);
            if (target) {
                target.classList.add("active");
            }
        });
    });

    // Show first tab by default
    tabs[0].classList.add("active");
    const firstTabTarget = tabs[0].dataset.tabTarget;
    const firstTabContent = document.querySelector(firstTabTarget);
    if (firstTabContent) {
        firstTabContent.classList.add("active");
    }
}

/*
function parseURLParams(){      //did find this ima try https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams  || https://stackoverflow.com/questions/814613/how-to-read-get-data-from-a-url-using-javascript || I dunno this is taking alotta time to research ima just leave it for now
    let params = new URLSearchParams(location.search);
    let tab = params.get('tab');       //get the tab parameter from the url
    console.log("Tab from URL:", tab);       //debugging
    return tab;       //return the tab parameter
}
*/

//need to find a way to read the url;
//if(window.location.href.includes("accounttabs.php")){      //if the url contains accounttabs.php then we need to read the url ; its too late for this for now im gonna try brute force it
    
//}
//Events
//added this at the top to fix not loading error in the script (temp fix, i know its not the best practice)     --its here as its not used across the pages, and im using a full load script page not dedicated functions for actions but im very late into this to change now  --update added to all relevant functions, this ensures that nothing is null causing errors 
if(btn_NavOpen && btn_NavClose && accountSideNavContainer){
btn_NavOpen.addEventListener("click", function(){
        //testing width changing
        navToggle = !navToggle;        //toggle the nav toggle variable
        accountSideNavContainer.style.width = navToggle ? "250px" : "0px";      //yeh i prefer this method in this context, when i tried it on other menu elements it wasnt what i wanted , also added a tenerary operator for toggling  --issue for mobile view atm
        accountSideNavContainer.style.visibility = navToggle ? "visible" : "hidden"; // Show or hide the side nav based on the toggle added back for moving orderContainer
        //orderContainer.style.marginLeft = navToggle ? "250px" : "0px"; // Move orderContainer when side nav is open
        //alert("Clicked Open Side Nav");    //testing  
    });
btn_NavClose.addEventListener("click", function(){
    navToggle = false;        //reset nav toggle variable
    accountSideNavContainer.style.visibility = "hidden";
        //testing width changing
    accountSideNavContainer.style.width = "0px";
        //orderContainer.style.marginLeft = "0px"; // Reset orderContainer margin when side nav is closed
        //alert("Clicked Close Side Nav");
    });

}

if(dropdownButton && categoryMenu && latestDealsContainer){     //if not null
dropdownButton.addEventListener("click", function () {
    //https://www.youtube.com/watch?v=atS_A9HHAVo&ab_channel=BroCode        --ternary operator usage
    menuIsToggled = !menuIsToggled;
    //categoryMenu.style.display = menuIsToggled ? "block" : "none";        //removed for jerky movements //refactor
    categoryMenu.style.opacity = menuIsToggled ? "1" : "0";     //uses a ternary operator to set opacity and visibility accordingly might revert back to if elses for consistency and less complexity (thought id just showcase and test usecase)
    categoryMenu.style.visibility = menuIsToggled ? "visible" : "hidden";  
    // Move Latest Deals when menu is open
    //latestDealsContainer.style.transform = menuIsToggled ? "translateY(250px)" : "translateY(0)";
    //margin move test      --nope doesnt fix my issue
    latestDealsContainer.style.marginTop = menuIsToggled ? "250px" : "0"; // Move Latest Deals down when menu is open
    //move scroll buttons when category menu is open
});

// Hover logic to reveal menu & move Latest Deals
dropdownButton.addEventListener("mouseover", function () {
    //categoryMenu.style.display = "block";         //removed for jerky movements
    if(!menuIsToggled){         //ensures no more overiding the click event causing incosistencies before
        categoryMenu.style.opacity = "1";
        categoryMenu.style.visibility = "visible";

        //body.style.transform = "translateY(250px)"; // Move body down when menu is open       //works but moves headerstrip aswell
        //latestDealsContainer.style.transform = "translateY(250px)";
        //topSellersContainer.style.transform = "translateY(250px)";
        //popularCategoriesContainer.style.transform = "translateY(250px)";
        //bestCarDealsContainer.style.transform = "translateY(250px)";
        //footer.style.transform = "translateY(250px)"; // Move footer down when menu is open

        //html.style.height = "135%"; // weirdly working not sure how else to go about this.
        //html.style.transform = "translateY(-250px)"; // Move html down when menu is open
        //html.style.height = "135%"; //

        //testing margin move
        latestDealsContainer.style.marginTop = "250px";         //i mean its working its animation isnt smooth tho. added animation to css, this is now working how i want.
        
        //these arnt needed after some testing
        //topSellersContainer.style.marginTop = "250px"; 
        //popularCategoriesContainer.style.marginTop = "250px"; 
        //bestCarDealsContainer.style.marginTop = "250px"; 
        //footer.style.marginTop = "250px"; 
    }
});
}
if(categoryMenu && latestDealsContainer){     //if not null
categoryMenu.addEventListener("mouseover", function () {
    //categoryMenu.style.display = "block";     //refactor
    if(!menuIsToggled){         //ensures no more overiding the click event causing incosistencies before
        categoryMenu.style.opacity = "1";
        categoryMenu.style.visibility = "visible";

        //latestDealsContainer.style.transform = "translateY(250px)";
        //topSellersContainer.style.transform = "translateY(250px)";
        //popularCategoriesContainer.style.transform = "translateY(250px)";
        //bestCarDealsContainer.style.transform = "translateY(250px)";
        //footer.style.transform = "translateY(250px)";

        //html.style.height = "135%"; 

        latestDealsContainer.style.marginTop = "250px"; 
         
    }
});
}

// Hide menu & reset Latest Deals position when mouse leaves both elements
if(dropdownButton && categoryMenu && latestDealsContainer){     //if not null
dropdownButton.addEventListener("mouseout", function () {
    if (!menuIsToggled) {
        //categoryMenu.style.display = "none";      //refactor
        categoryMenu.style.opacity = "0";
        categoryMenu.style.visibility = "hidden"; 

        //latestDealsContainer.style.transform = "translateY(0)";
        //topSellersContainer.style.transform = "translateY(0)";
        //popularCategoriesContainer.style.transform = "translateY(0)";
        //bestCarDealsContainer.style.transform = "translateY(0)";
        //footer.style.transform = "translateY(0)"; // Reset footer position when menu is closed

        //html.style.height = "100%";

        latestDealsContainer.style.marginTop = "0"; 
        
    }
});
dropdownButton.addEventListener("mouseout", function () {
    if (!menuIsToggled) {
        //categoryMenu.style.display = "none";      //refactor
        categoryMenu.style.opacity = "0";
        categoryMenu.style.visibility = "hidden"; 

        //latestDealsContainer.style.transform = "translateY(0)";
        //topSellersContainer.style.transform = "translateY(0)";
        //popularCategoriesContainer.style.transform = "translateY(0)";
        //bestCarDealsContainer.style.transform = "translateY(0)";
        //footer.style.transform = "translateY(0)"; // Reset footer position when menu is closed

        //html.style.height = "100%";

        latestDealsContainer.style.marginTop = "0"; 
        
    }
});
}
if(categoryMenu && latestDealsContainer){     //if not null
categoryMenu.addEventListener("mouseout", function () {
    if (!menuIsToggled) {
        //categoryMenu.style.display = "none";      //refactor
        categoryMenu.style.opacity = "0";
        categoryMenu.style.visibility = "hidden"; 

        //esentially a big refactor below, makes script handling alot more compact
        //latestDealsContainer.style.transform = "translateY(0)";
        //topSellersContainer.style.transform = "translateY(0)";
        //popularCategoriesContainer.style.transform = "translateY(0)";
        //bestCarDealsContainer.style.transform = "translateY(0)";
        //footer.style.transform = "translateY(0)"; 

        //html.style.height = "100%";

        latestDealsContainer.style.marginTop = "0";
        

    }
});
}
if(latestDealsScrollLeft && latestDealsScrollRight && latestDeals){     //if not null
latestDealsScrollLeft.addEventListener("click", function(){
    latestDeals.scrollBy({left: -200, behavior: "smooth"});
});

latestDealsScrollRight.addEventListener("click", function(){
    latestDeals.scrollBy({left: 200, behavior: "smooth"});
});
}
if(topSellersScrollLeft && topSellersScrollRight && topSellers){     //if not null
//need to ensure that the other containers are also scrollable      //probs need to use specific classes for each scroll?       --fixed by making unique variables for each scroll
topSellersScrollLeft.addEventListener("click", function(){
    topSellers.scrollBy({left: -200, behavior: "smooth"});
});

topSellersScrollRight.addEventListener("click", function(){
    topSellers.scrollBy({left: 200, behavior: "smooth"});
});
}
if(popularCategoriesScrollLeft && popularCategoriesScrollRight && popularCategories){     //if not null
popularCategoriesScrollLeft.addEventListener("click", function(){
    popularCategories.scrollBy({left: -200, behavior: "smooth"});
});

popularCategoriesScrollRight.addEventListener("click", function(){
    popularCategories.scrollBy({left: 200, behavior: "smooth"});
});
}
if(bestCarDealsScrollLeft && bestCarDealsScrollRight && bestCarDeals){     //if not null
bestCarDealsScrollLeft.addEventListener("click", function(){
    bestCarDeals.scrollBy({left: -200, behavior: "smooth"});
});
bestCarDealsScrollRight.addEventListener("click", function(){
    bestCarDeals.scrollBy({left: 200, behavior: "smooth"});
});
}
//login functionality
//show login container
if(showLoginButtons && loginContainer && blurOverlay){     //if not null
showLoginButtons.forEach(function(showLoginButton){     //foreach loop to ensure that all buttons are added the event listener
    showLoginButton.addEventListener("click",function(){
        if(loginContainer.style.display === "none" || loginContainer.style.display === ""){
            loginContainer.style.display = "flex";
            blurOverlay.style.display = "block";
        }else{
            loginContainer.style.display = "none";  //hides container again
            blurOverlay.style.display = "none";
        }

    });
});
}
//hide login container
if(closeLoginButton && loginContainer && blurOverlay){     //if not null
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
}
//2nd showlogin button (not great but needed for register form)
if(alreadyRegistered && loginContainer && registerContainer && blurOverlay){     //if not null
alreadyRegistered.addEventListener("click", function(){
    registerContainer.style.display="none";
    loginContainer.style.display = "flex";
    blurOverlay.style.display = "block";
})
}

//register functionality
//show register container
if(showRegisterButton && registerContainer && loginContainer && blurOverlay){     //if not null
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
}
if(closeRegisterButton && registerContainer && blurOverlay){     //if not null
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
}
//blur functionality
//added this for user ease to minimize everything by clickthing the blur effect
if(blurOverlay && registerContainer && loginContainer){     //if not null
blurOverlay.addEventListener("click",function(){
    registerContainer.style.display = "none";
    loginContainer.style.display = "none";
    blurOverlay.style.display = "none";
});
}
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
        categoryMenu.style.top = "200px"        //this works but still icant check for if the user resizes the windows      
    }   
});

//needa change the category to adjust to the above



//this is working, ive blindly stumbled into the solution, im aware of the duplicate essentially 1 controls when screen is resized and the other controls drop down location when mobile hamburger is toggled (so ultimately this is working)
if(homeStrip && categoryMenu){     //if not null
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
            categoryMenu.style.top = "200px"           //arrived at this value
        }
    }
});
};

//gonna enable hidden nav bar for scroll behaviour      //https://www.youtube.com/watch?v=Q_XZk5Vnujw for ref
window.addEventListener("scroll", () => {       
    if(lastScrollY < window.scrollY){
        console.log("Scrolling Down");      //for debug
        headerStrip.classList.add("nav--hidden");
    }else{
        console.log("Scrolling Up");
        headerStrip.classList.remove("nav--hidden");
    }

    lastScrollY = window.scrollY;
});



function editPassword(){
    inputPassword.style.display = "block";
    btnSavePassword.style.display = "inline-block";
    btnCancelPassword.style.display = "inline-block";
    tempPassword.style.display = "none";
    btnEditPassword.style.display = "none";

    inputPassword.focus();      /*sets focus to the input*/
}

function savePassword(){
//pw client side validation
    if(inputPassword.value.trim() === ""){
        alert("Please Enter a Password!");
        return;
    }else if(inputPassword.value.length < 6){
        alert("Password must be at least 6 characters in length");
        return;
    }

    //reset visibility
    inputPassword.style.display ="none";
    btnSavePassword.style.display = "none";
    btnCancelPassword.style.display = "none";
    tempPassword.style.display = "block";
    btnEditPassword.style.display = "block";
    //debug
    //alert(inputPassword.value)
    
}

function cancelPassword(){
    inputPassword.value = "";
    inputPassword.style.display ="none";
    btnSavePassword.style.display = "none";
    btnCancelPassword.style.display = "none";
    tempPassword.style.display = "block";
    btnEditPassword.style.display = "block";
}

function edit2Factor(){
    select2Factor.style.display = "block";
    btnSave2Factor.style.display = "inline-block";
    btnCancel2Factor.style.display = "inline-block";
    tempFactor.style.display = "none";
    btnEdit2Factor.style.display = "none";

    select2Factor.focus();      /*sets focus to the select*/
}

function save2Factor(){
//pw client side validation
    if(!select2Factor.value){
        alert("Please Select a 2Factor!");
        return;
    }

    //reset visibility
    select2Factor.style.display ="none";
    btnSave2Factor.style.display = "none";
    btnCancel2Factor.style.display = "none";
    tempFactor.style.display = "block";
    tempFactor.innerHTML = select2Factor.value;
    btnEdit2Factor.style.display = "block";
    //debug
    //alert(inputPassword.value)
    
}

function cancel2Factor(){
    select2Factor.value = 0;        //needa check --works
    select2Factor.style.display ="none";
    btnSave2Factor.style.display = "none";
    btnCancel2Factor.style.display = "none";
    tempFactor.style.display = "block";
    btnEdit2Factor.style.display = "block";
}

//name


function editName(){
    //put it here incase user messes up
    originalFirstName = inputFirstName.value;
    originalLastName = inputLastName.value;

    inputFirstName.style.display = "block";
    inputLastName.style.display = "block";
    btnEditName.style.display = "none";
    btnSaveName.style.display = "inline-block";
    btnCancelName.style.display = "inline-block";
    tempName.style.display = "none";
    

    inputFirstName.focus();      /*sets focus to the input*/
}

function saveName(){
//pw client side validation
    if(inputFirstName.value.trim() === ""){
        alert("Please Enter a First Name!");
        return;
    }else if(inputLastName.value.trim() ===""){
        alert("Please Enter a Last Name!");
        return;
    }

    //reset visibility
    inputFirstName.style.display = "none";
    inputLastName.style.display = "none";
    btnSaveName.style.display = "none";
    btnCancelName.style.display = "none";
    tempName.innerHTML = inputFirstName.value.trim() + " " + inputLastName.value.trim()
    tempName.style.display = "block";
    btnEditName.style.display = "block";
    //debug
    //alert(inputPassword.value)
    
}

function cancelName(){
    //think ima not reset this as it might cause issues
    //inputFirstName.value = "";      //might remove session variables in this instance(until page is reloaded)
    //inputLastName.value = "";
    //fixed by using a temp var
    inputFirstName.value = originalFirstName;
    inputLastName.value = originalLastName;
    inputFirstName.style.display = "none";
    inputLastName.style.display = "none";
    btnSaveName.style.display = "none";
    btnCancelName.style.display = "none";
    tempName.style.display = "block";
    btnEditName.style.display = "block";
}

//email

function editEmail(){
    //put it here incase user messes up
    originalEmail = inputEmail.value;
    inputEmail.style.display = "block";
    btnEditEmail.style.display = "none";
    btnSaveEmail.style.display = "inline-block";
    btnCancelEmail.style.display = "inline-block";
    tempEmail.style.display = "none";
    inputEmail.focus();      /*sets focus to the input*/
}

function saveEmail(){
//pw client side validation
    if(inputEmail.value.trim() === ""){
        alert("Please Enter an Email!");
        return;
    }
    //reset visibility
    inputEmail.style.display = "none";
    btnSaveEmail.style.display = "none";
    btnCancelEmail.style.display = "none";
    tempEmail.innerHTML = inputEmail.value;
    tempEmail.style.display = "block";
    btnEditEmail.style.display = "block";
    //debug
    //alert(inputPassword.value)
    
}

function cancelEmail(){
    
    inputEmail.value = originalEmail;
    inputEmail.style.display = "none";
    btnSaveEmail.style.display = "none";
    btnCancelEmail.style.display = "none";
    tempEmail.style.display = "block";
    btnEditEmail.style.display = "block";
}



/*
btn_NavOpen.addEventListener("click", function(){
    accountSideNavContainer.style.display = "flex";
    alert("Clicked Open Side Nav");
});
btn_NavClose.addEventListener("click", function(){
    accountSideNavContainer.style.display = "none";
    alert("Clicked Close Side Nav");
});
*/



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


//function for side nav
/*
function sideNavOpen(){
    document.getElementById("accountSideNavContainer").style.width = "500px";
}

function sideNavClose(){
    document.getElementById("accountSideNavContainer").style.width = "0px";
}
*/


