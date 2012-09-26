function mapPolygon(opt_options) {
  var options = opt_options || {};
  this.setValues(options);	
}
mapPolygon.prototype = new google.maps.Polygon();
window['mapPolygon'] = mapPolygon;

mapPolygon.prototype.getBounds = function() {
	var bounds = new google.maps.LatLngBounds();
	this.getPath().forEach(function(latlng,index){ // update the bounds with the current map polygon
		bounds.extend(latlng);
	});	
  	return (bounds); // @type {google.maps.LatLngBounds} 
};
mapPolygon.prototype['getBounds'] = mapPolygon.prototype.getBounds;

mapPolygon.prototype.save = function() {
	var that=this;//Closures... got to love em
	if (isNaN(mapno) || mapno=='' || mapno==null) {
		mapno = prompt("Map No:","");
		if (isNaN(mapno) || mapno=='' || mapno==null){
			alert("You didn't specify a valid map number!");
			this.setMap();
			return;
		}		
	}
	var data = 'mapno=' + mapno + '&path=' + google.maps.geometry.encoding.encodePath(this.getPath());
	$.ajax({
		url: '/polygon-update.php',
		type: 'POST',
		data: data,
		success: function(){
			that.setOptions({strokeColor: "green", fillColor: "green"});
		},
		error: function(){
			that.setOptions({strokeColor: "red", fillColor: "red"});
			that.setMap();
		}	
	});
}
mapPolygon.prototype['save'] = mapPolygon.prototype.save;

mapPolygon.prototype.setListeners = function() {
	var that=this; //Closures... got to love em
	google.maps.event.addListener(this, 'click', function() {  
		that.setEditable(true);
	});
	// unset editable when you click on the map
	google.maps.event.addListener(myMap, 'click', function() {
		that.setEditable(false);
	});
	google.maps.event.addListener(this, 'rightclick', function() {
		that.save();
	});
	// polygon edited event
	google.maps.event.addListener(this.getPath(), 'set_at', function() {
		that.save();
	});
};
mapPolygon.prototype['setListeners'] = mapPolygon.prototype.setListeners;