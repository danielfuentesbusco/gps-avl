<?php 
	//$inicio = time();
	//require "points.php";
	$inicio = time();
	$username="root";
	$password="r1r7C1h6ZG4ZVWF"; 
	$database="traccar";
	$locations = array();
	$i = 0;
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or print(mysqli_error($link));
	mysqli_select_db($link,$database) or print(mysqli_error($link));
	$query = "SELECT devices.id AS device_id, devices.name, devices.last_id ".
		 "FROM devices ".
		 "WHERE devices.installed = 1 LIMIT 1;";
	$resultado = mysqli_query($link,$query) or print(mysqli_error($link));
	$fecha_termino = date("YmdHis",time()+10800-24*60*60);
	//echo $query."<br />";
	$fecha_actual = date("Y-m-d H:i:s");
	while ($row = mysqli_fetch_array($resultado)) {
		$query = "SELECT * FROM traccar.state_change where device_id = 19 and state in (11,21,22) and utc is not null and utc <> '' and utc >= '$fecha_termino' order by utc;;";
		//echo $query."<br />";
		$resultado2 = mysqli_query($link,$query) or print(mysqli_error($link));
		$time_anterior = 0;
		$total = 0;
		$array = array();
		$array["11"] = 0;
		$array["21"] = 0;
		$array["22"] = 0;
		$anterior = "";
		while ($row2 = mysqli_fetch_array($resultado2)) {
			if($anterior!=''){
				if($anterior=='11'){
					$array["11"] += strtotime($row2["utc"]) - $time_anterior;
				}elseif($anterior=='21'){
					$array["21"] += strtotime($row2["utc"]) - $time_anterior;
				}elseif($anterior=='22'){
					$array["22"] += strtotime($row2["utc"]) - $time_anterior;
				}
			}
			$time_anterior = strtotime($row2["utc"]);
			$anterior = $row2["state"];
		}
		print_r($array);
		//echo "<hr />";
	}
	echo (time() - $inicio);
	//echo " $i";
?>