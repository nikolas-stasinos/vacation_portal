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
	   header("location: ../employee/welcome.php");
   }	   
   else {
		$sql = "SELECT email, first_name, last_name, type FROM users";
		$result = mysqli_query($db,$sql);
		//$count = mysqli_num_rows($result);
		
   }
   //print_r(array_values($_SESSION["user_type"]));
?>
<html>
   
   <head>
      <title>Welcome </title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   </head>
   
   <body>
	<?php if(!empty($_SESSION['error_message'])) { ?>
	<p style="color:red">
	<?php 	echo $_SESSION['error_message']; 
		$_SESSION['error_message']="";?>
	</p>
	<?php }?>	  	
		<h2 style="color:blue" align = "center">Epignosis Days-Off Portal</h2>
	  <div class="container">
      <h4 align="right"><a href = "../logout.php">Sign Out</a></h4>
		<button style="float: right;" type="button" class="btn btn-success" onclick="location.href = 'create_user.php';">Create User</button>
	  <h2>List of all Users</h2>            
	  <table class="table table-hover">
		<thead>
		  <tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Type</th>
			<th></th>
		  </tr>
		</thead>
		<tbody>
		<?php while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
		  <tr>
			<td><?php echo $row['first_name'] ?></td>
			<td><?php echo $row['last_name'] ?></td>
			<td><?php echo $row['email'] ?></td>
			<td><?php echo $row['type'] ?></td>
			<td><a href="edit_user.php?user_id=<?php echo $row['email']?>"><button type="button" class="btn btn-info">Edit</button></a></td>
		  </tr>
		<?php } ?>
		</tbody>
	  </table>
	</div>
   </body>
   
</html>