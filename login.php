<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM website_users WHERE username = ?";
        
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
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;    

                            //update the last login case in the database
                            $username = "infoco";
                            $password = "infoco";
                            $database = "project";
                            $mysqli = new mysqli("localhost", $username, $password, $database);
                            $query="UPDATE website_users SET lastlogin = current_time() WHERE id = ".$_SESSION["id"];
                            $mysqli->query("$query");                        
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
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
    <title>َWelcome to INFOCO</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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

<form class="box" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <h1>Welcome to the Servers Monitor</h1>

  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" placeholder="Enter your username"/>
    <span class="help-block"><?php echo $username_err; ?></span>
  </div>
  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <input type="password" name="password" placeholder="Enter your password" class="form-control">
    <span class="help-block"><?php echo $password_err; ?></span>
  </div>
  <div class="form-group">
    <input type="submit" name="" value="Login">
    <a href="contact.php">
   		<input type="button" value="Forgot Your Password?" />
	</a>
  </div>
</form>




  </body>
</html>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 