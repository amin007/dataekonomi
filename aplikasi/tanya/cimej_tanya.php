<?php

class Cimej_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function senaraiKes($myTable)
	{
		return $this->db->selectAll('SELECT sidap,newss,nama FROM ' . $myTable);
		//echo $result;
		//echo json_encode($result);
	}
	
	public function cariMedan($myTable, $medan, $cariMedan, $cariID)
	{
		return //$result =
		$this->db->selectAll('SELECT ' . $medan . ' FROM ' . $myTable .
		' WHERE ' . $cariMedan . ' like "%' . $cariID . '%" ');
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		//echo $result;
		//echo json_encode($result);
	}
	
	public function cariSemuaMedan($myTable, $medan, $cariMedan, $cariID)
	{
		return //$result =
		$this->db->selectAll('SELECT ' . $medan . ' FROM ' . $myTable .
		' WHERE ' . $cariMedan . ' like "%' . $cariID . '%" ');
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		//echo $result;
		//echo json_encode($result);
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