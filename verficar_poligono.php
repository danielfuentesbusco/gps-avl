<?php 
	$inicio = time();
	require "points.php";
	$inicio = time();
	$username="root";
	$password="r1r7C1h6ZG4ZVWF"; 
	$database="traccar";
	$locations = array();
	$i = 0;
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or print(mysqli_error($link));
	mysqli_select_db($link,$database) or print(mysqli_error($link));
	$query = "SELECT devices.id AS device_id, devices.name, devices.last_id, location_report.latitude, location_report.longitude, location_report.utc ".
		 "FROM devices, location_report ".
		 "WHERE devices.installed = 1 ".
		 "AND devices.last_id = location_report.id;";
	$resultado = mysqli_query($link,$query) or print(mysqli_error($link));
	//echo $query."<br />";
	$fecha_actual = date("Y-m-d H:i:s");
	while ($row = mysqli_fetch_array($resultado)) {
		$query = "SELECT name, vertices, geofence_device.geofence_id AS id FROM geofences, geofence_device WHERE geofence_device.device_id={$row["device_id"]} AND geofence_device.fecha_inicio<='$fecha_actual' AND (geofence_device.fecha_termino IS NULL OR geofence_device.fecha_termino>='$fecha_actual') AND geofences.id=geofence_device.geofence_id;";
		//echo $query."<br />";
		$resultado2 = mysqli_query($link,$query) or print(mysqli_error($link));
		$latitude = $row["latitude"];
		$longitude = $row["longitude"];
		while ($row2 = mysqli_fetch_array($resultado2)) {
			$pointLocation = new pointLocation();
			$polygon = explode(";", $row2["vertices"]);
			$location = $pointLocation->pointInPolygon($latitude." ".$longitude, $polygon);			
			$query = "SELECT state FROM geofence_state WHERE device_id={$row["device_id"]} AND geofence_id={$row2["id"]} ORDER BY utc DESC LIMIT 1;";
			//echo $query."<br />";
			$resultado3 = mysqli_query($link,$query) or print(mysqli_error($link));
			if($location=="outside"){
				$location=0;
			}else{
				$location=1;
			}
			if($row["utc"]==""){
				$row["utc"] = date("YmdHis");
			}
			if ($row3 = mysqli_fetch_array($resultado3)) {
				if($location!=$row3["state"]){
					//echo "{$row["name"]} {$row2["name"]}  $location ({$row3["state"]})";
					//echo "CHANGE<br />"; 
					$query = "INSERT INTO geofence_state (geofence_id,device_id,location_id,state,utc) VALUES ({$row2["id"]},{$row["device_id"]},{$row["last_id"]},$location,{$row["utc"]});";
					mysqli_query($link,$query) or print(mysqli_error($link) . " -> ".$query);
					//echo $query."<br />";
					$i++;
				}else{
					//echo "{$row["name"]} {$row2["name"]}  $location ({$row3["state"]})";
					//echo "SAME<br />"; 
				}
			} else {
				$i++;
				//echo "{$row["name"]} {$row2["name"]}  $location (NEW)<br />";
				$query = "INSERT INTO geofence_state (geofence_id,device_id,location_id,state,utc) VALUES ({$row2["id"]},{$row["device_id"]},{$row["last_id"]},$location,{$row["utc"]});";
				mysqli_query($link,$query) or print(mysqli_error($link));
				//echo $query."<br />";
			}
		}
		//echo "<hr />";
	}
	echo (time() - $inicio);
	//echo " $i";
?>