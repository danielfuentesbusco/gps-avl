<?php
	session_start();
	$userid=$_GET["uid"];
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	//print_r($_SESSION);
	$locations = array();
	//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
	$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
	mysql_select_db($database) or die(mysql_error());
	$q = "SELECT * FROM devices where id IN (SELECT deviceid FROM user_device WHERE userid = $userid);";
	if($userid=='9'||$userid=='11'||$userid=='12'){
		$q = "SELECT * FROM devices where installed = 1 order by ABS(name);";
	}
	$resultado2 = mysql_query($q) or die(mysql_error());
	while ($row2 = mysql_fetch_array($resultado2)) {
		$q = "SELECT location_report.latitude, location_report.longitude, location_report.speed, location_report.utc, location_report.heading FROM location_report WHERE location_report.latitude!=0 and location_report.longitude!=0 and location_report.id={$row2["last_id"]}";
		$resultado = mysql_query($q) or die(mysql_error());
		if ($row = mysql_fetch_array($resultado)) {
			$utc = date("d/m/Y h:i:s A",strtotime($row[3])-10800);
			$utc2 = date("Y/m/d H:i:s",strtotime($row[3])-10800);
			$ignition_utc = date("Y/m/d H:i:s",strtotime($row2["ignition_utc"])-10800);
			$locations[] = "['{$row2["name"]}',{$row[0]},{$row[1]},{$row[2]}, '$utc', {$row[4]}, '{$row2["ignition"]}','{$row2["id"]}','$utc2','$ignition_utc']";
		}
	}
	echo "[".implode(",",$locations)."]";
	mysql_close($link);
	?>
