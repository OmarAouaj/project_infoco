<?php
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $comment = $email ="";
$username_err = $comment_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if comment is empty
    if(empty(trim($_POST["comment"]))){
        $comment_err = "Please enter your comment.";
    } else{
        $comment = trim($_POST["comment"]);
    }
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Validate credentials
    if(empty($comment_err) && empty($username_err)){
        // Prepare a select statement
        $sql = "SELECT username FROM website_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    

                            //update the last login case in the database
                            $username1 = "infoco";
                            $password = "infoco";
                            $database = "project";
                            $mysqli = new mysqli("localhost", $username1, $password, $database);
                            $query="INSERT INTO reports(username,comment,email,submitted) VALUES(?,?,?,current_time())";
                            $stmt=$mysqli->prepare($query);
                            $stmt->bind_param("sss",$username,$comment,$email);
                            $stmt->execute();                       
                            // Redirect user to welcome page

                            echo "<script>alert(\"Report Submitted\");</script>";
                            echo "<script>setTimeout(\"location.href = 'login.php';\",1500);</script>";
                        }
                    
                 else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>


  <head>
    <title>َContact Us</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8">

  </head>
  <body>
  	 <style> 
		@font-face {
			font-family: 'robotoblack';
			src: url('Roboto-Black-webfont.eot');
			src: url('Roboto-Black-webfont.eot?#iefix') format('embedded-opentype'),
				 url('Roboto-Black-webfont.woff2') format('woff2'),
				 url('Roboto-Black-webfont.woff') format('woff'),
				 url('Roboto-Black-webfont.ttf') format('truetype'),
				 url('Roboto-Black-webfont.svg#robotoblack') format('svg');
			font-weight: normal;
			font-style: normal;

		}
		*{ font-family: 'robotoblack', Arial, sans-serif; }
   </style>


<div id="particles-js">

</div>
<script type="text/javascript" src="js/particles.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<form class="box" id="box1">
</form>

<form class="box" id="box2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <h1>Oops!..Contact Us</h1>

  <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <input type="text" name="email" placeholder="Enter your email" class="form-control">
    <span class="help-block"><?php echo $email_err; ?></span>
  </div>
  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" placeholder="Enter your username"/>
    <span class="help-block"><?php echo $username_err; ?></span>
  </div>
  <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
    <input type="text" name="comment" placeholder="Enter your comment" class="form-control">
    <span class="help-block"><?php echo $comment_err; ?></span>
  </div>
  <div class="form-group">
    <input type="submit" name="" value="Submit Your Comment">
    <a href="login.php">
   		<input type="button" value="Never Mind I Remembered It!" />
	</a>
  </div>
</form>




  </body>
</html>