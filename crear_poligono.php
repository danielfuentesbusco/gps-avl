<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Rastreo Servitrans</title>

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
       #map-container { height: 720px; width:900px;}
	   .acciones{
		width: 100%;
		height: 50px;
		position: absolute;
		bottom:0;
	   }
    </style>
  </head>
  <body>
     <div id="map-container"></div>
		 <div class="row acciones">
			<table width="90%" align="center">
				<tr>
					<td>
						<input type="text" name="name" id="name" class="form-control" placeholder="Ingrese Nombre" />
					</td>
					<td>
						<select name="tipo" id="tipo" class="form-control">
							<option value="2">Base</option>
							<option value="1">Ruta</option>
							<option value="3">Relleno o Vertedero</option>
						</select>
					</td>
					<td>
						<button type="submit" name="btn-submit" class="btn btn-danger pull-right geo_cancel" aria-haspopup="true" aria-expanded="false">Cerrar</button> 
						<button type="submit" name="btn-submit" class="btn btn-success pull-right geo_new" style="margin-right:5px;" aria-haspopup="true" aria-expanded="false">Crear Polígono</button>
					</td>
				</tr>
			</table>
		</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ4z5BFE4vj56liE3pwgzENu4J13lbyRk&libraries=drawing,geometry"></script>
    <script>	
		var var_map;
		var poly;
      function init_map() {
		var var_location = new google.maps.LatLng(-33.3266167,-70.7164856);
        var var_mapoptions = {
          center: var_location,
          zoom: 15
        };
		
		var drawingManager = new google.maps.drawing.DrawingManager({
			//drawingMode: google.maps.drawing.OverlayType.MARKER,
			drawingControl: true,
			drawingControlOptions: {
			  position: google.maps.ControlPosition.TOP_CENTER,
			  drawingModes: [
				google.maps.drawing.OverlayType.POLYGON
			  ]
			},
			polygonOptions: {
			  clickable: false,
			  editable: true
			}
		  });
		
		var_map = new google.maps.Map(document.getElementById("map-container"),var_mapoptions);
		drawingManager.setMap(var_map);
		google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
			var vertices = polygon.getPath();
			for (var i =0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				console.log(xy.lat() + ',' + xy.lng());
			}
			//polys.push(polygon);
			poly = polygon;
			polygon.addListener('click', function(){
				this.setMap(null);
			});
		});
     }
	  
		var id;
		google.maps.event.addDomListener(window, 'load', init_map);
		
		$('.geo_new').click(function(){
			var vertices = poly.getPath();
			var n = $("#name").val();
			var t = $("#tipo").val();
			var v = [];
			for (var i =0; i < vertices.getLength(); i++) {
				var xy = vertices.getAt(i);
				v.push(xy.lat() + ' ' + xy.lng());
			}
			var d = v.join(";");
			$.get( "set_polygon.php?gid=0&d="+d+"&n="+n+"&t="+t, function(data) {
				//console.log(data);
				//$('#geo_update').hide();
				//$('#geo_cancel').hide();
				alert("Polígono registrado con éxito.");
				window.opener.location.reload();
				window.close();
				//window.close();
				/*while(polys[0]){
					polys.pop().setMap(null);
				}*/
				//window.location="/geocercas.php";
			});
		});
		
		$('.geo_cancel').click(function(){
			window.close();
		});
    </script>
  </body>
</html>