<?php

class Tanya
{
##################################################################################################
##------------------------------------------------------------------------------------
	function __construct()
	{
		//$this->db = new PangkalanData(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		$this->db = new DB_Mysqli(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		//$this->crud = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	}
##------------------------------------------------------------------------------------
	function ubahMedan($myTable, $medan)
	{
	/*
	ALTER [IGNORE] TABLE tbl_name
	MODIFY [COLUMN] col_name column_definition
	[FIRST | AFTER col_name]
	*/

		$sql = 'ALTER TABLE `' . $myTable . '` '
			 . 'CHANGE `' . $medan['asal'] . '` '
			 . '`' . $medan['baru'] . '` ' . $medan['jenis'] . ' '
			 . 'AFTER `' . $medan['selepas'] . '` ';

		echo '<pre>$sql->' . htmlentities($sql) . '</pre><br>';
	}
##------------------------------------------------------------------------------------
	private function jika($fix,$atau,$medan,$cariApa,$akhir)
	{
		$dimana = null; //echo "\r($fix) +> $atau $medan -> '$cariApa' |";
		if($fix==null) $dimana .= null;
		elseif($cariApa==null)
			$dimana .= ($fix=='x!=') ? " $atau`$medan` != '' $akhir\r"
					: " $atau`$medan` is null $akhir\r";
		elseif($fix=='xnull')
			$dimana .= " $atau`$medan` is not null  $akhir\r";
		elseif($fix=='x=')
			$dimana .= " $atau`$medan` = '$cariApa' $akhir\r";
		elseif($fix=='x<=')
			$dimana .= " $atau`$medan` <= '$cariApa' $akhir\r";
		elseif($fix=='x>=')
			$dimana .= " $atau`$medan` >= '$cariApa' $akhir\r";
		elseif($fix=='like')
			$dimana .= " $atau`$medan` like '$cariApa' $akhir\r";
		elseif($fix=='xlike')
			$dimana .= " $atau`$medan` not like '$cariApa' $akhir\r";
		elseif($fix=='%like%')
			$dimana .= " $atau`$medan` like '%$cariApa%' $akhir\r";	
		elseif($fix=='x%like%')
			$dimana .= " $atau`$medan` not like '%$cariApa%' $akhir\r";
		elseif($fix=='like%')
			$dimana .= " $atau`$medan` like '$cariApa%' $akhir\r";
		elseif($fix=='xlike%')
			$dimana .= " $atau`$medan` not like '$cariApa%' $akhir\r";
		elseif($fix=='%like')
			$dimana .= " $atau`$medan` like '%$cariApa' $akhir\r";
		elseif($fix=='x%like')
			$dimana .= " $atau`$medan` not like '%$cariApa' $akhir\r";
		elseif($fix=='in')
			$dimana .= " $atau`$medan` in $cariApa $akhir\r";
		elseif($fix=='xin')
			$dimana .= " $atau`$medan` not in $cariApa $akhir\r";
		elseif($fix=='khas2')
			$dimana .= " $atau`$medan` REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";
		elseif($fix=='xkhas2')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('(^| )','',$cariApa) $akhir\r";
		elseif($fix=='khas3')
			$dimana .= " $atau`$medan` REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";
		elseif($fix=='xkhas4')
			$dimana .= " $atau`$medan` NOT REGEXP CONCAT('[[:<:]]',$cariApa,'[[:>:]]') $akhir\r";
		elseif($fix=='z%like%')
			$dimana .= " $atau$medan like '%$cariApa%' $akhir\r";
		elseif($fix=='z1')
			$dimana .= " $atau$medan = $cariApa $akhir\r";
		elseif($fix=='z2')
			$dimana .= " $atau$medan like '$cariApa' $akhir\r";
		elseif($fix=='z2x')
			$dimana .= " $atau$medan not like '$cariApa' $akhir\r";
		elseif($fix=='z3x')
			$dimana .= " $atau$medan IS NOT NULL $akhir\r";
		elseif($fix=='zin')
			$dimana .= " $atau$medan in $cariApa $akhir\r";
		elseif($fix=='zbetween')
			$dimana .= " $atau$medan BETWEEN $cariApa $akhir\r";

		return $dimana; //echo '<br>' . $dimana;
	}

	protected function dimana($carian)
	{
		$where = null; //echo '<pre>'; print_r($carian); echo '</pre>';
		if($carian==null || $carian=='' || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$value)
			{
				 $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				$medan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				  $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;
				 $cari = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				$akhir = isset($carian[$key]['akhir']) ? $carian[$key]['akhir']      : null;
				//echo "\r$key => ($fix) $atau $medan -> '$cari' |";
				$where .= $this->jika($fix,$atau,$medan,$cari,$akhir);
			}
		endif;

		return $where; //echo '<pre>'; print_r($where); echo '</pre>';
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

	protected function dibawah($carian)
	{
		$susunan = null; //echo '<pre>'; print_r($carian); echo '</pre>';
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
				if ($kumpul!=null) $susunan .= " GROUP BY $kumpul\r";
				if ($mengira!=null)$susunan .= " $mengira\r";
				if ($order!=null)  $susunan .= " ORDER BY $order\r";
				if ($max!=null)    $susunan .= ($dari==0) ? 
					" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; 

		return $susunan; //echo '<pre>'; print_r($susunan); echo '</pre>';
	}
##------------------------------------------------------------------------------------
##################################################################################################
}