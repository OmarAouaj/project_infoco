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
  <title>Welcome to INFOCO</title>
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
  background: #000000;
  display: block;
  position: absolute;
  right: 0;
  top: 0;
}

.topnav a:hover {
  background-color: #ddd;
  color: #000000;
}

.active {
  background-color: #000000;
  color: white;
}
</style>
 </head>
 <body style="background-color: #ffffff">
    <div class="topnav">
  <a href="#" class="active"><img src="logo.png" alt="logo" width="60px" height="60px">  INFOCO</a>

  <div id="myLinks">
    <a href="chart-final.php"> DASHBOARD</a>
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
   <h1 align="center" style="color: grey">Servers List</h1>
   <br />
  
   <div class="table-responsive">
   <br />
    <div align="right">
     <button type="button" style="background-color: #C0C0C0" name="add" id="add" class="btn btn-info">Add Server</button>
     <style>
      #add{
        text-align: center;
      }</style>
    </div>
    <br />
    <div id="alert_message"></div>
    <table style="background-color: #ffffff" id="servers" class="table table-bordered table-striped">
     <thead>
      <tr style="background-color: #87CEEB">
       <th style="color: #ffffff">Name</th>
       <th style="color: #ffffff">IP</th>
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
     url:'fetch.php',
     type: 'post'
   }
 }
   );
  }
  fetch_data();
  
  function update_data(id, column_name, value)
  {
   $.ajax({
    url:"update.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#servers').DataTable().destroy();
     fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
  });
  
$('#add').click(function(){
   var html = '<tr>';
   html += '<td contenteditable id="name"></td>';
   html += '<td contenteditable id="ip"></td>';
   html += '<td contenteditable id="state"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';

   $('#servers tbody').prepend(html);
  });
  
  $(document).on('click', '#insert', function(){
    var c=1;
    var username;
    var pwd;

  var state = $('#state').text();
    if(state=="up"){
  username = prompt("Please enter the server's username:", "");
  if (username == null || username == "") {
    alert("You didn't enter the server's username.");
    c=0;
  } else {
    pwd = prompt("Please enter the user's password:", "");
      if (pwd == null || pwd == ""){
        alert("You didn't enter the user's password.");
        c=0;
      }
  }}
   var name = $('#name').text();
   var ip = $('#ip').text();
 
   var arrOctets = ip.split('.');
   var a=1;
   if (arrOctets.length != 4)
    {
        alert("An IP Adress Should be like this: 0.0.0.0 !");
        a=0;
    }
   if(a==1){
   		var n=255;
   		var k=0;
   		for (var i = 0; i < arrOctets.length; i++) {
  			if(0<=parseInt(arrOctets[i]) && parseInt(arrOctets[i])<=n){
  				k+=1;
  			}
		}
		if(k<4){
			a=0;
			alert("IP Address Components Must Be Between 0 And 255!")
		}}
		if(a==1){
			if(state!="up" && state!="down"){
				a=0;
				alert("State Is Either up Or down");
			}}
			if(a==1){
				if(name == '' || ip == '' || state == ''){
					a=0;
					alert("All Fields are required");
				}
			}
   if(a==1 && c==1)
   {
    var ok={
     url:"insert.php",
     method:"POST",
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#servers').DataTable().destroy();
      fetch_data();
     }
    };
    if(state==="up"){
           ok.data={name:name, ip:ip, state:state, username:username, pwd:pwd};
    }
    else{
      ok.data={name:name, ip:ip, state:state};
    }
    $.ajax(ok);
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }});
  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"delete.php",
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#servers').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
 });
</script>