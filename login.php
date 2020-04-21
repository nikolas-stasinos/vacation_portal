<?php
	include("config.php");
	session_start();   
	//Check if user has already signed in
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: /epignosis/employee/welcome.php");
		exit;
	}
	$email = $password = "";
	$email_err = $password_err = "";
    // email and password sent from form   
	if($_SERVER["REQUEST_METHOD"] == "POST") {    
		// Check if email is empty
		if(empty(trim($_POST["email"]))){
			$email_err = "Please enter a valid email.";
		} else{
			$email = mysqli_real_escape_string($db,$_POST['email']);
		}    
		// Check if password is empty
		if(empty(trim($_POST["password"]))){
			$password_err = "Please enter your password.";
		} else{
			$password = mysqli_real_escape_string($db,$_POST['password']);
		}
		// Validate credentials
		if(empty($email_err) && empty($password_err)){
			// Prepare a select statement
			$encrypted_password=md5($password);
			$sql = "SELECT * FROM users WHERE email = '$email' and password = '$encrypted_password'";
			$result = mysqli_query($db,$sql);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$count = mysqli_num_rows($result);
			if($count == 1) {
				// Password is correct, so start a new session
				session_start();				
				// Store data in session variables
				$_SESSION["loggedin"] = true;
				$_SESSION["username"] = $email;	
				$_SESSION["user_type"] = $row["type"];
				// Redirect user to welcome page
				header("location: /epignosis/employee/welcome.php");
			}	 
			else{
				// Display an error message if password is not valid
				$password_err = "The password you entered was not valid.";
				echo $password_err;
			}			
		}		
		// Close connection
		mysqli_close($db);
	}
?>	
<html>
   
   <head>
      <title>Epignosis Vacation Portal</title> 
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">     
   </head>
   
   <body bgcolor = "#FFFFFF">
		<h2 style="color:blue" align = "center">Epignosis Days-Off Portal</h2>
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>Email  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type = "email" name = "email" class = "box"/><br /><br />
                  <label>Password  :&nbsp;</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>              
               	
            </div>
				
         </div>
			
      </div>

   </body>
</html>