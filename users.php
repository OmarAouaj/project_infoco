<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$connect = mysqli_connect("localhost", "infoco", "infoco", "project");
$query = "SELECT name FROM servers WHERE id = '".$_POST["id"]."'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
$name=$row['name'];
?>
<html>
 <head>
  <title>Users Of <?php echo $name;?></title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:1270px;
   padding:20px;
   background-color:#fff;
   border:1px solid #ccc;
   border-radius:5px;
   margin-top:25px;
   box-sizing:border-box;
  }
  </style>
   <style>
      .topnav {
  overflow: hidden;
  background-color: grey;
  position: relative;
}

.topnav #myLinks {
  display: none;
}

.topnav a {
  color: white;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 25px;
  display: block;
}

.topnav a.icon {
  background: black;
  display: block;
  position: absolute;
  right: 0;
  top: 0;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.active {
  background-color: #000000;
  color: white;
}
</style>
 </head>
 <body style="background-color: #ffffff">
    <div class="topnav">
  <a href="#" class="active"><img src="logo.png" alt="logo" width="60px" height="60px">Users</a>
  <div id="myLinks">
    <a href="showservers.php">More Details On The Servers</a>
    <a href="reset-password.php">Change Password</a>
    <a href="logout.php">Log Out</a>
  </div>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
<script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
</script>
  <div style="background-color: #ffffff" class="container box">
   <h1 align="center">Details On <?php echo $name;?>'s Users</h1>
   <br />
   <div class="table-responsive">
   <br />
    <div align="right">
     <button type="button" style="background-color: #696969" name="add" id="add" class="btn btn-info">Add User</button>
     <style>
      #add{
        text-align: center;
      }</style>
    </div>
    <br />
    <div id="alert_message"></div>
    <table style="background-color: white " id="users" class="table table-bordered table-striped">
     <thead>
      <tr style="background-color: #87CEEB">
       <th style="color: #ffffff">Name</th>
       <th style="color: #ffffff">Group</th>
       <th width="20%"></th>
       <th width="20%"></th>
      </tr>
     </thead>
    </table>
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  

  function fetch_data(name)
  {
   var dataTable = $('#users').DataTable({
    'processing' : true,
    'serverSide' : true,
    'serverMethod' : 'POST',
    'order' : [],
    'ajax' : {
     url:'fetch-users.php',
     type: 'post',
     data : {name:name}
   }
 }
   );
  }
  var name = "<?php echo $name; ?>";
  fetch_data(name);
  
  
$('#add').click(function(){
   var html = '<tr>';
   html += '<td contenteditable id="user"></td>';
   html += '<td contenteditable id="group"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';

   $('#users tbody').prepend(html);
  });
  
  $(document).on('click', '#insert', function(){
    var c=1;
    var username;
    var pwd;
    var name="<?php echo $name; ?>";
    var group=$('#group').text();
   var user = $('#user').text();
 
   username = prompt("Please enter the server's username:", "");
  if (username == null || username == "") {
    alert("You didn't enter the server's username.");
    c=0;
  } else {
    pwd = prompt("Please enter the user's password:", "");
      if (pwd == null || pwd == ""){
        alert("You didn't enter the user's password.");
        c=0;
      }}

if(c==1){      
    var ok={
     url:"insert-user.php",
     method:"POST",
     data:{name:name,user:user,username:username,pwd:pwd,group:group},
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#users').DataTable().destroy();
      fetch_data(name);
     }
    };
    $.ajax(ok);
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }});
  $(document).on('click', '.delete', function(){
   var user = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"delete-user.php",
     method:"POST",
     data:{user:user,name:name},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#users').DataTable().destroy();
      fetch_data(name);
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
 });
</script>