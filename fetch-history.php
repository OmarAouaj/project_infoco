<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//fetch.php
$username=$_POST["username"];
$user=$_POST["user"];
$pwd=$_POST["pwd"];

exec("python python/history.py $username $user $pwd");

$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
$columns = array('history');
$query = "SELECT id,history FROM history WHERE server IN (SELECT srv FROM users WHERE username LIKE '".$user."')";

if(isset($_POST["search"]["value"]))
{
 $query .= ' AND history LIKE "%'.$_POST["search"]["value"].'%"';
}


if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= ' ORDER BY id DESC ';
}

$query1 = ' ';
if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query . $query1));


$result = mysqli_query($connect, $query . $query1);
$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div contenteditable="false" style="text-align:center" class="update" data-id="'.$row["id"].'" data-column="history">' . $row["history"] . '</div>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM history";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>