<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
if(isset($_POST["name"]))
{
 $query = "DELETE FROM users WHERE username like '".$_POST["user"]."' AND srv IN (SELECT name FROM servers WHERE name = '".$_POST["name"]."')";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>