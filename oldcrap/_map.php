<!DOCTYPE html> 
<html> 
	<head> 
	<title>Map 1</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<link rel="stylesheet" href="/css/site.css" />    
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry" type="text/javascript"></script>
    <script type="text/javascript">
	var myMap; // declare the map variable globally
	var myBounds; // declare the bounds variable globally	
	var currentLocationMarker; //declare currentLocationMarker variable globally
	var currentLatLng; //declare currentLatLng variable globally

	
	function createCurrentLocationMarker(point){
		var image = new google.maps.MarkerImage(
			'/images/marker-images/image.png',
			new google.maps.Size(16,16),
			new google.maps.Point(0,0),
			new google.maps.Point(8,16)
		);
					
		var shape = {
			coord: [11,0,12,1,13,2,14,3,14,4,15,5,15,6,15,7,15,8,15,9,15,10,15,11,14,12,13,13,12,14,11,15,5,15,3,14,2,13,1,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,1,2,2,1,3,0,11,0],
			type: 'poly'
		};
			
		var marker = new google.maps.Marker({
			draggable: true,
			raiseOnDrag: false,
			icon: image, 
			shape: shape,
			map: myMap,
			position: point
		});
		return marker;
	}
	
<?php include('mapsjs.php');?>

	function initialize_gmap() {
		var myLatLng = new google.maps.LatLng(-34.412434, 150.868859);
		var myOptions = {
		  zoom: 16,
		  panControl: false,
		  zoomControl: false,
		  scaleControl: false,
	  	  streetViewControl: false,
		  overviewMapControl: false,		  
		  center: myLatLng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
    	myMap = new google.maps.Map(document.getElementById("gmap_canvas"),myOptions);
	}
	
	// when the mappage first comes into view load the gmap on it
	$("#mappage").live('pageinit',function(event){
		initialize_gmap();
		function updateLocation(){
			navigator.geolocation.getCurrentPosition(
				function(position) {
					// delete currentlatlng from bounds - we havent updated it yet so its still the old one
					var currentLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					if (!currentLocationMarker){ currentLocationMarker = createCurrentLocationMarker(currentLatLng); }
					currentLocationMarker.setPosition(currentLatLng);
					//add currentlatlng to bounds
					//fit to bounds
					// fit to bounds will take away the below
					myMap.panTo(currentLatLng);
				},
				function(error) {
					alert('Sorry, could not find you... error code: '+error.code);
				}
			);
		}
		
		$("#starttracking").click(function(){
			var locationChangedListener = navigator.geolocation.watchPosition(
				updateLocation,
				function(error){
					alert('Sorry, could not find you... error code: '+error.code);
				}
			);			
		});
				
		$("#stoptracking").click(function(){
			navigator.geolocation.clearWatch(locationChangedListener);
		});		
		
		// add some kind of listener to the map links which adds and removes polygons on the map. ie current polygon = polygon1 
		// add polygon to map
		// create a new bounds with current latlng and the polygons bounds and fit the map to those bounds.
	});
	</script>
</head> 

<body> 

<div data-role="page" id="mappage">

	<div data-role="header" data-theme="b">
    <a data-transition="flow" href="index.php" data-icon="home">Home</a>
		<h1>Map 1</h1>
	</div><!-- /header -->

	<div data-role="content">	
    <div id="location"></div>
		<div id="gmap_canvas"></div>
	</div><!-- /content -->
    
    <div data-role="footer" data-theme="c">
        <label for="flip-dnc">Show DNC:</label>
        <select name="slider" id="flip-dnc" data-role="slider" data-mini="true" data-theme="c">
            <option value="off">Off</option>
            <option value="on">On</option>
        </select>
        <a id="starttracking" href="" data-role="button" data-inline="true" data-theme="c" data-icon="track" data-iconpos="notext"></a>
        <a id="stoptracking" href="" data-role="button" data-inline="true" data-theme="c" data-icon="delete" data-iconpos="notext"></a>
	</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>