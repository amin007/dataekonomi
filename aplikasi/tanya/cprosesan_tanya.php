<?php

class Cprosesan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function cariKes($myTable, $cari)
	{
		$medan = ($myTable=='sse10_kawal') ? 'sidap,newss,nama' : 'sidap,nama'; 
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan LIKE '%$cariID%' ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariEstab($myTable, $medan, $cari)
	{
		$sv = ( !isset($cari['sv']) ) ? '' : $cari['sv'];
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		
		$sql = "SELECT $medan FROM `$myTable` "
			 . "WHERE $cariMedan like '$cariID%' ";
		$sql .= ($sv=='205') ? 
			"AND thn BETWEEN $thnMula and $thnAkhir " : '';
		
		//echo '<hr><pre>cariEstab()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariProdukLama($myTable, $medan, $cari)
	{
		$sv = ( !isset($cari['sv']) ) ? '' : $cari['sv'];
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		
		$sql = "SELECT $medan FROM `$myTable` "
			 . "WHERE $cariMedan like '$cariID%' ";
		$sql .= ($sv=='205') ? 
			"AND thn BETWEEN $thnMula and $thnAkhir " : '';
		
		//echo '<hr><pre>cariProdukLama()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariProdukBaru($myTable, $sql)
	{
		//echo '<hr><pre>cariProduk()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariAset($myTable, $sql)
	{
		//echo '<hr><pre>cariProduk()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function keterangan_medan($myTable, $cari)
	{
		$cariMedan = ( !isset($cari[0]['medan']) ) ? '' : $cari[0]['medan'];
		$cariID = ( !isset($cari[0]['id']) ) ? '' : $cari[0]['id'];
		$cariMedan2 = ( !isset($cari[1]['medan']) ) ? '' : $cari[1]['medan'];
		$cariID2 = ( !isset($cari[1]['id']) ) ? '' : $cari[1]['id'];
		
		$sql = "SELECT * FROM `$myTable` "
			 . "WHERE $cariMedan like '$cariID' " 
			 . "AND $cariMedan2 like '$cariID2' ";
		
		//echo '<hr><pre>keterangan_medan()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->select($sql,2);
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