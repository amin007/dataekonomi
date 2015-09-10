<?php
//echo '<pre>'; print_r($this->prosesData); echo '</pre>';
//echo '<pre>'; print_r($this->keterangan); echo '</pre>';
foreach ($this->prosesData as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{
		$tajuk = ' |' . dataSyarikat($perangkaan);
	
	?>	
	<span class="badge badge-success">Analisis data <?php 
	echo $myTable . $tajuk ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table><tr>
	<?php
	// mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	#print the data row ?>
		<td valign="top">
		<table border="1" class="excel" id="example">
		<?php 
		$printed_headers = false; # mula bina jadual
		#-----------------------------------------------------------------
		//if ( !$printed_headers ) #print the headers once:
		//	$printed_headers = tajukMedan($kira,$row);
		#-----------------------------------------------------------------	
		foreach ( $row[$kira] as $key=>$data ) : 
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
		
			if ($data == 0): echo '';
			/*elseif (in_array($key, array(
				'F1541','F1542','F1543','F1544','F1545','F1546','F1547','F1548','F1549','F1550','F1559',
				'F1641','F1642','F1643','F1644','F1645','F1646','F1647','F1648','F1649','F1650','F1659'))):
				//s11($keterangan, $key, $data, $row);
				echo '';*/
			else: prosesData($keterangan, $key, $data, $row); 
			endif;
		endforeach; ?>
		</table>
		</td><?php
	}
	#-----------------------------------------------------------------?>
	</tr></table>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
<?php
	} // if ( count($row)==0 )
}

function s11($keterangan, $kunci, $nilaiKunci, $row)
{
		$s11 = tatasusunanJenis();
		if ($kunci=='F1659'):
		?><tr><td align="right" colspan="2">Jum Kuantiti / Nilai <table><tr>
		<td colspan="1">Jenis</td>
		<td colspan="1">Aup</td>
		<td colspan="2">Dulu</td>
		<td colspan="2">Anggar</td></tr><?php
		foreach($s11 as $key2 => $medan2):
			//foreach($medan2 as $key3 => $medan):
			?><tr>
			<td align="right"><?php echo $s11[$key2]['jenis'] ?></td>
			<td align="right"><?php echo $s11[$key2]['aup'] ?></td>
			<td align="right"><?php echo 'F15' . $key2 ?></td>
			<td align="right"><?php echo 'F16' . $key2 ?></td>
			<td align="right"><?php echo 'F15' . $key2 ?></td>
			<td align="right"><?php echo 'F16' . $key2 ?></td>
			</tr><?php	
	
		//endforeach;
		endforeach;
		?></table></td></tr><?php
		endif;
}
function tatasusunanJenis()
{
				/*echo " array('keterangan'=> '" . $p2[$k2]['jenis'] . "',
				'aup'=> '" . $p2[$k2]['aup'] . "',
				'key'=>'F16$k2','nilai'=>$nilaiKunci) <br>";*/

		$p = array(41,42,43,44,45,46,47,48,49,50,59);
		
		foreach($p as $k2):
			if($k2==41): $data[$k2] = array('keterangan'=> 'Air','aup'=> 2.6,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==42): $data[$k2] = array('keterangan'=> 'Pelincir','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==43): $data[$k2] = array('keterangan'=> 'Minyak diesel','aup'=> 1.8,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==44): $data[$k2] = array('keterangan'=> 'Petrol','aup'=> 1.9,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==45): $data[$k2] = array('keterangan'=> 'Minyak relau/Minyak pembakar','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==46): $data[$k2] = array('keterangan'=> 'Gas petroleum cecair (LPG)','aup'=> 1200,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==47): $data[$k2] = array('keterangan'=> 'Gas asli/Gas asli untuk kenderaan (NGV)','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==48): $data[$k2] = array('keterangan'=> 'Bahan pembakar lain','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==49): $data[$k2] = array('keterangan'=> 'Tenaga elektrik yang dibeli','aup'=> 0.43,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==50): $data[$k2] = array('keterangan'=> 'Tenaga elektrik yang dijana','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			if($k2==59): $data[$k2] = array('keterangan'=> 'Jum Kuantiti / nilai','aup'=> null,'key'=>'F15' . $k2,'nilai'=>$nilaiKunci);		
			endif;
		endforeach;*/
	
		//echo '<pre>data='; print_r($data, 1) . '</pre>'; 

		return $data;
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
		$data = $nilai;
		$data = $data . ' | ' . $kunci;
		$keterangan = $keterangan;
	}
	/*elseif (in_array($kunci, array('F1541','F1542','F1543','F1544','F1545','F1546','F1547','F1548','F1549','F1550','F1559',
		'F1641','F1642','F1643','F1644','F1645','F1646','F1647','F1648','F1649','F1650','F1659')))
	{
		$data = '' . $nilai;
		$data = $kunci . ' x| ' . $data;
		$keterangan = $keterangan;
	}*/
	else 
	{
		$data = (is_numeric($nilai)) ? number_format($nilai,0) : $nilai;
		$data = $data . ' | ' . $kunci;
		$keterangan = $keterangan;
	}
	
	$lepas = array('F1541','F1542','F1543','F1544','F1545','F1546','F1547','F1548','F1549','F1550','F1559',
		'F1641','F1642','F1643','F1644','F1645','F1646','F1647','F1648','F1649','F1650','F1659');
	#papar data
		echo (in_array($kunci,$lepas)) ? '' :
		'<tr>
		<td align="right">'.$keterangan.'</td>
		<td align="right">'.$data.'</td>
		</tr>';	
}
?>