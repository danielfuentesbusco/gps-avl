<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	$locations = array();
	$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
	mysql_select_db($database) or die(mysql_error());
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
		body, html { 
			margin: 0 !important;
			padding: 0 !important;
			}
    </style>
  </head>
  <body>  
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Ruta <small>Asignación</small></h3>
    	</div>
        <div class="row">
            <div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <!--<a href="#" class="btn btn-default btn-sm">Ver Detalle</a>-->
                    </div>
                    <!--<h3 class="panel-title" style="padding-top:5px;">-->
                  </div>
				  <div class="panel-body">
				  <form method="post">
				  <div class="row">
				  <div class="col-md-2">
					<div class="form-group">
					<label class="" for="vid">Vehículo</label>
					<select name="vid" class="form-control">
						<?php
						
						$q = "SELECT * FROM devices where id IN (SELECT deviceid FROM user_device WHERE userid = $userid) order by ABS(name);";
						if($_SESSION["uid"]=='9'||$_SESSION["uid"]=='11'||$_SESSION["uid"]=='12'){
							$q = "SELECT * FROM devices where installed = 1 order by ABS(name);";
						}
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
					<?php }
						//mysql_close($link);
					?>
                     </select>
						 </div>
				  </div>
				   <div class="col-md-2">
					<div class="form-group">
					<label class="" for="pid">Ruta</label>
					<select name="pid" class="form-control">
						<?php
						$q = "SELECT * FROM geofences where tipo = 1 order by name;";
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
					<?php }
						
					?>
                     </select>
						 </div>
				  </div>
				   <div class="col-md-2">
					<div class="form-group">
					<label class="" for="pid">Conductor</label>
					<select name="cid" class="form-control">
						<?php
						$q = "SELECT id, nombres FROM conductores order by nombres;";
						$resultado = mysql_query($q) or die(mysql_error());
						while ($row = mysql_fetch_array($resultado)) {
						?>
							<option value="<?php echo $row["id"];?>"><?php echo $row["nombres"];?></option>
					<?php }
						
					?>
                     </select>
						 </div>
				  </div>
				   </div>
				  <div class="row">
				  <div class="col-xs-3">
						<label class="" for="vid">Fecha Inicio</label>
						<input type="date" name="fi" class="form-control" value="<?php echo @$_POST["fi"];?>" min="<?php echo date("Y-m-d");?>" />
				  </div>
				  
				  <div class="col-xs-3">
						<label class="" for="vid">Hora Inicio</label>
						<input type="time" class="form-control" name="hi" value="<?php echo $_POST["hi"];?>" step="1">
				  </div>
				  <div class="col-xs-3">
						<label class="" for="vid">Fecha Término</label>
						<input type="date" name="ft" class="form-control" value="<?php echo @$_POST["ft"];?>" min="<?php echo date("Y-m-d");?>" />
				  </div>
				  <div class="col-xs-3">
						<label class="" for="vid">Hora Término</label>
						<input type="time" class="form-control" name="ht" value="<?php echo $_POST["ht"];?>" step="1">
				  </div>
				</div>
			
				  <div class="row">
					<div class="col-md-12">
						 <div class="form-group">
							<button type="button" name="btn-close" class="btn btn-danger pull-right" onclick="javascript:window.close();" aria-haspopup="true" aria-expanded="false">Cerrar</button> 
							<button type="submit" name="btn-submit" class="btn btn-success pull-right" style="margin-right:5px;" aria-haspopup="true" aria-expanded="false">Guardar Cambios</button>
						</div>
					 </div>
					 </div>
					</form>
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
	
	<script>
		<?php 
			if(isset($_POST["btn-submit"])){
				$vid = $_POST["vid"];
				$pid = $_POST["pid"];
				$cid = $_POST["cid"];
				$fi = strtotime($_POST["fi"]." ".$_POST["hi"]);
				$fi = date("Y-m-d H:i:00",$fi);
				$ft = strtotime($_POST["ft"]." ".$_POST["ht"]);
				$ft = date("Y-m-d H:i:00",$ft);
				$q = "INSERT INTO geofence_device (geofence_id,device_id,fecha_inicio,fecha_termino,conductor_id) VALUES ($pid,$vid,'$fi','$ft',$cid);";
				@mysql_query($q, $link);
		?>
		window.opener.location.reload();
		window.close();
		<?php
			}
		?>
	</script>
  </body>
</html>
<?php 
	mysql_close($link); 
?>