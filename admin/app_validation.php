<?php
	include('../config.php');
	if ($_GET["status"]=="approval")
		$status="approved";
	else if ($_GET["status"]=="rejection")
		$status="rejected";
	else {
		echo "There is a problem with the link. Please retry the link that was went to your email.";
		exit;
	}
	$app_id=$_GET["id"];
	$sql = "UPDATE application SET status=\"$status\" WHERE application_id=$app_id";
	if (mysqli_query($db, $sql)) {
		echo "Record updated successfully.\r\n ";
	} else {
		echo "SQL Error: " . $sql . "\r\n " . mysqli_error($db)."\r\n ";
	}
	//Get date_submitted data
	$sql = "SELECT user_id,date_submitted from application where application_id=$app_id";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$date_submitted=date("Y-m-d",strtotime($row['date_submitted']));
	//Get user's mail
	$to_email = $row["user_id"];
	$msg="Dear employee, your supervisor has $status your application submitted on $date_submitted.";	
	$subject = "Evaluation of Days off Application";
	$body = $msg;
	$headers = "From: nikolas.epignosis@gmail.com";
	 
	if (mail($to_email, $subject, $body, $headers)) {
		echo "Email successfully sent to $to_email...";
	} else {
		echo "Email sending failed...";
	}
?>