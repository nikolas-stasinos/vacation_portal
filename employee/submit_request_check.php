<?php
   session_start();
   if(!(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true))){
		header("location: ../login.php");
		exit;
   }
   $username=$_SESSION["username"];		//user's mail
   $date_from=$_POST["date_from"];
   $date_to=$_POST["date_to"];
   $reason=$_POST["reason"];
   $date_submitted=date("Y-m-d H:i:s");
   if (($date_from=="")||($date_to=="")||($date_from>$date_to)||($date_from<$date_submitted)) {
		echo "Please select a valid period.";
		$_SESSION['error_message'] = "The dates you selected weren't valid.";
		header ("location: submit_request.php");
   }
   else {
		include("../config.php");
		$days=getDates($date_from, $date_to);
		$sql_max="SELECT MAX(application_id) AS max  FROM application";
		$maximum = mysqli_query($db,$sql_max);
		$row_max = mysqli_fetch_array( $maximum );
		$application_id =$row_max['max'];
		if ($application_id==null)
			$application_id=1;
		else
			$application_id++;
		//find user's First and Last Name (for the mail)
		$sql = "SELECT first_name, last_name, admin_email from users where email=\"$username\"";
		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if ($result) {
			$employee_name=$row["first_name"]." ".$row["last_name"];
		} else {
			$employee_name=$username;
		}
		$admin_email=$row["admin_email"];
		//Send mail to the administrator
		$to = $admin_email;
		$subject = "Epignosis Days-Off Portal: User $employee_name Request";
		$headers = "From: $admin_email\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = "<html><body>";
		$message .= "<div>Dear supervisor, employee $employee_name requested for some time off, starting on $date_from and ending on $date_to";
		if ($reason!="") $message .= ", stating the reason: $reason";
		$message .= ".</div><div>Click on one of the below links to approve or reject the application: ";
		$message .= "<p><a href =\"http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=approval\">Approve application</a></p>";
		$message .= "<p><a href =\"http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=rejection\">Reject application</a></p></div>";
		//$message .= "<p><a href =\"http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=approval\">Approve application</a>: http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=approval</p>";
		//$message .= "<p><a href =\"http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=rejection\">Reject application:</a> http://localhost/epignosis/admin/app_validation.php?id=$application_id&status=rejection</p></div>";
		$message .= "</body></html>";
		if (mail($to, $subject, $message, $headers)) {
			header("location:welcome.php");
		}
		else {
			$_SESSION['error_message'] = "The administrator couldn't be notified for this request.";
			header("location:welcome.php");
		}
		//Create application record in database
		$sql = "INSERT INTO application (application_id, user_id, date_submitted, date_requested_start, date_requested_end, days_requested, reason, status) VALUES ($application_id, \"$username\", \"$date_submitted\", \"$date_from\", \"$date_to\", $days, \"$reason\", \"pending\")";
		if (mysqli_query($db, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($db);
		}	
		
   }
   
function getDates($date_from, $date_to){
	$days=0;
	while ($date_from<=$date_to){
		//check if weekend
		if ((date("l",strtotime($date_from))!="Sunday")&&(date("l",strtotime($date_from))!="Saturday"))
			$days=$days+1;
		$date_from = date('Y-m-d', strtotime($date_from .' +1 day'));
	}	
	return $days;
}
?>
<html>
   
   <head>
      <title>Welcome </title>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   </head>
   <body>
	<p>You inserted the record: <?php echo $sql; ?>.</p>
	<p>You sent the mail: <?php echo $message; ?>.</p>
   </body>
</html>