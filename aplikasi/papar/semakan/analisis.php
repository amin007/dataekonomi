<?php
function analisis($perangkaan, $ppt, $jadual, $key, $data)
{
	$asetPenuh = $ppt['AsetPenuh'];
	$asetBrgAm = $ppt['BrgAm'];
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
	elseif ($jadual == $sv . '_q08_2010' && $sv='205')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0 || $data==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($hasil_dulu==0 || $data==0) ? 0 : (($data / $hasil_dulu) * $hasil_kini);
		$anggaran = number_format($anggar,0,'.',',');
		
	}
	elseif ($jadual == 's206_q08_2010' && $sv='206')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0 || $data==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($hasil_dulu==0 || $data==0) ? 0 : (($data / $hasil_dulu) * $hasil_kini);
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == $sv . '_q09_2010' && $sv='205')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($key=='F2130' && $susut_kini!=0) ? $susut_kini : ($data / $belanja_dulu) * $belanja_kini;
		$anggaran = number_format($anggar,0,'.',',');
		
	}
	elseif ($jadual == 's206_q09_2010' && $sv='206')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * $belanja_kini);
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == 's' . $sv . '_q02_2010' && $sv != '206')
	{// hasil
		$nilai_dulu = ($hasil_dulu==0 || $data==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($hasil_dulu==0 || $data==0) ? 0 : (($data / $hasil_dulu) * $hasil_kini);
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif ($jadual == 's' . $sv . '_q03_2010' && $sv != '206')
	{// belanja
		$nilai_dulu = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * 100 );
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($belanja_dulu==0 || $data==0) ? 0 : (($data / $belanja_dulu) * $belanja_kini);
		$anggaran = number_format($anggar,0,'.',',');
	}
	elseif($jadual == 's' . $sv . '_q08_2010' && in_array($sv,$asetPenuh))
	{# hasil
		$nilai_dulu = ($hasil_dulu==0 || $data==0) ? 0 :(($data / $hasil_dulu) * 100);
		$value = number_format($nilai_dulu,4,'.',',') . '%';
		$anggar = ($hasil_dulu==0 || $data==0) ? 0 : (($data / $hasil_dulu) * $hasil_kini);
		$anggaran = number_format($anggar,0,'.',',');
		$kosBahan = ($key=='F2101') ? $anggaran : 0;
	}
	elseif($jadual == 's' . $sv . '_q09_2010' && in_array($sv,$asetPenuh))
	{# belanja
		$nilai_dulu = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * 100 );
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
function dataSyarikat($perangkaan)
{
	$namaPertubuhan = $perangkaan['nama']['dulu'];
	
	//echo '<caption>'.$namaPertubuhan.'</caption>';
	return ' ' . $namaPertubuhan;
	//echo '';
}

if ($this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan: data kosong </span></h1>';
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian; 
	$ID = $this->paparID; 
	$senaraiMedan = array('sv','newss','nama');
	$sv = $this->kesID['semasa'][0]['sv'];
	$perangkaan['nama']['dulu'] = $this->kesID['semasa'][0]['nama'];
	$perangkaan['newss']['dulu'] = $this->kesID['semasa'][0]['newss'];
	$perangkaan['sv']['dulu'] = $this->kesID['semasa'][0]['sv'];
	$perangkaan['sv']['kini'] = $this->kesID['semasa'][0]['sv'];
	$perangkaan['hasil']['dulu'] = $this->kesID['semasa'][0]['hasil_dulu'];
	$perangkaan['belanja']['dulu'] = $this->kesID['semasa'][0]['belanja_dulu'];
	$perangkaan['gaji']['dulu'] = $this->kesID['semasa'][0]['gaji_dulu'];
	$perangkaan['susut']['dulu'] = $this->kesID['semasa'][0]['susut_dulu'];
	$perangkaan['aset']['dulu'] = $this->kesID['semasa'][0]['aset_dulu'];
	$perangkaan['asetsewa']['dulu'] = $this->kesID['semasa'][0]['asetsewa_dulu'];
	$perangkaan['hasil']['kini'] = $this->kesID['semasa'][0]['hasil_kini'];
	$perangkaan['belanja']['kini'] = $this->kesID['semasa'][0]['belanja_kini'];
	$perangkaan['gaji']['kini'] = $this->kesID['semasa'][0]['gaji_kini'];
	$perangkaan['susut']['kini'] = $this->kesID['semasa'][0]['susut_kini'];
	$perangkaan['aset']['kini'] = $this->kesID['semasa'][0]['aset_kini'];
	$perangkaan['asetsewa']['kini'] = $this->kesID['semasa'][0]['asetsewa_kini'];
	//echo '<pre>$perangkaan->'; print_r($perangkaan) . '</pre>';
?>
<style type="text/css">
/* Table like excel view
-------------------------------------------------- */
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:11px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align: top;
}
table.excel tbody th { text-align:center; vertical-align: top; }
table.excel tbody td { vertical-align:bottom; }
table.excel tbody td 
{ 
	padding: 0 3px; border: 1px solid #aaaaaa;
	background:#ffffff;
}
</style>

<span class="badge">Analisis Data</span>
<table border="1" class="excel" id="example">
<tr><td>data</td><td>dulu</td><td>kini</td></tr>
<?php

	foreach ( $perangkaan AS $key=>$data ) :
		//echo '<tr><td align="right">' .$key. '='.$data.'</td></tr>';
		echo '<tr><td align="right">' . $key . '</td>' 
		 . ((in_array($key, array('nama','newss') )) ? 
			( '<td align="right" colspan="2">' . $data['dulu'] . '</td>')
			: # untuk nombor sahaja
			( '<td align="right">' . kira($data['dulu']) . '</td>'
			 . '<td align="right">' . kira($data['kini']) . '</td>')
			) . '</tr>';
	endforeach;
?>
</table>

<!-- <pre><?php //print_r($this->kesID);?></pre> -->

<?php

foreach ($this->kesID as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	elseif ($myTable=='semasa') echo '';
	else
	{
		$tajuk = ' |' . dataSyarikat($perangkaan)
			. ' | Dulu:' . kira($perangkaan['hasil']['dulu']) 
			. ' | Kini:' . kira($perangkaan['hasil']['kini']);
	
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
		$senaraiJadual = array($sv . '_q08_2010','s' . $sv . '_q08_2010',
			$sv . '_q09_2010', 's' . $sv . '_q09_2010');
		$senaraiJadual2 = array('s' . $sv . '_q02_2010','s' . $sv . '_q03_2010');
		
		if (in_array($myTable, $senaraiJadual )):
			$tajukMedan = array('keterangan','kod','data','anggaran','% dulu');
		elseif (in_array($myTable, $senaraiJadual2 ) && $sv != '206'):
			$tajukMedan = array('keterangan','kod','data','anggaran','% dulu');
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
		
		if ($this->paparNilai == '-' && $data == 0): echo '';
		else:?><tr>
		<td><?php echo $keterangan ?></td>
		<td><?php echo $key ?></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($sv, $key, $data) ?></td>
		<?php 
			if ($myTable==$sv . '_q08_2010' || $myTable=='s' . $sv . '_q08_2010'
				|| $myTable==$sv .'_q09_2010' || $myTable=='s' . $sv . '_q09_2010'): 
				$p = analisis($perangkaan, $this->ppt, $myTable, $key, $data); 
				# array('nilai'=>$value,'anggar'=>$anggaran,'produk'=>$hasilProduk,'bahan'=>$kosBahan);
				echo '<td align="right">' . $p['anggar'] . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '';
			elseif ($myTable=='s' . $sv . '_q02_2010' && $sv!='206'): 
				$p = analisis($perangkaan, $this->ppt, $myTable, $key, $data); 
				echo '<td align="right">' . $p['anggar'] . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '';
			elseif ($myTable=='s' . $sv .'_q03_2010' && $sv!='206'): 
				$p = analisis($perangkaan, $this->ppt, $myTable, $key, $data); 
				echo '<td align="right">' . $p['anggar'] . '</td>'
					. '<td align="right">' . $p['nilai'] . '</td>'
					. '';
			else: echo '<td colspan=4>-</td>';
			endif; ?>
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
?>
<!-- Analisis data this->kod_produk -->
<?php
function dataProdukKodbahan($perangkaan, $kesID)
{
	$sv = $perangkaan['sv']['dulu'];
	$hasil_dulu = $perangkaan['hasil']['dulu'];
	$hasil_kini = $perangkaan['hasil']['kini'];
	$belanja_dulu = $perangkaan['belanja']['dulu'];
	$belanja_kini = $perangkaan['belanja']['kini'];
	
	foreach ($kesID as $myTable => $row):
		foreach ($row[0] as $key=>$data):
			if (in_array($key, array('F2001') ) )
			{
				$nilai_dulu = ($hasil_dulu==0 || $data==0) ? 0 :(($data / $hasil_dulu) * 100);
				$value = number_format($nilai_dulu,4,'.',',') . '%';
				$hasilProduk = ($hasil_dulu==0 || $data==0) ? 0 : (($data / $hasil_dulu) * $hasil_kini);
			}
			elseif (in_array($key, array('F2101') ) )
			{
				$nilai_dulu = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * 100 );
				$value = number_format($nilai_dulu,4,'.',',') . '%';
				$kosBahan = ($belanja_dulu==0 || $data==0) ? 0 :(($data / $belanja_dulu) * $belanja_kini);
			}
	endforeach;endforeach;
	
	return array('produk'=>$hasilProduk, 'kosBahan'=>$kosBahan);
}
function tajukMedan($kira,$row)
{
	?><thead><tr>
<th>#</th><?php	
		foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) 
			?><th><?php echo $tajuk ?></th><?php
		endforeach ?>
</tr></thead><?php 
	return $printed_headers = true;
}
function tajukMedan2($kira,$row)
{
	$papar = "<thead><tr>\r<th>#</th>";
		foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) 
			$papar .= "<th>$tajuk</th>";
		endforeach;
	$papar .= "\r</tr></thead>";
	return $papar;
}

