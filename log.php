<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rastreo</title>

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
  </head>
	<style>
		html {
			padding-top: 10px !important;
		}
	</style>
  <body>   
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3 style="margin-top:0;">Log <small>Registro de comunicación</small></h3>
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
                       Últimos 200 registros
                    </h3>
                  </div>
                  	
                    <table class="table table-hover">
                        <thead> 
                            <tr>	
                                <th>IMEI</th>	
                                <th>Fecha</th>
								<th>Data</th>
                            </tr>
                        </thead>
                        <tbody> 
						<?php
						$username="root";
						$password="r1r7C1h6ZG4ZVWF";
						$database="traccar";
						$locations = array();
						//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
						$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
						mysql_select_db($database) or die(mysql_error());
						$q = "SELECT devices.uniqueid as imei, data_log.fecha, data_log.data FROM traccar.data_log, devices where devices.id = data_log.device_id order by data_log.id desc limit 200;";
						$resultado2 = mysql_query($q) or die(mysql_error());
						while ($row2 = mysql_fetch_array($resultado2)) {
						?>
                    <tr> 
                     <td style="" nowrap>
                     <div class=""><?php echo $row2["imei"];?></div>
                     </td> 
                     <td style="" nowrap>
                     <div class=""><?php echo $row2["fecha"];?></div>
                     </td> 
					 <td style="" nowrap>
                     <div class="" ><?php echo $row2["data"];?></div>
                     </td> 
                    </tr>
					<?php }
						mysql_close($link);
					?>
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
        <p class="text-muted" style="color: #008175;">Sistema de Rastreo 1.0 / Servitrans / Cumsensu / 2016 &copy; Todos los derechos reservados / <?php echo date("d/m/Y h:i:s A");?></p>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
