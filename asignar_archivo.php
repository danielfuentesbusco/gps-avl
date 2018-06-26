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
	$link = mysqli_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysqli_error());
	mysqli_select_db($link, $database) or die(mysqli_error());
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
    	<div class="page-header" style="margin-top:20px;">    
			<h3 style="margin-top:0;">Ruta <small>Subir archivo de asignación</small></h3>
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
				  <form method="post" enctype="multipart/form-data">
				  <div class="row">
				  <div class="col-md-2">
					<div class="form-group">
					<label class="" for="vid">Archivo</label>
						<input type="file" name="archivo" class="form-control" id="archivo" required />
						 </div>
				  </div>
				  
				   </div>
				  
				
				
			
				  
				  <div class="row">
				  <div class="col-md-11">
				  </div>
					<div class="col-md-1">
					 <div class="col-md-12">
					<button type="button" name="btn-close" class="btn btn-danger pull-right" onclick="javascript:window.close();" aria-haspopup="true" aria-expanded="false">Cerrar</button> 
					<button type="submit" name="btn-submit" class="btn btn-success pull-right" style="margin-right:5px;" aria-haspopup="true" aria-expanded="false">Vista Previa</button>
				</div>
					 </div>
					 </div>
					</form>
					 </div>
                </div>
            </div>
		</div>
		<?php 
			//print_r($_FILES);
			//print_r($_POST);
			if(isset($_POST["btn-submit"])){
				$_SESSION["asignacion_rutas"] = array();
		?>
		<div class="row">
            <div class="col-md-12">
            	<div class="panel panel-default">
                  <div class="panel-heading clearfix">
                    <div class="btn-group pull-right">
                      <!--<a href="#" class="btn btn-default btn-sm">Ver Detalle</a>-->
                    </div>
                    <h3 class="panel-title" style="padding-top:5px;">Vista previa de asignación</h3>
                  </div>
				  <div class="panel-body">
				   <form method="post">
					  <table class="table table-hover" style="font-size: 100%;">
						<thead> 
							<tr>	
								<th style="width: 10px;">#</th>	
								<th>Vehículo</th>
								<th style="width: ;">Ruta</th>
								<th style="width: ;" nowrap>Conductor</th>
								<th style="width: ;" nowrap>Período</th>
							</tr>
						</thead>
						<tbody> 
				<?php
						$dir_subida = '/tmp/';
						$fichero_subido = $dir_subida . basename($_FILES['archivo']['name']).time();

						//echo '<pre>';
						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
							//echo "El fichero es válido y se subió con éxito.\n";
						} else {
							//echo "¡Posible ataque de subida de ficheros!\n";
						}
						$i = 1;
						$handle = fopen($fichero_subido, "r");
						if ($handle) {
							$line = fgets($handle);
							while (($line = fgets($handle)) !== false) {
								$data = explode(";",$line);
								$ruta = explode("_",$data[0]);
								$data[0] = $ruta[0];
								$interno = explode("-",$data[1]);
								$data[1] = $interno[0];
								$fecha = explode("-",$data[2]);
								$data[2] = $fecha[2]."-".$fecha[1]."-".$fecha[0];
								$rut = explode("-",$data[3]);
								$data[3] = intval($rut[0]);
								$resultado = mysqli_query($link, "SELECT id, nombres FROM conductores where rut = '{$data[3]}'") or die(mysqli_error());
								if ($row = mysqli_fetch_array($resultado)) {
									$data[3] = $row["id"];
									$nombres = $row["nombres"];
								}
							?>
								<tr>
									<td style="vertical-align: middle;" nowrap><?php echo $i++;?></td>
									<td style="vertical-align: middle;" nowrap><?php echo $data[0];?></td>
									<td style="vertical-align: middle;" nowrap><?php echo $data[1];?></td>
									<td style="vertical-align: middle;" nowrap><?php echo $nombres;?></td>
									<td style="vertical-align: middle;" nowrap><?php echo $fecha[0].'-'.$fecha[1].'-'.$fecha[2];?></td>
								</tr>
							<?php
								//print_r($data);
								
								$resultado = mysqli_query($link, "SELECT id FROM geofences where name = '{$data[0]}'") or die(mysqli_error());
								if ($row = mysqli_fetch_array($resultado)) {
									$data[0] = $row["id"];
								}
								$resultado = mysqli_query($link, "SELECT id FROM devices where name = '{$data[1]}'") or die(mysqli_error());
								if ($row = mysqli_fetch_array($resultado)) {
									$data[1] = $row["id"];
								}
								$_SESSION["asignacion_rutas"][] = "INSERT INTO geofence_device (geofence_id, device_id, fecha_inicio, fecha_termino, conductor_id) VALUES ('{$data[0]}','{$data[1]}','{$data[2]} 00:00:00','{$data[2]} 23:59:59','{$data[3]}');";
							}
							fclose($handle);
						} else {
							// error opening the file.
						} 

						//echo 'Más información de depuración:';
						//print_r($_FILES);

						//print "</pre>";

						//$q = "INSERT INTO geofence_device (geofence_id,device_id,fecha_inicio,fecha_termino,conductor_id) VALUES ($pid,$vid,'$fi','$ft',$cid);";
						//@mysql_query($q, $link);
				?>
							</tbody>
						</table>
						 <div class="row">
						  <div class="col-md-11">
						  </div>
							<div class="col-md-1">
							 <div class="col-md-12">
							<button type="submit" name="btn-guardar" class="btn btn-success pull-right" style="margin-right:5px;" aria-haspopup="true" aria-expanded="false">Asignar Rutas</button>
						</div>
							 </div>
							 </div>
						</form>
					</div>
                </div>
            </div>
		</div>
		<?php
			}
		?>
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
			if(isset($_POST["btn-guardar"])){
				foreach($_SESSION["asignacion_rutas"] as $value){
					mysqli_query($link, $value);
				}
				$_SESSION["asignacion_rutas"] = array();
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
	mysqli_close($link); 
?>