function analisisProdukKodBahan($borang, $p, $jadual, $row, $kiraBil)
{
	/*[output][0][F22]	$key F24 $data 168 | $key F25 $data 37572-113856
	//[input][0][F22]	$key F22 $data 3002	| $key F23 $data 13667-48810
	*/
	$kiniP = (int)$p['produk'];
	$kiniK = (int)$p['kosBahan'];
	
	foreach ($row[$kiraBil] as $key => $data):
		if ($jadual=='output' && in_array($key,array('F25'))):
			list($dulu,$jum) = explode('-',$data);
			$nisbah = ($jum==0 || $dulu==0) ? 0 :($dulu / $jum);
			$nisbah2 = ($jum==0 || $dulu==0) ? 0 :(($dulu / $jum) * 100);
			$value = number_format($nisbah2,2,'.',',') . '%';
			$anggar = ($jum==0 || $dulu==0) ? 0 : (($dulu / $jum) * $kiniP);
			$nilai_kini = floor($anggar * 1) / 1;
					
			$papar = ($data==0) ? 0: "dulu = $dulu |  $value<br>"
				. " kini = ($dulu / $jum) x $kiniP = " . $nilai_kini 
				. " ";
		elseif ($jadual=='output' && in_array($key,array('F24'))):
			# produk
			list($dulu,$jum) = explode('-',$borang['output'][$kiraBil]['F25']);
			$nisbah = ($jum==0 || $dulu==0) ? 0 :($dulu / $jum);
			$nisbah2 = ($jum==0 || $dulu==0) ? 0 :(($dulu / $jum) * 100);
			$value = number_format($nisbah2,2,'.',',') . '%';
			$anggar = ($jum==0 || $dulu==0) ? 0 : (($dulu / $jum) * $kiniP);
			$nilai_kini = floor($anggar * 1) / 1;
			# kuantiti
			$kuantiti_dulu = $data;
			$aup = ($data==0) ? 0: ($dulu / $data);
			$aup2 = number_format($aup,2,'.',',') . '';
			$kini = ($data==0) ? 0: $nilai_kini / $aup2;
			$kuantiti_kini = number_format($kini,0,'.',',') . '';
			
			$papar = ($kuantiti_dulu==0) ? 0 : " dulu = $kuantiti_dulu | aup " . $aup2 . '<br>'
				. " kini = $nilai_kini / $aup2 = " . ($kuantiti_kini)
				. "";
		elseif ($jadual=='input' && in_array($key,array('F23'))):
			list($dulu,$jum) = explode('-',$data);
			$nisbah = ($jum==0 || $dulu==0) ? 0 :($dulu / $jum);
			$nisbah2 = ($jum==0 || $dulu==0) ? 0 :(($dulu / $jum) * 100);
			$value = number_format($nisbah2,2,'.',',') . '%';
			$anggar = ($jum==0) ? 0 : (($dulu / $jum) * $kiniK);
			$nilai_kini = floor($anggar * 1) / 1;
					
			$papar = ($dulu==0) ? 0: "dulu = $dulu |  $value<br>"
				. " kini = ($dulu / $jum) x $kiniK = " . $nilai_kini 
				. " ";
		elseif ($jadual=='input' && in_array($key,array('F22'))):
			# produk
			list($dulu,$jum) = explode('-',$borang['input'][$kiraBil]['F23']);
			$nisbah = ($jum==0 || $dulu==0) ? 0 :($dulu / $jum);
			$nisbah2 = ($jum==0 || $dulu==0) ? 0 :(($dulu / $jum) * 100);
			$value = number_format($nisbah2,2,'.',',') . '%';
			$anggar = ($jum==0 || $dulu==0) ? 0 : (($dulu / $jum) * $kiniP);
			$nilai_kini = floor($anggar * 1) / 1;
			# kuantiti
			$kuantiti_dulu = $data;
			$aup = ($data==0 || $dulu==0) ? 0: ($dulu / $data);
			$aup2 = number_format($aup,2,'.',',') . '';
			$kini = ($nilai_kini==0 || $aup==0) ? 0 : $nilai_kini / $aup;
			$kuantiti_kini = number_format($kini,0,'.',',') . '';
			
			$papar = ($kuantiti_dulu==0) ? 0 : " dulu = $kuantiti_dulu | aup " . $aup2 . '<br>'
				. " kini = $nilai_kini / $aup2 = " . ($kuantiti_kini)
				. "";
		else:
			$papar = $data;
		endif;
		echo "<td>$papar</td>";
	endforeach;
}
function dataGaji($perangkaan, $key, $data, $row, $kiraBil)
{
	$sv = $perangkaan['sv']['dulu'];
	$hasil_dulu = $perangkaan['hasil']['dulu'];
	$hasil_kini = $perangkaan['hasil']['kini'];
	$belanja_dulu = $perangkaan['belanja']['dulu'];
	$belanja_kini = $perangkaan['belanja']['kini'];
	$gaji_dulu = $perangkaan['gaji']['dulu'];
	$gaji_kini = $perangkaan['gaji']['kini'];

	# kira purata sebulan untuk seorang staf
	$org = $row[$kiraBil][(($key=='Gaji|L18') ? 'Jum|L14' : 'Jum|W14')];
	$bln = ($org==0 || $data==0) ? '' :($data / $org)/12;
	$purataGaji = ($org==0 || $data==0) ? '' : 'sebln = ' . number_format($bln,2,'.',',') . '';

	#L	Msia|L	Pati|L	JumL|L14	Gaji|L18	W	Msia|W	Pati|W	JumW|W14	Gaji|W18
	if (in_array($key, array('Gaji|L18','Gaji|W18') ) )
	{
		$nisbah = ($gaji_dulu==0 || $data==0) ? 0 :(($data / $gaji_dulu) * 100);
		$value = number_format($nisbah,2,'.',',') . '%';
		$kini = ($gaji_dulu==0 || $data==0) ? 0 : (($data / $gaji_dulu) * $gaji_kini);
		$nilai_kini = number_format($kini,0,'.',',') . '';
		
		$papar = ($data==0) ? '' : " $purataGaji <br>"
				. " dulu = $data |  " . $value . '<br>'
				. " kini = ($data / $gaji_dulu) x $gaji_kini) = " . ($nilai_kini)
				. "";
	}
	else
		$papar = $data;
	
	return '<td align="right">' . "$papar</td>";
}

