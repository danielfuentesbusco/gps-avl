<html lang="en">
  <head>
  </head>
  <body>
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyAr_-4pxrC16Ii95y8KeviDojtob5kgTiU&libraries=geometry"></script>
	<script>	
	//$(document).ready(function(){
		<?php			
		$t = microtime();
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="traccar";
		$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		
		$q = "SELECT name, id FROM devices WHERE id IN (42) AND installed = '1';";
		$resultado2 = mysql_query($q) or die(mysql_error());
		while ($row2 = mysql_fetch_array($resultado2)) {		
			$q = "SELECT location_report.utc, location_report.latitude, location_report.longitude FROM location_report WHERE location_report.device_id = {$row2["id"]} AND location_report.latitude!=0 AND location_report.longitude!=0";
			$resultados = array();
			$resultado = mysql_query($q) or die(mysql_error());
			while ($row = mysql_fetch_array($resultado)) {
				if(substr($row["utc"],0,8)=='20161201'){
					$resultados[$row["utc"]] = array($row["latitude"],$row["longitude"]);
				}
			}
			ksort($resultados);
			echo "{"."\n";
			echo "var recorrido_arr = [];"."\n";
			foreach($resultados as $utc => $coordinates){
				echo "recorrido_arr.push({lat: {$coordinates[0]}, lng: {$coordinates[1]}});"."\n";
			}
			echo "var recorrido = new google.maps.Polyline({
					path: recorrido_arr,
					geodesic: true,
					strokeColor: 'grey',
					strokeOpacity: 1,
					strokeWeight: 3
				});"."\n";
			echo 'var path = recorrido.getPath(); 
				 var distancia = google.maps.geometry.spherical.computeLength(path.getArray());
				 distancia = Math.round(distancia/1000);'."\n";
			echo 'document.open();
				  document.write(distancia);
				  document.close();'."\n";
			//echo "console.log(distancia);"."\n";
			echo "}"."\n";
		}
		mysql_close($link);
		?>
	//});
	</script>
</body>
</html>