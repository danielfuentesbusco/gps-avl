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
	/*
	.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 3px 3px;
    font-size: 13px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
	}*/
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
            <li><a href="./seguimiento.php"><span class="fa fa-map-marker"></span> Rastreo</a></li>
			<li><a href="./rutas.php"><span class="fa fa-map-signs"></span> Rutas</a></li>
			<li class="dropdown active"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-file-text-o"></span> Reportes</a>
				<ul class="dropdown-menu">
					<li><a href="./reporte_desconexion.php"><span class="fa fa-plug"></span> Desconexión</a></li>
					<li><a href="./reporte_ignition.php"><span class="fa fa-key"></span> Ignición</a></li>
					<li><a href="./reporte_velocidad.php"><span class="fa fa-tachometer"></span> Velocidad</a></li>
					<li class="active"><a href="./reporte_ruta.php"><span class="fa fa-map-signs"></span> Rutas</a></li>
				</ul>
			</li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-map"></span> Polígonos</a>
				<ul class="dropdown-menu">
					<li><a href="./poligonos.php"><span class="fa fa-file-text-o"></span> Listado</a></li>
					<li><a href="./asignacion_poligono.php"><span class="fa fa-map"></span> Polígonos Asignados</a></li>
					<li><a href="./asignacion_ruta.php"><span class="fa fa-map-signs"></span> Rutas Asignadas</a></li>
				</ul>
			</li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php"><span class="fa fa-sign-out"></span> Salir</a></li>
            <!--
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
            -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
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
						$q = "SELECT * FROM devices where id IN (SELECT deviceid FROM user_device WHERE userid = $userid) order by ABS(name);";
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<option value="<?php echo $row["id"];?>"<?php echo (@$_POST["vid"]==$row["id"]) ? " selected=\"selected\"" : "";?>><?php echo $row["name"];?></option>
					<?php }
						mysql_close($link);
					?>
                     </select>
						 </div>
				  </div>
				  <div class="col-md-2">
					<div class="form-group">
					<input type="date" name="fi" class="form-control" value="<?php echo @$_POST["fi"];?>" />
						 </div>
				  </div>
				  
				  <div class="col-md-2">
				  <div class="form-group">
					
					<input type="time" class="form-control" name="hi" value="<?php echo $_POST["hi"];?>" step="1">
				  </div>
				  </div>
				   
				  <div class="col-md-2">
					<div class="form-group">
					<input type="date" name="ft" class="form-control" value="<?php echo @$_POST["ft"];?>" />
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
		<div class="row">
        	<div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-body"  style="padding:0;">
                  	<table class="table table-hover" style="font-size: 100%;">
                        <thead> 
                            <tr>	
								<th style="width: 10px;">#</th>	
                                <th style="width: 70px;">Vehículo</th>	
                                <th style="width: 80px;">Fecha</th>
								<th style="width: 80px;">Velocidad</th>
								<th style="width: 80px;">Motor</th>
								<th style="width: 80px;">Ubicación</th>
                            </tr>
                        </thead>
                        <tbody>
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
							$i=1;
							//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
							$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
							mysql_select_db($database) or die(mysql_error());
							$q = "SELECT name, id FROM devices where id = $did;";
							$resultado2 = mysql_query($q) or die(mysql_error());
							if ($row2 = mysql_fetch_array($resultado2)) {
								$q = "SELECT location_report.latitude, location_report.longitude, location_report.speed, location_report.utc, location_report.heading, location_report.id FROM location_report WHERE location_report.latitude!=0 and location_report.longitude!=0 and location_report.device_id={$row2["id"]} and location_report.utc >= '$fi' and location_report.utc <= '$ft' ORDER BY location_report.utc asc";
								$resultado = mysql_query($q) or die(mysql_error());
								while ($row = mysql_fetch_array($resultado)) {
									$utc = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
									$motor = "Apagado";
									$q = "SELECT device_id, estado, utc FROM traccar.ignition where device_id={$row2["id"]} and utc <= {$row["utc"]} order by utc desc limit 1;";
									$resultado3 = mysql_query($q) or die(mysql_error());
									if ($row3 = mysql_fetch_array($resultado3)) {
										if($row3["estado"]==1){
											$motor = "Encendido";
										}
									}
									
									//$ub = array();
									$ubicacion = array();
									$q = "SELECT name, state FROM geofence_state, geofences where device_id={$row2["id"]} and geofences.id=geofence_state.geofence_id and location_id = '{$row["id"]}'";
									$resultado3 = mysql_query($q) or die(mysql_error());
									while ($row3 = mysql_fetch_array($resultado3)) {
										if($row3["state"]=="1"){
											//$ub[]=$row3["name"];
											$ubicacion[] = "Entra a ".$row3["name"];
										}else{
											/*if(($key = array_search($row3["name"], $ub)) !== false) {
												unset($ub[$key]);
											}*/
											$ubicacion[] = "Sale de ".$row3["name"];
										}
									}
									
									?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row2["name"]; ?></td>
											<td nowrap><?php echo $utc; ?></td>
											<td><?php echo $row["speed"]; ?> Km/h</td>
											<td><?php echo $motor; ?></td>
											<td><?php
												if(count($ubicacion)>0){
													echo implode(" / ",$ubicacion);
												}else{
													//echo implode(" / ",array_unique($ub));
												}
											?></td>
										</tr>
									<?php
								}
							}
							mysql_close($link);
							}
						?>
							
						</tbody>
					</table>
                  </div>
                </div>
            </div>
        </div>
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
  </body>
</html>