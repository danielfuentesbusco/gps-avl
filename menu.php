<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
	<div class="navbar-header">
		<img src="img/logo-servitrans.png" height="50" style="margin-right:10px;" />
	</div>
	<div id="navbar" class="navbar-collapse collapse">
	  <ul class="nav navbar-nav">
		<li><a href="./seguimiento.php"><span class="fa fa-map-marker"></span> Rastreo</a></li>
		<li class=""><a href="./rutas.php"><span class="fa fa-map-signs"></span> Rutas</a></li>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-file-text-o"></span> Reportes</a>
			<ul class="dropdown-menu">
				<li><a href="./reporte_desconexion.php"><span class="fa fa-plug"></span> Desconexión</a></li>
				<li><a href="./reporte_ignition.php"><span class="fa fa-key"></span> Ignición</a></li>
				<li><a href="./reporte_velocidad.php"><span class="fa fa-tachometer"></span> Velocidad</a></li>
				<li><a href="./reporte_ruta.php"><span class="fa fa-map-signs"></span> Rutas</a></li>
				<li><a href="./reporte_km.php"><span class="fa fa-car"></span> Kilómetros recorridos</a></li>
				<li><a href="./reporte_historial_velocidad.php"><span class="fa fa-tachometer"></span> Historial de velocidad</a></li>
				<li><a href="./reporte_poligonos.php"><span class="fa fa-map"></span> Entrada y salida polígonos</a></li>
			</ul>
		</li> 
		<?php if ($_SESSION["admin"]=='1'){ ?>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-map"></span> Polígonos</a>
			<ul class="dropdown-menu">
				<li><a href="./asignacion_poligono.php"><span class="fa fa-map"></span> Polígonos asignados</a></li>
				<li><a href="./asignacion_ruta.php"><span class="fa fa-map-signs"></span> Rutas asignadas</a></li>
			</ul>
		</li>
		<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-gear"></span> Administración</a>
			<ul class="dropdown-menu">
				<li><a href="./poligonos.php"><span class="fa fa-file-text-o"></span> Polígonos</a></li>
				<li><a href="./conductores.php"><span class="fa fa-user"></span> Conductores</a></li>
				<li><a href="./grupos.php"><span class="fa fa-group"></span> Grupos</a></li>
			</ul>
		</li>
		<?php } ?>
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
		<li><a href="index.php"><span class="fa fa-sign-out"></span> Salir</a></li>
	  </ul>
	</div><!--/.nav-collapse -->
  </div>
</nav>