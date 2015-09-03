<?php
function analisis($perangkaan, $jadual, $key, $data)
{
	// (in_array($jadual, array('q08_2010','q09_2010') ) )
	$asetPenuh = array(101,205,206,301,303,305,306,307,308,309,312,314,316,331);
	$sv = $perangkaan['sv']['dulu'];
	$hasil_dulu = $perangkaan['hasil']['dulu'];
	$hasil_kini = $perangkaan['hasil']['kini'];
	$belanja_dulu = $perangkaan['belanja']['dulu'];
	$belanja_kini = $perangkaan['belanja']['kini'];
	$susut_dulu = $perangkaan['susut']['dulu'];
	$susut_kini = $perangkaan['susut']['kini'];
	
	if (in_array($key, array('F3501','F3502','F3503','F3509','F1539') ) )
	{
		$value = $data;
		$anggaran = null;
	}
	if (in_array($key, array('F2001','F2101') ) )
	{
		$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $hasil_dulu) * $hasil_kini;
		$anggaran = number_format($anggar,0,'.',',');
		$hasilProduk = ($key=='F2001') ? $anggaran : 0;
		$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($key=='F2130' && $susut_kini!=0) ? $susut_kini : ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
		$kosBahan = ($key=='F2101') ? $anggaran : 0;
	}
	elseif ($jadual == $sv . '_q08_2010' && $sv='205')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $hasil_dulu) * $hasil_kini;
		$anggaran = number_format($anggar,0,'.',',');
		
	}
	elseif ($jadual == 's206_q08_2010' && $sv='206')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $hasil_dulu) * $hasil_kini;
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == $sv . '_q09_2010' && $sv='205')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($key=='F2130' && $susut_kini!=0) ? $susut_kini : ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
		
	}
	elseif ($jadual == 's206_q09_2010' && $sv='206')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == 's' . $sv . '_q02_2010' && $sv != '206')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $hasil_dulu) * $hasil_kini;
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == 's' . $sv . '_q03_2010' && $sv != '206')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif($jadual == 's' . $sv . '_q08_2010' && in_array($sv,$asetPenuh))
	{# hasil
		$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($data / $hasil_dulu) * $hasil_kini;
		$anggaran = number_format($anggar,0,'.',',');
		$kosBahan = ($key=='F2101') ? $anggaran : 0;
	}
	elseif($jadual == 's' . $sv . '_q09_2010' && in_array($sv,$asetPenuh))
	{# belanja
		$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($key=='F2130' && $susut_kini!=0) ? $susut_kini : ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
	}
	else
	{
		$value = '-';
		$anggaran = '-';
	}

	// istihar pembolehubah 
	return $data = array('nilai'=>$value,'anggar'=>$anggaran,
	'produk'=>(isset($hasilProduk) ? $hasilProduk : 0),
	'bahan'=>(isset($kosBahan) ? $kosBahan : 0)
	);
	//$input = $value . '</td><td align="right">' . $anggaran;
	//return '<td align="right">' . $value . '</td><td align="right">' . $anggaran . '</td>' . "\r";
}

