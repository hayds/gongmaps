<?php
/**
 * @ File: class-map.php
 * @ Created: 22-05-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Map class
 */
 
if (!class_exists('db')){
	require_once(INCLUDES . '/class-db.php');
}
if (!class_exists('marker')){
	require_once(INCLUDES . '/class-marker.php');
}

class map {
	var $database;
	var $mapno;
	var $path;
	var $editable;
	
	// Contructor
	function __construct($options){
		$this->database = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
		$this->mapno = $options['mapno'];
		$this->editable = $options['editable'];
		$this->loadMap($this->mapno);		
	}	

	private function loadMap($mapno){
		$sql = "SELECT * FROM maps WHERE mapno=".$mapno." LIMIT 1;";
		if ($map = $this->database->get_result($sql)){
			$this->mapno = $map['mapno'];
			$this->path = $map['path'];
		} else {
			error('That map does not exist!');
		}
	}

	function getMapno(){
		return $this->mapno;
	}

	function genPolygonJS(){
		echo "	var polygon = new mapPolygon({\n"
		   . "		map: myMap,\n"
		   . "		paths: google.maps.geometry.encoding.decodePath(\"".$this->path."\"),\n"
		   . "		strokeColor: \"blue\",\n"
		   . "		strokeOpacity: 0.5,\n"
		   . "		strokeWeight: 2,\n"
		   . "		fillColor: \"blue\",\n"
		   . "		fillOpacity: 0.15\n"
		   . "	});\n";
	}

	// returns an array of block marker objects
	function getBlockMarkers(){
		$blockmarkers = array();
		$sql = "SELECT * FROM markers "
			 . "WHERE mapno=".$this->mapno." "
			 . "AND type='block' "
			 . "ORDER BY blockno;";
		if ($results = $this->database->get_results($sql)){
			foreach ( $results as $key => $val){
				$blockmarkers[] = new marker(
					$val['mapno'],
					$val['type'],
					$val['lat'],
					$val['lng'],
					$val['blockno'],
					$val['subpremise'],
					$val['streetno'],
					$val['street'],
					$val['suburb'],
					$val['state'],
					$val['postcode'],
					$this->editable
				 );
			}
		}
		return $blockmarkers;			
	}
	
	// returns an array of marker objects
	function getDNCMarkers(){
		$dncmarkers = array();
		$sql = "SELECT * FROM markers "
			 . "WHERE mapno=".$this->mapno." "
			 . "AND type='dnc' "
			 . "ORDER BY street, streetno, subpremise;";
		if ($results = $this->database->get_results($sql)){
			foreach ( $results as $key => $val){
				$dncmarkers[] = new marker(
					$val['mapno'],
					$val['type'],
					$val['lat'],
					$val['lng'],
					$val['blockno'],
					$val['subpremise'],
					$val['streetno'],
					$val['street'],
					$val['suburb'],
					$val['state'],
					$val['postcode'],					
					$this->editable
				 );
			}
		}
		return $dncmarkers;			
	}

	function genDNCList(){
		$dncmarkers = $this->getDNCMarkers();
		foreach ($dncmarkers as $dncmarker){
			echo "	<li><a href=\"#\" data-icon=\"delete\" data-role=\"button\" data-inline=\"true\" data-mini=\"true\" data-iconpos=\"notext\"></a>" . $dncmarker->getFullAddress() . "</li>\n";
		}
	}
	
	function genDNCMarkersJS(){
		$dncmarkers = $this->getDNCMarkers();
		foreach ($dncmarkers as $dncmarker){	
			echo "var position=new google.maps.LatLng(".$dncmarker->getLat().",".$dncmarker->getLng().");\n"
			   . "var dncmarker = new DNCMarker({\n"
			   . "	icon: dnc_marker_image(),\n"
			   . "	shadow: dnc_marker_shadow(),\n"
			   . "	shape: dnc_marker_shape(),\n"			   
			   . "	position: position,\n"
			   . "	map: myMap,\n"
			   . "	subpremise:'$dncmarker->subpremise',\n"
			   . "	streetno:'$dncmarker->streetno',\n"
			   . "	street:'$dncmarker->street',\n"
			   . "	suburb:'$dncmarker->suburb',\n"
			   . "	state:'$dncmarker->state',\n"			   
			   . "	postcode:'$dncmarker->postcode',\n"
			   . "	labelClass: 'markerwithlabel',\n"
			   . "});\n"
			   . "(function(){\n"
			   . "	var infoWindowOptions = {content: '".$dncmarker->getFullAddress()."'};\n"
			   . "	var infoWindow = new google.maps.InfoWindow(infoWindowOptions);\n"
			   . "	google.maps.event.addListener(dncmarker, 'click', function() {\n"
			   . "		infoWindow.open(myMap,this);\n"
			   . "	});\n"
			   . "})();";
		}
	}
	
	function genDNCMarkersOLD(){
		$dncmarkers = $this->getDNCMarkers();
		foreach ($dncmarkers as $dncmarker){	
			echo "var position=new google.maps.LatLng(".$dncmarker->getLat().",".$dncmarker->getLng().");\n"
			   . "var dncmarker = createDNCMarker(position);"
			   . "var infoWindowOptions = {content: '".$dncmarker->getFullAddress()."'};\n"
			   . "var infoWindow = new google.maps.InfoWindow(infoWindowOptions);\n"
			   . "google.maps.event.addListener(dncmarker, 'click', function() {\n"
			   . "	infoWindow.open(myMap,dncmarker);\n"
			   . "});\n";	   
		}
	}
	
	function genBlockMarkersJS(){
		$blockmarkers = $this->getBlockMarkers();
		foreach ($blockmarkers as $blockmarker){	
			echo "var position=new google.maps.LatLng(".$blockmarker->getLat().",".$blockmarker->getLng().");\n"
			   . "var blockmarker = new BlockMarker({\n"
			   . "	position: position,\n"
			   . "	map: myMap,\n"
			   . "	mapno: '".$this->mapno."',\n"
			   . "	anchor: 5,\n"
			   . "	blockno: '".$blockmarker->getBlockno()."',\n"
			   . "	shadow: false,\n"
			   . "	draggable: ".($this->editable ? "true" : "false").",\n"
			   . "	content: '".$blockmarker->getBlockMarkup()."',\n"
			   . "	editable: ".$blockmarker->getEditable()."\n"
			   . "});\n"
			   . "blockmarker.setMap(myMap);\n"
			   . "google.maps.event.addListener(blockmarker, 'dragend', function() {\n"
			   . "	this.update();\n"
			   . "});\n";
		}
	}

	// Destruct function
	function __destruct() {
		return TRUE;
	}
}