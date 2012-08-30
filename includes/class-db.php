<?php
/**
 * @ File: db.php
 * @ Created: 29-03-2012
 * @ Creator: Hadyn Dickson
 * @ Description: Database class
 * @ Use: Gives access to the database and manages security for SQL transactions
 */
 
class db {
	var $rows = 0;
	var $error = false;
	var $errorstring = '';
	
	// Contructor
	function __construct( $dbuser, $dbpassword, $dbname, $dbhost ) {	
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		$this->dbhost = $dbhost;
		$this->db_connect();		
	}
	
	// Set an error
	private function set_error($errorstring){
		$this->error=true;
		$this->errorstring=$errorstring;
	}
	
	// Clears error status
	private function clear_error(){
		$this->error=false;
		$this->errorstring='';
	}
	
	function get_error(){
		if ($this->error){
			return $this->errorstring;
		}
	}
		
	// Connect to MYSQL
	function db_connect() {		
		$this->dbh = mysql_connect( $this->dbhost, $this->dbuser, $this->dbpassword, true );	
		$this->clear_error();
		if (!$this->dbh) {			
			$this->set_error('Could not connect to database: ' . mysql_error());
			return false;
		} else {
			$this->select_db( $this->dbname, $this->dbh );
			return true;
		}
		
	}
	
	// Select a database from MYSQL
	function select_db( $dbname, $dbh ) {
		$this->clear_error();
		if (!mysql_select_db( $dbname, $dbh )) {
			$this->set_error('Could not select database: ' . mysql_error());
			return false;
		} else {			
			return true;
		}
	}
	
	// Perform query and store results in the result var, returns amount of rows affected
	function query( $sql ) {
			$this->clear_error();
		if (!$this->result = mysql_query( $sql )) {
			$this->set_error(mysql_error() . ' ' . $sql);
			return false;
		} else {	
			$this->rows = mysql_affected_rows();
			return $this->rows;
		}
	}
	
	// return just one row of a query NB prob should just delete this as i cant see a purppose for it, might as well use the below function
	function get_result( $sql ) {
		$this->clear_error();		
		if (!$this->query( $sql )){
			$this->set_error(mysql_error() . ' ' . $sql);
			return false;
		} else {
			return mysql_fetch_assoc($this->result);	
		}
	}
	
	// return an assoc array of the results
	function get_results( $sql ) {
		$this->clear_error();
		if (!$this->query( $sql )){
			$this->set_error(mysql_error() . ' ' . $sql);
			return false;
		} else {
			$result = array();			
			while($row = mysql_fetch_assoc($this->result))
			{
				$result[] = $row;
			}
			return $result;
		}
	}

	// return amount of rows affected by last query
	function get_num_rows() {
		return $this->rows;
	}

	// Destruct function
	function __destruct() {
		return TRUE;
	}
}