<?php

class Ruangtamu_Tanya extends Tanya 
{

	public function __construct() 
	{
		parent::__construct();
	}

##################################################################################################################
## contoh koding yang standard untuk carian dalam mysql

	/*private function jika($atau,$medan,$fix,$cariApa,$akhir)
	{
		$dimana = null;
		if($atau==null) $dimana .= null;
		elseif($cariApa==null )
			$dimana .= ($fix=='x!=') ? " $atau`$medan` !='' $akhir\r"
					: " $atau`$medan` is null $akhir\r";
		elseif($fix=='xnull')
			$dimana .= " $atau`$medan` is not null  $akhir\r";
		elseif($fix=='x=')
			$dimana .= " $atau`$medan` = '$cariApa' $akhir\r";
		elseif($fix=='x!=')
			$dimana .= " $atau`$medan` != '$cariApa' $akhir\r";
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
		elseif($fix=='zxin')
			$dimana .= " $atau$medan not in $cariApa $akhir\r";	
		return $dimana;
	}

	private function dimana($carian)
	{
		//' WHERE ' . $medan . ' like %:cariID% ', array(':cariID' => $cariID));
		$where = null;
		if($carian==null || $carian=='' || empty($carian)):
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
				$where .= $this->jika($atau,$medan,$fix,$cariApa,$akhir);
			}
		endif; //echo "<hr>$where";

		return $where;
	}

	private function dibawah($carian)
	{
		$susunan = null;
		if($carian==null || empty($carian) ):
			$susunan .= null;
		else:
			foreach ($carian as $key=>$cari)
			{
				$kumpul = isset($carian[$key]['kumpul'])? $carian[$key]['kumpul'] : null;
				 $order = isset($carian[$key]['susun']) ? $carian[$key]['susun']  : null;
				  $dari = isset($carian[$key]['dari'])  ? $carian[$key]['dari']   : null;
				   $max = isset($carian[$key]['max'])   ? $carian[$key]['max']    : null;
				
				//echo "\$cari = $cari, \$key=$key <br>";
			}
				if ($kumpul!=null)$susunan .= " GROUP BY $kumpul\r";
				if ($order!=null) $susunan .= " ORDER BY $order\r";
				if ($max!=null)   $susunan .= ($dari==0) ? 
						" LIMIT $max\r" : " LIMIT $dari,$max\r";
		endif; 
		
		//echo "<hr>\$kumpul:$kumpul \$order:$order \$dari:$dari \$max:$max hahaha<hr>";
		return $susunan;
	}//*/
	
	public function cariSemuaData($myTable, $medan, $carian, $susun)
	{
		$sql = 'SELECT ' . $medan . ' FROM ' . $myTable 
			 . $this->dimana($carian)
			 . $this->dibawah($susun);

		//echo '<pre>susun:'; print_r($susun) . '</pre><br>';
		//echo htmlentities($sql) . '<br>';
		//echo '<pre>';print_r($sql) . '</pre><br>';
		$result = $this->db->selectAll($sql);
		//echo json_encode($result);

		return $result;
	}

##################################################################################################################

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