<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Asignación Poligonos / Servitrans</title>

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
    <?php include("menu.php"); ?>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Polígonos <small>Asignación de Bases, Rellenos o Vertederos</small></h3>
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
                       Bases, Rellenos o Vertederos
                    </h3>
                  </div>
                  <div class="panel-body">
				   <table class="table table-hover" style="font-size: 100%;">
                        <thead> 
                            <tr>	
								<th style="width: 10px;">ID</th>	
                                <th>Interno</th>
								<th style="width: 70px;">Polígono</th>
								<th style="width: 200px;" nowrap>Período</th>
								<th style="width: 70px;">
									<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  Acciones
									  <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
									  <li><a href="javascript:window.open('./asignar_poligono.php','verPoligono','width=900, height=720');">Asignación manual</a></li>
									</ul>
								  </div>
								</th>
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
							$q = "SELECT geofence_device.id, devices.name, geofences.name, geofences.tipo FROM geofences, geofence_device, devices where devices.id IN (SELECT deviceid FROM user_device WHERE userid = $userid) and geofences.tipo <> 1 and geofence_device.geofence_id=geofences.id and devices.id=geofence_device.device_id order by abs(devices.name);";
							if($_SESSION["uid"]=='9'||$_SESSION["uid"]=='11'||$_SESSION["uid"]=='12'){
								$q = "SELECT geofence_device.id, devices.name, geofences.name, geofences.tipo FROM geofences, geofence_device, devices where geofences.tipo <> 1 and geofence_device.geofence_id=geofences.id and devices.id=geofence_device.device_id order by abs(devices.name);";
							}
							$resultado = mysqli_query($link, $q) or die(mysqli_error());
							while ($row = mysqli_fetch_array($resultado)) {
								if($row["tipo"]==2){
									$row["tipo"] = "Base";
								}
								if($row["tipo"]==3){
									$row["tipo"] = "Relleno o Vertedero";
								}
						?>
							<tr>
								<td style="vertical-align: middle;" nowrap><?php echo $row[0];?></td>
								<td style="vertical-align: middle;" nowrap><?php echo $row[1];?></td>
								<td style="vertical-align: middle;" nowrap><?php echo utf8_encode($row[2]);?></td>
								<td style="vertical-align: middle;" nowrap>Indefinido</td>
								<td style="vertical-align: middle;">
									<a class="btn btn-danger btn-sm btn-eliminar" href="#" asignacion_id="<?php echo $row[0];?>" role="button"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</a>
								</td>
							</tr>
						<?php 
							}
						?>
						</tbody>
                    </table>
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
	<script>
		$(document).ready(function(){
			$(".btn-eliminar").click(function(){
				var id = $(this).attr("asignacion_id");
				if(confirm("¿Está seguro que desea eliminar esta asignación permanente?")){
					window.location = "./eliminar_asignacion.php?aid="+id;
				}
				return false;
			});
		});
	</script>
  </body>
</html>
