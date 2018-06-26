<?php
	$id=@$_GET["gid"];
	$d=@$_GET["d"];
	$name=@$_GET["n"];
	$t=@$_GET["t"];
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
	mysqli_select_db($link, $database) or die(mysqli_error());
	if($id=="0"){
		$q = "INSERT INTO traccar.geofences (name, vertices, tipo) VALUES ('$name','$d', $t);";
	}else{
		$q = "UPDATE traccar.geofences set vertices='$d' where id = $id;";
	}
	mysqli_query($link, $q) or die("1");
	echo "0";
	mysqli_close($link);
?>
