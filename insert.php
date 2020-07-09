<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
$state = "";

if(isset($_POST["name"], $_POST["ip"], $_POST["state"]))
{
 $name = mysqli_real_escape_string($connect, $_POST["name"]);
 $ip = mysqli_real_escape_string($connect, $_POST["ip"]);
 $state = mysqli_real_escape_string($connect, $_POST["state"]);
 if($state=="up"){
 	$username = mysqli_real_escape_string($connect, $_POST["username"]);
 	$pwd = mysqli_real_escape_string($connect, $_POST["pwd"]);
 }
 $sql = "SELECT * FROM servers WHERE ip = ?";
 $number=0;
if($stmt = mysqli_prepare($connect, $sql)){
	mysqli_stmt_bind_param($stmt, "s", $param_ip);
	$param_ip = $ip;
	if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                $number=mysqli_stmt_num_rows($stmt);}}



 if($number < 1){
 	if($state == "up"){
 		$result=exec("python python/add-server.py $name $ip $username $pwd $state");
 		if($result=="ok"){
 		echo 'Data Inserted';}
 		else{
 			echo '<script>alert("SSH unsuccessful, check your server state..")</script>';
 		}
 	}
 	else{
 		$query = "INSERT INTO servers(name, ip, state) VALUES('$name', '$ip', '$state')";
 		if(mysqli_query($connect, $query))
	 	{
	  		echo 'Data Inserted';
	 	}

 	}}
 else{
			echo "<script>alert('IP already exists in the database')</script>";
		}



 
}
?>