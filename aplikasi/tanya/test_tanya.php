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

#####################################################################################################
}