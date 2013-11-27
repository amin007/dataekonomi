<?php

class Prosesan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function senaraiKes($myTable, $medan)
	{
		return $this->db->select('SELECT ' . $medan . ' FROM ' . $myTable);
		//echo '<br>SELECT ' . $medan . ' FROM ' . $sv . $myTable;
		//echo $result; 
		//echo json_encode($result);
	}

	public function hadKes($myTable, $medan, $tahun, $jum)
	{
		$caritahun = ( !isset($tahun) ) ? '' : ' WHERE tahun_rujukan = "' . $tahun . '"';
		//$jum['dari'] . ', ' . $jum['max']
		$result = $this->db->select(
		'SELECT ' . $medan . ' FROM ' . $myTable . ' j1' . 
		$caritahun . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max']);
		//echo '<br>SELECT ' . $medan . ' FROM ' . $myTable . ' j1' . 
		//$carife . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
		//echo $result;
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSelesai($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' and fe = "' . $fe . '"';
		$result = $this->db->select('SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . ' WHERE terima is not null ' .	$carife .
		' LIMIT ' . $jum['dari'] . ', ' . $jum['max']);
		//echo $result;
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariSemuaMedan($myTable, $medan, $cari)
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

	public function cariProsesan($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE ' . $cariMedan . ' like "' . $cariID . '%" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function xhrInsert() 
	{
		$text = $_POST['text'];
		$this->db->insert('data', array('text' => $text));
		$data = array('text' => $text, 'id' => $this->db->lastInsertId());
		echo json_encode($data);
	}
	
	public function xhrGetListings()
	{
		$result = $this->db->select("SELECT * FROM data");
		//echo $result;
		echo json_encode($result);
	}
	
	public function xhrDeleteListing()
	{
		$id = (int) $_POST['id'];
		$this->db->delete('data', "id = '$id'");
	}

}