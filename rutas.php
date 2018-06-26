<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
	
		if(!isset($_POST["fi"])){
		$_POST["fi"]=date("Y-m-d",time()-3600);
	}
	if(!isset($_POST["ft"])){
		$_POST["ft"]=date("Y-m-d");
	}
	if(!isset($_POST["ht"])){
		$_POST["ht"]=date("H:i:s");
	}
	if(!isset($_POST["hi"])){
		$_POST["hi"]=date("H:i:s",time()-3600);
	}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rutas Servitrans</title>

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
    <?php include("menu.php"); ?>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Rutas <small>Despliegue de Recorridos</small></h3>
    	</div>
        <div class="row">
            <div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <!--<a href="#" class="btn btn-default btn-sm">Ver Detalle</a>-->
                    </div>
                    <!--<h3 class="panel-title" style="padding-top:5px;">-->
                    <h3 class="panel-title">
                       Filtros
                    </h3>
                  </div>
				  <div class="panel-body">
				  <form method="post">
				 <div class="row">
				  <div class="col-md-2">
				  Vehículo
				  </div>
				  <div class="col-md-2">
				  Fecha Inicio
				  </div>
				  
				  <div class="col-md-2">
				  Hora Inicio
				  </div>
				   
				  <div class="col-md-2">
				  Fecha Término
				  </div>
				  
				  <div class="col-md-2">
				  Hora Término
				  </div>
				  
					<div class="col-md-2">
					 </div>
					 </div>
				  <div class="row">
				  <div class="col-md-2">
					<div class="form-group">
					<select name="vid" class="form-control">
						<?php
						$username="root";
						$password="r1r7C1h6ZG4ZVWF";
						$database="traccar";
						$locations = array();
						//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
						$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
						mysql_select_db($database) or die(mysql_error());
						$q = "SELECT device_group.id, device_group.name FROM user_group_assign, device_group WHERE user_group_assign.user_id = $userid AND user_group_assign.device_group_id = device_group.id;";
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<optgroup label="<?php echo $row["name"];?>">
						<?php
							$q = "SELECT devices.id, devices.name FROM device_group_assign, devices WHERE device_group_assign.device_group_id = {$row["id"]} AND device_group_assign.device_id = devices.id;";
							$resultado2 = mysql_query($q) or die(mysql_error());
							while ($row2 = mysql_fetch_array($resultado2)) {
						?>
							<option value="<?php echo $row2["id"];?>"<?php echo (@$_POST["vid"]==$row2["id"]) ? " selected=\"selected\"" : "";?>><?php echo $row2["name"];?></option>
						<?php
							}
						?>
							</optgroup>
					<?php }
						mysql_close($link);
					?>
                     </select>
						 </div>
				  </div>
				  <div class="col-md-2">
					<div class="form-group">
					<input type="date" name="fi" class="form-control" value="<?php echo @$_POST["fi"];?>" max="<?php echo date("Y-m-d");?>" />
						 </div>
				  </div>
				  
				  <div class="col-md-2">
				  <div class="form-group">
					
					<input type="time" class="form-control" name="hi" value="<?php echo $_POST["hi"];?>" step="1">
				  </div>
				  </div>
				   
				  <div class="col-md-2">
					<div class="form-group">
					<input type="date" name="ft" class="form-control" value="<?php echo @$_POST["ft"];?>" max="<?php echo date("Y-m-d");?>" />
						 </div>
				  </div>
				  
				  <div class="col-md-2">
				  <div class="form-group">
					<input type="time" class="form-control" name="ht" value="<?php echo $_POST["ht"];?>" step="1">
					
				  </div>
				  </div>
				  
					<div class="col-md-2">
					 <div class="form-group">
					 <button type="submit" name="btn-submit" class="btn btn-primary pull-right">Aceptar</button>
					 </div>
					 </div>
					 </div>
					</form>
					 </div>
                </div>
            </div>
		</div>
		<?php if(isset($_POST["btn-submit"])){	?>
		
		
		<div class="row">
        	<div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-body">
                  	<div class="info-recorrido"></div>
                  </div>
                </div>
            </div>
        </div>
		
		<div class="row">
        	<div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-body"  style="padding:0;">
                  	<div id="map-container"></div>
                  </div>
                </div>
            </div>
        </div>
		<?php } ?>
    </div> <!-- /container -->
    
    <footer class="footer">
      <div class="container">
        <p class="text-muted" style="color: #008175;">Sistema de Rastreo 1.0 / Servitrans / 2016 &copy; Todos los derechos reservados / <?php echo date("d/m/Y h:i:s A");?></p>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAr_-4pxrC16Ii95y8KeviDojtob5kgTiU&libraries=geometry"></script>
    <script>	
		var map;
		var var_location;
      function init_map() {
		<?php
		if(isset($_POST["btn-submit"])){
			$did=$_POST["vid"];
			$fi = strtotime($_POST["fi"]." ".$_POST["hi"])+10800;
			$fi = date("YmdHis",$fi);
			$ft = strtotime($_POST["ft"]." ".$_POST["ht"])+10800;
			$ft = date("YmdHis",$ft);
			$username="root";
			$password="r1r7C1h6ZG4ZVWF";
			$database="traccar";
			$locations = array();
			//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
			$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
			mysql_select_db($database) or die(mysql_error());
			$q = "SELECT name, id FROM devices where id = $did;";
			$resultado2 = mysql_query($q) or die(mysql_error());
			while ($row2 = mysql_fetch_array($resultado2)) {
				$q = "SELECT location_report.latitude, location_report.longitude, location_report.speed, location_report.utc, location_report.heading FROM location_report WHERE location_report.latitude!=0 and location_report.longitude!=0 and location_report.device_id={$row2["id"]} and location_report.utc >= '$fi' and location_report.utc <= '$ft' ORDER BY location_report.utc DESC";
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
		var recorridoCoor = [];
		  for (i = 0; i < locations.length; i++) {  
			 var icono = google.maps.SymbolPath.FORWARD_CLOSED_ARROW;
			 var color = 'grey';
			 var scale = 3;
			if (i==0||i+1==locations.length){
				icono = google.maps.SymbolPath.FORWARD_CLOSED_ARROW;
				color = 'green';
				scale = 3;
				if (i==0){
					color = 'red';
				}
			}
				  marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
					icon: {
						path: icono,
						scale: scale,
						strokeColor: color,
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
							'<h5>Fecha</h5>'+
							locations[i][4]+
							'<h5>Velocidad</h5>'+
							locations[i][3]+' Km/h'+
						'</div>';
				  var infowindow = new google.maps.InfoWindow({ });
				  infowindow.setContent(contentString);
				  infowindow.open(map, marker);
				}
			  })(marker, i));
			  recorridoCoor.push({lat: locations[i][1], lng: locations[i][2]});
			}
			// Linea de recorrido
			var recorrido = new google.maps.Polyline({
				path: recorridoCoor,
				geodesic: true,
				strokeColor: 'grey',
				strokeOpacity: 1,
				strokeWeight: 3
			  });
			  recorrido.setMap(map);
			  
			var path = recorrido.getPath(); 
			var distancia = google.maps.geometry.spherical.computeLength(path.getArray()); // em metros
			if(distancia > 0){
				distancia = Math.round(distancia/1000);
				$(".info-recorrido").text("El recorrido desplegado tiene una longitud de " +distancia+ " kilómetros.");
			}
			//console.log(distancia/1000);
		//var_marker.setMap(var_map);	
		<?php } ?>
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