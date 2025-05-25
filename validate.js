//console.log("validate.js loaded!");

function ValidateLogin(){
    //console.log("ValidateLogin loaded!");
    //variables
    let loginEmail = document.getElementById("loginEmail").value.trim();
    let loginPassword = document.getElementById("loginPassword").value.trim();
    let emailError = document.getElementById("emailErrorField");
    let passwordError = document.getElementById("passwordErrorField");
    //defaults
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    let isValid = true;
    emailError.innerHTML = "";
    passwordError.innerHTML = "";
    

    if(loginEmail === "" || !loginEmail.match(emailPattern)){
        emailError.innerHTML = "Email is Invalid, Please Enter a Valid Email <br>";
        isValid = false;
    }
    if(loginPassword === ""){
        passwordError.innerHTML = "Password is Invalid, Please Enter a Valid Password <br>";
        isValid = false;
    }else if(loginPassword.length < 6){
        passwordError.innerHTML = "Your Password is too short, please enter a valid password longer than 6 characters <br>"
        isValid = false;
    }
    
    //else{
        //redirect to php
        //window.location.href = "login.php";     //might not be the best practice but im testing
        //gonna stick to isvalid
    //}
    //console.log("Validation result:", isValid); // Debugging result

    return isValid;
}

function ValidateRegister(){
    //console.log("ValidateRegister loaded!");
    //variables
    let registerFirstName = document.getElementById("registerFirstName").value;
    let registerLastName = document.getElementById("registerLastName").value;
    let registerEmail = document.getElementById("registerEmail").value.trim();
    let registerPassword = document.getElementById("registerPassword").value.trim();
    let emailError = document.getElementById("emailError");     //nameing conven very similair to above function i know... i would probs change this in final release
    let passwordError = document.getElementById("passwordError");
    let firstNameError = document.getElementById("firstNameError");
    let lastNameError = document.getElementById("lastNameError");
    //defaults
    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/ ;
    let namePattern = /^[a-zA-Z]+$/; // regex to check if the name contains only letters
    emailError.innerHTML = "";
    passwordError.innerHTML = "";
    firstNameError.innerHTML = "";
    lastNameError.innerHTML = "";
    let isValid = true;
    //check if empty
    //check if no numbers are in the name
    if(registerFirstName === "" || !registerFirstName.match(namePattern)){       //uses regex to check if there are any numbers in the name
        firstNameError.innerHTML = "First Name is Invalid, Please Enter a Valid First Name <br>";
        isValid = false;
    }
    //check if no numbers are in the last name
    if(registerLastName === "" || !registerLastName.match(namePattern)){    //uses regex to check if there are any numbers in the name
        lastNameError.innerHTML = "Last Name is Invalid, Please Enter a Valid Last Name <br>";
        isValid = false;
    }
    if(registerEmail === "" || !registerEmail.match(emailPattern)){
        emailError.innerHTML = "Email is Invalid, Please Enter a Valid Email <br>";
        isValid = false;
    }
    if(registerPassword === ""){
        passwordError.innerHTML = "Password is Invalid, Please Enter a Valid Password <br>";
        isValid = false;
    }else if(registerPassword.length < 6){
        passwordError.innerHTML = "Your Password is too short, please enter a valid password longer than 6 characters <br>"
        isValid = false;
    }
    //console.log("Validation result:", isValid); // Debugging result

    return isValid;

}