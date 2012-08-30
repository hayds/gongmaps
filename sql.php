<?php
require_once('config.php');



		$sql = "SELECT * FROM markers "
			 . "WHERE mapno=1 "
			 . "AND type='dnc' "
			 . "ORDER BY street, 0+streetno, subpremise;";
		$results = $DB->get_results($sql);
		print_r($results);