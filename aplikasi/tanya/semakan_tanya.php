<?php

class Semakan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	public function cariKawal($myTable, $cari)
	{
		$medan = '*';
		$newssTable = array('sse10_kawal','alamat_newss_2013');
		$cariMedan = (in_array($myTable,$newssTable))  ? 
			'newss' : 'sidap'; 
		$cariID = ( !isset($cari['id']) ) ? '' : 
			"WHERE $cariMedan LIKE '%" . $cari['id'] . "%'";

		$sql = "SELECT * FROM $myTable $cariID ";

		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>'; $data=array();
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
		$medan = 'kod_medan,kod_survey,`2010`'; // 2005-2013
		//$medan = '*'; // 2005-2013
		$sql = "SELECT $medan FROM `$myTable` "
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

	public function stafngaji($sv,$senaraiKP) 
	{
		//echo '<pre>Sebelum $posmen=>'; print_r($posmen['proses']); echo '</pre><hr>';
		$padam = array(
			'F0101','F0102','F0103','F0104','F0105','F0106','F0107','F0108','F0109','F0110','F0111','F0112','F0113',
			'F1001','F1002','F1003','F1004','F1005','F1006','F1007','F1008','F1009','F1010',
			'F1011','F1012','F1013','F1014','F1015','F1016','F1017','F1018',
            'F1101','F1102','F1103','F1104','F1105','F1106','F1107','F1108','F1109','F1110',
            'F1111','F1112','F1113','F1114','F1115','F1116','F1117','F1118',
            'F1201','F1202','F1203','F1204','F1205','F1206','F1207','F1208','F1209','F1210',
			'F1211','F1212','F1213','F1214','F1215','F1216','F1217','F1218',
            'F1305','F1306','F1307','F1308','F1309','F1310',
            'F1311','F1312','F1313','F1314','F1315','F1316','F1317','F1318'
		);
		if (in_array($sv,$senaraiKP)) 
		{
			foreach ($_POST['proses'] as $myMedan => $value)
			{
				if(in_array($myMedan,$padam)) 
				{
					///echo $myMedan . ' ada dalam $padam <hr>';
					unset($_POST['proses'][$myMedan]);
				}
			}
		}
		//echo '<pre>Selepas $_POST=>'; print_r($_POST['proses']); echo '</pre><hr>';
	}
# end - class Semakan_Tanya
#######################################################################
}