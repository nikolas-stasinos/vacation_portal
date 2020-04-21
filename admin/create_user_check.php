<?php
   session_start();
   if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true))){
		header("location: ../login.php");
		exit;
   }
   $username=$_SESSION["username"];	//admin's email
   $first_name=$_POST["first_name"];
   $last_name=$_POST["last_name"];
   $email=$_POST["email"];
   $password=$_POST["password"];
   $password2=$_POST["password2"];
   $type=$_POST["type"];
   if (($first_name=="")||($last_name=="")||($email=="")||($password=="")) {
		$_SESSION['error_message'] = "Please fill in all the forms.";
		header ("location: create_user.php");
   }
   else if (strcmp($password,$password2)){
		$_SESSION['error_message'] = "The password must be the same in both instances.";
		header ("location: create_user.php");
   }
   else {
		include("../config.php");
		$encrypted_password=md5($password);
		$sql = "INSERT INTO users (email, password, first_name, last_name, type, admin_email) VALUES (\"$email\", \"$encrypted_password\", \"$first_name\", \"$last_name\", \"$type\", \"$username\")";
		if (mysqli_query($db, $sql)) {
			$_SESSION['error_message'] = "New record created successfully";
			header("location:welcome.php");
		} else {
			$_SESSION['error_message'] = "User could not be saved. Make sure this email is not already in the system.";
			echo "Error: " . $sql . "<br>" . mysqli_error($db);
			header("location:create_user.php");
		}
   }
   
?>
<html>
   
   <head>
      <title>Welcome </title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   </head>
   <body>
	<p>You inserted the record: <?php echo $sql; ?>.</p>
   </body>
</html>