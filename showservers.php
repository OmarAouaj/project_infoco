<?php
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html>
 <head>
  <title>Servers Details</title>
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
  <a href="#" class="active"><img src="logo.png" alt="logo" width="60px" height="60px">Details On The Servers</a>
  <div id="myLinks">
    <a href="welcome.php">Main Page</a>
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
   <h1 align="center" style="color:grey">Details On The Servers</h1>
   <br />
   <div class="table-responsive">
    <div id="alert_message"></div>
    <table style="background-color: white " id="servers" class="table table-bordered table-striped">
     <thead>
      <tr style="background-color: #87CEEB">
       <th style="color: #ffffff">Name</th>
       <th style="color: #ffffff">MAC</th>
       <th style="color: #ffffff">IP</th>
       <th style="color: #ffffff">OS</th>
       <th style="color: #ffffff">Total Storage</th>
       <th style="color: #ffffff">Available Storage</th>
       <th style="color: #ffffff">Total Ram</th>
       <th style="color: #ffffff">Available Ram</th>
       <th style="color: #ffffff">State</th>
       <th style="color: #ffffff">Action</th>
      </tr>
     </thead>
    </table>
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  

  function fetch_data()
  {
   var dataTable = $('#servers').DataTable({
    'processing' : true,
    'serverSide' : true,
    'serverMethod' : 'POST',
    'order' : [],
    'ajax' : {
     url:'fetch-servers.php',
     type: 'post'
   }
 }
   );
  }
  fetch_data();


 });
</script>