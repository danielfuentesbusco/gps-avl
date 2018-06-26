<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
	
	$stats = array();
	$stats[1]=0;
	$stats[2]=0;
	$stats[3]=0;
	$total = 0;
	$encendido = 0;
	$car_alarm = 0;
?>
<?php include("points.php");?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rastreo</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/font-awesome-animation.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
      #map-container { min-height: 755px; height: 100%;}
	  
	  .panel-fullscreen {
		display: block;
		z-index: 9999;
		position: fixed;
		width: 98%;
		/*height: 98%;*/
		top: 1%;
		right: 1%;
		left: 1%;
		/*bottom: 1%;*/
		overflow: auto;
	}
	
	.panel-actions {
	  margin-top: -17px;
	  margin-bottom: 0;
	  text-align: right;
	  margin-right: -6px;
	}
	.panel-actions a {
	  color:#333;
	}
    </style>
	
	<style type="text/css">
   .labels {
     //color: red;
     //background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
     //border: 1px solid black;
	// padding: 2px;
     //white-space: nowrap;
	 margin-top: 50px;
	 white-space: nowrap;
	-webkit-text-stroke: 1px #000;
	color: white;
	text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
   }
   
   .label_polygon {
     color: red;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   
  .label_green{
    color:  #00FF00;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   
   .label_brown{
    color:  #B25900;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   .label_purple{
    color:  #BF00FF;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   .label_red{
    color:  red;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   
   .label_yellow{
    color:  yellow;
     background-color: white;
     font-family: Verdana, "Arial", sans-serif;
     font-size: 14px;
     font-weight: bold;
     text-align: center;
	 white-space: nowrap;
     border: 1px solid black;
	 padding: 2px;
	 margin-top: 50px;
   }
   
   .fecha_reporte{
	font-size: 0.8em;
   }
   
   .estado-input-div {
	display:none;/* z-index: 1100000; */position: fixed;padding: 10px;z-index: 1100;width: 20%;background-color: whitesmoke;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;border: 1px #ddd solid;left: 40%;top: 20%;-webkit-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.44);-moz-box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.44);box-shadow: 0px 0px 25px 0px rgba(0,0,0,0.44);
   } 
   
   .estado-input-div input[type=text]{
	    margin-bottom: 10px;
   }
   
   .estado-input-div button {
	    float: right;
   }
   
   div.todo-transparente {
		background-color: rgb(0, 0, 0);
		opacity: 0.5;
		color: #000;
		height:100vh;
		position: absolute;
		width: 100%;
		z-index: 1050;
		top: 0;
		left: 0;
		display: none;
	}
	
	body {
		height: 100%;
	}
	
	.panel-title {
		/*margin-top: 7px;*/
	}
	
	.vehiculos-notification {
		cursor: pointer;
	}
	
	.navbar-header{
		/*display: none;*/
	}
	
	.tr_moviles{
		display: none;
	}
	
	.tr_group{
		cursor: pointer;
	}
   
 </style>
  </head>
  <body>
  <!-- Fixed navbar --> 
    <!--<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#008175;color:#97BE0D;">-->
	<div class="todo-transparente"></div>
    <?php include("menu.php"); ?>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<div style="float: right; width:45px;"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="cursor:pointer;color:#FFDF00;" data-toggle="tooltip" title="" data-original-title="GPS Desconectados"></i> <span id="car_alarm"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-power-off" aria-hidden="true" style="cursor:pointer;color:red;" data-toggle="tooltip" title="" data-original-title="Vehículos Apagados"></i> <span id="car_off"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-power-off" aria-hidden="true" style="cursor:pointer;color: #109618" data-toggle="tooltip" title="" data-original-title="Vehículos Encendidos"></i> <span id="car_on"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-car" aria-hidden="true" style="cursor:pointer;" data-toggle="tooltip" title="" data-original-title="Vehículos"></i> <span id="stats_car"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-home" aria-hidden="true" style="cursor:pointer;" data-toggle="tooltip" title="" data-original-title="En Base"></i> <span id="stats_base"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-map-pin" aria-hidden="true" style="cursor:pointer;" data-toggle="tooltip" title="" data-original-title="En Ruta"></i> <span id="stats_ruta"></span></div>
			<div style="float: right; width:45px;"><i class="fa fa-industry" aria-hidden="true" style="cursor:pointer;" data-toggle="tooltip" title="" data-original-title="En Relleno o Vertedero"></i> <span id="stats_kdm"></span></div>
			<h3 style="margin-top:0;">Rastreo <small>Ubicación en Tiempo Real</small></h3>
    	</div>
        <div class="row">
            <div class="col-md-3">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <!--<div class="btn-group pull-right">
                     <a href="#" class="btn btn-default btn-sm" id="mostrarPoly">Mostrar Polígonos</a>
                    </div>-->
                    <!--<h3 class="panel-title" style="padding-top:5px;">-->
                    <h3 class="panel-title">
                       Vehículos
                    </h3>
                  </div>
                  	<div style="height:715px; overflow: scroll;">
                    <table class="table table-hover" style="font-size: 100%; width: 100%;">
                        <!--<thead> 
                            <tr>	
								<th style="width: 100%;"></th>	-->
                                <!--<th style="width: 70px;">Vehículo / Último</th>	-->
                                <!--<th style="width: 80px;">Último</th>-->
								<!--<th>Estados</th>-->
								<!--<th>Ubicación</th>-->
								<!--<th>Señal</th>-->
                                <!--<th style="width: 100px;"></th>-->
                           <!-- </tr>
                        </thead>-->
                        <tbody> 
						<?php
						$i = 1;
						$username="root";
						$password="r1r7C1h6ZG4ZVWF";
						$database="traccar";
						$locations = array();
						$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
						mysql_select_db($database) or die(mysql_error());
						
						
						
						$q = "SELECT device_group.id, device_group.name FROM user_group_assign, device_group WHERE user_group_assign.user_id = $userid AND user_group_assign.device_group_id = device_group.id;";
						//echo $q;
						$resultado5 = mysql_query($q) or die(mysql_error()." ".$q);
						while ($row5 = mysql_fetch_array($resultado5)) {
							$i = 1;
							echo '<tr>';
							echo '<td style="width: 100%; height: 20px;" class="tr_group" group_id="'.$row5["id"].'">';
							echo '<div style="width: 100%;">';
							echo $row5["name"];
							echo '</div>';
							echo '</td>';
							echo '</tr>';
						
						$q = "SELECT devices.* FROM device_group_assign, devices WHERE device_group_assign.device_group_id = {$row5["id"]} AND device_group_assign.device_id = devices.id;";
						//echo $q;
						$resultado2 = mysql_query($q) or die(mysql_error()." ".$q);
							
							
						//$q = "SELECT * FROM devices where id IN (SELECT deviceid FROM user_device WHERE userid = $userid) order by ABS(name);";
						//if($_SESSION["uid"]=='9'||$_SESSION["uid"]=='11'||$_SESSION["uid"]=='12'){
						//	$q = "SELECT * FROM devices where installed = 1 order by ABS(name);";
						//}
						//$resultado2 = mysql_query($q) or die(mysql_error());
						while ($row2 = mysql_fetch_array($resultado2)) {
							$total++;
							//$q = "SELECT max(utc) as utc FROM device_info where device_id = {$row2["id"]}";
						//	$resultado = mysql_query($q) or die(mysql_error());
							$ultimo = "";
							$ultimo_reporte = "S/I";
						/*	if ($row = mysql_fetch_array($resultado)) {
								if(is_numeric($row["utc"])){
									$ultimo = strtotime($row["utc"])-10800;
									$ultimo_reporte = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
								}
							}*/
							
							$external = false;
							if($row2["external_supply"]==1){
								$external = true;
							}
							
							$q = "SELECT speed, latitude, longitude,utc FROM location_report where id = {$row2["last_id"]};";
							$resultado = mysql_query($q) or die(mysql_error());
							$ultima_posicion = "S/I";
							$velocidad = "S/I";
							$ubicacion = "Traslado";
							$latitude = "";
							$longitude = "";
							if ($row = mysql_fetch_array($resultado)) {
								$ultimo = strtotime($row["utc"])-10800;
                                $ultimo_reporte = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
								$velocidad = $row["speed"];
								$latitude = $row["latitude"];
								$longitude = $row["longitude"];
								$q = "SELECT name, tipo, vertices FROM geofences;";
								$resultado3 = mysql_query($q) or die(mysql_error());
								while ($row3 = mysql_fetch_array($resultado3)) {
									$pointLocation = new pointLocation();
									$polygon = explode(";", $row3["vertices"]);
									$location = $pointLocation->pointInPolygon($latitude." ".$longitude, $polygon);
									if($location!="outside"){
										$ubicacion = $row3["name"];
									}
									if($ubicacion!="Traslado"){
										$stats[$row3["tipo"]]++;
										/*if(!isset($stats[$ubicacion])){
											$stats[$ubicacion]=1;
										}else{
											$stats[$ubicacion]++;
										}*/
										break;
									}
								}
								//if(is_numeric($row["utc"])){
								//	$ultima_posicion = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
								//}
							}
							
							/*$q = "SELECT estado FROM ignition where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							$resultado = mysql_query($q) or die(mysql_error());
							$estado_motor = "Apagado";
							if ($row = mysql_fetch_array($resultado)) {
								if($row["estado"]=="1"){
									$estado_motor = "Encendido";
								}
							}*/
							
							
							
							/*$q = "SELECT data FROM device_info where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							$resultado = mysql_query($q) or die(mysql_error());
							$signal = "0";
							if ($row = mysql_fetch_array($resultado)) {
								$data = explode(",",$row["data"]);
								$signal = $data[6];
								$signal = 2.2446*$signal-120.13;
								if($signal <= -105){
									$signal = "0%";
								}elseif($signal <= -99 && $signal > -105){
									$signal = "20%";
								}elseif($signal <= -90 && $signal > -99){
									$signal = "40%";
								}elseif($signal <= -80 && $signal > -90){
									$signal = "60%";
								}elseif($signal <= -65 && $signal > -80){
									$signal = "80%";
								}elseif($signal > -65){
									$signal = "100%";
								}
							}*/
							
							//$q = "SELECT state FROM state_change where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							//$resultado = mysql_query($q) or die(mysql_error());
							$movimiento = false;
							$state = "";
							$estado_motor = "Apagado";
							if($row2["state"]=="12"||$row2["state"]=="22"||$row2["state"]=="42"||$row2["state"]=="16"||$row2["state"]=="1A"){
								$movimiento=true;
							}
							switch($row2["state"]){
								case '16':
									$state = "<!--Tow";
									break;
								case '1A':
									$state = "<!--Fake Tow";
									break;
								case '11':
									$state = "Apagado y Detenido<!--Ignition Off Rest";
									break;
								case '12':
									$state = "Apagado y en Movimiento<!--Ignition Off Motion";
									break;
								case '21':
									$estado_motor = "Encendido";
									$state = "Encendido y Detenido<!--Ignition On Rest";
									break;
								case '22':
									$estado_motor = "Encendido";
									$state = "Encendido y en Movimiento<!--Ignition On Motion";
									break;
								case '41':
									$state = "<!--Sensor Rest";
									break;
								case '42':
									$state = "<!--Sensor Motion";
									break;
							}
							
							if($row2["ignition_utc"]!=null&&$row2["ignition_utc"]!=""){
								$ignition_utc =  time() - (strtotime($row2["ignition_utc"])-10800);
								$ignition_utc = intval($ignition_utc / 60);
								$hora = floor($ignition_utc / 60);
								$minuto = $ignition_utc % 60;
								if($hora > 0) {
									$ignition_utc = $hora."h ".$minuto."m";
								}else{
									$ignition_utc = $minuto."m";
								}
								$ignition_utc = "hace $ignition_utc";
							}else{
								$ignition_utc = "";
							}
							
							$estado_motor = "Apagado";
							if($row2["ignition"]=="1"){
								$estado_motor = "Encendido";
								$encendido++;
							}
						?>
                    <tr class="tr_<?php echo $row5["id"];?> tr_moviles"> 
						<td style="width: 100%; height: 20px;">
							<div style="width: 100%;">
								<div style="width:30px; float: left;">
									<?php echo $i++;?>
								</div>
								<div style="width:60px; float: left;"> 
									<div class="vehiculos vehiculo-<?php echo $row2["name"];?>" number="<?php echo $row2["id"];?>" style="cursor:pointer;" id="veh-<?php echo $row2["id"];?>" lat="<?php echo $latitude;?>" lng="<?php echo $longitude;?>"><?php echo $row2["name"];?>
									 <div class="vehiculoInfo" style="display:none;">
										<div style="font-size:90%;">
											<h4>Vehículo <?php echo $row2["name"];?></h4>
											<h5>Reporte</h5>
											<span class="ultimo-reporte-<?php echo $row2["id"];?>"><?php echo $ultimo_reporte;?></span>
											<h5>Velocidad</h5>
											<span class="velocidad-<?php echo $row2["id"];?>"><?php echo $velocidad;?></span> Km/h
											<h5>Motor</h5>
											<?php echo $estado_motor;?> <?php echo $ignition_utc; ?>
											 <h5>IMEI</h5>
											<?php echo $row2["uniqueid"];?>
										</div>
									 </div>
								 </div>
								</div>
								<div style="width:80px; float: left;">
									<?php if($estado_motor=="Apagado") { ?>
									<i class="fa fa-power-off" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Apagado"></i>
									<?php } else { ?>
									<i class="fa fa-power-off" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo Encendido"></i>
									<?php } ?>
									<?php if($movimiento==true) { ?>
									<i class="fa fa-car" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo en Movimiento"></i>
									<?php } else { ?>
									<i class="fa fa-car" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Detenido"></i>
									<?php } ?>
									<?php if($external==true) { ?>
									<i class="fa fa-plug" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="GPS Conectado"></i>
									<?php } else { ?>
									<i class="fa fa-plug" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="GPS Desconectado"></i>
									<?php } ?>
									 <?php if($external!=true) { 
									$car_alarm++;
									 ?>
									 <!--animated-->
									 <i class="fa fa-exclamation-triangle faa-flash " aria-hidden="true" style="cursor:pointer;color: #FFDF00;" data-toggle="tooltip" title="El GPS ha sido desconectado de la fuente de energía!"></i>
									 <?php } ?>
								</div>
								<div style="width:100px; float: left;font-size:0.9em; margin-top: 4px; overflow: hidden;">
									<span class="ubicacion_<?php echo $row2["name"];?>" <?php if ($row2["estado"]!=null&&$row2["estado"]!=''){ echo "style=\"display:none;\"";}?>>
									<?php echo utf8_encode($ubicacion);?>
									</span>
									<span class="estado_<?php echo $row2["name"];?>" <?php if ($row2["estado"]==null||$row2["estado"]==''){ echo "style=\"display:none;\"";}?>>
										<?php echo $row2["estado"];?>
									</span>
								</div>
								<div style="width:80px; float: left; clear: right;">
									<div class="btn-group">
									  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Acciones <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu">
										<li><a href="#" class="set-estado" id="<?php echo $row2["name"];?>">Estado</a></li>
									  </ul>
									</div>
									<div class="estado-input-<?php echo $row2["name"];?> estado-input-div" style="">
										<h4 style="margin-top: 0;">Ingrese Estado</h4>
										<input type="text" placeholder="Ingrese estado para <?php echo $row2["name"];?>" class="form-control estado-txt-<?php echo $row2["name"];?>" movil="<?php echo $row2["name"];?>" value="<?php echo $row2["estado"];?>" /> <button class="btn btn-default btn-sm ok-estado" movil="<?php echo $row2["name"];?>" type="button" aria-haspopup="true" aria-expanded="false">
										Aceptar
										</button>
									</div>
								</div>
								<div style="margin-left:30px; width:200px; float: left; clear:left; margin-top: -10px;color: #A4A4A4;"> 
									<span class="fecha_reporte"><span class="minutos-<?php echo $row2["id"];?>"><?php if($ultimo!="") {echo (intval((time()-$ultimo)/60))."m";}else{echo "S/I";}?></span> - <span class="ultimo-reporte-<?php echo $row2["id"];?>"><?php echo $ultimo_reporte;?></span></span>
								</div>
							</div>
						</td>
					<!--
						<td style="padding-top: 14px;"><?php //echo $i++;?></td>
                     <td style="padding-top: 14px;">
                     <div class="vehiculos" number="<?php echo $row2["id"];?>" style="cursor:pointer;" id="veh-<?php echo $row2["id"];?>" lat="<?php echo $latitude;?>" lng="<?php echo $longitude;?>"><?php echo $row2["name"];?>
					 
                         <div class="vehiculoInfo" style="display:none;">
                         	<div style="font-size:90%;">
                                <h4>Vehículo <?php echo $row2["name"];?></h4>
                                <?php echo $ultimo_reporte;?>
                                <h5>Velocidad</h5>
                                <?php echo $velocidad;?> Km/h
                                <h5>Motor</h5>
                                <?php echo $estado_motor;?> <?php echo $ignition_utc; ?>
								 <h5>IMEI</h5>
                                <?php echo $row2["uniqueid"];?>
                            </div>
                         </div>
                     </div>
                     </td> 
					<td style="padding-top: 14px;" nowrap> <?php //if($ultimo!="") {echo (intval((time()-$ultimo)/60))."m";}else{echo "S/I";}?> <?php //echo date("d/m/Y h:i:s A");?></td>
					 <td style="padding-top: 14px;" nowrap>
						<?php if($estado_motor=="Apagado") { ?>
						<i class="fa fa-power-off" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Apagado"></i>
						<?php } else { ?>
						<i class="fa fa-power-off" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo Encendido"></i>
						<?php } ?>
						<?php if($movimiento==true) { ?>
						<i class="fa fa-car" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo en Movimiento"></i>
						<?php } else { ?>
						<i class="fa fa-car" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Detenido"></i>
						<?php } ?>
						<?php if($external==true) { ?>
						<i class="fa fa-plug" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="GPS Conectado"></i>
						<?php } else { ?>
						<i class="fa fa-plug" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="GPS Desconectado"></i>
						<?php } ?>
						 <?php if($external!=true) { 
						$car_alarm++;
						 ?>
						 <i class="fa fa-exclamation-triangle faa-flash animated" aria-hidden="true" style="cursor:pointer;color: #FFDF00;" data-toggle="tooltip" title="El GPS ha sido desconectado de la fuente de energía!"></i>
						 <?php } ?>
						</td>
						<td>
						<?php //echo $ubicacion;?>
					 </td>
					 <td>
					 <div class="btn-group" style="float: right;">
					  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Acciones <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
						<li><a href="#">Definir estado</a></li>
					  </ul>
					</div>
					-->
					 
					 <?php //echo $ubicacion;?></td>
					 <!--
					 <td style="padding-top: 14px;" nowrap>
						<?php //echo $state;?>
					 </td>
					 -->
					 <!--
					 <td style="padding-top: 14px;" nowrap>
						<?php //echo $signal?>
					 </td>
					 -->
					 <!--
                     <td style="padding-top: 14px;">
                         <i class="fa fa-circle" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo en Vertedero"></i>
                         <i class="fa fa-signal" aria-hidden="true" style="color: green;cursor:pointer;" data-toggle="tooltip" title="Señal GPS buena"></i>
                         <i class="fa fa-square" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Detenido"></i>
                         <i class="fa fa-batery-full" aria-hidden="true" style="color: green;" title=""></i>
                     </td>
					 -->
					 <!--
                     <td>
                    <div class="btn-group pull-right">
                      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Acciones <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                      <li><a href="#"><i class="fa fa-crosshairs" aria-hidden="true"></i> Centrar en el mapa</a></li>
                                <li><a href="#"><i class="fa fa-bell-o" aria-hidden="true"></i> Ver alertas</a></li>
                                <li><a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i> Ver historial</a></li>
                                 <li><a href="#"><i class="fa fa-location-arrow" aria-hidden="true"></i> Solicitar ubicación</a></li>
                                <li><a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Verificar dispositivo</a></li>
                                <li><a href="#"><i class="fa fa-lock" aria-hidden="true"></i> Desactivar motor</a></li>
                                <li><a href="#"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Reactivar motor</a></li>
                      </ul>
                    </div>
                    </td>
					-->					
                    </tr>
					<?php }
					
					}
						//mysql_close($link);
						echo '<tr>';
						echo '<td style="width: 100%; height: 1px;">';
						echo '<div style="width: 100%;">';
						echo '</div>';
						echo '</td>';
						echo '</tr>';
					?>
                        </tbody>
                    </table>
					</div>
                    <!--<div class="panel-body">
						Ubicación de vehículos según color:<br />
                        <i class="fa fa-circle" aria-hidden="true" style="color: #3366cc;"></i> Ruta
                        <i class="fa fa-circle" aria-hidden="true" style="color: #109618;"></i> Vertedero
                        <i class="fa fa-circle" aria-hidden="true" style="color: #dc3912;"></i> Base
                        <i class="fa fa-circle" aria-hidden="true" style="color: #ff9900;"></i> Taller
                    </div>-->
                </div>
            </div>
        	<div class="col-md-9">
            	<div class="panel panel-default">
                  <div class="panel-body"  style="padding:0;">
					<!--
					<div class="btn-group pull-right" style="position: absolute;   z-index: 1000;    top: 10px;right: 180px;">
						<input type="checkbox" class="form-control movil-alertas" style="position: absolute;   z-index: 1000;    top: 10px;right: 260px; width: 300px" /> Mostrar alarmas
					</div>
					-->
					<input type="text" placeholder="Ingrese móvil o dirección" class="form-control movil-busqueda" style="position: absolute;   z-index: 1000;    top: 10px;right: 260px; width: 300px" />
					
					<div class="btn-group pull-right" style="position: absolute;   z-index: 1000;    top: 10px;right: 180px;">
						<a href="#" class="btn btn-default" id="buscarMovil">Buscar</a>
                    </div>
					<div class="btn-group pull-right" style="position: absolute;   z-index: 1000;    top: 10px;right: 30px;">
						<a href="#" class="btn btn-default" id="mostrarPoly">Mostrar Polígonos</a>
                    </div>
                  	<div id="map-container"></div>
                  </div>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
    
    <footer class="footer">
      <div class="container">
        <p class="text-muted" style="color: #008175;">Sistema de Rastreo 1.0 / Servitrans / 2016 &copy; Todos los derechos reservados / Actualizado el <span id="fecha"><?php echo date("d/m/Y");?> a las <?php echo date("H:i");?> hrs.</span></p>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAr_-4pxrC16Ii95y8KeviDojtob5kgTiU&libraries=drawing,geometry"></script>
	<script src="js/markerwithlabel.js"></script>
	<script src="js/bootstrap-notify-master/bootstrap-notify.min.js"></script>
    <script>	
		var map;
		var var_location;
		var infowindow = null;
		var markersArray = [];
		var polyArray = [];
		var polyMarkers = [];
		var polyState = false;
		
      function init_map() {
		var_location = new google.maps.LatLng(-33.3266167,-70.7164856);
        var var_mapoptions = {
          center: var_location,
          zoom: 14
        };
		map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);
		
		// Despliegue de poligonos
		var poligonos = [];
		var poligonos_nombre = [];
		<?php
			$id=$_GET["gid"];
			$username="root";
			$password="r1r7C1h6ZG4ZVWF";
			$database="traccar";
			
			$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
			mysqli_select_db($link, $database) or die(mysqli_error());
			
			$q = "SELECT geofences.name, geofences.vertices FROM traccar.geofences, traccar.geofence_user where traccar.geofences.id = traccar.geofence_user.geofence_id and traccar.geofence_user.user_id = $userid;";
			
			if($_SESSION["uid"]=='9'||$_SESSION["uid"]=='11'||$_SESSION["uid"]=='12'){
				$q = "SELECT name, vertices FROM traccar.geofences;";
			}

			$resultado = mysqli_query($link, $q) or die(mysqli_error());
			$i=0;
			while ($row = mysqli_fetch_array($resultado)) {
				$locations = array();
				$i++;
				$coor = explode(";", $row["vertices"]);
				foreach($coor as $key => $value){
					$t = explode(" ", $value);
					$locations[] = "{lat: {$t[0]}, lng: {$t[1]}}";
				}
				echo "poligonos.push(\"[".implode(",",$locations)."]\");";
				echo "poligonos_nombre.push(\"".utf8_encode($row["name"])."\");";
			}
			mysqli_close($link);
		?>
	
			//console.log(poligonos.length);
		$("#mostrarPoly").click(function(){
			if(!polyState){
				polyState = true;
				if (polyArray) {
					for (i in polyArray) {
						polyArray[i].setMap(null);
					}
				}
				
				if (polyMarkers) {
					for (i in polyMarkers) {
						polyMarkers[i].setMap(null);
					}
				}
				
				for (var i =0; i < poligonos.length; i++) {
					var fill = "#FF0000";
					var name = poligonos_nombre[i];
					if(name.substr(0, 4)=="0211"||name.substr(0, 4)=="0212"||name.substr(0, 4)=="0221"||name.substr(0, 4)=="0222"||name.substr(0, 4)=="0315"){
						fill = "#00FF00";
					}
					if(name.substr(0, 4)=="0412"||name.substr(0, 4)=="0411"||name.substr(0, 4)=="0413"||name.substr(0, 4)=="0421"||name.substr(0, 4)=="0422"){
						fill = "#B25900";
					}
					if(name.substr(0, 4)=="0515"){
						fill = "#BF00FF";
					}
					if(name.substr(0, 4)=="0612"){
						fill = "red";
					}
					if(name.substr(0, 4)=="0611"||name.substr(0, 4)=="0711"||name.substr(0, 4)=="0712"){
						fill = "yellow";
					}
					//console.log(eval(poligonos[i]));
					var poly = new google.maps.Polygon({
						paths: eval(poligonos[i]),
						//strokeColor: '#FF0000',
						//strokeOpacity: 0.8,
						//strokeWeight: 2,
						fillColor: fill,
						fillOpacity: 0.2,
						clickable: false,
						editable: false,
					});
					polyArray.push(poly);
					poly.setMap(map);
					//console.dir(poly);
					var coors = eval(poligonos[i]);
					//console.log(poligonos[i]);
					var bounds = new google.maps.LatLngBounds();
					for (var j = 0; j < coors.length; j++) {
						bounds.extend(new google.maps.LatLng(coors[j].lat, coors[j].lng));
					}
					
					var image = 'blank.png';
					
					var style = "label_polygon";
					
					if(name.substr(0, 4)=="0211"||name.substr(0, 4)=="0212"||name.substr(0, 4)=="0221"||name.substr(0, 4)=="0222"||name.substr(0, 4)=="0315"){
						style = "label_green";
					}
					
					if(name.substr(0, 4)=="0412"||name.substr(0, 4)=="0411"||name.substr(0, 4)=="0413"||name.substr(0, 4)=="0421"||name.substr(0, 4)=="0422"){
						style = "label_brown";
					}
					
					if(name.substr(0, 4)=="0515"){
						style = "label_purple";
					}
					if(name.substr(0, 4)=="0612"){
						style = "label_red";
					}
					if(name.substr(0, 4)=="0611"||name.substr(0, 4)=="0711"||name.substr(0, 4)=="0712"){
						fill = "label_yellow";
					}
					
					
					var marker1 = new MarkerWithLabel({
						position: bounds.getCenter(),
						draggable: true,
						raiseOnDrag: true,
						icon: image,
						map: map,
						labelContent: name,
						labelAnchor: new google.maps.Point(30, 30),
						labelClass: style,
						labelStyle: {opacity: 1}
					});
					polyMarkers.push(marker1);
				}
				$("#mostrarPoly").text("Ocultar Polígonos");
			}else{
				polyState = false;
				if (polyArray) {
					for (i in polyArray) {
						polyArray[i].setMap(null);
					}
				}
				if (polyMarkers) {
					for (i in polyMarkers) {
						polyMarkers[i].setMap(null);
					}
				}
				$("#mostrarPoly").text("Mostrar Polígonos");
			}
			return false;
		});
		
		//var trafficLayer = new google.maps.TrafficLayer();
		//trafficLayer.setMap(map);
		var boundsset = false;
		
		var get_data = function(first){
			$.get("map-feed.php?uid="+<?php echo $userid;?>, function(data){
				var bounds = new google.maps.LatLngBounds();
				var locations = eval(data);
				if (markersArray) {
					for (i in markersArray) {
						markersArray[i].setMap(null);
					}
				}
				for (i = 0; i < locations.length; i++) { 
					var color = "red";
					var path = google.maps.SymbolPath.CIRCLE;
					if(locations[i][6]=="1"){
						color = "#109618";
						path = google.maps.SymbolPath.FORWARD_CLOSED_ARROW;
					}
					var id = locations[i][7];
					var lat = locations[i][1];
					var lng = locations[i][2];
					var speed = locations[i][3];
					speed = parseFloat(speed);
					var d = Date.parse(locations[i][8]);
					var d2 = (new Date()).getTime();
					var m = Math.round((d2 - d)/60000);
					if(speed>100.0){
						if(m<=1){
							$.notify({
								title: "<strong>Alerta de Velocidad</strong><br />",
								message: "<span class=\"vehiculos-notification\" vid=\""+locations[i][7]+"\">Vehículo "+locations[i][0]+" reportó velocidad de "+speed+" km/h hace "+m+"m.</span>"
							},{
								type: 'danger',
								newest_on_top: true,
								delay: 10000,
								placement: {
									from: "bottom",
									align: "right"
								},
								//timer: 2500,
								mouse_over: 'pause'
							});
						}
					}
					
					// Notificacion de Ignición
					if(localStorage.getItem("ignOn_"+locations[i][7])!=null&&localStorage.getItem("ignOn_"+locations[i][7])!=locations[i][9]&&locations[i][6]=="1"){
						var d = Date.parse(locations[i][9]);
						var d2 = (new Date()).getTime();
						var m = Math.round((d2 - d)/60000);
						if(m<=1){
							$.notify({
								title: "<strong>Alerta de Encendido</strong><br />",
								message: "<span class=\"vehiculos-notification\" vid=\""+locations[i][7]+"\">Vehículo "+locations[i][0]+" fue encencido hace "+m+"m.</span>"
							},{
								type: 'success',
								newest_on_top: true,
								delay: 10000,
								placement: {
									from: "bottom",
									align: "right"
								},
								//timer: 2500,
								mouse_over: 'pause'
							});
						}
						localStorage.setItem("ignOn_"+locations[i][7],locations[i][9]);
					}
					
					if(localStorage.getItem("ignOn_"+locations[i][7])==null){
						localStorage.setItem("ignOn_"+locations[i][7],locations[i][9]);
					}
					
					// Notificacion de Ignición
					if(localStorage.getItem("ignOff_"+locations[i][7])!=null&&localStorage.getItem("ignOff_"+locations[i][7])!=locations[i][9]&&locations[i][6]=="0"){
						var d = Date.parse(locations[i][9]);
						var d2 = (new Date()).getTime();
						var m = Math.round((d2 - d)/60000);
						if(m<=1){
							$.notify({
								title: "<strong>Alerta de Apagado</strong><br />",
								message: "<span class=\"vehiculos-notification\" vid=\""+locations[i][7]+"\">Vehículo "+locations[i][0]+" fue apagado hace "+m+"m.</span>"
							},{
								type: 'warning',
								newest_on_top: true,
								delay: 10000,
								placement: {
									from: "bottom",
									align: "right"
								},
								//timer: 2500,
								mouse_over: 'pause'
							});
						}
						localStorage.setItem("ignOf_"+locations[i][7],locations[i][9]);
					}
					
					if(localStorage.getItem("ignOf_"+locations[i][7])==null){
						localStorage.setItem("ignOf_"+locations[i][7],locations[i][9]);
					}
					
					// Actualización de valores
					$("#veh-"+id).attr("lat",lat);
					$("#veh-"+id).attr("lng",lng);
					$(".velocidad-"+id).text(speed);
					$(".minutos-"+id).text(m+"m");
					$(".ultimo-reporte-"+id).text(locations[i][4]);
					
				/*  marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
					icon: {
						path: path,
						scale: 4,
						rotation: locations[i][5],
						strokeColor: color
					  }
				  });*/
				  
				  var marker = new MarkerWithLabel({
						position: new google.maps.LatLng(locations[i][1], locations[i][2]),
						draggable: false,
						raiseOnDrag: false,
						icon: {
							path: path,
							scale: 4,
							rotation: locations[i][5],
							strokeColor: color
						  },
						map: map,
						labelContent: locations[i][0],
						labelAnchor: new google.maps.Point(22, 0),
						labelClass: "labels",
						labelStyle: {opacity: 1}
					});
					
					//marker.setMap(map);
				  //markersArray.push(marker);
				  markersArray[id] = marker;
				  if(first){
					  if(!boundsset){
						bounds.extend(marker.position);
						map.fitBounds(bounds);
					  }
				  }
				  
				 /* var latlng = {lat: parseFloat(locations[i][1]), lng: parseFloat(locations[i][2])};
				  var address = "";
				   geocoder.geocode({'location': latlng}, function(results, status) {
						if (status === google.maps.GeocoderStatus.OK) {
						  if (results[1]) {
							address = results[1].formatted_address;
						  } else {
							console.log(locations[i][0]+ 'No results found');
							//window.alert('No results found');
						  }
						} else {
							console.log(locations[i][0]+' Geocoder failed due to: ' + status);
						 // window.alert('Geocoder failed due to: ' + status);
						}
					});*/
				  
				  google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						if (infowindow) {
							infowindow.close();
						}
						var contentString = '<div style="font-size:90%;">'+
								'<h4>Vehículo '+locations[i][0]+'</h4>'+
								'<h5>Fecha</h5>'+
								locations[i][4]+
								'<h5>Velocidad</h5>'+
								locations[i][3]+' Km/h'+
								//'<h5>Dirección</h5>'+
								//address+' Km/h'+
							'</div>';
						//var infowindow = new google.maps.InfoWindow({ });
						infowindow = new google.maps.InfoWindow({ });
						infowindow.setContent(contentString);
						infowindow.open(map, marker);
					}
				  })(marker, i));
				}
				boundsset=true;
			});
			var d = new Date();
			var m = d.getMonth() + 1;
			// 28/11/2016 03:50:36 PM
			var minutes = d.getMinutes();
			var hours = d.getHours();
			if(minutes<10){
				minutes = "0"+minutes;
			}
			if(hours<10){
				hours = "0"+hours;
			}
			$("#fecha").text(d.getDate()+"/"+m+"/"+d.getFullYear()+" a las "+hours+":"+minutes+" hrs.");
		}
		
		get_data(true);
		setInterval(function(){ 
			get_data(false);
		}, 20000);
      
		geocoder = new google.maps.Geocoder();
		$("#buscarMovil").click(function(){
			var movil = $(".movil-busqueda").val();
			if(movil!=""&&$.isNumeric(movil)){
				$(".vehiculo-"+movil).click();
				$(".vehiculo-"+movil).focus();
			}else if(movil!=""&&!$.isNumeric(movil)){
				// Es dirección
				geocoder.geocode( { 'address': movil}, function(results, status) {
				  if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
				  } else {
					alert("La dirección ingresada no es válida.");
				  }
				});
			}
		});
		
		$("body").on('click', '.vehiculos-notification', function(){
			var id = $(this).attr("vid");
			$("#veh-"+id).click();
			$(this).closest(".alert-warning").remove();
		});
	}
	  
	
	
	
	
	
	/*//strokeColor: '#FF0000',
			//strokeOpacity: 0.8,
			//strokeWeight: 2,
			//fillColor: '#FF0000',
			//fillOpacity: 0.35
			*/

 
      google.maps.event.addDomListener(window, 'load', init_map);
 		
		$('.vehiculos').click(function(){
			var number = $(this).attr("number");
			map.setCenter(new google.maps.LatLng($(this).attr("lat"), $(this).attr("lng")));
			map.setZoom(17);
			google.maps.event.trigger(markersArray[number], 'click');
		});
		
		
		
		$(document).ready(function () {
		
			$(".set-estado").click(function(){
				$(".estado-input-div").hide();
				var id = $(this).attr("id");
				console.log(id);
				$(".todo-transparente").show();
				$(".estado-input-"+id).show();
			});
			
			$(".ok-estado").click(function(){
				var id = $(this).attr("movil");
				$(".estado-input-"+id).hide();
				
				var val = $(".estado-txt-"+id).val();
				if(val==""){
					$(".ubicacion_"+id).show();
					$(".estado_"+id).text("");
					$(".estado_"+id).hide();
				}else{
					$(".ubicacion_"+id).hide();
					$(".estado_"+id).text(val);
					$(".estado_"+id).show();
				}
				$.get( "set-state.php?m="+id+"&s="+val, function( data ) {});
				$(".todo-transparente").hide();
			});
		});
		
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip(); 
			
			$('.vehiculos').each(function() {
			  var $this = $(this);
			  $this.popover({
				trigger: 'hover',
				placement: 'right',
				html: true,
				content: $this.find('.vehiculoInfo').html() 
			  });
			});
			
			$(".tr_group").click(function(){
				var group_id = $(this).attr("group_id");
				$(".tr_"+group_id).toggle();
			});
			
			$("#stats_base").text('<?php echo (@$stats[2]=="")?'0':@$stats[2]; ?>');
			$("#stats_ruta").text('<?php echo $total - @$stats[2] - @$stats[3]; ?>');
			$("#stats_kdm").text('<?php echo (@$stats[3]=="")?'0':@$stats[3]; ?>');
			$("#stats_car").text('<?php echo $total; ?>');
			$("#car_on").text('<?php echo $encendido; ?>');
			$("#car_off").text('<?php echo $total - $encendido; ?>');
			$("#car_alarm").text('<?php echo $car_alarm; ?>');
		});
    </script>
  </body>
</html>