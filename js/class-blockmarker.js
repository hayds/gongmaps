// ==ClosureCompiler==
// @compilation_level ADVANCED_OPTIMIZATIONS
// @externs_url http://closure-compiler.googlecode.com/svn/trunk/contrib/externs/maps/google_maps_api_v3.js
// @output_wrapper (function() {%output%})();
// ==/ClosureCompiler==

/**
 * A BlockMarker that allows any HTML/DOM to be added to a map and be draggable.
 *
 * @param {Object.<string, *>=} opt_options Optional properties to set.
 * @extends {google.maps.OverlayView}
 * @constructor
 */
function BlockMarker(opt_options) {
  var options = opt_options || {};

  /**
   * @type {boolean}
   * @private
   */
  this.ready_ = false;

  /**
   * @type {boolean}
   * @private
   */
  this.dragging_ = false;

  if (opt_options['visible'] == undefined) {
    opt_options['visible'] = true;
  }

  if (opt_options['shadow'] == undefined) {
    opt_options['shadow'] = '7px -3px 5px rgba(88,88,88,0.7)';
  }

  if (opt_options['anchor'] == undefined) {
    opt_options['anchor'] = BlockMarkerPosition['BOTTOM'];
  }
	
  if (opt_options['editable'] == undefined) {
    opt_options['editable'] = false;
  }

  if (opt_options['mapno'] == undefined) {
    opt_options['mapno'] = "";
  }
  
  if (opt_options['blockno'] == undefined) {
    opt_options['blockno'] = "";
  }

  if (opt_options['fontsize'] == undefined) {
    opt_options['fontsize'] = "";
  }
    
  this.setValues(options);
}window['BlockMarker'] = BlockMarker;
BlockMarker.prototype = new google.maps.OverlayView();



/*VISIBLE*/

//Set
BlockMarker.prototype.setVisible = function(visible) {
  this.set('visible', visible);
}
BlockMarker.prototype['setVisible'] = BlockMarker.prototype.setVisible;

//Get
BlockMarker.prototype.getVisible = function() {
  return (this.get('visible')); // @type {boolean} 
};
BlockMarker.prototype['getVisible'] = BlockMarker.prototype.getVisible;

//Changed
BlockMarker.prototype.visible_changed = function() {
  if (this.ready_) {
    this.markerWrapper_.style['display'] = this.getVisible() ? '' : 'none';
    this.draw();
  }
};
BlockMarker.prototype['visible_changed'] = BlockMarker.prototype.visible_changed;


/*FONTSIZE*/

//Set
BlockMarker.prototype.setFontSize = function(fontsize) {
  this.set('fontsize', fontsize);
  //this.fontsize_changed();
}
BlockMarker.prototype['setFontSize'] = BlockMarker.prototype.setFontSize;

//Get
BlockMarker.prototype.getFontSize = function() {
  return (this.get('fontsize')); // @type {number} 
};
BlockMarker.prototype['getFontSize'] = BlockMarker.prototype.getFontSize;

//Changed
BlockMarker.prototype.zoom_changed = function() {
	var zoom = this.getMap().getZoom();
	if (zoom < 12 ) {zoom = 12;}
	if (zoom > 18 ) {zoom = 18;}
	var sizearray = new Array();
	sizearray[12]=1;sizearray[13]=4;sizearray[14]=8;sizearray[15]=12;sizearray[16]=16;sizearray[17]=20;sizearray[18]=24;
	this.setFontSize(sizearray[zoom]);
	this.markerContent_.style.fontSize =  this.getFontSize() + 'px';		
  if (this.ready_) {	
    this.draw();
  }
};
BlockMarker.prototype['fontsize_changed'] = BlockMarker.prototype.fontsize_changed;


/*MARKER*/

//Set
BlockMarker.prototype.setFlat = function(flat) {
  this.set('flat', !!flat);
};
BlockMarker.prototype['setFlat'] = BlockMarker.prototype.setFlat;

//Get
BlockMarker.prototype.getFlat = function() {
  return  (this.get('flat')); // @type {boolean}
};
BlockMarker.prototype['getFlat'] = BlockMarker.prototype.getFlat;


/*WIDTH*/

