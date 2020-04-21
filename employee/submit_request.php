<?php
   include('../config.php');
   session_start();
   if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true))){
		header("location: ../login.php");
		exit;
   }
   $username=$_SESSION["username"];
   $type=$_SESSION["user_type"];
   if ($type=="admin") {
	   header("location: welcome_admin.php");
   }	   
   else {
		$sql = "SELECT user_id, date_submitted, date_requested_start, date_requested_end , days_requested, status FROM application WHERE user_id=$username";
		$result = mysqli_query($db,$sql);
		$count=0;
		if ($result!=FALSE)
			$count = mysqli_num_rows($result);
		
   }
?>
<html>
   
   <head>
		<title>Submit Request </title>	  
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
		<button style="float: right;" type="button" class="btn btn-danger" onclick="location.href = 'welcome.php';">Cancel</button>
	  <h2>Please fill in the following form</h2>
	  <form class="form-horizontal" action="submit_request_check.php" method="post">
		<div class="form-group">
		  <label class="control-label col-sm-2" for="date_from">Date from:</label>
		  <div class="col-sm-10">
			<input type="date" class="form-control" id="date_from"  name="date_from">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="date_to">Date to:</label>
		  <div class="col-sm-10">          
			<input type="date" class="form-control" id="date_to" name="date_to">
		  </div>
		</div>
		<div class="form-group">
		  <label class="control-label col-sm-2" for="reason">Reason&nbsp<i>(optional)</i>:</label>
		  <div class="col-sm-10">          
			<input type="textarea" class="form-control" id="reason" placeholder="Enter the reason" name="reason">
		  </div>
		</div>
		<div class="form-group">        
		  <div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">Submit</button>
		  </div>
		</div>
	  </form>
	</div>
		
		
   </body>
   
</html>