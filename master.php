<?php
require_once('config.php');
if (isset($_REQUEST['mapno']) && $_REQUEST['mapno']!=''){
	$map = new map(array(
		'mapno' => $_REQUEST['mapno'],
		'editable' => TRUE
	));
}
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title><?php echo APPNAME; ?> <?php echo VERSION; ?> - Master</title>
	<link rel="stylesheet" href="/css/site.css" />    
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry,drawing" type="text/javascript"></script>
	<script src="/js/class-blockmarker.js"></script>
	<script src="/js/class-mappolygon.js"></script>    
	<style type="text/css">
		
	</style>
	<script type="text/javascript">	
	// Declare global variables
	var myMap;
	var mapno='<?php echo isset($map) ? $map->getMapno() : ''; ?>';
	var polygon;
	
	// Set up the Drawing Manager Object
	var drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.<?php echo isset($map) ? 'MARKER' : 'POLYGON'; ?>,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_RIGHT,
			drawingModes: [
				google.maps.drawing.OverlayType.POLYGON,
				google.maps.drawing.OverlayType.MARKER
			]
		},
		polygonOptions: {
			strokeColor: "blue",
			strokeOpacity: 0.5,
			strokeWeight: 2,
			fillColor: "blue",
			fillOpacity: 0.15
		}
	});
	
	//Set up the google map
	function initialize_gmap() {
		var myLatLng = new google.maps.LatLng(-34.4, 150.9); // Wollongong
		var myOptions = {
			zoom: 13,
			streetViewControl: false,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		myMap = new google.maps.Map(document.getElementById("gmap_canvas"),myOptions);
		drawingManager.setMap(myMap);
		<?php
			if (isset($map)){
				$map->genPolygonJS();
				$map->genBlockMarkersJS(); 	
				echo "myMap.fitBounds(polygon.getBounds());\n";
			}		
		?>
	}	
	
	// converts a standard marker to a blockmarker and saves it to the db
	function convertMarker(marker){
		if (isNaN(mapno) || mapno=='' || mapno==null) {
			alert('A map number has not been set yet');
			return;
		}
		var blockno=prompt("Block No:","");
		if (isNaN(blockno) || blockno=='' || blockno==null) {
			alert('That\'s not a valid block number');
			return;
		}
		blockmarker = new BlockMarker({
			position: marker.getPosition(),
			map: myMap,
			mapno: mapno,
			blockno: blockno,
			shadow: false,
			draggable: true,
			editable: true,
			content: '<div class="blockno">Block&nbsp;' + blockno + '</div>'
		});
		blockmarker.save();
	}
	
	// Add listeners for polygon events
	google.maps.event.addListener(drawingManager, 'polygoncomplete', function(drawingManagerPolygon) {
		polygon = new mapPolygon(drawingManagerPolygon);
		polygon.setListeners();
		polygon.save();
	});	
	
	google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
		convertMarker(marker);
		marker.setMap();
	});
	
	// Boot it
	$(document).ready(function(){
		initialize_gmap();	
	});
	</script>
</head> 

<body> 
	<div id="gmap_canvas" style="height:800px; width:100%;"></div>
</body>
</html>