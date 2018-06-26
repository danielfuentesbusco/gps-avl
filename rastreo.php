<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rastreo Servitrans</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
      #map-container { min-height: 700px; height: 100%;}
	  
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
  </head>
  <body>
  <!-- Fixed navbar -->
    <!--<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#008175;color:#97BE0D;">-->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
        	<img src="img/logo-servitrans.png" height="50" style="margin-right:10px;" />
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="./index.php"><span class="fa fa-tachometer"></span> Dashboard</a></li>
            <li class="active"><a href="./rastreo.php"><span class="fa fa-map-marker"></span> Rastreo</a></li>
            <li><a href="./geocercas.php"><span class="fa fa-map-o"></span> Geocercas</a></li>
            <li><a href="#"><span class="fa fa-map-signs"></span> Rutas</a></li>
            <li><a href="#"><span class="fa fa-truck"></span> Vehiculos</a></li>
            <li><a href="#"><span class="fa fa-bell-o"></span> Eventos</a></li>
            <li><a href="#"><span class="fa fa-history"></span> Historial</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              	<span class="fa fa-file-text-o"></span> Reportes <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="#">Ubicación Vehículos</a></li>
                <li><a href="#">Uso Combustible</a></li>
                <li><a href="#">Retiro Desecho</a></li>
                <li><a href="#">Km Recorridos Vehículos</a></li>
                <li><a href="#">Km Recorridos Conductores</a></li>
                <li><a href="#">Detenciones Prolongadas</a></li> 
                <li><a href="#">Velocidades</a></li> 
                <li><a href="#">Estimación Revisiones</a></li> 
                <li><a href="#">Geocercas</a></li> 
                <li><a href="#">Rutas</a></li> 
                <li><a href="#">Turnos</a></li> 
                <!--
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
                -->
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="fa fa-user"></span> Perfil</a></li>
            <li><a href="#"><span class="fa fa-sign-out"></span> Salir</a></li>
            <!--
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
            -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Rastreo <small>Ubicación en Tiempo Real</small></h3>
    	</div>
        <div class="row">
            <div class="col-md-4">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <!--<a href="#" class="btn btn-default btn-sm">Ver Detalle</a>-->
                    </div>
                    <!--<h3 class="panel-title" style="padding-top:5px;">-->
                    <h3 class="panel-title">
                       Vehículos
                    </h3>
                  </div>
                  	
                    <table class="table table-hover">
                        <thead> 
                            <tr>	
                                <th style="width: 70px;">Vehículo</th>	
                                <th style="width: 80px;">Último</th>
								<th>Motor</th>
                                <th>Movimiento</th>
								<th>Estado</th>
								<th>Señal</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody> 
						<?php
						$username="root";
						$password="r1r7C1h6ZG4ZVWF";
						$database="traccar";
						$locations = array();
						//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
						$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
						mysql_select_db($database) or die(mysql_error());
						$q = "SELECT * FROM devices where installed=1 order by ABS(name);";
						$resultado2 = mysql_query($q) or die(mysql_error());
						while ($row2 = mysql_fetch_array($resultado2)) {
							$q = "SELECT max(utc) as utc FROM device_info where device_id = {$row2["id"]} ";
							$resultado = mysql_query($q) or die(mysql_error());
							$ultimo = "";
							$ultimo_reporte = "S/I";
							if ($row = mysql_fetch_array($resultado)) {
								if(is_numeric($row["utc"])){
									$ultimo = strtotime($row["utc"])-10800;
									$ultimo_reporte = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
								}
							}
							
							$q = "SELECT utc, speed FROM location_report where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							$resultado = mysql_query($q) or die(mysql_error());
							$ultima_posicion = "S/I";
							$velocidad = "S/I";
							if ($row = mysql_fetch_array($resultado)) {
								$velocidad = $row["speed"];
								if(is_numeric($row["utc"])){
									$ultima_posicion = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
								}
							}
							
							/*$q = "SELECT estado FROM ignition where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							$resultado = mysql_query($q) or die(mysql_error());
							$estado_motor = "Apagado";
							if ($row = mysql_fetch_array($resultado)) {
								if($row["estado"]=="1"){
									$estado_motor = "Encendido";
								}
							}*/
							
							$q = "SELECT data FROM device_info where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
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
							}
							
							$q = "SELECT state FROM state_change where device_id = {$row2["id"]} ORDER BY utc DESC LIMIT 1;";
							$resultado = mysql_query($q) or die(mysql_error());
							$movimiento = false;
							$state = "";
							$estado_motor = "Apagado";
							if ($row = mysql_fetch_array($resultado)) {
								if($row["state"]=="12"||$row["state"]=="22"||$row["state"]=="42"||$row["state"]=="16"||$row["state"]=="1A"){
									$movimiento=true;
								}
								switch($row["state"]){
									case '16':
										$state = "Tow";
										break;
									case '1A':
										$state = "Fake Tow";
										break;
									case '11':
										$state = "Ignition Off Rest";
										break;
									case '12':
										$state = "Ignition Off Motion";
										break;
									case '21':
										$estado_motor = "Encendido";
										$state = "Ignition On Rest";
										break;
									case '22':
										$estado_motor = "Encendido";
										$state = "Ignition On Motion";
										break;
									case '41':
										$state = "Sensor Rest";
										break;
									case '42':
										$state = "Sensor Motion";
										break;
								}
							}
						?>
                    <tr> 
                     <td style="padding-top: 14px;">
                     <div class="vehiculos" style="cursor:pointer;"><?php echo $row2["name"];?>
                         <div class="vehiculoInfo" style="display:none;">
                         	<div style="font-size:90%;">
                                <h4>Vehículo <?php echo $row2["name"];?></h4>
                                <h5>Conductor</h5>
                                Daniel Fuentes Busco
                                <h5>Último Reporte</h5>
                                <?php echo $ultimo_reporte;?>
                                <h5>Última Posición</h5>
                                <?php echo $ultima_posicion;?>
                                <h5>Última velocidad</h5>
                                <?php echo $velocidad;?>Km/h
                                <h5>Velocidad Máxima</h5>
                                97Km/h
                                <h5>Batería GPS</h5>
                                95%
                                <h5>Motor</h5>
                                <?php echo $estado_motor;?>
                                <h5>Dirección</h5>
                                Avenida Vizcaya 260, Pudahuel.
                            </div>
                         </div>
                     </div>
                     </td> 
                     <td style="padding-top: 14px;" nowrap> <?php if($ultimo!="") {echo (intval((time()-$ultimo)/60))."m";}else{echo "S/I";}?> <?php //echo date("d/m/Y h:i:s A");?></td>
					 <td style="padding-top: 14px;" nowrap>
						<?php if($estado_motor=="Apagado") { ?>
						<i class="fa fa-circle" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip"></i>
						<?php } else { ?>
						<i class="fa fa-circle" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip"></i>
						<?php } ?>
					 </td>
					 <td style="padding-top: 14px;" nowrap>
						<?php if($movimiento==true) { ?>
						<i class="fa fa-circle" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip"></i>
						<?php } else { ?>
						<i class="fa fa-circle" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip"></i>
						<?php } ?>
					 </td>
					 <td style="padding-top: 14px;" nowrap>
						<?php echo $state;?>
					 </td>
					  <td style="padding-top: 14px;" nowrap>
						<?php echo $signal?>
					 </td>
					 <!--
                     <td style="padding-top: 14px;">
                         <i class="fa fa-circle" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo en Vertedero"></i>
                         <i class="fa fa-signal" aria-hidden="true" style="color: green;cursor:pointer;" data-toggle="tooltip" title="Señal GPS buena"></i>
                         <i class="fa fa-square" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Detenido"></i>
                         <i class="fa fa-batery-full" aria-hidden="true" style="color: green;" title=""></i>
                     </td>
					 -->
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
                    </tr>
					<?php }
						mysql_close($link);
					?>
                        </tbody>
                    </table>
                    <!--<div class="panel-body">
						Ubicación de vehículos según color:<br />
                        <i class="fa fa-circle" aria-hidden="true" style="color: #3366cc;"></i> Ruta
                        <i class="fa fa-circle" aria-hidden="true" style="color: #109618;"></i> Vertedero
                        <i class="fa fa-circle" aria-hidden="true" style="color: #dc3912;"></i> Base
                        <i class="fa fa-circle" aria-hidden="true" style="color: #ff9900;"></i> Taller
                    </div>-->
                </div>
            </div>
        	<div class="col-md-8">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" id="panel-fullscreen" class="btn btn-default btn-sm" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                       Ubicación de Vehículos
                    </h3>
                  </div>
                  <div class="panel-body"  style="padding:0;">
                  	<div id="map-container"></div>
                  </div>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
    
    <footer class="footer">
      <div class="container">
        <p class="text-muted" style="color: #008175;">Sistema de Rastreo 1.0 / Servitrans / Cumsensu / 2016 &copy; Todos los derechos reservados / <?php echo date("d/m/Y h:i:s A");?></p>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAr_-4pxrC16Ii95y8KeviDojtob5kgTiU"></script>
    <script>	
		var map;
		var var_location;
      function init_map() {
	  
		<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="traccar";
		$locations = array();
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$q = "SELECT name, id FROM devices where installed=1;";
		$resultado2 = mysql_query($q) or die(mysql_error());
		while ($row2 = mysql_fetch_array($resultado2)) {
			$q = "SELECT location_report.latitude, location_report.longitude, location_report.speed, location_report.utc, location_report.heading FROM location_report WHERE location_report.latitude!=0 and location_report.longitude!=0 and location_report.device_id={$row2["id"]} ORDER BY location_report.utc DESC LIMIT 1";
			$resultado = mysql_query($q) or die(mysql_error());
			while ($row = mysql_fetch_array($resultado)) {
				$utc = date("d/m/Y h:i:s A",strtotime($row[3])-10800);
				$locations[] = "['{$row2["name"]}',{$row[0]},{$row[1]},{$row[2]}, '$utc', {$row[4]}]";
			}
		}
		mysql_close($link);
		?>
		
		var bounds = new google.maps.LatLngBounds();
		var locations = [<?php echo implode(",",$locations);?>];
		var_location = new google.maps.LatLng(-33.3266167,-70.7164856);
        var var_mapoptions = {
          center: var_location,
          zoom: 14
        };
		//var var_marker = new google.maps.Marker({
			//position: var_location,
			//map: var_map,
			//title:""});
		map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);
		  for (i = 0; i < locations.length; i++) {  
			  marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				map: map,
				icon: {
					path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
					scale: 5,
					rotation: locations[i][5]
				  },
			  });
			  marker.setMap(map);
			  bounds.extend(marker.position);
			  map.fitBounds(bounds);
			  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				var contentString = '<div style="font-size:90%;">'+
							'<h4>Vehículo '+locations[i][0]+'</h4>'+
							'<h5>Conductor</h5>'+
							'Daniel Fuentes Busco'+
							'<h5>Fecha</h5>'+
							locations[i][4]+
							'<h5>Velocidad</h5>'+
							locations[i][3]+'Km/h'+
							'<h5>Estado</h5>'+
							'En Movimiento/Detenido/Apagado'+
							'<h5>Dirección</h5>'+
							'Avenida Vizcaya 260, Pudahuel.'+
						'</div>';
				  var infowindow = new google.maps.InfoWindow({ });
				  infowindow.setContent(contentString);
				  infowindow.open(map, marker);
				}
			  })(marker, i));
			}
		 
		//var_marker.setMap(var_map);	
      }
 
      google.maps.event.addDomListener(window, 'load', init_map);
 		
		$(document).ready(function () {
			//Toggle fullscreen
			$("#panel-fullscreen2").click(function (e) {
				var full_screen_height = window.innerHeight - 100;
				e.preventDefault();
				
				var $this = $(this);
			
				if ($this.children('i').hasClass('glyphicon-resize-full'))
				{
					$this.children('i').removeClass('glyphicon-resize-full');
					$this.children('i').addClass('glyphicon-resize-small');
					document.getElementById("map-container").style.width = "100%";
					document.getElementById("map-container").style.height = full_screen_height+"px";
				}
				else if ($this.children('i').hasClass('glyphicon-resize-small'))
				{
					$this.children('i').removeClass('glyphicon-resize-small');
					$this.children('i').addClass('glyphicon-resize-full');
					document.getElementById("map-container").style.width = "100%";
					document.getElementById("map-container").style.height = "500px"
				}
				$(this).closest('.panel').toggleClass('panel-fullscreen');
    			google.maps.event.trigger(var_map,"resize");
				var_map.setCenter(var_location);
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
		});
		
		

    </script>
  </body>
</html>
