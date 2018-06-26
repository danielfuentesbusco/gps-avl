<?php
	$m=@$_GET["m"];
	$s=@$_GET["s"];
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
	mysqli_select_db($link, $database) or die(mysqli_error());
	$q = "UPDATE traccar.devices set estado='$s' where name = '$m';";
	mysqli_query($link, $q) or die("1");
	echo "0";
	mysqli_close($link);
?>
