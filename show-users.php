<?php
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
if(isset($_POST["id"]))
{
 $query = "SELECT u.username,u.grp FROM users u join servers s on u.srv=s.name WHERE s.id = '".$_POST["id"]."'";
 $result=mysqli_query($connect, $query);

 }
?>