<?php
	$id=$_GET["gid"];
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
	mysqli_select_db($link, $database) or die(mysqli_error());
	$q = "SELECT vertices FROM traccar.geofences where id = $id;";
	$resultado = mysqli_query($link, $q) or die(mysqli_error());
	if ($row = mysqli_fetch_array($resultado)) {
		$coor = explode(";", $row["vertices"]);
		foreach($coor as $key => $value){
			$t = explode(" ", $value);
			$locations[] = "{lat: {$t[0]}, lng: {$t[1]}}";
		}
		echo "[".implode(",",$locations)."]";		  
	}
	mysqli_close($link);
?>
