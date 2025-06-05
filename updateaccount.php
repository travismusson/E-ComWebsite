<?php
session_start();
include("dbconnection.php");
echo '<style>body{background:linear-gradient(to top,#686868,rgb(54,54,54))!important;}</style>';

if(!isset($_SESSION['id'])){
    echo "Please Sign In!";
    header("Location: index.php");
    exit;
}else{
    $userID = $_SESSION['id'];
};
//geting posted var
if(isset($_POST['inputFirstName']) && $_POST['inputFirstName'] !== ''){     //checking if set and not null
    $firstName = $_POST['inputFirstName'];
    echo "First Name Set";      //debug
};
if(isset($_POST['inputLastName']) && $_POST['inputLastName'] !== ''){     //checking if set and not null
    $lastName = $_POST['inputLastName'];
    echo "Last Name Set";      //debug
};
if(isset($_POST['inputEmail']) && $_POST['inputEmail'] !== ''){     //checking if set and not null
    $email = $_POST['inputEmail'];
    echo "Email Set";      //debug
};
if(isset($_FILES['profileImage'])){
    //profile image handeling
if(isset($_POST['addImage'])){
    //var
    $fileName = $_FILES['profileImage']['name']; //getting file name
    $fileTmpName = $_FILES['profileImage']['tmp_name'];
    $folder = "images/".$fileName;
    $userID = $_SESSION['id'];      //dont think i need this here
    $sql = "UPDATE users SET Profile_IMG_DIR = ? WHERE id = ?";        //https://www.w3schools.com/php/php_mysql_update.asp needa use updaet here
    $stmt = mysqli_prepare($db_Conn, $sql);
    if(!$stmt){
        echo "Error preparing statement";
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
}

?>