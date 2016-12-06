<?php

class Tanya
{
##################################################################################################
##------------------------------------------------------------------------------------
	function __construct()
	{
		//$this->db = new PangkalanData(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$this->db = new DB_Mysqli(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		//$this->crud = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	}
##------------------------------------------------------------------------------------
	function ubahMedan($myTable, $medan)
	{
	/*
	ALTER [IGNORE] TABLE tbl_name
	MODIFY [COLUMN] col_name column_definition
	[FIRST | AFTER col_name]
	*/
	
		$sql = 'ALTER TABLE `' . $myTable . '` '
			 . 'CHANGE `' . $medan['asal'] . '` '
			 . '`' . $medan['baru'] . '` ' . $medan['jenis'] . ' '
			 . 'AFTER `' . $medan['selepas'] . '` ';

		echo '<pre>$sql->' . htmlentities($sql) . '</pre><br>';
		
	}
##------------------------------------------------------------------------------------
##################################################################################################
}