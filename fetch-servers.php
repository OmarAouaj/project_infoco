<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//fetch.php
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
$columns = array('name', 'mac', 'ip', 'totalstorage', 'availstorage','totalram','availram','state');
$query = "SELECT * FROM servers";

if(isset($_POST["search"]["value"]))
{
 $query .= ' WHERE name LIKE "%'.$_POST["search"]["value"].'%" OR ip LIKE "%'.$_POST["search"]["value"].'%" OR state LIKE "%'.$_POST["search"]["value"].'%" OR os LIKE "%'.$_POST["search"]["value"].'%" OR os LIKE "%'.$_POST["search"]["value"].'%" OR totalstorage LIKE "%'.$_POST["search"]["value"].'%" OR availstorage LIKE "%'.$_POST["search"]["value"].'%" OR totalram LIKE "%'.$_POST["search"]["value"].'%" OR availram LIKE "%'.$_POST["search"]["value"].'%"';
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
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="name">' . $row["name"] . '</div>';
 $sub_array[] = '<div contenteditable="false" class="update" data-id="'.$row["id"].'" data-column="mac">' . $row["mac"] . '</div>';
  $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="ip">' . $row["ip"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="os">' . $row["os"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="totalstorage">' . $row["totalstorage"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="availstorage">' . $row["availstorage"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="totalram">' . $row["totalram"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="availram">' . $row["availram"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="state">' . $row["State"] . '</div>';
  $sub_array[] = '<form action="users.php" method="post">
 <button style="background-color: #696969" name="id" value="'.$row["id"].'" data-value="'.$row["name"].'" class="btn btn-info">Show Users</button></form>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM servers";
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