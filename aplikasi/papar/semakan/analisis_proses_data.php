<table><tr><?php
foreach ($this->dataAsal as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{	$tajuk = ' |' . dataSyarikat($perangkaan);
	?>
	<td align="top">
	<span class="badge badge-success">Analisis data <?php echo $myTable . $tajuk ?></span>
<?php 
			echo '<table  border="1" class="excel" id="example">';
			#-----------------------------------------------------------------
				foreach ( $row[0] as $key=>$data ) :
					$thn = ($key=='thn') ? $data : 2010; 
					$keterangan = !isset($this->keterangan['proses'][$key][$thn]) ?
						'-' : $this->keterangan['proses'][$key][$thn];
					echo '<tbody><tr>' . "\r";
					echo '<td align="right">' . "$keterangan|$key</td>";
					echo '<td align="right">' . "$data</td>";
					//echo jadualData($keterangan, $key, $data, $row);
					echo '</tr></tbody>';
				endforeach;				
			#-----------------------------------------------------------------
			echo '</table></div>';	
?>	</td>
	<?php
	} // if ( count($row)==0 )
}
?>
</tr></table>
<?php 
echo '<pre>';
echo '<hr>$this->papar->keterangan->', print_r($this->keterangan, 1);
echo '</pre>';
//*/
function jadualData($keterangan, $kunci, $nilai, $row)
{
	list($kodMedan, $data) = prosesData($keterangan, $kunci, $nilai, $row);
	echo 
	'<td align="right">'.$kodMedan.'</td>
	<td align="right">'.$data.'</td>
	';	
}
function prosesData($keterangan, $kunci, $nilai, $row)
{
	
	if (in_array($kunci, array('F0003','F0004','F0005')))
	{
		$data = preg_replace('/(\d{1,2})(\d{2})(\d{4})$/', 
			'$3-$2-$1', $nilai).PHP_EOL;
		$data = date('d M Y',strtotime($data));
		$data = $data . ' | ' . $kunci;
		$keterangan = $keterangan;
	}
	elseif  (in_array($kunci, array('NEGERILOK','REGIONLOK','F0014','F0015',
		'F0016','F0017','F0018','F0023','F0024','F0030','F0047',
		'F1510','F1511','F1512','F1513','F1913','F1919')))
	{
		$data = $nilai . ' | ' . $kunci;
		$keterangan = $keterangan;
	}
	else 
	{
		$data = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
		$data = $data . ' | ' . $kunci;
		$keterangan = $keterangan;
	}
	
	#papar data
		return array('keterangan'=>$keterangan, 'data'=>$data);
}
?>