//Get
BlockMarker.prototype.getWidth = function() {
  return  (this.get('width')); // @type {Number} 
};
BlockMarker.prototype['getWidth'] = BlockMarker.prototype.getWidth;


/*HEIGHT*/

//Get
BlockMarker.prototype.getHeight = function() {
  return  (this.get('height')); //@type {Number}
};
BlockMarker.prototype['getHeight'] = BlockMarker.prototype.getHeight;


/*SHADOW*/

//Set
BlockMarker.prototype.setShadow = function(shadow) {
  this.set('shadow', shadow);
  this.flat_changed();
};
BlockMarker.prototype['setShadow'] = BlockMarker.prototype.setShadow;


//Get
BlockMarker.prototype.getShadow = function() {
  return (this.get('shadow')); // @type {string} 
};
BlockMarker.prototype['getShadow'] = BlockMarker.prototype.getShadow;


/*FLAT*/

//Changed
BlockMarker.prototype.flat_changed = function() {
  if (!this.ready_) {
    return;
  }

  this.markerWrapper_.style['boxShadow'] =
  this.markerWrapper_.style['webkitBoxShadow'] =
  this.markerWrapper_.style['MozBoxShadow'] =
  this.getFlat() ? '' : this.getShadow();
};
BlockMarker.prototype['flat_changed'] = BlockMarker.prototype.flat_changed;


/*SET INDEX*/

//Set
BlockMarker.prototype.setZIndex = function(index) {
  this.set('zIndex', index);
};
BlockMarker.prototype['setZIndex'] = BlockMarker.prototype.setZIndex;

//Get
BlockMarker.prototype.getZIndex = function() {
  return  (this.get('zIndex')); // @type {Number}
};
BlockMarker.prototype['getZIndex'] = BlockMarker.prototype.getZIndex;

//Changed
BlockMarker.prototype.zIndex_changed = function() {
  if (this.getZIndex() && this.ready_) {
    this.markerWrapper_.style.zIndex = this.getZIndex();
  }
};
BlockMarker.prototype['zIndex_changed'] = BlockMarker.prototype.zIndex_changed;


/*DRAGGABLE*/

//Get
BlockMarker.prototype.getDraggable = function() {
  return  (this.get('draggable')); // @type {boolean}
};
BlockMarker.prototype['getDraggable'] = BlockMarker.prototype.getDraggable;

//Set
BlockMarker.prototype.setDraggable = function(draggable) {
  this.set('draggable', !!draggable);
};
BlockMarker.prototype['setDraggable'] = BlockMarker.prototype.setDraggable;

//Changed
BlockMarker.prototype.draggable_changed = function() {
  if (this.ready_) {
    if (this.getDraggable()) {
      this.addDragging_(this.markerWrapper_);
    } else {
      this.removeDragListeners_();
    }
  }
};
BlockMarker.prototype['draggable_changed'] = BlockMarker.prototype.draggable_changed;


/*POSITION*/

//Get
BlockMarker.prototype.getPosition = function() {
  return  (this.get('position')); // @type {google.maps.LatLng}
};
BlockMarker.prototype['getPosition'] = BlockMarker.prototype.getPosition;

//Set
BlockMarker.prototype.setPosition = function(position) {
  this.set('position', position);
};
BlockMarker.prototype['setPosition'] = BlockMarker.prototype.setPosition;

//Changed
BlockMarker.prototype.position_changed = function() {
  this.draw();
};
BlockMarker.prototype['position_changed'] = BlockMarker.prototype.position_changed;


/*ANCHOR*/

//Get
BlockMarker.prototype.getAnchor = function() {
  return  (this.get('anchor'));
};
BlockMarker.prototype['getAnchor'] = BlockMarker.prototype.getAnchor;

//Set
BlockMarker.prototype.setAnchor = function(anchor) {
  this.set('anchor', anchor);
};
BlockMarker.prototype['setAnchor'] = BlockMarker.prototype.setAnchor;

//Changed
BlockMarker.prototype.anchor_changed = function() {
  this.draw();
};
BlockMarker.prototype['anchor_changed'] = BlockMarker.prototype.anchor_changed;


/*REMOVE*/

