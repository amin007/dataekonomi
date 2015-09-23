<?php
//echo '<pre>$perangkaan->'; print_r($perangkaan) . '</pre>';
echo $tajuk = ' | ' . dataSyarikat($perangkaan);
?>
<table><tr><?php
$mengira = 1;
foreach ($this->dataAsal as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{	
	?><td valign="top"><?php 
		echo '<table  border="1" class="excel" id="example">';
		#-----------------------------------------------------------------
		foreach ( $row[0] as $key=>$data ) :
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan['proses'][$key][$thn]) ?
				'-' : $this->keterangan['proses'][$key][$thn];

				echo '<tbody><tr><td>' . $mengira++ . "</td>\r";
				echo jadualData($keterangan, $key, $data, $perangkaan);
				echo '</tr></tbody>';

		endforeach;				
		#-----------------------------------------------------------------
		echo '</table></div>';	
	?></td><?php
	} // if ( count($row)==0 )
}
?>
</tr></table>
<?php 
/*
echo '<pre>';
echo 'medan ada ' . $mengira;
echo '</pre>';
//*/
function jadualData($keterangan, $kunci, $nilai, $perangkaan)
{
	$data = prosesData($kunci, $nilai, $perangkaan);
	$papar = $kunci . ' = ' . $nilai;
	//$papar = '<td colspan="3">'.$kunci.'='.$data.'</td>';
	echo ($keterangan=='-') ? '<td colspan="3">'.$papar.'</td>':
		'<td align="right">'.$keterangan.'</td><td>'.$kunci.'</td>
		<td align="right">'.$data.'</td>';	
}
function prosesData($kunci, $nilai, $perangkaan)
{
	$paparMedan = array('Survey','Input','Output','OwnershipRvw','LegalStatus','ValueAdded');
	if (in_array($kunci, array('F0003','F0004','F0005')))
	{
		$data = preg_replace('/(\d{1,2})(\d{2})(\d{4})$/', 
			'$3-$2-$1', $nilai).PHP_EOL;
		$data = date('d-M-Y',strtotime($data));
	}
	elseif  (in_array($kunci, $paparMedan))
	{
		$data = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
		$data = $kunci . ' = ' . $data;
	}# perkataan
	elseif  (in_array($kunci, array('NEGERILOK','REGIONLOK',
		'estab','KodIndustri','KodNegeri','Year'
		)))
	{
		$data = $kunci . ' = ' . $nilai;
	}# kod sahaja
	elseif  (in_array($kunci, array('F0002','F0014','F0015',
		'F0016','F0017','F0018','F0023','F0024','F0025','F0026',
		'F0030','F0047','F1510','F1511','F1512','F1513','F1913','F1919')))
	{
		$data = $nilai;
	}
	elseif ($kunci=='F1530') 
	{
		$nisbah = rand(-30, 30)/100;
		$nisbah = 1 - $nisbah;
		# kini
		$untungK = $perangkaan['hasil']['kini'] - $perangkaan['belanja']['kini'];
		$nisbahK = ($untungK * $nisbah);
		$untungK = number_format($nisbahK,0,'.',',') . '';
		$untungD = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
		
		$data = "dulu = $untungD <br> kini = $untungK ";
	}
	elseif ($kunci=='F1630') 
	{
		$untungKini = $perangkaan['hasil']['kini'] - $perangkaan['belanja']['kini'];
		$untungKini = number_format($untungKini,0,'.',',') . '';
		$untungDulu = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
		
		$data = " kini = $untungKini <br> dulu = $untungDulu";
	}
	else 
	{
		$data = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
	}
	
	#papar data
		return $data;
}
?>