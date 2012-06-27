// labelMarker Object
function labelMarker(options) {
	// Set defaults when initialised	
	options = options || {};
	this.position = options.position || ""; 			// @type {google.maps.LatLng}
	this.map = options.map || ""; 						// @type {google.maps.Map}
	this.html = options.html || "nothing specified";	// @type any text or html code
	
	// Explicity set the instance of the labelMarker to the map you specified in options
	this.setMap(this.map);
}

// Overload labelMarker to a new instance of google.maps.OverlayView
labelMarker.prototype = new google.maps.OverlayView();

labelMarker.prototype.onAdd = function() {	
	this.div = document.createElement('div');
	this.div.style['position'] = 'absolute';
	this.div.innerHTML = this.html;
	var panes = this.getPanes();
	panes.overlayImage.appendChild(this.div);
}
labelMarker.prototype.draw = function() {
	// This.getProjection() only available in draw function
	var pos = this.getProjection().fromLatLngToDivPixel(this.get('position'));
	this.div.style['top'] = (pos.y) + 'px';
	this.div.style['left'] = (pos.x) + 'px';
}

labelMarker.prototype.onRemove = function() {
	this.div.parentNode.removeChild(this.div);
}