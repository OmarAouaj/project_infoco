<?php
// Initialize the session
session_start();

$username = "infoco";
$password = "infoco";
$database = "project";
$mysqli = new mysqli("localhost", $username, $password, $database);
$query="UPDATE website_users SET lastlogin = current_time() WHERE id = ".$_SESSION["id"];
$mysqli->query("$query");
$mysqli->close();

 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 

// Redirect to login page
header("location: login.php");
exit;
?>