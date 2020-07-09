<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE website_users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>َChange Password</title>
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

<form class="box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <h1>Change Your Password</h1>

  <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
    <input type="password" name="new_password" value="<?php echo $new_password; ?>" class="form-control" placeholder="Enter the new password.."/>
    <span class="help-block"><?php echo $new_password_err; ?></span>
  </div>
  <div class="form-group <?php echo (!empty($confirm_password)) ? 'has-error' : ''; ?>">
    <input type="password" name="confirm_password" placeholder="Confirm the new password.." class="form-control">
    <span class="help-block"><?php echo $confirm_password_err; ?></span>
  </div>
  <div class="form-group">
    <input type="submit" name="" value="Submit">
    <a href="welcome.php">
        <input type="button" value="Go Back" />
    </a>
  </div>
</form>




  </body>
</html>