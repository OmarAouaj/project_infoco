<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//fetch.php
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
$columns = array('username','grp');
$query = "SELECT u.id,u.username,u.grp FROM users u join servers s on u.srv=s.name WHERE u.srv = '".$_POST["name"]."'";

if(isset($_POST["search"]["value"]))
{
 $query .= ' AND (u.username LIKE "%'.$_POST["search"]["value"].'%" OR u.grp LIKE "%'.$_POST["search"]["value"].'%")';
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
 $sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["id"].'" data-column="username">' . $row["username"] . '</div>';
 $sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["id"].'" data-column="grp">' . $row["grp"] . '</div>';
  $sub_array[] = '<form action="historique.php" method="post">
 <button name="username" style="background-color: #696969" value="'.$row["username"].'" class="btn btn-info">Show User History</button></form>';
$sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["username"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM users";
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