//echo '<pre>'; print_r($this->borang); echo '</pre>';
if (isset($this->borang['output'])):
	$p = dataProdukKodbahan($perangkaan, $this->kesID);
	foreach ($this->borang as $jadual => $row):
		if ( count($row)==0 ) echo '';
		else
		{
			echo '<div class="tab-pane" id="' . $jadual . '">' . "\r"
				. '<span class="badge badge-success">Analisis data ' 
				. $jadual . dataSyarikat($perangkaan) . "\r"
				. 'Ada ' . count($row) . ' kes </span>'
				. '<table  border="1" class="excel" id="example">';
			$printed_headers = false; # mula bina jadual
			#-----------------------------------------------------------------
			for ($kiraBil=0; $kiraBil < count($row); $kiraBil++)
			{		
					if ( !$printed_headers )#print the headers once:
						$printed_headers = tajukMedan($kiraBil,$row);
					echo '<tbody><tr>' . "\r" . '<td>' . ($kiraBil+1) . '</td>' . "\r";
					$p2 = analisisProdukKodBahan($this->borang, $p, $jadual, $row, $kiraBil);
					echo '</tr></tbody>';
			}
			echo '</table></div>';
		}# if ( count($row)==0 )
	endforeach;
endif;
if (isset($this->staf['teamgenius'])):
	//echo '<pre>'; print_r($this->staf); echo '</pre>';
		foreach ($this->staf as $jadual => $row):
		if ( count($row)==0 ) echo '';
		else
		{
			echo '<div class="tab-pane" id="' . $jadual . '">' . "\r"
				. '<span class="badge badge-success">Analisis data ' 
				. $jadual . dataSyarikat($perangkaan) . "\r"
				. 'Ada ' . count($row) . ' kes </span>'
				. '<table  border="1" class="excel" id="example">';
			$printed_headers = false; # mula bina jadual
			#-----------------------------------------------------------------
			for ($kiraBil=0; $kiraBil < count($row); $kiraBil++)
			{		
				if ( !$printed_headers ) #print the headers once:
					$printed_headers = tajukMedan($kiraBil,$row);
				echo '<tbody><tr>' . "\r" . '<td>' . ($kiraBil+1) . '</td>';
				foreach ( $row[$kiraBil] as $key=>$data ) :
					//echo '<td align="right">' . "$data</td>";
					echo dataGaji($perangkaan, $key, $data, $row, $kiraBil);
				endforeach;				
				echo '</tr></tbody>';
			}
			echo '</table></div>';
		}# if ( count($row)==0 )
	endforeach;

