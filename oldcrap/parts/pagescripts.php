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
	var currentPolygon; //declare the current polygon variable globally
	var mapfixed;
	
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

	function updateLocation(){
		navigator.geolocation.getCurrentPosition(
			function(position) {			
				var currentLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				if (!currentLocationMarker){ currentLocationMarker = createCurrentLocationMarker(currentLatLng); }
				currentLocationMarker.setPosition(currentLatLng);
				myMap.panTo(currentLatLng);
				//fit to bounds
			},
			function(error) {
				alert('Sorry, could not find you... error code: '+error.code);
			}
		);
	}
	
	function setCurrentPolygon(polygonname){
		if (currentPolygon){			
			currentPolygon.setMap(); //delete curent poly from the map			
		}
		currentPolygon = eval(polygonname); //load up the new poly
		currentPolygon.setMap(myMap); //add the poly to the map
		// no way to remove points from a LatLngBounds object so have to start from scratch.
		myBounds = new google.maps.LatLngBounds();
		currentPolygon.getPath().forEach(function(latlng,index){
			myBounds.extend(latlng);
		});
		//myBounds.extend(currentLatLng);
		myMap.fitBounds(myBounds);
	}
	
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

	function fixmap(){
		mapfixed=1;		
		alert('d');
		google.maps.event.trigger(myMap, 'resize');
	}

	$("#mappage").live('pageload',function(event, data){
		//every time a mappage is shown resize the map...it fixes the bug where you initialise a gmap on a hidden div and it looks wierd
		if (!mapfixed){fixmap();}
		myMap.fitBounds(myBounds);
	});
	
	$("#mappage").live('pageinit',function(event){
		if(!myMap){initialize_gmap();}
		$("#flip-tracking").change(function(){
			if ($(this).val()=='on'){
				var locationChangedListener = navigator.geolocation.watchPosition(
					updateLocation,
					function(error){
						//alert('Sorry, could not find you... error code: '+error.code);
					}
				);
			} else { // must be off then	
				navigator.geolocation.clearWatch(locationChangedListener);
			}					
		});
	});
	
	$("#menupage").live('pageinit',function(event){
		if(!myMap){initialize_gmap();}
		// watch for link clicks here
		$(".maplink").click(function(){
			setCurrentPolygon('polygon'+$(this).attr('map'));
			$("#mappage #title").text('Map '+$(this).attr('map'));
		});
	});
	</script>