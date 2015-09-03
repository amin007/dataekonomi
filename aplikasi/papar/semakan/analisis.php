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
		$senaraiJadual = array($sv . '_q08_2010','s' . $sv . '_q08_2010',
			$sv . '_q09_2010', 's' . $sv . '_q09_2010');
		$senaraiJadual2 = array('s' . $sv . '_q02_2010','s' . $sv . '_q03_2010');
		
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
				$nilai_dulu = ($hasil_dulu==0) ? 0 :(($data / $hasil_dulu) * 100);
				$value = number_format($nilai_dulu,4,'.',',') . '%';
				$hasilProduk = ($data / $hasil_dulu) * $hasil_kini;
			}
			elseif (in_array($key, array('F2101') ) )
			{
				$nilai_dulu = ($belanja_dulu==0) ? 0 :(($data / $belanja_dulu) * 100 );
				$value = number_format($nilai_dulu,4,'.',',') . '%';
				$kosBahan = ($data / $belanja_dulu) * $belanja_kini;

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
}
function tajukMedan2($kira,$row)
{
	$papar = "<thead><tr>\r<th>#</th>";
		foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) 
			$papar .= "<th>$tajuk</th>";
		endforeach;
	$papar .= "</tr></thead>";
}

function analisisProdukKodbahan($p, $borang)
{
	//echo "\$produk " . $p['produk'] . ",\$kosBahan " . $p['kosBahan'] . "<br>";
	//echo '<pre>'; print_r($borang); echo '</pre>';
	/*[output][0][F22]
			$key F22 $data
			$key F23 $data
			$key F24 $data 168
			$key F25 $data 37572-113856
			$key F26 $data 0-0
			$key F27 $data 0-0
			$key kodUnit $data 7
			$key kodProduk $data 62599903072-2599903072

	//[input][0][F22]
	
			$key F22 $data 3002
			$key F23 $data 13667-48810
			$key kodUnit $data 23
			$key kodProduk $data 72410101002-2410101002
	*/
	$jumNilai = 0;
	$kiniP = (int)$p['produk'];
	$papar = '<table  border="1" class="excel" id="example">';
	foreach ($borang as $jadual => $row):
	$printed_headers = false; # mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{
		//print the headers once: 	
		if ( !$printed_headers ) 
			$papar .= tajukMedan2($kira,$row);
		$printed_headers = true;

		foreach($row[$kira] as $key=>$data): 
			//echo "\$key $key \$data $data<br>";
			if ($jadual=='output' && $key=='F25'):
				list($dulu,$jum) = explode('-',$data);
				
				//$nilai_dulu = ($jum==0) ? 0 :(($dulu / $jum) * 100);
				$nisbah = ($jum==0) ? 0 :($dulu / $jum);
				$value = number_format($nisbah,2,'.',',') . '%';
				$anggar = ($dulu / $jum) * $kiniP;
				$jumNilai += floor($anggar * 1) / 1;
				$nilai_kini = floor($anggar * 1) / 1;
		
				$papar .= "<tr><td>dulu / jum $value </td><td>
				($dulu / $jum) x $kiniP = " . $nilai_kini . " | $jumNilai
				</td></tr>
				";

			endif;
		endforeach;
	}
	endforeach;

	$produk = $p['produk'];
	$papar .= "<tr><td> $produk = $produk </td><td> \$jumNilai = $jumNilai </td></tr>";
	$papar .= '<table>';
	return $papar;
}
//analisisProdukKodbahan($perangkaan, $this->kesID, $this->papar->borang);
$p = dataProdukKodbahan($perangkaan, $this->kesID);
$p2 = analisisProdukKodbahan($p, $this->borang);
echo $p2;
//echo '<pre>'; print_r($p); echo '</pre>';

?>
<!-- Analisis data this->kod_aset -->
<?php 
foreach ($this->kod_aset as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Analisis data <?php echo $myTable ?>|
	D: Data Tahun Lepas, SI : Peratus Susutnilai, H: Peratus Dari Jumlah Harta, A: Anggaran</span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table  border="1" class="excel" id="example">
<?php $printed_headers = false; # mula bina jadual
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

<?php } // $this->carian=='sidap' - tamat ?>