endif;
echo "\n\r"; ?>
<!-- Analisis data this->kod_aset -->
<?php 
//echo '<pre>'; print_r($this->kod_aset); echo '</pre>';
foreach ($this->kod_aset as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Analisis data <?php echo $myTable . dataSyarikat($perangkaan) ?>|
	D: Data Tahun Lepas, SI : Peratus Susutnilai, H: Peratus Dari Jumlah Harta, A: Anggaran</span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table  border="1" class="excel" id="example">
<?php  
	$printed_headers = false; # mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{
		//print the headers once: 	
		if ( !$printed_headers ) 
			tajukMedan($kira,$row);
		$printed_headers = true;
	#-----------------------------------------------------------------?>
<tbody><tr>
<td><?php echo $kira+1 ?></td>	
<?php 	foreach ( $row[$kira] as $key=>$data ) :?>
<td align="right"><?php echo (in_array($key, 
			array('thn','Estab','F3001','Commodity'))) ? 
			$data : semakJenis($sv, $key, $data) ?></td>
<?php 	endforeach ?>
</tr></tbody>
<?php
	}
#-----------------------------------------------------------------?></table>
<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>

data2 lain
<?php include 'analisis_proses_data.php'; ?>
<?php } // $this->carian=='sidap' - tamat ?>