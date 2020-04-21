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
   if ($type=="admin") {
	   header("location: ../admin/welcome.php");
   }	   
   else {
		$sql = "SELECT user_id, date_submitted, date_requested_start, date_requested_end , days_requested, status FROM application WHERE user_id=\"$username\" ORDER BY date_submitted DESC";
		$result = mysqli_query($db,$sql);
		$count=0;
		if ($result!=FALSE)
			$count = mysqli_num_rows($result);
		
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
		<button style="float: right;" type="button" class="btn btn-success" onclick="location.href = 'submit_request.php';">Submit Request</button>
	  <h2>List of post applications</h2>  
	  <?php 
		if ($count>0){ ?>
	  <table class="table table-hover">
		<thead>
		  <tr>
			<th>Date submitted</th>
			<th>Dates requested</th>
			<th>Days requested</th>
			<th>Status</th>
		  </tr>
		</thead>
		<tbody>
		<?php while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
		  <tr>
			<td><?php echo date("Y-m-d",strtotime($row['date_submitted'])) ?></td>
			<td><?php echo date("Y-m-d",strtotime($row['date_requested_start']))." to ".date("Y-m-d",strtotime($row['date_requested_end']))  ?></td>
			<td><?php echo $row['days_requested'] ?></td>
			<td><?php echo $row['status'] ?></td>
		  </tr>
		<?php }
		}
		else
			echo "No post applications found.";?>
		</tbody>
	  </table>
	</div>
   </body>
   
</html>