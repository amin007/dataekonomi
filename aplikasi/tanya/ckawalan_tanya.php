<?php

class Ckawalan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function cariKes($myTable, $cari)
	{
		$medan = ($myTable=='sse10_kawal' || $myTable=='alamat_newss_2013') ? 
			'sidap,newss,nama,operator' : 'sidap,nama,operator'; 
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan LIKE '%$cariID%' ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariSidap($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan like '$cariID%' ";
		
		//echo '<hr><pre>cariSatuSahaja()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariSatuSahaja($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan = '$cariID' ";
		
		//echo '<hr><pre>cariSatuSahaja()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

}