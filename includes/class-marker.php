<?php
/**
 * @ File: class-marker.php
 * @ Created: 24-05-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Marker class
 */
 
if (!class_exists('db')){
	require_once(INCLUDES . '\class-db.php');
}

class marker {
	var $database;
	var $mapno;
	var $type;
	var $lat;
	var $lng;
	var $blockno;
	var $subpremise;
	var $streetno;
	var $street;
	var $suburb;
	var $state;	
	var $postcode;
	
	// Contructor
	function __construct($mapno,$type,$lat,$lng,$blockno,$subpremise,$streetno,$street,$suburb,$state,$postcode,$editable=FALSE){
		$this->mapno = $mapno;
		$this->type = $type;
		$this->lat = $lat;
		$this->lng = $lng;
		$this->blockno = $blockno;
		$this->subpremise = $subpremise;
		$this->streetno = $streetno;
		$this->street = $street;
		$this->suburb = $suburb;
		$this->state = $state;
		$this->postcode = $postcode;
		$this->editable = $editable;
		$this->fulladdress = $this->subpremise . ($this->subpremise ? '/' : '')
						   . $this->streetno . " "
						   . $this->street;
						   //. $this->suburb . " "
						   //. $this->state . " "
						   //. $this->postcode;
						   
		$this->shortaddress = $this->subpremise . ($this->subpremise ? '/' : '')	
							. $this->streetno;
	}	

	function getMapno(){
		return $this->mapno;
	}
	
	function getBlockno(){
		return $this->blockno;
	}

	function getFullAddress(){
		return $this->fulladdress;
	}

	function getShortAddress(){
		return $this->shortaddress;
	}
	
	function getBlockMarkup(){ // dont use single quotes or escape them in the html you return from this as it is used in javascript code
		if (!$this->blockno || $this->blockno==''){
			return 'nothing';
		} else {
			if ($this->editable==TRUE){
				return 'Block&nbsp;'.$this->blockno;
			} else {
				return 'Block&nbsp;'.$this->blockno;
			}
		}			
	}
	
	function getLat(){
		return $this->lat;
	}
	
	function getLng(){
		return $this->lng;
	}	
	
	function getEditable(){
		return ($this->editable ? "true" : "false");
	}
	
	// Destruct function
	function __destruct() {
		return TRUE;
	}
}