<?php
//$loginEmail = $_POST["loginEmail"];
//$loginPassword = $_POST["loginPassword"];
//testing filter_input, gonna also check server side that the data is valid
include("dbconnection.php");    //included to ensure db connection is valid
//needa add session start here to keep user logged in
session_start();      //this is needed to start the session
if(!filter_input(INPUT_POST, "loginEmail", FILTER_VALIDATE_EMAIL)){     //this is good as we are double checkign server side to see if value is working
    echo "Email is invalid";   //temp for debugging
    $_SESSION["error"] = "Email is invalid";      //this will set an error message in the session which will show to user on homepage
    header("Location: index.php");     //this will redirect the user to the home page
    exit;
}else{
    echo "Email is valid <br>";
    $loginEmail = filter_input(INPUT_POST, "loginEmail", FILTER_SANITIZE_EMAIL);       //gonna use filter to sanatize also
};

/*refactor
if(!filter_input(INPUT_POST, "loginPassword", FILTER_VALIDATE_STRING)){     //getting error here as ive used numbers within the test data needa replace with something?
if(strlen(INPUT_POST, "loginPassword") < 6){      //manually checks to see if password is longer than 6 characters as there is no filter_validate equiv
//getting error as only needs 1 arg going to have to temp store variable
*/
$tempPassword = $_POST["loginPassword"];        //not necessary after refactor but ill keep it for now
if(strlen($tempPassword) < 6 || empty($tempPassword)){
    echo "Password is invalid";    //temp for debugging
    $_SESSION["error"] = "Password is invalid";      
    header("Location: index.php");     
    exit;
}else{
    echo("Password is valid <br>");
    //$loginPassword = filter_input(INPUT_POST, "loginPassword", FILTER_SANITIZE_STRING);         //apparently according to W3 schools this is depreciated, after looking at stack overflow + w3 schools ive seen people saying that we need to use htmlspecialchars()/strip_tags()
    //after some reading they dont do same thing, i think im gonna go for strip tags to avoid any tags writing to db
    //strip_tags($tempPassword);
    //not sure if this is redundant     
    //htmlspecialchars($tempPassword);       //might get an error
    //echo ($loginPassword);    //debug
    //refactored above as some pw use special characters
    $loginPassword = $tempPassword;
};


/* refactor
//print_r($_POST); instead of displaying in an array we are going to use vardump
//var_dump($loginEmail, $loginPassword);
//after validation of user input we need to validate that the passwords match user accounts within the database
//testing db querys --this is working now i need to check to see if user matches any of the fields within the table

$query = "SELECT id, Email, Password FROM users";    //debugging users within the db
$result = mysqli_query($db_Conn, $query);  //fetches from db procudeurally

if(mysqli_num_rows($result) > 0){
    //output data
    while($row = mysqli_fetch_assoc($result)){
        echo "id: ".$row["id"]." - Email: ".$row["Email"]." - Password: ".$row["Password"]."<br>";
    }
}else{
    echo "0 Results";
}

$db_Conn->close();
*/

//think im going to have to use bind and secure statements here aswell so lets adjust to use that and select where for fetching exact data i need
$query = "SELECT id, FirstName, LastName, Email, Password, User_Level FROM users WHERE Email = ?";
$stmt = mysqli_prepare($db_Conn, $query);       //creates a prepared statement within our db connection and object (my sql query)
mysqli_stmt_bind_param($stmt, "s", $loginEmail);    //binds the parameter to the statement, s = string
mysqli_stmt_execute($stmt);     //executes the statement
$result = mysqli_stmt_get_result($stmt);    //gets the result of the statement
if($row = mysqli_fetch_assoc($result)){     //this will return the row if it exists (email exists)
    //think i need to add a password check here to see if the password matches the one in the db
    //i need to unhash the password to check if it matches
    if(password_verify($loginPassword, $row["Password"])){      //this checks if the password matches the hashed password returns boolean   //https://www.tutorialspoint.com/php/php_function_password_verify.htm
        echo "User Found: ID: ".$row["id"]." - First Name: ".$row["FirstName"]." - Last Name: ".$row["LastName"]." - Email: ".$row["Email"]." - Password: ".$row["Password"]."- User Level: ".$row["User_Level"]."<br>";       //added user level to check if admin
        //now im gonna needa figure out how to keep user logged in and redirect them to the home page
        //set session variables (according to lecture held by sir)
        $_SESSION["loggedin"] = true;      //this is a boolean to check if user is logged in
        //not sure if i need everything here.
        $_SESSION["id"] = $row["id"];      //this is the id of the user
        $_SESSION["FirstName"] = $row["FirstName"];      //this is the first name of the user
        $_SESSION["LastName"] = $row["LastName"];      //this is the last name of the user
        $_SESSION["Email"] = $row["Email"];      //this is the email of the user
        //$_SESSION["Password"] = $row["Password"];      //this is the password of the user       //might not need this also probs dont want to store this in the session
        $_SESSION["User_Level"] = $row["User_Level"];
        //redirect to home page
        header("Location: index.php");     //this will redirect the user to the home page
        exit;      
    }else{
        echo "Password is incorrect";      //this will show if the password is incorrect
        $_SESSION["error"] = "Password is incorrect";      //this will set an error message in the session
        header("Location: index.php");     
        exit;      
    }
}else{
    echo "No User found matching that Email and Password";
    $_SESSION["error"] = "No User found matching that Email";      //this will set an error message in the session
    header("Location: index.php");     //this will redirect the user to the home page
    exit;      
}

//not sure if i need to do mysqli_close() 
//$db_Conn->close();
//gonna do it as i did it in the register page
mysqli_close($db_Conn);      //this will close the connection to the db


//this is working   https://www.w3schools.com/php/php_mysql_select.asp
//https://www.w3schools.com/php/php_mysql_prepared_statements.asp



?>