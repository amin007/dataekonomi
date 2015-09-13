<?php

class Semakan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
		$this->_susun = ' ORDER BY nama';
	}
	
	public function cariKawal($myTable, $cari)
	{
		$medan = '*';
		$cariMedan = ($myTable=='sse10_kawal' || $myTable=='alamat_newss_2013') ? 
			'newss' : 'sidap'; 
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan LIKE '%$cariID%' ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariEstab($myTable, $cari)
	{
		$sv = ( !isset($cari['sv']) ) ? '' : $cari['sv'];
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		
		$sql = "SELECT * FROM `$myTable` "
			 . "WHERE $cariMedan like '$cariID%' ";
		$sql .= ($sv=='205') ? 
			"AND thn BETWEEN $thnMula and $thnAkhir " : '';
		
		//echo '<hr><pre>cariEstab()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariProdukBaru($myTable, $sql)
	{
		//echo '<hr><pre>cariProdukbaru()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>cariProdukbaru()$data='; print_r($data) . '</pre>';
		
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
##########################################################################################
## fungsi standard setiap class *_Tanya
	public function paparMedan($myTable, $papar = null)
	{
		$cari = ( !isset($papar) ) ? '' : ' WHERE  ' . $papar . ' ';
		//return $this->db->select('SHOW COLUMNS FROM ' . $myTable);
		$sql = 'SHOW COLUMNS FROM ' . $myTable . $cari;
		
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}
	
	public function cariSemuaMedan($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
		
	public function ubahSimpan($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		$senarai = null;
		$medanID = 'newss';
		
		foreach ($data as $medan => $nilai)
		{
			if ($medan == $medanID)
				$cariID = $medan;
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$cariID` = '{$data[$cariID]}' ";
		
		# set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//$this->db->update($sql);
	}

	public function tambahSimpan($data, $myTable)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';
		//$fieldNames = implode('`, `', array_keys($data));
		//$fieldValues = ':' . implode(', :', array_keys($data));

		$senarai = null;
		
		foreach ($data as $medan => $nilai)
		{
			$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		
		# set sql
		$sql = " INSERT `$myTable` SET \r$senaraiData";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->insert($sql);
	}
	
	public function cantumsql($sql) 
	{
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
# end - class Semakan_Tanya
#######################################################################
}