BlockMarker.prototype.remove = function() {
	var data = 'mapno=' + this.mapno + '&blockno=' + this.blockno + '&lat=' + this.getPosition().lat() + '&lng=' + this.getPosition().lng();
	var that=this;
	$.ajax({
		url: '/marker-delete.php',
		type: 'POST',
		data: data,
		success: function(){that.setMap();},
		error: function(){alert('error');}	
	});
};
BlockMarker.prototype['remove'] = BlockMarker.prototype.remove;


/*SAVE*/

BlockMarker.prototype.save = function() {
	if (isNaN(mapno) || mapno=='' || mapno==null) {
		alert('A map number has not been set yet!');
		return;
	}
	var data = 'mapno=' + this.mapno + '&type=block' + '&blockno=' + this.blockno + '&lat=' + this.getPosition().lat() + '&lng=' + this.getPosition().lng();
	$.ajax({
		url: '/create-marker.php',
		type: 'POST',
		data: data,
		success: function(){},
		error: function(){alert('error');}	
	});
};
BlockMarker.prototype['save'] = BlockMarker.prototype.save;


/*UPDATE*/

BlockMarker.prototype.update = function() {
	if (isNaN(mapno) || mapno=='' || mapno==null) {
		alert('A map number has not been set yet!');
		return;
	}
	var data = 'mapno=' + this.mapno + '&type=block' + '&blockno=' + this.blockno + '&lat=' + this.getPosition().lat() + '&lng=' + this.getPosition().lng();
	$.ajax({
		url: '/marker-update.php',
		type: 'POST',
		data: data,
		success: function(){},
		error: function(){alert('error');}	
	});
};
BlockMarker.prototype['update'] = BlockMarker.prototype.update;
/**
 * Converts a HTML string to a document fragment.
 *
 * @param {string} htmlString The HTML string to convert.
 * @return {Node} A HTML document fragment.
 * @private
 */
BlockMarker.prototype.htmlToDocumentFragment_ = function(htmlString) {
  var tempDiv = document.createElement('DIV');
  tempDiv.innerHTML = htmlString;
  if (tempDiv.childNodes.length == 1) {
    return /** @type {!Node} */ (tempDiv.removeChild(tempDiv.firstChild));
  } else {
    var fragment = document.createDocumentFragment();
    while (tempDiv.firstChild) {
      fragment.appendChild(tempDiv.firstChild);
    }
    return fragment;
  }
};


/**
 * Removes all children from the node.
 *
 * @param {Node} node The node to remove all children from.
 * @private
 */
BlockMarker.prototype.removeChildren_ = function(node) {
  if (!node) {
    return;
  }

  var child;
  while (child = node.firstChild) {
    node.removeChild(child);
  }
};


/**
 * Sets the content of the marker.
 *
 * @param {string|Node} content The content to set.
 */
BlockMarker.prototype.setContent = function(content) {
  this.set('content', content);
};
BlockMarker.prototype['setContent'] = BlockMarker.prototype.setContent;


/**
 * Get the content of the marker.
 *
 * @return {string|Node} The marker content.
 */
BlockMarker.prototype.getContent = function() {
  return /** @type {Node|string} */ (this.get('content'));
};
BlockMarker.prototype['getContent'] = BlockMarker.prototype.getContent;


/**
 * Sets the marker content and adds loading events to images
 */
BlockMarker.prototype.content_changed = function() {
  if (!this.markerContent_) {
    // Marker content area doesnt exist.
    return;
  }

  this.removeChildren_(this.markerContent_);
  var content = this.getContent();
  if (content) {
    if (typeof content == 'string') {
      content = content.replace(/^\s*([\S\s]*)\b\s*$/, '$1');
      content = this.htmlToDocumentFragment_(content);
    }
    this.markerContent_.appendChild(content);

    var that = this;
    var images = this.markerContent_.getElementsByTagName('IMG');
    for (var i = 0, image; image = images[i]; i++) {
      // By default, a browser lets a image be dragged outside of the browser,
      // so by calling preventDefault we stop this behaviour and allow the image
      // to be dragged around the map and now out of the browser and onto the
      // desktop.
      google.maps.event.addDomListener(image, 'mousedown', function(e) {
        if (that.getDraggable()) {
          if (e.preventDefault) {
            e.preventDefault();
          }
          e.returnValue = false;
        }
      });

      // Because we don't know the size of an image till it loads, add a
      // listener to the image load so the marker can resize and reposition
      // itself to be the correct height.
      google.maps.event.addDomListener(image, 'load', function() {
        that.draw();
      });
    }

    google.maps.event.trigger(this, 'domready');
  }

  if (this.ready_) {
    this.draw();
  }
};
BlockMarker.prototype['content_changed'] = BlockMarker.prototype.content_changed;