if ($this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan: data kosong </span></h1>';
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian; 
	$ID = $this->paparID; 
	$senaraiMedan = array('sv','newss','nama');
	$sv = $this->kesID['semasa'][0]['sv'];
	/*$perangkaan['nama'] = $this->kesID['semasa'][0]['nama'];
	$perangkaan['newss'] = $this->kesID['semasa'][0]['newss'];*/
	$perangkaan['sv']['dulu'] = $this->kesID['semasa'][0]['sv'];
	$perangkaan['sv']['kini'] = $this->kesID['semasa'][0]['sv'];
	$perangkaan['hasil']['dulu'] = $this->kesID['semasa'][0]['hasil_dulu'];
	$perangkaan['belanja']['dulu'] = $this->kesID['semasa'][0]['belanja_dulu'];
	$perangkaan['susut']['dulu'] = $this->kesID['semasa'][0]['susut_dulu'];
	$perangkaan['aset']['dulu'] = $this->kesID['semasa'][0]['aset_dulu'];
	$perangkaan['asetsewa']['dulu'] = $this->kesID['semasa'][0]['asetsewa_dulu'];
	$perangkaan['hasil']['kini'] = $this->kesID['semasa'][0]['hasil_kini'];
	$perangkaan['belanja']['kini'] = $this->kesID['semasa'][0]['belanja_kini'];
	$perangkaan['susut']['kini'] = $this->kesID['semasa'][0]['susut_kini'];
	$perangkaan['aset']['kini'] = $this->kesID['semasa'][0]['aset_kini'];
	$perangkaan['asetsewa']['kini'] = $this->kesID['semasa'][0]['asetsewa_kini'];
	//echo '<pre>$perangkaan->'; print_r($perangkaan) . '</pre>';
	
?>
<span class="badge">Analisis Data</span>
<table border="1" class="excel" id="example">
<tr><td>data</td><td>dulu</td><td>kini</td></tr>
<?php

	foreach ( $perangkaan AS $key=>$data ) :
		//echo '<tr><td align="right">' .$key. '='.$data.'</td></tr>';
		echo '<tr><td align="right">' . $key . '</td>' 
		 . '<td align="right">' . kira($data['dulu']) . '</td>'
		 . '<td align="right">' . kira($data['kini']) . '</td>'
		 . '</tr>';
	endforeach;
?>
</table>

<?php 
//echo '<pre>'; print_r($this->kesID) . '</pre>';
foreach ($this->kesID as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	elseif ($myTable=='semasa') echo '';
	else
	{?>	
	<span class="badge badge-success">Analisis data <?php echo $myTable ?></span>
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
		$senaraiJadual = array($sv . '_q08_2010','s' . $sv . '_q08_2010'
			$sv .'_q09_2010', 's' . $sv . '_q09_2010');
		$senaraiJadual2 = array('s' . $sv . '_q02_2010','s' . $sv .'_q03_2010');
		
		if (in_array($myTable, $senaraiJadual )):
			$tajukMedan = array('keterangan','kod','data',
				'jum_dulu','jum_kini','% dulu','anggaran'
			);
		elseif (in_array($myTable, $senaraiJadual2 ) && $sv != '206'):
			$tajukMedan = array('keterangan','kod','data',
				'jum_dulu','jum_kini','% dulu','anggaran'
			);
		else: 
			$tajukMedan = array('keterangan','kod','data');
		endif;
		#-----------------------------------------------------------------
			if ( !$printed_headers ) : ?><tr>
		<?php	foreach ( $tajukMedan AS $tajuk ) : 
				?><th><?php echo $tajuk ?></th>
		<?php	endforeach;	?></tr><?php 
				$printed_headers = true; 
			endif;
		#-----------------------------------------------------------------	
		foreach ( $row[$kira] as $key=>$data ) : 
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
			$paparanData = ($data==null || $data == 0) ? '-' : null;
		
		if ($this->paparNilai == '-' && $data == 0): echo '';
		else:?><tr>
		<td><?php echo $keterangan ?></td>
		<td><?php echo $key . $paparanData ?></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($sv, $key, $data) ?></td>
		<?php 
			if ($myTable==$sv . '_q08_2010' || $myTable=='s' . $sv . '_q08_2010'
				|| $myTable==$sv .'_q09_2010' || $myTable=='s' . $sv . '_q09_2010'): 
				$p = analisis($perangkaan, $myTable, $key, $data); 
				# array('nilai'=>$value,'anggar'=>$anggaran,'produk'=>$hasilProduk,'bahan'=>$kosBahan);
				echo '<td>' . kira($perangkaan['hasil']['dulu']) . '</td>'
					. '<td>' . kira($perangkaan['hasil']['kini']) . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '<td align="right">' . $p['anggar'] . '</td>'
					. '';
			elseif ($myTable=='s' . $sv . '_q02_2010' && $sv!='206'): 
				$p = analisis($perangkaan, $myTable, $key, $data); 
				echo '<td>' . kira($perangkaan['hasil']['dulu']) . '</td>'
					. '<td>' . kira($perangkaan['hasil']['kini']) . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '<td align="right">' . $p['anggar'] . '</td>'
					. '';
			elseif ($myTable=='s' . $sv .'_q03_2010' && $sv!='206'): 
				$p = analisis($perangkaan, $myTable, $key, $data); 
				echo '<td>' . kira($perangkaan['belanja']['dulu']) . '</td>'
					. '<td>' . kira($perangkaan['belanja']['kini']) . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '<td align="right">' . $p['anggar'] . '</td>'
					. '';
			else: echo '<td colspan=4>-</td>';
			endif;
		//echo analisis($perangkaan, $myTable, $key, $data) ?>
		</tr><?php
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
?><pre>$p-><?php
#$p = analisis($perangkaan, $myTable, $key, $data); # array('nilai'=>$value,'anggar'=>$anggaran,'produk'=>$hasilProduk,'bahan'=>$kosBahan);
echo ''; print_r($p) . '';
?></pre>
<!-- Analisis data this->kod_produk -->
<?php 
foreach ($this->kod_produk as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Analisis data <?php echo $myTable ?>|
	D: Data Tahun Lepas, SI : Peratus Susutnilai, H: Peratus Dari Jumlah Harta, A: Anggaran</span>
<!-- Jadual <?php echo $myTable ?> ########################################### -->	
<table  border="1" class="excel" id="example">
<?php
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	//print the headers once: 	
	if ( !$printed_headers ) 
	{	?><thead><tr>
<th>#</th>
<?php	foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) 
			?><th><?php echo $tajuk ?></th><?php
		endforeach ?>
</tr></thead><?php
		$printed_headers = true; 
	}
#-----------------------------------------------------------------		 
	//print the data row ?>
<tbody><tr>
<td><?php echo $kira+1 ?></td>	
<?php foreach ( $row[$kira] as $key=>$data ) :?>
<td align="right"><?php echo (in_array($key, 
	array('thn','Estab','F3001','Commodity'))) ? 
	$data : semakJenis($sv, $key, $data) ?></td>
<?php endforeach ?>
</tr></tbody>
<?php
}
#-----------------------------------------------------------------
?></table>
<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>

<?php } // $this->carian=='sidap' - tamat ?>