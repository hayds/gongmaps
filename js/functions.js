// Create lovely little iphone style blue dot marker
function createCurrentLocationMarker(point){
	var image = new google.maps.MarkerImage(
		'/images/markers/locator/image.png',
		new google.maps.Size(16,16),
		new google.maps.Point(0,0),
		new google.maps.Point(8,16)
	);
				
	var shape = {
		coord: [11,0,12,1,13,2,14,3,14,4,15,5,15,6,15,7,15,8,15,9,15,10,15,11,14,12,13,13,12,14,11,15,5,15,3,14,2,13,1,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,1,2,2,1,3,0,11,0],
		type: 'poly'
	};
		
	var marker = new google.maps.Marker({
		draggable: false,
		raiseOnDrag: false,
		icon: image, 
		shape: shape,
		map: myMap,
		position: point
	});
	return marker;
}

// Create lovely little red dnc marker
function dnc_marker_image(){
	var image = new google.maps.MarkerImage(
	  '/images/markers/dnc/image.png',
	  new google.maps.Size(20,34),
	  new google.maps.Point(0,0),
	  new google.maps.Point(10,34)
	);
	return image;
}

function dnc_marker_shadow(){
	var shadow = new google.maps.MarkerImage(
	  '/images/markers/dnc/shadow.png',
	  new google.maps.Size(40,34),
	  new google.maps.Point(0,0),
	  new google.maps.Point(10,34)
	);
	return shadow;
}

function dnc_marker_shape(){
	var shape = {
	  coord: [13,0,15,1,16,2,17,3,18,4,18,5,19,6,19,7,19,8,19,9,19,10,19,11,19,12,19,13,18,14,18,15,17,16,16,17,15,18,14,19,14,20,13,21,13,22,12,23,12,24,12,25,11,26,11,27,11,28,11,29,11,30,11,31,11,32,11,33,8,33,8,32,8,31,8,30,8,29,8,28,8,27,8,26,7,25,7,24,7,23,6,22,6,21,5,20,5,19,4,18,3,17,2,16,1,15,1,14,0,13,0,12,0,11,0,10,0,9,0,8,0,7,0,6,1,5,1,4,2,3,3,2,4,1,6,0,13,0],
	  type: 'poly'
	};
	return shape;
}

// Create lovely little iphone style red dnc marker
function createDNCMarker(point,title){
	var image = new google.maps.MarkerImage(
	  '/images/markers/dnc/image.png',
	  new google.maps.Size(15,37),
	  new google.maps.Point(0,0),
	  new google.maps.Point(8,37)
	);
	
	var shadow = new google.maps.MarkerImage(
	  '/images/markers/dnc/shadow.png',
	  new google.maps.Size(37,37),
	  new google.maps.Point(0,0),
	  new google.maps.Point(8,37)
	);
	
	var shape = {
	  coord: [11,0,12,1,13,2,14,3,14,4,14,5,14,6,14,7,14,8,14,9,14,10,14,11,13,12,12,13,11,14,8,15,8,16,8,17,8,18,8,19,8,20,8,21,8,22,8,23,8,24,8,25,8,26,8,27,8,28,8,29,8,30,8,31,9,32,9,33,9,34,9,35,7,36,7,36,5,35,5,34,5,33,5,32,6,31,6,30,6,29,6,28,6,27,6,26,6,25,6,24,6,23,6,22,6,21,6,20,6,19,6,18,6,17,6,16,6,15,3,14,2,13,1,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,1,2,2,1,3,0,11,0],
	  type: 'poly'
	};
	
	var marker = new google.maps.Marker({
	  draggable: false,
	  raiseOnDrag: false,
	  icon: image,
	  shadow: shadow,
	  shape: shape,
	  map: myMap,
	  position: point,
	  title: title
	});
	return marker;
}

function clean_address(address_components){
	var result='';
	for (i=0; i < address_components.length; i++) {
		if (address_components[i].types[0]!='administrative_area_level_1' && address_components[i].types[0]!='country' && address_components[i].types[0]!='postal_code' && address_components[i].types[0]!='street_name') {
			result = result + address_components[i].short_name+' ';
		}
		if (address_components[i].types[0]=='subpremise'){
			result = result + '/ ';
		}
	}
	return result;
}