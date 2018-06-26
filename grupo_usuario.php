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
	$asignaciones = array();
	$q = "SELECT user_id FROM user_group_assign WHERE device_group_id = '{$_GET["id"]}';";
	$resultado = mysql_query($q);
	while ($row = mysql_fetch_assoc($resultado)){
		$asignaciones[$row["user_id"]] = true;
	}
	
	$q = "SELECT name FROM device_group WHERE id = '{$_GET["id"]}';";
	$resultado = mysql_query($q);
	$row = mysql_fetch_assoc($resultado);
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
			<h3>Usuarios <small>grupo <?php echo $row["name"];?></small></h3>
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
					<input type="hidden" name="device_group_id" value="<?php echo $_GET["id"]; ?>" />
				  <?php
					$q = "SELECT id, name FROM users ORDER BY name;";
					$resultado = mysql_query($q);
					$i = 1;
					while ($row = mysql_fetch_assoc($resultado)) {
						if ($i % 3 == 0){
							echo '<div class="row">';
						}
						$checked = "";
				  ?>
				  <div class="col-xs-4">
						<div class="form-check">
							<label class="form-check-label">
							<?php if (isset($asignaciones[$row["id"]]) && $asignaciones[$row["id"]]==true){
								$checked = "checked";
							}
							?>
							<input class="form-check-input" type="checkbox" name="checkbox[<?php echo $row["id"]; ?>]" value="1" <?php echo $checked;?> />
							<?php echo $row["name"]; ?>
						  </label>
					  </div>
				  </div>
				<?php
						if ($i % 3 == 0){
							echo '</div>';
							echo '<div class="row">';
							echo '</div>';
						}
						$i++;
					}
				  ?>
				  <div class="row">
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script>
		<?php 
			if(isset($_POST["btn-submit"])){
				$query = "DELETE FROM user_group_assign WHERE device_group_id = '{$_POST["device_group_id"]}';";
				 mysql_query($query);
				foreach($_POST["checkbox"] as $key => $value){
					$query = "INSERT INTO user_group_assign (user_id, device_group_id) VALUES ('$key','{$_POST["device_group_id"]}');";
					 mysql_query($query);
				}
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