<?php

class Test_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	private function cariApa($fix,$atau,$medan,$cariApa,$akhir)
	{
		$where = null; //' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		if($cariApa==null )
			$where .= ($fix=='x!=') ? " $atau`$medan` !='' $akhir\r"
				: " $atau`$medan` is null $akhir\r";
		elseif($fix=='xnull')
			$where .= " $atau`$medan` is not null  $akhir\r";
		elseif($fix=='x=')
			$where .= " $atau`$medan` = '$cariApa' $akhir\r";
		elseif($fix=='x!=')
			$where .= " $atau`$medan` != '$cariApa' $akhir\r";
		elseif($fix=='like')
			$where .= " $atau`$medan` like '$cariApa' $akhir\r";
		elseif($fix=='xlike')
			$where .= " $atau`$medan` not like '$cariApa' $akhir\r";
		elseif($fix=='%like%')
			$where .= " $atau`$medan` like '%$cariApa%' $akhir\r";
		elseif($fix=='x%like%')
			$where .= " $atau`$medan` not like '%$cariApa%' $akhir\r";
		elseif($fix=='like%')
			$where .= " $atau`$medan` like '$cariApa%' $akhir\r";
		elseif($fix=='xlike%')
			$where .= " $atau`$medan` not like '$cariApa%' $akhir\r";
		elseif($fix=='%like')
			$where .= " $atau`$medan` like '%$cariApa' $akhir\r";
		elseif($fix=='x%like')
			$where .= " $atau`$medan` not like '%$cariApa' $akhir\r";
		elseif($fix=='in')
			$where .= " $atau`$medan` in $cariApa $akhir\r";
		elseif($fix=='xin')
			$where .= " $atau`$medan` not in $cariApa $akhir\r";
		elseif($fix=='khas2')
			$where .= " $atau`$medan` REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";
		elseif($fix=='xkhas2')
			$where .= " $atau`$medan` NOT REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";
		elseif($fix=='khas3')
			$where .= " $atau`$medan` REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";
		elseif($fix=='xkhas4')
			$where .= " $atau`$medan` NOT REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";
		elseif($fix=='z1')
			$where .= " $atau$medan = $cariApa $akhir\r";
		elseif($fix=='z2')
			$where .= " $atau$medan like $cariApa $akhir\r";
		elseif($fix=='zin')
			$where .= " $atau$medan in $cariApa $akhir\r";
		elseif($fix=='zxin')
			$where .= " $atau$medan not in $cariApa $akhir\r";
		# pulangkan nilai $where
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		return $where;
	}

	private function dimana($carian)
	{
		$where = null;
		if($carian==null || $carian=='' || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$value)
			{
				   $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				  $medan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				    $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;
				$cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				  $akhir = isset($carian[$key]['akhir']) ? $carian[$key]['akhir']      : null;
				//echo "\r$key => ($fix) $atau $medan -> '$cariApa' |";
				$where = $this->cariApa($fix,$atau,$medan,$cariApa,$akhir);
			}
		endif;

		return $where;
	}

	private function dibawah($carian)
	{
		//echo '<pre>'; print_r($carian).  '<pre>';
		$susunan = null;
		if($carian==null || empty($carian) ):
			$susunan .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$mengira = isset($carian[$key]['mengira'])? $carian[$key]['mengira'] : null;
				 $kumpul = isset($carian[$key]['kumpul']) ? $carian[$key]['kumpul']  : null;
				  $order = isset($carian[$key]['susun'])  ? $carian[$key]['susun']   : null;
				   $dari = isset($carian[$key]['dari'])   ? $carian[$key]['dari']    : null;
				    $max = isset($carian[$key]['max'])    ? $carian[$key]['max']     : null;

				//echo "\$cari = $cari, \$key=$key <br>";
			}
				if ($kumpul!=null)$susunan .= " GROUP BY $kumpul\r";
				if ($mengira!=null)$susunan .= " $mengira\r";
				if ($order!=null) $susunan .= " ORDER BY $order\r";
				if ($max!=null)   $susunan .= ($dari==0) ? 
						" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; 

		return $susunan;
	}

	public function pilihMedan($database,$myTable)
	{
		/*TABLE_CATALOG TABLE_SCHEMA	TABLE_NAME	
		COLUMN_NAME	ORDINAL_POSITION COLUMN_DEFAULT	IS_NULLABLE	DATA_TYPE
		CHARACTER_MAXIMUM_LENGTH	CHARACTER_OCTET_LENGTH	NUMERIC_PRECISION	NUMERIC_SCALE
		CHARACTER_SET_NAME	COLLATION_NAME	
		COLUMN_TYPE	COLUMN_KEY	EXTRA	PRIVILEGES	COLUMN_COMMENT*/
		$medan = 'COLUMN_NAME, DATA_TYPE, ' . "\r"
			   . 'concat_ws(" ",CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION) DATA_NO, '. "\r"
			   . 'COLUMN_KEY, EXTRA, PRIVILEGES,	COLUMN_COMMENT';
		$medan = huruf('Besar_Depan', $medan);
		$sql = ' SELECT ' . "\r" . $medan . "\r" 
			 . ' FROM INFORMATION_SCHEMA.COLUMNS' . "\r"
			 . ' WHERE table_schema = ' . $database . "\r"
			 . ' AND table_name = ' . $myTable;

		echo htmlentities($sql) . '<br>';
		return $this->db->selectAll($sql);
	}

	public function ubahMedan($myTable, $medan)
	{
		$sql = 'ALTER TABLE `' . $myTable . '` '
			 . 'CHANGE `' . $medan['asal'] . '` '
			 . '`' . $medan['baru'] . '` ' . $medan['jenis'] . ' '
			 . 'AFTER `' . $medan['selepas'] . '` ';

		echo htmlentities($sql) . '<br>';
		//return $this->db->selectAll($sql);
	}

	public function cariSemuaData($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);

		return $result;
	}

	public function cariSql($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		echo htmlentities($sql) . '<br>';
	}

	public function tambahSql($myTable, $data, $medan)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';

		# set sql
		$sql = "INSERT INTO $myTable ($medan) VALUES \r";
		$sql .= implode(",\r", $data);

		echo '<pre>$sql->', print_r($sql, 1) . '</pre>';
		//$this->db->insert($sql);
	}

	public function tambahJadual($myTable, $kira, $cantumMedan, $cantumData)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';

		# set sql
		$sql  = "CREATE TABLE `$myTable` "; ///*" . ($kira) . "*/";
		$sql .= "(" . substr($cantumMedan, 0, -1). "\r) COMMENT='' ENGINE='MyISAM'";

		echo '$sql->()<pre>', print_r($sql);  '</pre>';
		//$this->db->insert($sql);	header('location:' . URL . 'test/paparfail/masuk/data');
	}

	public function tambahData($myTable, $kira, $cantumMedan, $cantumData)
	{
		//echo '<pre>$sql->', print_r($data, 1) . '</pre>';

		# set sql
		$sql  = "INSERT INTO `$myTable` VALUES \r";
		$sql .= implode(",\r", $cantumData);

		echo '$sql->(' . count($cantumData) . ')<pre>', print_r($sql);  '</pre>';
		//$this->db->insert($sql);	header('location:' . URL . 'test/paparfail');
	}

	public function bacaFail($lokasi)
	{
		$bacafail = fopen($lokasi, "r");
		while(!feof($bacafail)) 
		{ 
			$data[] = explode("|", fgets($bacafail));
		}
		fclose($bacafail);

		$buang = count($data)-1;
		unset($data[$buang]);

		return $data; # pulangkan nilai
	}

	public function cantumMedanData($data, $senarai = array(), $cantumMedan = null)
	{
		foreach ($data as $key => $papar):
			foreach ($papar as $kira => $papar2):
				if($key==0 || $key==1)
					$cantuMedan[$key][] = bersih($papar2);
				$senarai[] = bersih($papar2);
			endforeach;
				unset($senarai[count($senarai)-1]);
				if($key!=0)
					$cantumData[] = "('" . implode("','", $senarai) . "')";
			$senarai = null;
		endforeach;

		return array($cantuMedan, $cantumData); # pulangkan nilai
	}

	public function cantumMedanDataLama($data, $senarai = array(), $cantumMedan = null)
	{
			foreach ($data as $key => $papar):
				foreach ($papar as $key2 => $papar2):
					$senarai[] = $paparan = bersih($papar2);
					/*if ($key==0)
					{
						echo $key2 . '|';
						//if (in_array($key2,array(0,2,3,4,5,11,16,17,18)))
						//	$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " varchar(".strlen($paparan)."),";
						if (in_array($key2,array(0,,1,2,5,6,7))) # data be16
							$cantumMedan .= $this->tanya->pilihMedanKhas($key2);
						elseif (strlen($paparan) < 7)
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " int(10),";
						elseif (is_numeric($papar2))
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " bigint(20),";
						else
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " varchar(".strlen($paparan)."),"; #$paparan
						$kira = $key2;
					}//*/
				endforeach;
				$cantumData[] = "('" . implode("','", $senarai) . "')";
				$senarai = null;
			endforeach;

		return array($cantumMedan, $cantumData); # pulangkan nilai
	}

	public function pilihMedanKhas($senaraiMedan)
	{
		//echo '<pre>$sql->'; print_r($senaraiMedan); echo '</pre>';
		$cantumMedan = null;
		foreach ($senaraiMedan as $key => $papar):
		foreach ($papar as $key2 => $papar2):
			if($key==0):
				$paparan = $senaraiMedan[1][$key2];
				//echo "\$papar2 = $papar2 | \$paparan = $paparan => strlen(".strlen($paparan).") Nom=> ".is_numeric($paparan)." <hr>";
				if ( in_array($papar2,array('NoSiri','KodBanci','NoBatch','StatusTD','StatusValid','F0002','F0003','F0004','F0005')) )
					$cantumMedan .=  '`' . ($papar2) . '` varchar(' . strlen($paparan) . ')'; #$paparan
				elseif (strlen($paparan) < 7)
					$cantumMedan .= '`' . ($papar2) . '` int(10)';
				elseif (is_numeric($paparan))
					$cantumMedan .= '`' . ($papar2) . '` bigint(20)';
				else
					$cantumMedan .= '`' . ($papar2) . '` varchar(' . strlen($paparan) . ')'; #$paparan

				$cantumMedan .= ($key2!=0 && $key2%5==0) ? ",\r" : ',';
			endif;
		endforeach;endforeach;//*/

		//echo '<pre>$sql->'; print_r($cantumMedan); echo '</pre>';

		return substr($cantumMedan, 0, -1);
	}

#####################################################################################################
}