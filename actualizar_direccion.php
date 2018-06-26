<?php
	function getAddress($lat,$lng){
		$api_key = "AIzaSyD9F9V08fx3fWrBMLBAZ7CsU7PYEkzttLY";
		$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&output=json&sensor=false&key=" . $api_key;
		$data = @file_get_contents($url);
		$jsondata = json_decode($data,true);
		if(isset($jsondata["results"][0]["formatted_address"])){
			  return $jsondata["results"][0]["formatted_address"];
		}
	}
	$time = time();
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$i=1;
	//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
	$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
	mysql_select_db($database) or die(mysql_error());
	$q = "SELECT min(id) as min, max(id) as max FROM coordinate_address;";
	$resultado = mysql_query($q) or die(mysql_error());
	$row = mysql_fetch_array($resultado);
	$rand = rand($row["min"], $row["max"]);
	$q = "SELECT coordinate_address.id, coordinate_address.latitude, coordinate_address.longitude FROM coordinate_address WHERE id = '$rand';";
	$resultado = mysql_query($q) or die(mysql_error());
	$lat = "";
	$lng = "";
	$address = "";
	while ($row = mysql_fetch_array($resultado)) {
		if($row["latitude"]!=$lat&&$row["longitude"]!=$lng){
			$row["address"] = getAddress($row["latitude"],$row["longitude"]);
			$row["address"] = utf8_decode($row["address"]);
			$query = "UPDATE coordinate_address SET address = '{$row["address"]}' WHERE id = '{$row["id"]}';";
			mysql_query($query);
			$query = "UPDATE coordinate_address SET address = '{$row["address"]}' WHERE latitude = '{$row["latitude"]}' AND longitude = '{$row["longitude"]}';";
			mysql_query($query);
			//echo "<br />";
		}
	}
	echo time()-$time;
?>