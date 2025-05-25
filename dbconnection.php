<?php
//brocode help  https://www.youtube.com/watch?v=-1DTYAQ25bY&ab_channel=BroCode
//variables
$db_Server = "localhost";
$db_User = "root";
$db_Pass = "";      //temp
$db_Name = "Website_DB";
$db_Conn = "";
//try catch connection to ensure successful db connection and user error showcasing
try{
    $db_Conn = mysqli_connect($db_Server, $db_User, $db_Pass, $db_Name);        //procedural approach
}catch(mysqli_sql_exception){
    echo("Could not connect <br>");
}
//debug can comment out later
/*
if($db_Conn){
    echo("You are connected <br>");
}
*/

?>