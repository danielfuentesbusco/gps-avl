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
    <title>Conductores / Servitrans</title>

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
			<h3 style="margin-top:0;">Conductores <small>Administración de conductores</small></h3>
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
                       Conductores
                    </h3>
                  </div>
                  <div class="panel-body">
				   <table class="table table-hover" style="font-size: 100%;">
                        <thead> 
                            <tr>	
								<th style="width: 10px;">ID</th>	
                                <th>Nombres</th>
								 <th>Paterno</th>
								  <th>Materno</th>
								<th style="width: 70px;">Rut</th>
								 <th>Estado</th>
								<th style="width: 70px;">
									<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  Acciones
									  <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
									  <li><a href="javascript:window.open('./conductor_nuevo.php','neoConductor','width=900, height=720');">Nuevo</a></li>
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
							$q = "SELECT id, paterno, materno, nombres, rut, dv, estado FROM traccar.conductores ORDER BY paterno, materno, nombres;";
							$resultado = mysqli_query($link, $q) or die(mysqli_error());
							while ($row = mysqli_fetch_array($resultado)) {
						?>
							<tr>
								<td style="vertical-align: middle;" nowrap><?php echo $row["id"];?></td>
								<td style="vertical-align: middle;" nowrap><?php echo utf8_encode($row["nombres"]);?></td>
								<td style="vertical-align: middle;" nowrap><?php echo utf8_encode($row["paterno"]);?></td>
								<td style="vertical-align: middle;" nowrap><?php echo utf8_encode($row["materno"]);?></td>
								<td style="vertical-align: middle;" nowrap><?php echo utf8_encode($row["rut"]);?>-<?php echo utf8_encode($row["dv"]);?></td>
								<td style="vertical-align: middle;" nowrap><?php if($row["estado"]=='1'){echo "Activo";}else{echo "Inactivo";};?></td>
								<td style="vertical-align: middle;">
									<div class="btn-group" role="group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  Acciones
									  <span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
									  <li><a href="javascript:window.open('./conductor_actualizar.php?id=<?php echo $row["id"];?>','conductorModificar','width=900, height=720');">Modificar</a></li>
									  <!--<li><a href="javascript:window.open('./conductor_eliminar.php?pid=<?php echo $row["id"];?>','conductorEliminar','width=900, height=720');">Eliminar</a></li>-->
									</ul>
								  </div>
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
  </body>
</html>
