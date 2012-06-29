<?php
require_once('config.php');
if (isset($_REQUEST['mapno']) && $_REQUEST['mapno']!=''){
	$map = new map(array(
		'mapno' => $_REQUEST['mapno'],
		'editable' => FALSE
	));
} else {
	error('no map specified');
}
?>
<!DOCTYPE html>
<html>
	<head> 
	<title>Map <?php echo $map->getMapno(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<link rel="stylesheet" href="/min/f=css/site.css" />    
    
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="/min/f=js/jquery.mobile-1.1.0.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry,places" type="text/javascript"></script>
	<script src="/min/f=js/functions.js,js/class-mappolygon.js,js/class-blockmarker.js,js/class-dncmarker.js&debug=1"></script>
    <script type="text/javascript">
	var myMap; 					// declare the map variable globally
	var myBounds; 				// declare the bounds variable globally
	var polygon;				// declare the bounds variable globally
	var currentLocationMarker;	// declare currentLocationMarker variable globally
	var currentLatLng; 			// declare currentLatLng variable globallky
	var autocomplete;			// declare autocomplete variable globally
	var mapno='<?php echo $map->getMapno(); ?>';

	<?php $map->genPolygonJS(); ?>
	function initialize_gmap() {
		var myOptions = {
		  panControl: false,
		  zoomControl: false,
		  scaleControl: false,
	  	  streetViewControl: false,
		  overviewMapControl: false,		  
		  mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
    	myMap = new google.maps.Map(document.getElementById("gmap_canvas"),myOptions);
		polygon.setMap(myMap);
		<?php $map->genBlockMarkersJS(); ?>
		<?php $map->genDNCMarkersJS(); ?>
		update_bounds();
	}
	
	// zooms and centers the map to fit the current polygon and your current location if tracking is on
	// assumes polygon, mybounds and currentLatLng exist
	function update_bounds(){ 
		myBounds = polygon.getBounds();		
		if (currentLocationMarker){ // if we are tracking the location add it
			myBounds.extend(currentLatLng); // update the bounds with the current location
		}
		myMap.fitBounds(myBounds); // fit the map to the bounds
	}
	
	// gets your current GPS location from the HTML5 browser and updates currentLocationMarker
	function updateLocation(){
			navigator.geolocation.getCurrentPosition(
			function(position) { // function if it works
				currentLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				if (!currentLocationMarker || currentLocationMarker==null ){ // if currentLocationMarker doesnt exist create it with the current latlng
					currentLocationMarker = createCurrentLocationMarker(currentLatLng); 
				} else { // else just update its latlng
					currentLocationMarker.setPosition(currentLatLng);
				}				
				update_bounds();
			},
			function(error) {// function if it fails
				alert('Sorry, could not find you... error code: '+error.code);
			}
		);
	}
	
	// JQuery mobile equivalent to doc ready function
	$("#mappage").live('pageinit',function(event){
		// Load the map. Note: This has to go here because this is the jquery mobile equiv of doc ready so the map canvas div exists at this point
		if (!myMap){initialize_gmap();}
		
		// Tracking flipper
		$("#flip-tracking").change(function(){
			if ($(this).val()=='on'){
				updateLocation();
				var locationChangedListener = navigator.geolocation.watchPosition(updateLocation,function(error){alert('Sorry, could not find you... error code: '+error.code);});
			} else { // must be off then
				navigator.geolocation.clearWatch(locationChangedListener);
				currentLocationMarker.setMap();
				currentLocationMarker=null;
				update_bounds();
			}					
		});
		
	});	
	
	$("#mappage").live('pageshow',function(event){		
		google.maps.event.trigger(myMap, 'resize');	// forces the map to redraw which prevents the map looking wierd when hidden and reshown
		update_bounds();
	});	
	
	// JQuery mobile equivalent to doc ready function
	$("#dncpage").live('pageinit',function(event){
		// Load the map. Note: This has to go here because this is the jquery mobile equiv of doc ready so the map canvas div exists at this point
		// This must be triggered here in case you reload the application @ #dncpage. If not put here then myMap will not exist as a gmap and will cause errors when a marker is added or removed.
		if (!myMap){initialize_gmap();}

		// MAKE THE ACCEPT BUTTON DISSAPEAR WHEN NEEDED
	    $("#accept_button").hide();
		$("#address_input").parent().find('a').click(function(){
			$("#accept_button").hide();
		});
		$("#address_input").keydown(function(){
			$("#accept_button").hide();
		});
		//END
		
		// Load up the autocomplete for the DNC's
		var input = document.getElementById('address_input');
		var autocompleteOptions = {
			bounds: polygon.getBounds(),
			types: ['geocode'],
			componentRestrictions: {country: 'au'}
		};
		autocomplete = new google.maps.places.Autocomplete(input,autocompleteOptions);

		google.maps.event.addListener(autocomplete, 'place_changed', function() {
		  $("#accept_button").show();  			
        });		
		
		$("#accept_button").click(function(){
			var place = autocomplete.getPlace();
			var address=new Array();
			if (place.address_components){
				for (i=0; i < place.address_components.length; i++) {
					switch(place.address_components[i].types[0])
					{
					case 'subpremise':
					  address['subpremise']=place.address_components[i].short_name;
					  break;
					case 'street_number':
					  address['streetno']=place.address_components[i].short_name;
					  break;
					case 'route': //street name
					  address['street']=place.address_components[i].short_name;
					  break;	
					case 'locality': //suburb
					  address['suburb']=place.address_components[i].short_name;
					  break;
					case 'administrative_area_level_1': //state
					  address['state']=place.address_components[i].short_name;
					  break;		  
					case 'postal_code':
					  address['postcode']=place.address_components[i].short_name;
					  break;			  
				    }
			    }
			}

			if (!address['streetno']){ 
				alert('sorry that address does not exist'); 
				return false;
			}

			var dncmarker=new DNCMarker({
			    icon: dnc_marker_image(),
			    shadow: dnc_marker_shadow(),
			    shape: dnc_marker_shape(),
				position: place.geometry.location,
				map: myMap,
				subpremise: address['subpremise'],
				streetno: address['streetno'],
				street: address['street'],
				suburb: address['suburb'],
				state: address['state'],
				postcode: address['postcode'],
				labelClass: 'markerwithlabel',
			});	
			
			dncmarker.save({
				onsuccess: function(){
					//Reload the DNC list with the new entry
					$("#dnclist").load("/map-ajax-dnclist.php?mapno=" + mapno, function(response, status, xhr) {
						if (status == "error") {
							alert("Sorry but there was an error: " + xhr.status + " " + xhr.statusText);
						} else {
							$("#dnclist").trigger("create"); //apply jquery mobile visualizations to new markup
						}
					});
				}
			});
			
		});
		
		$("#dnclist").on("click", "a", function(){		
			var sysid = $(this).attr("data-sysid"); //get the sysid of the marker out of the link
			var thelink=$(this);
			myMap.getDNCMarker(sysid).remove({ // get the marker from the map based on the id and call the remove function to delete it form the db and take it off the map
				onsuccess: function(){
					thelink.parent().remove(); // if it succeeds, remove the link from the dom
				}
			});
		});
	});	
	</script>
</head>
<body class="ui-body-c"><!--Watch out for this ui-body-c this is hard coded-->

<div data-role="page" id="mappage">

	<div data-role="header" data-theme="b">
	    <a data-transition="reverse flow" href="/index.php" data-icon="home" data-ajax="false">Home</a>
		<h1>Map <?php echo $map->getMapno(); ?></h1>
        <a data-transition="flow" href="#dncpage" data-icon="alert">DNC's</a>
	</div><!-- /header -->

	<div data-role="content">	
    <div id="location"></div>
		<div id="gmap_canvas"></div>
	</div><!-- /content -->
    
	<div data-role="footer" data-theme="c" class="ui-bar clearfix">
        <div class="ui-grid-a clearfix">
            <div class="ui-block-a">
                <label for="flip-dnc">Show DNC's</label>
                <select name="slider" id="flip-dnc" data-role="slider" data-mini="true" data-theme="c">
                    <option value="off">Off</option>
                    <option value="on">On</option>
                </select>
            </div>   
            <div class="ui-block-b">   
                <label for="flip-tracking">Tracking</label>
                <select name="slider" id="flip-tracking" data-role="slider" data-mini="true" data-theme="c">
                    <option value="off">Off</option>
                    <option value="on">On</option>
                </select>
            </div>
        </div>
	</div><!-- /footer -->

</div><!-- /page -->


<div data-role="page" id="dncpage">
	<div data-role="header" data-theme="b">
    <a data-transition="reverse flow" href="#mappage" data-icon="back">Back</a>
		<h1>Map <?php echo $map->getMapno(); ?> DNC's</h1>
	</div><!-- /header -->

	<div data-role="content">
        <div data-role="fieldcontain">
            <label for="address_input" class="ui-hidden-accessible">Address:</label>
            <input type="search" name="address_input" id="address_input" value="" placeholder="Enter new DNC Address"/>     
            <div class="align-right">
        		<a id="accept_button" href="#" data-role="button" data-icon="plus" data-inline="true" data-mini="true">Add DNC</a>
        	</div>      
        </div>        
        <ul id="dnclist" class="styled">
        <?php $map->genDNCList(); ?>
        </ul>
	</div><!-- /content -->
    
	<div data-role="footer" data-theme="c" class="ui-bar">
        
	</div><!-- /footer -->

</div><!-- /page -->
</body>
</html>