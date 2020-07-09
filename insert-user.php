<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$grp=$_POST["group"];
$name=$_POST["name"];
$user=$_POST["user"];
$username=$_POST["username"];
$pwd=$_POST["pwd"];

$result=exec("python python/create-user.py $name $user $username $pwd $grp");
if($result=="ok"){
 		echo 'Data Inserted';}
 		elseif($result=="exists"){
 			echo '<script>alert("User already exists..")</script>';
 		}
 		else{
 			echo '<script>alert("SSH unsuccessful, check your server state..")</script>';
 		}