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
    <?php include("menu.php"); ?>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Reporte <small>Polígonos</small></h3>
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
				  <div class="col-md-1">
				  Vehículo
				  </div>
				   <div class="col-md-1">
				  Polígono
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
				  <div class="col-md-1">
					<div class="form-group">
					<select name="vid" class="form-control">
						<option value="0">Todos</option>
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
				   <div class="col-md-1">
					<div class="form-group">
					<select name="pid" class="form-control">
						<option value="0">Todos</option>
						<?php
						$username="root";
						$password="r1r7C1h6ZG4ZVWF";
						$database="traccar";
						$locations = array();
						//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
						$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
						mysql_select_db($database) or die(mysql_error());
						$q = "SELECT * FROM geofences order by ABS(name);";
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<option value="<?php echo $row["id"];?>"<?php echo (@$_POST["pid"]==$row["id"]) ? " selected=\"selected\"" : "";?>><?php echo utf8_encode($row["name"]);?></option>
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
		<?php
	if(isset($_POST["btn-submit"])){
	
	?>
		<div class="row">
        	<div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-body"  style="padding:0;">
                  	<table class="table table-hover" style="font-size: 100%;">
                        <thead> 
                            <tr>	
								<th style="width: 10px;">#</th>	
                                <th style="width: 70px;">Vehículo</th>
								<th style="width: 70px;">Polígono</th>	
                                <th style="width: 80px;">Fecha</th>
								<th style="width: 80px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
						//

						if(isset($_POST["btn-submit"])){
							$did=$_POST["vid"];
							$pid = $_POST["pid"];;
							$fi = strtotime($_POST["fi"]." ".$_POST["hi"])+10800;
							$fi = date("YmdHis",$fi);
							$ft = strtotime($_POST["ft"]." ".$_POST["ht"])+10800;
							$ft = date("YmdHis",$ft);
							$username="root";
							$password="r1r7C1h6ZG4ZVWF";
							$database="traccar";
							$locations = array();
							$i=1;
							$query = "";
							if($pid!="0"){
								$query .= " geofence_state.geofence_id=$pid AND ";
							}
							if($did!="0"){
								$query .= " geofence_state.device_id=$did AND ";
							}
							$query .= " 1=1 AND ";
							
							$fi = strtotime($_POST["fi"]." ".$_POST["hi"])+10800;
							$fi = date("YmdHis",$fi);
							$ft = strtotime($_POST["ft"]." ".$_POST["ht"])+10800;
							$ft = date("YmdHis",$ft);
			
							//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
							$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
							mysql_select_db($database) or die(mysql_error());
							$q = "SELECT devices.name as device_name, geofences.name as geofence_name, geofence_state.state, location_report.utc, geofence_state.device_id, geofence_state.geofence_id FROM `geofence_state`, geofences, devices, location_report where $query geofence_state.utc >= '$fi' and geofence_state.utc <= '$ft' and geofence_state.geofence_id = geofences.id AND geofence_state.device_id=devices.id and geofence_state.location_id=location_report.id order by location_report.utc asc";
							$resultado = mysql_query($q) or die(mysql_error());
								while ($row = mysql_fetch_array($resultado)) {
									$utc = date("d/m/Y h:i:s A",strtotime($row["utc"])-10800);
									if($row["state"]=='1'){
										$row["state"] = "Entra";
									} else {
										$row["state"] = "Sale";
									}
									?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row["device_name"]; ?></td>
											<td><?php echo utf8_encode($row["geofence_name"]); ?></td>
											<td nowrap><?php echo $utc; ?></td>
											<td nowrap><?php echo $row["state"]; ?></td>
										</tr>
									<?php
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
  </body>
</html>