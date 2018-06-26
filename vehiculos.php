<?php
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="traccar";
	//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
	$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
	mysql_select_db($database) or die(mysql_error());
	$q = "SELECT * FROM devices;";
	$resultado = mysql_query($q) or die(mysql_error());
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Vehículos Servitrans</title>

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
      #map-container { min-height: 500px; height: 100%;}
	  
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
            <div class="col-md-12">
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
                  <div class="panel-body">
                 	</div>	
                    <table class="table table-hover">
                        <thead> 
                            <tr>	
                                <th style="width: 70px;">Vehículo</th>	
                                <th style="width: 80px;">Último</th>
                                <th>Estados</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
								while ($row = mysql_fetch_assoc($resultado)) {
							?>
								<tr>
									<?php echo $row[""]
								</tr>
							<?php
								}
							?>
						
							<tr> 
							 <td style="padding-top: 14px;">
							  <div class="vehiculos" style="cursor:pointer;">8087</div>
							 </td> 
							 <td style="padding-top: 14px;">2m</td>
							 <td style="padding-top: 14px;">
								 <i class="fa fa-circle" aria-hidden="true" style="color: #109618; cursor:pointer;" data-toggle="tooltip" title="Vehículo en Vertedero"></i>
								 <i class="fa fa-signal" aria-hidden="true" style="color: green;cursor:pointer;" data-toggle="tooltip" title="Señal GPS buena"></i>
								 <i class="fa fa-square" aria-hidden="true" style="color: red; cursor:pointer;" data-toggle="tooltip" title="Vehículo Detenido"></i>
								 <i class="fa fa-batery-full" aria-hidden="true" style="color: green;" title=""></i>
							 </td>
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
  </body>
</html>
<?php mysql_close($link); ?>