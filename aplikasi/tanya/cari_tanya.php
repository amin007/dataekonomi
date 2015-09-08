<?php

class Cari_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function paparMedan($myTable)
	{
		return $this->db->selectAll('SHOW COLUMNS FROM ' . $myTable);
	}
	
	public function paparSemuaJadual($myTable, $medan)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSql($myTable, $medan, $kira, $had)
	{
		$sql ="\rSELECT $medan FROM $myTable WHERE \r";
		
		foreach ($_POST['pilih'] as $key=>$cari)
		{
			$apa = $_POST['cari'][$key];
			$f = isset($_POST['fix'][$key]) ? $_POST['fix'][$key] : null;
			$atau = isset($_POST['atau'][$key]) ? $_POST['atau'][$key] : null;
			
			//$sql.="\r$key => $f  | ";

			if ($apa==null) 
				$sql .= "$atau $cari is null\r";
			elseif ($myTable=='msic2008') 
			{
				if ($cari=='msic') $sql.=($f=='x') ?
				"$atau ($cari='$apa' or msic2000='$apa')\r" :
				"$atau ($cari like '%$apa%' or msic2000 like '%$apa%')\r";
				else $sql.=($f=='x') ?
				"$atau ($cari='$apa' or notakaki='$apa')\r" :
				"$atau ($cari like '%$apa%' or notakaki like '%$apa%')\r";
			}
			elseif ($myTable=='kodproduk_aup') 
			{
				$pilih = 'substring(kod_produk,1,5)';
				if ($cari=='msic') $sql.=($f=='x') ?
				"$atau ($pilih='$apa' or kod_produk='$apa')\r" :
				"$atau ($pilih like '%$apa%' or kod_produk like '%$apa%')\r";
				else $sql.=($f=='x') ? "$atau `$cari`='$apa'\r" : 
				"$atau `$cari` like '%$apa%'\r";					
			}
			else 
				$sql.=($f=='x') ? "$atau `$cari`='$apa'\r" : 
				"$atau `$cari` like '%$apa%'\r";					
		}
		
		$sql.="LIMIT $had "; echo $sql . '<br>';
		return $this->db->selectAll($sql);
	
	}
	
	public function cariBanyakMedan($myTable, $medan, $kira, $had)
	{
		$sql ="\rSELECT $medan FROM $myTable WHERE \r";
		
		foreach ($_POST['pilih'] as $key=>$cari)
		{
			$apa = $_POST['cari'][$key];
			$f = isset($_POST['fix'][$key]) ? $_POST['fix'][$key] : null;
			$atau = isset($_POST['atau'][$key]) ? $_POST['atau'][$key] : null;
			
			//$sql.="\r$key => $f  | ";

			if ($apa==null) 
				$sql .= "$atau $cari is null\r";
			elseif ($myTable=='msic2008') 
			{
				if ($cari=='msic') $sql.=($f=='x') ?
				"$atau ($cari='$apa' or msic2000='$apa')\r" :
				"$atau ($cari like '%$apa%' or msic2000 like '%$apa%')\r";
				else $sql.=($f=='x') ?
				"$atau ($cari='$apa' or notakaki='$apa')\r" :
				"$atau ($cari like '%$apa%' or notakaki like '%$apa%')\r";
			}
			elseif ($myTable=='kodproduk_aup') 
			{
				$pilih = 'substring(kod_produk,1,5)';
				if ($cari=='msic') $sql.=($f=='x') ?
				"$atau ($pilih='$apa' or kod_produk='$apa')\r" :
				"$atau ($pilih like '%$apa%' or kod_produk like '%$apa%')\r";
				else $sql.=($f=='x') ? "$atau `$cari`='$apa'\r" : 
				"$atau `$cari` like '%$apa%'\r";					
			}
			else 
				$sql.=($f=='x') ? "$atau `$cari`='$apa'\r" : 
				"$atau `$cari` like '%$apa%'\r";					
		}
		
		$sql.="LIMIT $had "; //echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}
	
	public function cariMedanSahaja($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable .
			' WHERE ' . $cariMedan . ' = "%' . $cariID . '%" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSatuSahaja($myTable, $medan, $cari)
	{
	
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}

}