<?php

class Anggaran_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
		$this->_susun = ' ORDER BY nama';
	}
	
	public function paparjadual($myTable, $medan)
	{
		$sql = "SELECT $medan FROM $myTable ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}
	
	public function cariKawal($myTable, $cari)
	{
		$medan = '*';
		$cariMedan = ($myTable=='sse10_kawal' || $myTable=='alamat_newss_2013') ? 
			'newss' : 'sidap'; 
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT * FROM $myTable "
			 . "WHERE $cariMedan LIKE '%$cariID%' ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariEstab($myTable, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = "SELECT * FROM `$myTable` "
			 . "WHERE $cariMedan like '$cariID%' ";
		
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
		
		//echo '<hr><pre>cariEstab()=>$sql='; print_r($sql) . '</pre>';
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

	public function paparMedan($myTable, $papar = null)
	{
		$cari = ( !isset($papar) ) ? '' : ' WHERE  ' . $papar . ' ';
		//return $this->db->select('SHOW COLUMNS FROM ' . $myTable);
		$sql = 'SHOW COLUMNS FROM ' . $myTable . $cari;
		
		//echo $sql . '<br>';
		return $this->db->selectAll($sql);
	}

	public function kiraKes($sv, $myTable, $medan, $fe)
	{
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' .
		$sv . $myTable . $carife . $this->_susun;
		
		//echo $sql . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function paparSemua($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';
		$sql = 'SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . ' b ' . $carife . $this->_susun;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemua($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . 
			$sv . $myTable . ' as b ' . $carife . $this->_susun .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSelesai($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' and fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable . 
			' b WHERE terima is not null ' .
			$carife . $this->_susun .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesJanji($sv, $myTable, $medan, $fe, $jum)
	{
		$carife = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable 
		     . ' b, `' . $sv .'rangka13` as c WHERE b.newss = c.newss '
			 . ' and (b.terima is null and c.respon != "A1") ' 
			 . $carife . $this->_susun 
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesBelum($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' and fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . $sv . $myTable . 
			' as b WHERE (terima is null' .
			' or terima like "0000%") ' . $carife .
			$this->_susun .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesTegar($sv, $myTable, $medan, $fe, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' and fe = "' . $fe . '"';

		$sql = 'SELECT ' . $medan . ' FROM ' . 
			$sv . $myTable . ' WHERE (`respon` not like "A1"' .
			' and `respon` not like "B%") ' . $carife .
			$this->_susun .
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kiraKesUtama($myTable, $medan, $cari)
	{
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mdt_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe;

		//echo $sql . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kesUtama($myTable, $medan, $cari, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$cariUtama = ( !isset($cari['utama']) ) ? 
		'' : ' WHERE b.newss=c.newss and b.utama = "' . $cari['utama'] . '"';
		$respon = ( !isset($cari['respon']) ) ? null : $cari['respon'] ;
		$cariFe = ( !isset($fe) ) ? '' : ' and b.fe = "' . $fe . '"';
		$AN=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13');
		
		if  ($respon=='a1')
			$cariRespon = " AND c.respon='A1' and b.terima like '20%' \r";
		elseif ($respon=='xa1')
			$cariRespon = " AND b.terima is null \r";
		elseif ($respon=='tegar')
			$cariRespon = " AND(`c.respon` IN ('" . implode("','",$AN) . "')) \r";
		else $cariRespon = '';

		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable 
			 . ' b, `mdt_rangka13` as c '
			 . $cariUtama . $cariRespon . $cariFe
			 . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function kesSemak($myTable, $myJoin, $medan, $jum)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$sql = 'SELECT ' . $medan . ' FROM ' . 
			$myTable . ' a, '.$myJoin.' b ' .
			' WHERE a.newss=b.newss ' . 
			' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
			
		$result = $this->db->selectAll($sql);
		//echo '<pre>' . $sql . '</pre><br>';
		//echo json_encode($result);
		
		return $result;
	}
	
	public function cariMedan($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable .
		' WHERE ' . $cariMedan . ' like "%' . $cariID . '%" ';
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));

		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
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
	
	public function cariIndustri($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable . 
			' WHERE ' . $cariMedan . ' = "' . $cariID . '" ';
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
	
	public function kiraProsesan($myTable)
	{
		$sql = 'SELECT * FROM ' . $myTable . 
			' WHERE data12 <> "Batch 1" ';
		
		//echo $sql . '<br>';
		$result = $this->db->rowcount($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function semakProsesan($myTable)
	{
		$sql = 'SELECT * FROM ' . 	$myTable . 
			' WHERE data12 <> "Batch 1" ';
		
		//echo $sql . '<br>';
		$result = $this->db->select($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function semakRangkaProsesan($myTable, $medan, $cari, $jum)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$cari = ( !isset($cari['medan']) ) ? '' 
			: ' and ' . $cariMedan . ' = "' . $cariID . '" ';
		
		$sql = 'SELECT ' . $medan . ' FROM ' . 	$myTable . 
			' WHERE data12 <> "Batch 1" ' .
			$cari . ' LIMIT ' . $jum['dari'] . ', ' . $jum['max'];
		
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
			//$postData[$medan] = $nilai;
			if ($medan == $medanID)
				$cariID = $medan;
			elseif ($medan != $medanID)
				$senarai[] = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
			if(($medan == 'fe'))
				$fe = ($nilai==null) ? " `$medan`=null" : " `$medan`='$nilai'"; 
		}
		
		$senaraiData = implode(",\r",$senarai);
		$where = "`$cariID` = '{$data[$cariID]}' ";
		
		// set sql
		$sql = " UPDATE `$myTable` SET \r$senaraiData\r WHERE $where";
		//echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		$this->db->update($sql);
	}
/*
	public function senarai($)
	{
		//$jum['dari'] . ', ' . $jum['max']
		$carife = ( !isset($fe) ) ? '' : ' WHERE fe = "' . $fe . '"';
		$sql = 'SELECT ' . $medan . ' FROM ' . 
		$sv . $myTable . $carife;
		
		//echo $sql . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}
*/
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
		
		// set sql
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