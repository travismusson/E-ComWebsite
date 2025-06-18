<?php
//https://www.youtube.com/watch?v=Y9yE98etanU&ab_channel=DaveHollingworth       //for db connection and using perpared statement and php binding
//$registerEmail = $_POST["registerEmail"];
//$registerPassword = $_POST["registerPassword"];
include("dbconnection.php");        //included to ensure db connection is valid
//testing adding session to keep track of session variables
session_start();      
$registerFirstName = $_POST["registerFirstName"];
$registerLastName = $_POST["registerLastName"];
//using php filter ref here for the multiple filters
if(empty($registerFirstName) || !preg_match("/^[a-zA-Z]*$/", $registerFirstName)){   //using this to check if the first not empty and using preg_match to check if it only contains letters according to stack overflow
    //die("First Name is invalid");   //temp for debugging, stops script
    $_SESSION["error"] = "First Name is invalid";  //using session to store error message
    header("Location: index.php");     //redirect to register page
    exit;
}else{
    echo("First Name is valid <br>");
    $registerFirstName = filter_input(INPUT_POST, "registerFirstName", FILTER_SANITIZE_SPECIAL_CHARS);       //gonna use filter to sanatize also
}
if(empty($registerLastName) || !preg_match("/^[a-zA-Z]*$/", $registerLastName)){
    //die("Last Name is invalid");   //temp for debugging, stops script
    $_SESSION["error"] = "Last Name is invalid";  //using session to store error message
    header("Location: index.php");     //redirect to register page
    exit;
}else{
    echo("Last Name is valid <br>");
    $registerLastName = filter_input(INPUT_POST, "registerLastName", FILTER_SANITIZE_SPECIAL_CHARS);       //gonna use filter to sanatize also
}
if(!filter_input(INPUT_POST, "registerEmail", FILTER_VALIDATE_EMAIL)){     //this is good as we are double checkign server side to see if value is working
    //die("Email is invalid");   //temp for debugging, stops script
    $_SESSION["error"] = "Email is invalid";  //using session to store error message
    header("Location: index.php");     //redirect to register page
    exit;
}else{
    echo("Email is valid <br>");
    $registerEmail = filter_input(INPUT_POST, "registerEmail", FILTER_SANITIZE_EMAIL);       //gonna use filter to sanatize also
};

//checking password validation
$tempPassword = $_POST["registerPassword"];     //thinking i should have a popup to ask user to confirm password
if(strlen($tempPassword) < 6 ){
    //die("Password is invalid");    //temp for debugging
    $_SESSION["error"] = "Password is invalid";  //using session to store error message
    header("Location: index.php");     //redirect to register page
    exit;
}else{
    echo("Password is valid <br>");
    strip_tags($tempPassword);
    $registerPassword = $tempPassword;
};
//now its time to check if the email already exists in the db
$sql = "SELECT * FROM users WHERE Email='$registerEmail'";      //query to check if user email exists
$check = mysqli_query($db_Conn, $sql);
if(mysqli_num_rows($check) > 0){
    //die ("User Email already exists");
    $_SESSION["error"] = "User Email already exists";  //using session to store error message
    header("Location: index.php");     //redirect to register page
    exit;
}else{
    //need to hash pw also
    $hashPassword = password_hash($registerPassword, PASSWORD_DEFAULT);
    //need to check if user exists before inserting going to add that code now^
    //i need to generate a username here using first part of email and user can change it later maybe in register field we should have a username? -- not generating username for now added it in the register form
    $sql = "INSERT INTO users (FirstName, LastName, Email, Password)
    VALUES (?, ?, ?, ?)";    //this is used to prevent vulnerabilties this is known as a prepared statement (using placeholders)
    $stmt = mysqli_stmt_init($db_Conn);
        if(!mysqli_stmt_prepare($stmt, $sql,)){
            die(mysqli_error($db_Conn));        //might get error here due to connection being in a seperate file
        }
    mysqli_stmt_bind_param($stmt, "ssss", $registerFirstName, $registerLastName, $registerEmail, $hashPassword);     //using a bind, passing in parameter 2 strings i dont know if this will work as we have an email and pw     //doesnt seem that php.net has that in its types
    mysqli_stmt_execute($stmt);
    echo "Record has been saved";       //WORKING YAY!!!!!
    header("Location: index.php");     //move to home page this will bypass all the error checking so will comment out for testing -- renabled
    $_SESSION['error'] = "Please login to confirm account creation";        //added this to curve the issue i was having before
    //thinking as ive added session i should log user in automatically after registration
    /*  gonna refactor this as im getting a bug with loggin user in like this
    $_SESSION["loggedin"] = true;      //set session variable to true
    $_SESSION["FirstName"] = $registerFirstName;      //set session variable for first name
    $_SESSION["LastName"] = $registerLastName;        //set session variable for last name
    */
    exit;
}

//close connection
mysqli_close($db_Conn);






//print_r($_POST); instead of displaying in an array we are going to use vardump
//var_dump($registerEmail, $registerPassword);      //just used for debug

?>