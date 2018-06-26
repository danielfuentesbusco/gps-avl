<?php
	session_start();
	$userid = @$_SESSION["uid"];
	if($userid==""){
		header("Location: /");
		exit;
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
		body, html { 
			margin: 0 !important;
			padding: 0 !important;
			}
    </style>
  </head>
  <body>  
    <div class="container">  
    	<div class="page-header" style="margin-top:0;">    
			<h3>Grupos <small>ingreso de nuevo registro</small></h3>
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
				  <div class="col-xs-12">
						<label class="" for="vid">Nombre</label>
						<input type="text" name="name" class="form-control" value="<?php echo @$_POST["name"];?>" required />
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
				$username="root";
				$password="r1r7C1h6ZG4ZVWF";
				$database="traccar";
				$locations = array();
				$link = mysql_connect("sscl-db-instance.chapmhehekr9.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
				mysql_select_db($database) or die(mysql_error());
				$q = "INSERT INTO device_group (name) VALUES ('{$_POST["name"]}');";
				@mysql_query($q, $link);
		?>
		window.opener.location.reload();
		window.close();
		<?php
				mysql_close($link);
			}
		?>
	</script>
  </body>
</html>