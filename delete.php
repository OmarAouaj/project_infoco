<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM servers WHERE id = '".$_POST["id"]."'";
 $query1 = "DELETE FROM users WHERE srv IN (SELECT name FROM servers WHERE id = '".$_POST["id"]."')";
 if(mysqli_query($connect, $query) && mysqli_query($connect,$query1))
 {
  echo 'Data Deleted';
 }
}
?>