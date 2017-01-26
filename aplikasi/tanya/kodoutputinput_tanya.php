<?php

class Kodoutputinput_Tanya extends Tanya 
{
#----------------------------------------------------------------------------------------------------------------------------#
	public function __construct() 
	{
		parent::__construct();
	}

	public function pulangPembolehubah($semak, $myTable, $sv, $cariID, $mula, $akhir)
	{
		$medan = '*'; $susun = null;
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>$this->medanID($myTable, $semak),'apa'=>$cariID);

		if($mula != null && $akhir != null)
			$carian[] = array('fix'=>'zbetween','atau'=>'AND','medan'=>'thn','apa'=>"$mula AND $akhir");

		return array($medan, $susun, $carian); # pulangkan nilai
	}

	public function medanID($myTable, $semak)
	{
		$newssTable = array('sse10_kawal','alamat_newss_2013');
		if($semak == 'K')
			$namaMedan = (in_array($myTable,$newssTable))  ? 
				'newss' : 'sidap'; 
		else
			$namaMedan = 'estab';

		return $namaMedan; # pulangkan nilai
	}

	public function paparSQL($semak, $myTable, $sv, $cariID, $mula = null, $akhir = null)
	{
		//echo "<hr>\$semak $semak, \$myTable $myTable, \$sv $sv, \$cariID $cariID, \$mula $mula, \$akhir $akhir|<br>";
		list($medan, $susun, $carian) = $this->pulangPembolehubah($semak, $myTable, $sv, $cariID, $mula, $akhir);
		
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';

		echo htmlentities($sql) . '<br>';
	}

	public function cariData($semak, $myTable, $sv, $cariID, $mula = null, $akhir = null)
	{
		//echo "<hr>\$semak $semak, \$myTable $myTable, \$sv $sv, \$cariID $cariID, \$mula $mula, \$akhir $akhir|<br>";
		list($medan, $susun, $carian) = $this->pulangPembolehubah($semak, $myTable, $sv, $cariID, $mula, $akhir);
		
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun)
			 . '';

		//echo htmlentities($sql) . '<br>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';

		return $data;
	}

	public function cariDalamSQL($sql)
	{
		//echo '<hr>$sql<pre>' . htmlentities($sql) . '</pre><br>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';

		return $data;
	}

#----------------------------------------------------------------------------------------------------------------------------#
}