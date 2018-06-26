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
       #map-container { min-height: 755px; height: 100%;}
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
            <li><a href="./rastreo.php"><span class="fa fa-map-marker"></span> Rastreo</a></li>
            <li class="active"><a href="./geocercas.php"><span class="fa fa-map-o"></span> Geocercas</a></li>
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
			<h3 style="margin-top:0;">Geocercas <small>Administración de geocercas</small></h3>
    	</div>
        <div class="row">
            <div class="col-md-3">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <!--<a href="#" class="btn btn-default btn-sm">Ver Detalle</a>-->
                    </div>
                    <!--<h3 class="panel-title" style="padding-top:5px;">-->
                    <h3 class="panel-title">
                       Geocercas
                    </h3>
                  </div>
                  <div class="panel-body">
				   <table class="table table-hover" style="font-size: 100%;">
                        <thead> 
                            <tr>	
								<th style="width: 10px;">#</th>	
                                <th style="width: 70px;">Nombre</th>
                            </tr>
                        </thead>
                        <tbody> 
						<?php
							$i = 1;
							$username="root";
							$password="r1r7C1h6ZG4ZVWF";
							$database="traccar";
							$locations = array();
							$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
							mysqli_select_db($link, $database) or die(mysqli_error());
							$q = "SELECT id, name, vertices FROM traccar.geofences;";
							$resultado = mysqli_query($link, $q) or die(mysqli_error());
							while ($row = mysqli_fetch_array($resultado)) {
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td id="<?php echo $row["id"];?>" class="get_geo"><?php echo $row["name"];?></td>
							</tr>
						<?php 
							}
						?>
						</tbody>
                    </table>
					<input type="button" value="Actualizar" id="geo_update" />
					<input type="button" value="Cancelar" id="geo_cancel" />
					<input type="text" placeholder="Ingrese nombre" id="geo_name" />
					<input type="button" value="Guardar" id="geo_new" />
                  </div>
                </div>
                
                
            </div>
        	<div class="col-md-9">
            	<div class="panel panel-default">
                  <div class="panel-body"  style="padding:0;">
                  	<div id="map-container"></div>
                  </div>
            </div>
        </div>
    </div> <!-- /container -->
    
    <footer class="footer">
      <div class="container">
        <p class="text-muted" style="color: #008175;">Sistema de Rastreo 1.0 / Servitrans / Cumsensu / 2016 &copy; Todos los derechos reservados</p>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ4z5BFE4vj56liE3pwgzENu4J13lbyRk&libraries=drawing,geometry"></script>
    <script>	
		var var_map;
		var polys = [];
		var poly;
      function init_map() {
		var var_location = new google.maps.LatLng(-33.3266167,-70.7164856);
 
        var var_mapoptions = {
          center: var_location,
          zoom: 15
        };
 
		var drawingManager = new google.maps.drawing.DrawingManager({
			//drawingMode: google.maps.drawing.OverlayType.MARKER,
			drawingControl: true,
			drawingControlOptions: {
			  position: google.maps.ControlPosition.TOP_CENTER,
			  drawingModes: [
				//google.maps.drawing.OverlayType.MARKER,
				//google.maps.drawing.OverlayType.CIRCLE,
				google.maps.drawing.OverlayType.POLYGON,
				//google.maps.drawing.OverlayType.POLYLINE,
				//google.maps.drawing.OverlayType.RECTANGLE
			  ]
			},
			//markerOptions: {icon: 'images/beachflag.png'},
			circleOptions: {
			  clickable: false,
			  editable: true
			},
			polygonOptions: {
			  clickable: false,
			  editable: true
			},
			rectangleOptions: {
			  clickable: false,
			  editable: true
			}
		  });
		  
		   var_map = new google.maps.Map(document.getElementById("map-container"),
            var_mapoptions);
			
		  drawingManager.setMap(var_map);
		  
		  google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
				var newShape = event.overlay;
				newShape.type = event.type;
			});

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event){
                overlayClickListener(event.overlay);
                //console.log(event.overlay.getPath().getArray());
            });
			
			google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
				//console.log(polygon.getPath());
				var vertices = polygon.getPath();
				for (var i =0; i < vertices.getLength(); i++) {
					var xy = vertices.getAt(i);
					console.log(xy.lat() + ',' + xy.lng());
				}
				polys.push(polygon);
				poly = polygon;
				$('#geo_cancel').show();

				//var area = google.maps.geometry.spherical.computeArea(polygon.getPath());
				/*for (i = 0; i < arr.length; i++) {
					var a = arr[i][0];
					var b = arr[i][1];
					var c = arr[i][4];
					var latlng = new google.maps.LatLng(arr[i][2],arr[i][3]);
					if (google.maps.geometry.poly.containsLocation(latlng, polygon)){
						electores += parseInt(c);
					}
				}*/
				
			//	var areaM = parseInt(area);//parseInt(parseInt(area)/1000000);
				//var ele = electores / areaM;
				
				polygon.addListener('click', function(){
					this.setMap(null);
				});
				/*
				google.maps.event.addListener(polygon, 'click', function() {
					  this.setMap(null);
				  });
				  */
			});
 
      }
	  
	  function overlayClickListener(overlay) {
			google.maps.event.addListener(overlay, "mouseup", function(event){
				//console.log(overlay.getPath().getArray());
			});
		}
		
		var id;
		
		$('#geo_update').hide();
		$('#geo_cancel').hide();
		google.maps.event.addDomListener(window, 'load', init_map);
		
		$('.get_geo').click(function(){
			id = $(this).attr("id");
			while(polys[0]){
				polys.pop().setMap(null);
			}
			var bounds = new google.maps.LatLngBounds();
			var i;
			$.get( "get_polygon.php?gid="+id, function(data) {
				poly = new google.maps.Polygon({
					paths: eval(data),
					//strokeColor: '#FF0000',
					//strokeOpacity: 0.8,
					//strokeWeight: 2,
					//fillColor: '#FF0000',
					//fillOpacity: 0.35
					clickable: true,
					editable: true,
				});
				var coors = eval(data);
				for (i = 0; i < coors.length; i++) {
					bounds.extend(new google.maps.LatLng(coors[i].lat, coors[i].lng));
				}
				var_map.setCenter(bounds.getCenter());
				poly.setMap(var_map);
				polys.push(poly);
			});
			$('#geo_update').show();
			$('#geo_cancel').show();
		});
		
		$('#geo_update').click(function(){
			var vertices = poly.getPath();
			var v = [];
			for (var i =0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				v.push(xy.lat() + ' ' + xy.lng());
			}
			var d = v.join(";");
			$.get( "set_polygon.php?gid="+id+"&d="+d, function(data) {
				//console.log(data);
				$('#geo_update').hide();
				$('#geo_cancel').hide();
				alert("Polígono actualizado con éxito.");
				while(polys[0]){
					polys.pop().setMap(null);
				}
			});
		});
		
		$('#geo_cancel').click(function(){			
			$('#geo_update').hide();
			while(polys[0]){
				polys.pop().setMap(null);
			}
			$('#geo_cancel').hide();
		});
		
		$('#geo_new').click(function(){
			var vertices = poly.getPath();
			var n = $("#geo_name").val();
			var v = [];
			for (var i =0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				v.push(xy.lat() + ' ' + xy.lng());
			}
			var d = v.join(";");
			$.get( "set_polygon.php?gid=0&d="+d+"&n="+n, function(data) {
				//console.log(data);
				$('#geo_update').hide();
				$('#geo_cancel').hide();
				alert("Polígono ingresado con éxito.");
				while(polys[0]){
					polys.pop().setMap(null);
				}
				window.location="/geocercas.php";
			});
		});
		
 
    </script>
  </body>
</html>
