<?php
	ini_set('memory_limit', '1024M');
	session_start();
	$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	
	function UltimoDia($anho,$mes){ 
		if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) { 
		   $dias_febrero = 29; 
		} else { 
		   $dias_febrero = 28; 
		} 
		switch($mes) { 
		   case 01: return 31; break; 
		   case 02: return $dias_febrero; break; 
		   case 03: return 31; break; 
		   case 04: return 30; break; 
		   case 05: return 31; break; 
		   case 06: return 30; break; 
		   case 07: return 31; break; 
		   case 08: return 31; break; 
		   case 09: return 30; break; 
		   case 10: return 31; break; 
		   case 11: return 30; break; 
		   case 12: return 31; break; 
		} 
	}
	
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
	}
	
	if(!isset($_POST["ft"])){
		$_POST["ft"]=date("Y-m-d");
	}
	if(!isset($_POST["ht"])){
		$_POST["ht"]=date("h");
	}
	if(!isset($_POST["mt"])){
		$_POST["mt"]=date("i");
	}
	if(!isset($_POST["pt"])){
		$_POST["pt"]=date("A");
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
	
	td, th {
		padding: 5px !important;
	}
    </style>
  </head>
  <body>
  <!-- Fixed navbar -->
    <!--<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#008175;color:#97BE0D;">-->
    <?php include("menu.php"); ?>
    
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Reporte <small>Kilómetros recorridos</small></h3>
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
				  <div class="col-md-2">Vehículo
				  </div>
				  <div class="col-md-2">Mes
				  </div>
				  
				  <div class="col-md-2">
				  Año
				  </div>
				  <div class="col-md-2">
					 </div>
				  </div>
				   <div class="row">
				  <div class="col-md-2">
					<div class="form-group">
					<select name="vid[]" class="form-control">
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
					<select name="mes" class="form-control">
						<?php foreach($meses as $key => $value){
							$key++;
							echo "<option value=\"$key\" ".((@$_POST["mes"]==$key) ? " selected=\"selected\"" : "").">$value</option>"."\n";
						}?>
						</select>
					 </div>
				  </div>
				  
				  <div class="col-md-2">
				  <div class="form-group">
					<select name="anio" class="form-control">
						<?php for($i=date("Y");$i>date("Y")-5;$i--){
							echo "<option value=\"$i\" ".((@$_POST["anio"]==$i) ? " selected=\"selected\"" : "").">$i</option>"."\n";
						}?>
						</select>
				  </div>
				  </div>
					<div class="col-md-2">
					</div>
					<div class="col-md-2">
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
					<table border="1" id="result" width="100%">
						<tr>
							<th cellpadding="5">Móvil</th>
							<?php 
							$mes = $_POST["mes"];
							$mes = str_pad($mes, 2, "0", STR_PAD_LEFT); 
							$anio = $_POST["anio"];
							$ultimo_dia = UltimoDia($anio,$mes);
							for($i = 0;$i < $ultimo_dia; $i++){
								$date = date('d/m', strtotime("$anio-$mes-01 + $i day"));
								echo "<th nowrap cellpadding=\"5\">$date</th>";
							}
							?>
						</tr>
					</table>
					<?php
					
					?>
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
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAr_-4pxrC16Ii95y8KeviDojtob5kgTiU&libraries=geometry"></script>
    <script>	
		$(document).ready(function(){
			<?php
			if(isset($_POST["btn-submit"])){
				$did = implode(",",$_POST["vid"]);
				$mes = $_POST["mes"];
				$mes = str_pad($mes, 2, "0", STR_PAD_LEFT); 
				$anio = $_POST["anio"];
				$utc =$anio.$mes; 
				$username="root";
				$password="r1r7C1h6ZG4ZVWF";
				$database="traccar";
				
				echo "var result = '';\n";
				$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
				mysql_select_db($database) or die(mysql_error());
				$q = "SELECT name, id  
					FROM devices
					WHERE id IN ($did) AND installed = '1'
					ORDER BY name;";
				$resultado2 = mysql_query($q) or die(mysql_error());
				$ultimo_dia = UltimoDia($anio,$mes);
				while ($row2 = mysql_fetch_array($resultado2)) {
					$locations = array();
					/*$td_fechas = "";
					for($i = 0;$i < $ultimo_dia; $i++){
						$date_td = date('d_m_Y', strtotime("$anio-$mes-01 + $i day"));
						$td_fechas .= '<td class="td_'.$row2["name"].'_'.$date_td.'"></td>';
					}*/
					
					echo "result += '<tr><td>{$row2["name"]}</td>';"."\n";
					$q = "SELECT location_report.latitude, location_report.longitude, location_report.utc, location_report.device_id  
					FROM location_report
					WHERE location_report.latitude!=0 
						and location_report.longitude!=0 
						and location_report.device_id = {$row2["id"]}
						
					ORDER BY location_report.device_id, location_report.utc;";
					//echo "/* $q */";///*and location_report.utc like '$utc%'*/
					$resultado = mysql_query($q) or die(mysql_error());
					$anterior_lat = "";
					$anterior_lng = "";
					while ($row = mysql_fetch_array($resultado)) {
						if(substr($row["utc"],0,6)==$utc){
							$resultados[$row["utc"]] = array($row["latitude"],$row["longitude"]);						
							$utc_ = date("d_m_Y",strtotime($row[2]));//-10800
							//echo "1052 $utc {$row[0]},{$row[1]}";
							$locations[$row[3]][$utc_][] = "[{$row[0]},{$row[1]}]";
							$anterior_lat = $row[0];
							$anterior_lng = $row[1];
						}
					}
					
					
					$distancias = array();
					 
					foreach($locations as $key => $value){
						foreach($value as $key2 => $value2){
							echo "var locations_".$key."_".$key2." = [".implode(",",$locations[$key][$key2])."];";
							echo "
								var recorrido_arr_".$key."_".$key2." = [];
								for (i = 0; i < locations_".$key."_".$key2.".length; i++) {
									recorrido_arr_".$key."_".$key2.".push({lat: locations_".$key."_".$key2."[i][0], lng: locations_".$key."_".$key2."[i][1]});
								}
								
								var recorrido_".$key."_".$key2." = new google.maps.Polyline({
									path: recorrido_arr_".$key."_".$key2.",
									geodesic: true,
									strokeColor: 'grey',
									strokeOpacity: 1,
									strokeWeight: 3
								});
							  
								var path_".$key."_".$key2." = recorrido_".$key."_".$key2.".getPath(); 
								var distancia_".$key."_".$key2." = google.maps.geometry.spherical.computeLength(path_".$key."_".$key2.".getArray());
								distancia_".$key."_".$key2." = Math.round(distancia_".$key."_".$key2."/1000);
								//console.log(distancia_".$key."_".$key2.");
								//$(\".td_".$key."_".$key2."\").text(distancia_".$key."_".$key2.");
								result += '<td>'+distancia_".$key."_".$key2."+'</td>';
							";
						}
					}
					echo "result += '</tr>';\n";
				}
				echo "$('#result').append(result);"."\n";
				mysql_close($link);
			}
			?>
		});
    </script>
  </body>
</html>