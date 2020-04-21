<?php
   //include('session.php');
   include('../config.php');
   session_start();
   if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true))){
		header("location: ../login.php");
		exit;
   }
   $username=$_SESSION["username"];
   $type=$_SESSION["user_type"];
   if ($type!="admin") {
	   header("location: ../welcome.php");
   }	   
   else {
		$user_id=$_GET["user_id"];
		$sql = "SELECT email, password, first_name, last_name, type FROM users where email=\"$user_id\"";
		$result = mysqli_query($db,$sql);		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if ($row["type"]=="admin") {
			$selected_admin="selected";
			$selected_employee="";
		}
		else {
			$selected_admin="";
			$selected_employee="selected";
		}
   }
?>
<html>
   <head>
		<title>Edit User</title>	  
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	</head>
	<?php if(!empty($_SESSION['error_message'])) {
		echo $_SESSION['error_message']; 
		$_SESSION['error_message']="";
	}?>
   <body>	
		<h2 style="color:blue" align = "center">Epignosis Days-Off Portal</h2>
	  <div class="container">
      <h4 align="right"><a href = "../logout.php">Sign Out</a></h4>
		<button style="float: right;" type="button" class="btn btn-danger" onclick="location.href = 'welcome.php';">Cancel</button>
	  <h2>Please fill in the following form</h2>
	  <form class="form-horizontal" action="edit_user_check.php?user_id=<?php echo $user_id?>" method="post">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="first_name" required>First Name:</label>
		  <div class="col-sm-10">          
			<input type="text" class="form-control" id="first_name"  value="<?php echo $row["first_name"] ?>" name="first_name">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="last_name" required>Last Name:</label>
		  <div class="col-sm-10">          
			<input type="text" class="form-control" id="last_name" value="<?php echo $row["last_name"] ?>" name="last_name">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="email" required>Email:</label>
		  <div class="col-sm-10">          
			<input type="email" class="form-control" id="email" value="<?php echo $row["email"]?>" name="email">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="password" required>Password:</label>
		  <div class="col-sm-10">          
			<input type="password" class="form-control" id="password" name="password">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="password2" required>Confirm password:</label>
		  <div class="col-sm-10">          
			<input type="password" class="form-control" id="password2" name="password2">
		  </div>
		</div>
		<div class="form-group">		
			<label class="control-label col-sm-2" for="type">User type:</label>
			<select class="form-control" id="type" name="type" style="width:80%">
			  <option value="employee" <?php echo $selected_employee ?>>Employee</option>
			  <option value="admin" <?php echo $selected_admin ?>>Admin</option>
			</select>
		</div>
		<div class="form-group">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Update</button>
		  </div>
		</div>
	  </form>
	</div>
		
		
   </body>
   
</html>