/**
 * Sets the cursor.
 *
 * @param {string} whichCursor What cursor to show.
 * @private
 */
BlockMarker.prototype.setCursor_ = function(whichCursor) {
  if (!this.ready_) {
    return;
  }

  var cursor = '';
  if (navigator.userAgent.indexOf('Gecko/') !== -1) {
    // Moz has some nice cursors :)
    if (whichCursor == 'dragging') {
      cursor = '-moz-grabbing';
    }

    if (whichCursor == 'dragready') {
      cursor = '-moz-grab';
    }

    if (whichCursor == 'draggable') {
      cursor = 'pointer';
    }
  } else {
    if (whichCursor == 'dragging' || whichCursor == 'dragready') {
      cursor = 'move';
    }

    if (whichCursor == 'draggable') {
      cursor = 'pointer';
    }
  }

  if (this.markerWrapper_.style.cursor != cursor) {
    this.markerWrapper_.style.cursor = cursor;
  }
};

/**
 * Start dragging.
 *
 * @param {Event} e The event.
 */
BlockMarker.prototype.startDrag = function(e) {
  if (!this.getDraggable()) {
    return;
  }

  if (!this.dragging_) {
    this.dragging_ = true;
    var map = this.getMap();
    this.mapDraggable_ = map.get('draggable');
    map.set('draggable', false);

    // Store the current mouse position
    this.mouseX_ = e.clientX;
    this.mouseY_ = e.clientY;

    this.setCursor_('dragready');

    // Stop the text from being selectable while being dragged
    this.markerWrapper_.style['MozUserSelect'] = 'none';
    this.markerWrapper_.style['KhtmlUserSelect'] = 'none';
    this.markerWrapper_.style['WebkitUserSelect'] = 'none';

    this.markerWrapper_['unselectable'] = 'on';
    this.markerWrapper_['onselectstart'] = function() {
      return false;
    };

    this.addDraggingListeners_();

    google.maps.event.trigger(this, 'dragstart');
  }
};


/**
 * Stop dragging.
 */
BlockMarker.prototype.stopDrag = function() {
  if (!this.getDraggable()) {
    return;
  }

  if (this.dragging_) {
    this.dragging_ = false;
    this.getMap().set('draggable', this.mapDraggable_);
    this.mouseX_ = this.mouseY_ = this.mapDraggable_ = null;

    // Allow the text to be selectable again
    this.markerWrapper_.style['MozUserSelect'] = '';
    this.markerWrapper_.style['KhtmlUserSelect'] = '';
    this.markerWrapper_.style['WebkitUserSelect'] = '';
    this.markerWrapper_['unselectable'] = 'off';
    this.markerWrapper_['onselectstart'] = function() {};

    this.removeDraggingListeners_();

    this.setCursor_('draggable');
    google.maps.event.trigger(this, 'dragend');

    this.draw();
  }
};


/**
 * Handles the drag event.
 *
 * @param {Event} e The event.
 */
BlockMarker.prototype.drag = function(e) {
  if (!this.getDraggable() || !this.dragging_) {
    // This object isn't draggable or we have stopped dragging
    this.stopDrag();
    return;
  }

  var dx = this.mouseX_ - e.clientX;
  var dy = this.mouseY_ - e.clientY;

  this.mouseX_ = e.clientX;
  this.mouseY_ = e.clientY;

  var left = parseInt(this.markerWrapper_.style['left'], 10) - dx;
  var top = parseInt(this.markerWrapper_.style['top'], 10) - dy;

  this.markerWrapper_.style['left'] = left + 'px';
  this.markerWrapper_.style['top'] = top + 'px';

  var offset = this.getOffset_();

  // Set the position property and adjust for the anchor offset
  var point = new google.maps.Point(left - offset.width, top - offset.height);
  var projection = this.getProjection();
  this.setPosition(projection.fromDivPixelToLatLng(point));

  this.setCursor_('dragging');
  google.maps.event.trigger(this, 'drag');
};


