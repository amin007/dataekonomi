<?php

class Ckawalan_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

	private function cariApa($fix,$atau,$medan,$cariApa,$akhir)
	{
		$where = null;
			if($cariApa==null )
				$where .= ($fix=='x!=') ? " $atau`$medan` !='' $akhir\r"
					: " $atau`$medan` is null $akhir\r";
			elseif($fix=='xnull')
				$where .= " $atau`$medan` is not null  $akhir\r";
			elseif($fix=='x=')
				$where .= " $atau`$medan` = '$cariApa' $akhir\r";
			elseif($fix=='x!=')
				$where .= " $atau`$medan` != '$cariApa' $akhir\r";
			elseif($fix=='x<=')
				$where .= " $atau`$medan` <= '$cariApa' $akhir\r";
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
			elseif($fix=='z=')
				$where .= " $atau$medan = $cariApa $akhir\r";
			elseif($fix=='zlike')
				$where .= " $atau$medan like $cariApa $akhir\r";
			elseif($fix=='zin')
				$where .= " $atau$medan in $cariApa $akhir\r";
			elseif($fix=='zxin')
				$where .= " $atau$medan not in $cariApa $akhir\r";	

		return $where;
	}
	
	private function dimana($carian)
	{
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		$where = null;
		if($carian==null || $carian=='' || empty($carian) ):
			$where .= null;
		else:
			foreach ($carian as $key=>$value)
			{
				    $fix = isset($carian[$key]['fix'])   ? $carian[$key]['fix']        : null;
			       $atau = isset($carian[$key]['atau'])  ? $carian[$key]['atau'] . ' ' : null;
				  $medan = isset($carian[$key]['medan']) ? $carian[$key]['medan']      : null;
				$cariApa = isset($carian[$key]['apa'])   ? $carian[$key]['apa']        : null;
				  $akhir = isset($carian[$key]['akhir']) ? $carian[$key]['akhir']      : null;
				//echo "\r$key => ($fix) $atau $medan -> '$cariApa' |";
				$where .= $this->cariApa($fix,$atau,$medan,$cariApa,$akhir);
			}
		endif;
	
		return $where;
	
	}

	private function dibawah($susun)
	{
		$susunan = null; //echo '<pre>susun:'; print_r($susun) . '</pre><br>';
		if($susun==null || empty($susun) ):
			$susunan .= null;
		else:
			foreach ($susun as $key=>$cari)
			{
				$kumpul = isset($susun[$key]['kumpul'])? $susun[$key]['kumpul'] : null;
				 $order = isset($susun[$key]['susun']) ? $susun[$key]['susun']  : null;
				  $dari = isset($susun[$key]['dari'])  ? $susun[$key]['dari']   : null;			
				   $max = isset($susun[$key]['max'])   ? $susun[$key]['max']    : null;
			}
				if ($kumpul!=null)$susunan .= " GROUP BY $kumpul\r";
				if ($order!=null) $susunan .= " ORDER BY $order\r";
				if ($max!=null)   $susunan .= ($dari==0) ? 
					" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; 
		
		return $susunan;		
	}

	private function bentukSQL($myTable, $medan = '*', $carian, $susun)
	{
		//$this->bentukSQL($myTable, $medan, $carian, $susun);
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);
		
		//echo '<pre>susun:'; print_r($susun) . '</pre><br>';
		//echo htmlentities($sql) . '<br>';
		
		return $sql;
	}
	
	public function cariRow($myTable, $medan = '*', $carian)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian);
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->rowCount($sql);
		
		return $result;
	}

	public function cariSemuaData($myTable, $medan = '*', $carian, $susun)
	{
		$sql = $this->bentukSQL($myTable, $medan, $carian, $susun);
		
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);
		
		return $result;
	}

	public function cariSemuaSql($sql)
	{	
		//echo htmlentities($sql) . '<br>';
		$result = $this->db->selectAll($sql);
		
		return $result;
	}
	
	public function cariSql($myTable, $medan = '*', $carian, $susun)
	{
		$sql = $this->bentukSQL($myTable, $medan, $carian, $susun);
		
		echo htmlentities($sql) . '<br>';
	}

	public function cariCantumSql($myTable, $medan = '*', $carian, $susun)
	{
		return $sql = $this->bentukSQL($myTable, $medan, $carian, $susun);
		
		//echo htmlentities($sql) . '<br>';
	}

	public function cariKes($myTable, $cari)
	{
		$medan = ($myTable=='sse10_kawal' || $myTable=='alamat_newss_2013') ? 
			'sidap,newss,nama,operator' : 'sidap,nama,operator'; 
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan LIKE '%$cariID%' ";
		
		//echo '<hr><pre>cariKes()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariSidap($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan like '$cariID%' ";
		
		//echo '<hr><pre>cariSatuSahaja()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

	public function cariSatuSahaja($myTable, $medan, $cari)
	{
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];

		$sql = "SELECT $medan FROM $myTable "
			 . "WHERE $cariMedan = '$cariID' ";
		
		//echo '<hr><pre>cariSatuSahaja()=>$sql='; print_r($sql) . '</pre>';
		$data = $this->db->selectAll($sql,2);
		//echo '<hr><pre>$data='; print_r($data) . '</pre>';
		
		return $data;
	}

}