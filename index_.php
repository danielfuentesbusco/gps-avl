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
      #map-container { min-height: 300px; height: 100%;}
	  
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
            <li class="active"><a href="./index.php"><span class="fa fa-tachometer"></span> Dashboard</a></li>
            <li><a href="./rastreo.php"><span class="fa fa-map-marker"></span> Rastreo</a></li>
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
       		<h3 style="margin-top:0;">Dashboard <small>Panel de Operaciones</small></h3>
    	</div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="./rastreo.php" class="btn btn-default btn-sm">Ver Detalle</a> 
                      <a href="#" id="panel-fullscreen" class="btn btn-default btn-sm" title="Toggle fullscreen"><i class="glyphicon glyphicon-resize-full"></i></a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                       Rastreo General Vehículos
                    </h3>
                    
                  </div>
                  <div class="panel-body" style="padding:0;">
                  	<div id="map-container"></div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-4">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-default btn-sm">Ver Detalle</a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                        Ubicación Vehículos
                    </h3>
                  </div>
                  <div class="panel-body">
                  	 <div id="donutchart" style="width: 100%; height: 300px;"></div>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-default btn-sm">Ver Detalle</a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                        Uso Combustible
                    </h3>
                  </div>
                  <div class="panel-body">
                  	<div id="combustible" style="width: 100%; height: 300px;"></div>
                  </div>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-default btn-sm">Ver Detalle</a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                        Retiro Desechos
                    </h3>
                  </div>
                  <div class="panel-body">
                  	<div id="desechos" style="width: 100%; height: 300px;"></div>
                  </div>
                </div>
            </div>
          
		</div>
        
        <div class="row">
            <div class="col-md-6">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-default btn-sm">Ver Detalle</a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                        Km Conductores
                    </h3>
                  </div>
                  <div class="panel-body">
                    <table class="table table-hover">
                        <thead> 
                            <tr>	
                                <th>#</th>
                                <th>Rut</th>	
                                <th>Nombre</th>
                                <th>Km</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr> <th scope="row">1</th> <td>13.345.256-3</td> <td>Otto</td> <td>19,4Km</td> </tr>
                            <tr> <th scope="row">2</th> <td>14.876.356-2</td> <td>Thornton</td> <td>14,2Km</td> </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <a href="#" class="btn btn-default btn-sm">Ver Detalle</a>
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">
                        Km Vehículos
                    </h3>
                  </div>
                  <div class="panel-body">
                  	  <table class="table table-hover">
                        <thead> 
                            <tr>	
                                <th>#</th>
                                <th>Tipo</th>	
                                <th>Patente</th>
                                <th>Número</th>
                                <th>Km</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr> <th scope="row">1</th> <td>Cambión</td> <td>22 55 22</td><td>8082</td> <td>19,4Km</td> </tr>
                            <tr> <th scope="row">2</th> <td>Camioneta</td> <td>11 55 GG</td><td>8084</td> <td>14,2Km</td> </tr>
                        </tbody>
                    </table>
                  </div>
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
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
		var var_map;
		var var_location;
		function init_map() {
		<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="traccar";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$q = "SELECT devices.name, location_report.latitude, location_report.longitude  FROM devices,location_report  WHERE location_report.device_id=4 AND location_report.device_id=devices.id ORDER BY location_report.utc DESC LIMIT 1";
		$resultado = mysql_query($q) or die(mysql_error());
		while ($row = mysql_fetch_array($resultado)) {
			echo "var_location = new google.maps.LatLng({$row[1]},{$row[2]});";
			break;
		}
		mysql_close($link);
		?>
		//var_location = new google.maps.LatLng(-33.3266167,-70.7164856);
        var var_mapoptions = {
          center: var_location,
          zoom: 15
        };
		var var_marker = new google.maps.Marker({
			position: var_location,
			map: var_map,
			title:""});	
		var_map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);	
		var_marker.setMap(var_map);	
 
      }
 
      google.maps.event.addDomListener(window, 'load', init_map);
		 $(document).ready(function () {
					//Toggle fullscreen
					$("#panel-fullscreen").click(function (e) {
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
							document.getElementById("map-container").style.height = "300px"
						}
						$(this).closest('.panel').toggleClass('panel-fullscreen');
						google.maps.event.trigger(var_map,"resize");
						var_map.setCenter(var_location);
					});
				});
    </script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(initcharts);
	  function initcharts(){
			ubicacion();
			combustible(); 
			desechos(); 
		}
      function ubicacion() {
        var data = google.visualization.arrayToDataTable([
          ['Estado', 'Vehículos'],
          ['Ruta',     11],
          ['Base',      2],
          ['Taller',  2],
          ['Vertedero', 2],
          ['Sin Información',    7]
        ]);

        var options = {
          //title: '',
          pieHole: 0.4,
		  chartArea:{left:10,top:20,width:"100%",height:"100%"}
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
	  
	  function combustible() {
        var data = google.visualization.arrayToDataTable([
          ['Hora', '8082', '8084'],
          ['10am',  1000,      400],
          ['11am',  1170,      460],
          ['12pm',  660,       1120],
          ['1pm',  1030,      540]
        ]);

        var options = {
          isStacked: true,
          hAxis: {title: '',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
			chartArea:{left:35,top:20,width:"70%",height:"80%"}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('combustible'));
        chart.draw(data, options);
      }
	  
	  function desechos() {
        var data = google.visualization.arrayToDataTable([
          ['Hora', '8082', '8084'],
          ['10am',  300,      200],
          ['11am',  380,      270],
          ['12pm',  410,       490],
          ['1pm',  590,      520]
        ]);

        var options = {
          isStacked: true,
          hAxis: {title: '',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0},
			chartArea:{left:35,top:20,width:"70%",height:"80%"}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('desechos'));
        chart.draw(data, options);
      }
    </script>
  </body>
</html>