/**
 * Removes the drag listeners associated with the marker.
 *
 * @private
 */
BlockMarker.prototype.removeDragListeners_ = function() {
  if (this.draggableListener_) {
    google.maps.event.removeListener(this.draggableListener_);
    delete this.draggableListener_;
  }
  this.setCursor_('');
};


/**
 * Add dragability events to the marker.
 *
 * @param {Node} node The node to apply dragging to.
 * @private
 */
BlockMarker.prototype.addDragging_ = function(node) {
  if (!node) {
    return;
  }

  var that = this;
  this.draggableListener_ =
    google.maps.event.addDomListener(node, 'mousedown', function(e) {
      that.startDrag(e);
    });

  this.setCursor_('draggable');
};


/**
 * Add dragging listeners.
 *
 * @private
 */
BlockMarker.prototype.addDraggingListeners_ = function() {
  var that = this;
  if (this.markerWrapper_.setCapture) {
    this.markerWrapper_.setCapture(true);
    this.draggingListeners_ = [
      google.maps.event.addDomListener(this.markerWrapper_, 'mousemove', function(e) {
        that.drag(e);
      }, true),
      google.maps.event.addDomListener(this.markerWrapper_, 'mouseup', function() {
        that.stopDrag();
        that.markerWrapper_.releaseCapture();
      }, true)
    ];
  } else {
    this.draggingListeners_ = [
      google.maps.event.addDomListener(window, 'mousemove', function(e) {
        that.drag(e);
      }, true),
      google.maps.event.addDomListener(window, 'mouseup', function() {
        that.stopDrag();
      }, true)
    ];
  }
};


/**
 * Remove dragging listeners.
 *
 * @private
 */
BlockMarker.prototype.removeDraggingListeners_ = function() {
  if (this.draggingListeners_) {
    for (var i = 0, listener; listener = this.draggingListeners_[i]; i++) {
      google.maps.event.removeListener(listener);
    }
    this.draggingListeners_.length = 0;
  }
};


/**
 * Get the anchor offset.
 *
 * @return {google.maps.Size} The size offset.
 * @private
 */
BlockMarker.prototype.getOffset_ = function() {
  var anchor = this.getAnchor();
  if (typeof anchor == 'object') {
    return /** @type {google.maps.Size} */ (anchor);
  }

  var offset = new google.maps.Size(0, 0);
  if (!this.markerContent_) {
    return offset;
  }

  var width = this.markerContent_.offsetWidth;
  var height = this.markerContent_.offsetHeight;

  switch (anchor) {
   case BlockMarkerPosition['TOP_LEFT']:
     break;
   case BlockMarkerPosition['TOP']:
     offset.width = -width / 2;
     break;
   case BlockMarkerPosition['TOP_RIGHT']:
     offset.width = -width;
     break;
   case BlockMarkerPosition['LEFT']:
     offset.height = -height / 2;
     break;
   case BlockMarkerPosition['MIDDLE']:
     offset.width = -width / 2;
     offset.height = -height / 2;
     break;
   case BlockMarkerPosition['RIGHT']:
     offset.width = -width;
     offset.height = -height / 2;
     break;
   case BlockMarkerPosition['BOTTOM_LEFT']:
     offset.height = -height;
     break;
   case BlockMarkerPosition['BOTTOM']:
     offset.width = -width / 2;
     offset.height = -height;
     break;
   case BlockMarkerPosition['BOTTOM_RIGHT']:
     offset.width = -width;
     offset.height = -height;
     break;
  }

  return offset;
};


/**
 * Adding the marker to a map.
 * Implementing the interface.
 */
