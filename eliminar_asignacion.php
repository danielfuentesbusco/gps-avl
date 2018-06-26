<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
	mysqli_select_db($link, $database) or die(mysqli_error());
	mysqli_query($link, "DELETE FROM geofence_device WHERE id = '".intval($_GET["aid"])."' LIMIT 1;");
	mysqli_close($link); 
	header("Location: " . $_SERVER["HTTP_REFERER"]);
	exit;
?>