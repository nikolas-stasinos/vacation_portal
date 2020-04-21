<?php
   session_start();
   if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true))){
		header("location: ../login.php");
		exit;
   }
   $user_id=$_GET["user_id"];		//user's username (mail)
   $username=$_SESSION["username"];	//admin's username
   $first_name=$_POST["first_name"];
   $last_name=$_POST["last_name"];
   $email=$_POST["email"];
   $password=$_POST["password"];
   $password2=$_POST["password2"];
   $type=$_POST["type"];
   //if admin wants to change his/her data
   /*if (!(strcmp($user_id,$username)){
	   
   }*/
   if (($first_name=="")||($last_name=="")||($email=="")) {
		$_SESSION['error_message'] = "Please fill in all the forms.";
		header ("location: edit_user.php?user_id=$user_id");
   }
   else if (strcmp($password,$password2)){
		$_SESSION['error_message'] = "The password must be the same in both instances.";
		header ("location: edit_user.php?user_id=$user_id");
   }
   else {
		include("../config.php");
		if ($password=="")
			$sql = "UPDATE users SET first_name=\"$first_name\", last_name= \"$last_name\", email=\"$email\", type=\"$type\" WHERE email=\"$user_id\"";
		else {
			$encrypted_password=md5($password);			
			$sql = "UPDATE users SET password=\"$encrypted_password\", first_name=\"$first_name\", last_name= \"$last_name\", email=\"$email\", type=\"$type\" WHERE email=\"$user_id\"";
		}
		echo $sql;
		if (mysqli_query($db, $sql)) {
			$_SESSION['error_message'] = "Record updated successfully.";
			header("location:welcome.php");
		} else {
			$_SESSION['error_message'] = "User could not be saved. Make sure this email is not already in the system.";
			echo "Error: " . $sql . "<br>" . mysqli_error($db);
			header ("location: edit_user.php?user_id=$user_id");
		}
   }
   
?>
<html>
   
   <head>
      <title>Welcome </title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   </head>
   <body>
	<p>You updated the record: <?php echo $sql; ?>.</p>
   </body>
</html>