BlockMarker.prototype.onAdd = function() {
  if (!this.markerWrapper_) {
    this.markerWrapper_ = document.createElement('DIV');
    this.markerWrapper_.style['position'] = 'absolute';
  }

  if (this.getZIndex()) {
    this.markerWrapper_.style['zIndex'] = this.getZIndex();
  }

  this.markerWrapper_.style['display'] = this.getVisible() ? '' : 'none';

  if (!this.markerContent_) {
    this.markerContent_ = document.createElement('DIV');
	this.markerContent_.className = 'blockno';
    this.markerWrapper_.appendChild(this.markerContent_);
	var that = this;
	if (this.editable){
		this.mydeletebutton = document.createElement('DIV');
		this.mydeletebutton.innerHTML = '<img src="/icon/silk/cancel.png" class="delete_button" />';
		this.mydeletebutton.style['position'] = 'absolute';
		google.maps.event.addDomListener(this.mydeletebutton, 'click', function(e) {
			that.remove();
		});
	}

    google.maps.event.addDomListener(this.markerContent_, 'click', function(e) {
      google.maps.event.trigger(that, 'click');
    });
    google.maps.event.addDomListener(this.markerContent_, 'mouseover', function(e) {
      google.maps.event.trigger(that, 'mouseover');
    });
    google.maps.event.addDomListener(this.markerContent_, 'mouseout', function(e) {
      google.maps.event.trigger(that, 'mouseout');
    });
	google.maps.event.addListener(this.map, 'zoom_changed', function() {
	  that.zoom_changed();
	});
	google.maps.event.addListener(this, 'dragend', function() {
	  that.update();
	});

  }

  this.ready_ = true;
  this.content_changed();
  this.flat_changed();
  this.draggable_changed();
  this.zoom_changed();
  var panes = this.getPanes();
  if (panes) {  
  	panes.overlayLayer.appendChild(this.markerWrapper_);
	if (this.mydeletebutton){
		panes.overlayLayer.appendChild(this.mydeletebutton);
	}
  }

  google.maps.event.trigger(this, 'ready');
};
BlockMarker.prototype['onAdd'] = BlockMarker.prototype.onAdd;


/**
 * Impelementing the interface.
 */
BlockMarker.prototype.draw = function() {
  if (!this.ready_ || this.dragging_) {
    return;
  }

  var projection = this.getProjection();

  if (!projection) {
    // The map projection is not ready yet so do nothing
    return;
  }

  var latLng = /** @type {google.maps.LatLng} */ (this.get('position'));
  var pos = projection.fromLatLngToDivPixel(latLng);

  var offset = this.getOffset_();
  this.markerWrapper_.style['top'] = (pos.y + offset.height) + 'px';
  this.markerWrapper_.style['left'] = (pos.x + offset.width) + 'px';
  if (this.mydeletebutton){
	  this.mydeletebutton.style['top'] = (pos.y + offset.height - 15) + 'px';
	  this.mydeletebutton.style['left'] = (pos.x + offset.width - 15) + 'px';
  }

  var height = this.markerContent_.offsetHeight;
  var width = this.markerContent_.offsetWidth;

  if (width != this.get('width')) {
    this.set('width', width);
  }

  if (height != this.get('height')) {
    this.set('height', height);
  }
};
BlockMarker.prototype['draw'] = BlockMarker.prototype.draw;


/**
 * Removing a marker from the map.
 * Implementing the interface.
 */
BlockMarker.prototype.onRemove = function() {
  if (this.markerWrapper_ && this.markerWrapper_.parentNode) {
    this.markerWrapper_.parentNode.removeChild(this.markerWrapper_);
  }
  if (this.mydeletebutton && this.mydeletebutton.parentNode) {
  	this.mydeletebutton.parentNode.removeChild(this.mydeletebutton);
  }
  this.removeDragListeners_();
};
BlockMarker.prototype['onRemove'] = BlockMarker.prototype.onRemove;


/**
 * BlockMarker Anchor positions
 * @enum {number}
 */
var BlockMarkerPosition = {
  'TOP_LEFT': 1,
  'TOP': 2,
  'TOP_RIGHT': 3,
  'LEFT': 4,
  'MIDDLE': 5,
  'RIGHT': 6,
  'BOTTOM_LEFT': 7,
  'BOTTOM': 8,
  'BOTTOM_RIGHT': 9
};
window['BlockMarkerPosition'] = BlockMarkerPosition;
