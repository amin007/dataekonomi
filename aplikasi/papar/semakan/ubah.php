<?php

function analisis($perangkaan, $jadual, $key, $data)
{
	// (in_array($jadual, array('q08_2010','q09_2010') ) )
	$sv = $perangkaan['sv'];
	$hasil = $perangkaan['hasil'];
	$belanja = $perangkaan['belanja'];
	$aset = $perangkaan['aset'];
	$sewa = $perangkaan['asetsewa'];
	$noKey = substr($key, 0, 3);
	//echo "<hr>$key : $sewaHarta ";
	
	if (in_array($key, array('thn','batch','Estab') ) )
	{
		$value = $data;
	}
	elseif ($sv=='205') 
	{//untuk survey 205 sahaja
		if ($jadual == 'q04_2010' && $noKey == 'F09') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == 'q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == 'q08_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 'q09_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		$value = number_format($nilai,4,'.',',') . '%';
		$name = 'name="' . $sv . '_' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	elseif ($sv=='206') 
	{//untuk survey 205 sahaja
		if ($jadual == $sv.'_q04_2010' && $noKey == 'F09') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == $sv.'_q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == $sv.'_q08_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == $sv.'_q09_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		$value = number_format($nilai,4,'.',',') . '%';
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	else
	{
		if ($jadual == 's'.$sv.'_q02_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 's'.$sv.'_q03_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		elseif ($jadual == 's'.$sv.'_q04_2010')
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100 );
		$value = number_format($nilai,4,'.',',') . '%';
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';

	}
	// istihar pembolehubah 
	$input = '<input type="text" ' . $name . ' value="' 
		   . $data . '" class="input-large">' . $value;
	return '<td>' . $input . '</td>' . "\r";
}

if ( !isset($this->carian) || $this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan: data kosong </span></h1>';
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian; 
	$ID = $this->paparID; 
	$tahun = $this->thn_mula . ' hingga ' . $this->thn_akhir;
	$paparKesID = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir . '/cetak';
	$tajuk = 'Prosesan' . $this->sv . ' : Dari tahun ' . $tahun;
	$cetak = URL . $this->kelas . 'ubah/' . $this->sv . '/' . $paparKesID;
	$mencari = URL . $this->kelas . 'ubahCetak/' . $this->sv;
	$senaraiMedan = array('thn','Estab','F0002','F0014','F0015');
	$buangJadual = array('q04_2010','q05a_2010','q05b_2010',
		's' . $this->sv . '_q04_2010',
		's' . $this->sv . '_q05a_2010',
		's' . $this->sv . '_q05b_2010',
		'lelaki','wanita');
	//echo '$cetak:' . $cetak . '|$mencari:' . $mencari;
	//echo '<pre>205::$this->kod_produk='; print_r($this->kod_produk) . '<pre>';
	//echo "<hr>perangkaan : " . print_r($this->perangkaan) . "";
?>
<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<span class="badge"><?php echo $tajuk ?></span>
<a href="<?php echo $cetak ?>"><span class="badge"><i
 class="icon-print icon-white"></i>Cetak</span></a>
<input type="text" name="cari" size="40" value="<?=$ID;?>">
<font size="5" color="red">&rarr;</font>
<input type="submit" value="mencari">
</form></div>

<hr>
<form method="post" action="<?php echo URL;?>semakan/simpan/">
<span class="badge">Jadual Kawalan</span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari...</span></a></li>
<?php 
	foreach ($this->kawalID as $jadual => $baris):
		if ( count($baris)==0 ): echo '';
		else:?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="badge badge-success"><?php echo $jadual ?></span></a></li>
<?php
		endif;
	endforeach;
?>	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="<?php echo $cari ?>">
	<span class="badge badge-success">Mencari <?php echo $cari ?> ya</span>
	</div>
	<?php 
foreach ($this->kawalID as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table><tr>
	<?php
	// mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	//print the data row ?>
		<td valign="top">
		<table border="1" class="excel" id="example">
	<?php foreach ( $row[$kira] as $key=>$data ) : 
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
			?><tr>
		<td><abbr title="<?php echo  $keterangan ?>"><?php echo $key ?></abbr></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($this->sv, $key, $data) ?></td>
		<?php echo inputText('kawal', $key, $data) ?>
		</tr><?php endforeach ?>
		</table>
		</td><?php
	}
	#-----------------------------------------------------------------?>
	</tr></table>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>
</div>
</div> <!-- /tab-content -->

<hr>
<?php $cari = 'data_proses'; ?>
<span class="badge">Jadual Prosesan</span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari...</span></a></li>
<?php 
	foreach ($this->prosesID as $jadual => $baris):
		if ( count($baris)==0 ): echo '';
		elseif (in_array($jadual,$buangJadual)): echo '';
		else:?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="badge badge-success"><?php echo $jadual ?></span></a></li>
<?php
		endif;
	endforeach;
?>	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="<?php echo $cari ?>">
	<span class="badge badge-success">Mencari <?php echo $cari ?> ya</span>
	</div>
	<?php 
foreach ($this->prosesID as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	elseif (in_array($myTable,$buangJadual)) echo '';
	else
	{
		if ($myTable == 'q08_2010'):
			$kiraJumlah = ' id="kirahasil"';
		elseif ($myTable == 'q09_2010'):
			$kiraJumlah = ' id="kirabelanja"';
		else:
			$kiraJumlah = '';
		endif;
	?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table><tr><?php // mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++) //print the data row 
	{ echo "\r\t";?><td valign="top">
		<table border="1" class="excel" <?php echo $kiraJumlah ?>><?php 
		foreach ( $row[$kira] as $key=>$data ) : 
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
			if (in_array($key, array('thn','Batch','Estab') ) ): echo '';
			else:echo "\r\t\t";?><tr>
		<td><abbr title="<?php echo  $keterangan ?>"><?php echo $key ?></abbr></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($this->sv, $key, $data) ?></td>
		<?php $jadualAnalisa = array('q04_2010','q08_2010','q09_2010',
			's'.$this->sv.'_q02_2010','s'.$this->sv.'_q03_2010',
			'206_q08_2010','206_q09_2010',
			's'.$this->sv.'_q04_2010');
			echo (in_array($myTable, $jadualAnalisa ) ) ?
			analisis($this->perangkaan, $myTable, $key, $data)
			: inputText('proses', $key, $data) ?>
		</tr><?php endif; endforeach; ?></table>
	</td><?php
	}#-----------------------------------------------------------------?>
	</tr></table>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>
</div>  <!-- /tab-content line:168-->
</div> <!-- /tabbable tabs-top line:154-->

<hr>
<span class="badge">Jadual Kod <?php $cari = 'kod_produk';
//echo '<pre>$this->kod_produk=' . print_r($this->kod_produk, 1) . '</pre>'; ?></span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="label label-success">Cari ...</span></a></li>
<?php 

foreach ($this->kod_produk as $jadual => $baris)
{
	if ( count($baris)==0 ) echo '';
	else
	{?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="label label-success"><?php echo $jadual ?>
	<span class="badge"><?php echo count($baris)?></span>
	</span></a></li>
<?php
	}
}
?>	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="<?php echo $cari ?>">
	<p>Mencari <?php echo $cari ?> ya ...</p>
	</div>
<?php 
foreach ($this->kod_produk as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
<!-- Jadual <?php echo $myTable ?> ########################################### -->	
<table  border="1" class="excel" id="example"><?php
// mula bina jadual
	$io = array('thn','Batch','Estab',/*'nama_produk',*/'Commodity','F3001',
		'nama','kod');
	$jadual= array('q14_2010','q15_2010','harta_q04_2010','pekerjaan');
	$jum = count($row);	
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	if (isset($row[$kira]))://print the headers once: 
		if ( !$printed_headers ):?><thead><tr><th>#</th><?php
		foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) ?><th><?php 
			echo pilihTajuk($tajuk, $myTable); ?></th><?php
		endforeach ?></tr></thead><?php
			$printed_headers = true; 
		endif; echo "\r\t";
#-----------------------------------------------------------------		
//print the data row ?><tbody><tr>
	<td><?php echo $kira+1 ?></td>	
	<?php foreach ( $row[$kira] as $key=>$data ) :?>
	<td align="right"><?php $papar = (in_array($key, $io)) ? 
		$data : semakJenis($this->sv, $key, $data);
		echo (in_array($myTable, $jadual)) ? $papar : 
			inputText2($kira, $jum, $io, $myTable, $key, $data); ?></td>
	<?php endforeach ?>
	</tr></tbody>
<?php
	endif;#if (isset($row[$kira]))
}
#-----------------------------------------------------------------
?></table>
<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>
</div>
</div> <!-- /tab-content -->


<!-- kawasan button dan nilai2 ditambah kemudian -->
<hr><div align="center">
<?php //print_r($this->perangkaan) 
//print_r($this->kod_produk['harta']);
?>
<table>
<?php
// kira IO
if ( isset($this->output) && isset($this->input) )
{
	$Output = kira($this->output);
	$Input = kira($this->input);
	$NilaiTambah = kira($this->output - $this->input);
	$NilaiIO = ($Input == 0) ? 0 : kiraPerpuluhan( ($this->input/$this->output) , 4);

	echo 'Nilai Output : ' . $Output 
		. ' | Nilai Input : ' . $Input
		. ' | Nilai Tambah : ' . $NilaiTambah
		. ' | Nilai IO : ' . $NilaiIO . '<br>';

}

// nilai untuk input2 khas
// $this->kawalID['alamat_newss_2013'][0]['newss']
// $this->kawalID['alamat_newss_2013'][0]['nama']
$perangkaan['newss'] = $ID;
$perangkaan['nama'] = isset($this->perangkaan['nama']) ?
	$this->perangkaan['nama'] : null;
$perangkaan['hasil_dulu'] = isset($this->perangkaan['hasil']) ?
	$this->perangkaan['hasil'] : null;
$perangkaan['belanja_dulu'] = isset($this->perangkaan['belanja']) ? 
	$this->perangkaan['belanja'] : null;
$perangkaan['gaji_dulu'] = isset($this->perangkaan['gaji']) ? 
	$this->perangkaan['gaji'] : null;
$perangkaan['aset_dulu'] = isset($this->perangkaan['aset']) ?
	$this->perangkaan['aset'] : null;
$perangkaan['asetsewa_dulu'] = isset($this->perangkaan['asetsewa']) ?
	$this->perangkaan['asetsewa'] : null;
$semasa = array(
	'sv' => $this->sv,
	'newss' => $perangkaan['newss'],
	'nama' => $perangkaan['nama'] ,
	'hasil_dulu' => $perangkaan['hasil_dulu'],
	'belanja_dulu' => $perangkaan['belanja_dulu'],
	'gaji_dulu' => $perangkaan['gaji_dulu'],
	'aset_dulu' => $perangkaan['aset_dulu'],
	'asetsewa_dulu' => $perangkaan['asetsewa_dulu'],
	'hasil_kini' => 0,
	'belanja_kini' => 0,
	'gaji_kini' => 0,
	'aset_kini' => 0,
	'asetsewa_kini' => 0,
	'catatan' => null,
	);

foreach ( $semasa AS $key=>$data ) :
	if (in_array($key,array('hasil_kini','belanja_kini','gaji_kini','aset_kini','asetsewa_kini',))): echo '';
	else:
		?><tr><td align="right"><?php echo $key ?></td><?php
		if ($key=='catatan'):
		//'<textarea ' . $name . ' rows="1" cols="20">' . $data . '</textarea>';
			?><td valign="center"><textarea name="semasa[<?php echo $key 
			?>]" rows="5" cols="30"><?php echo $data ?></textarea></td><td><?php
			?>Papar Semua Nilai</td><td><select name="paparNilai"><?php
			?><option>Ya</option><option>Tidak</option></select></td><?php
		elseif($key == 'hasil_dulu'):
			?><td><input type="text" name="semasa[hasil_dulu]" value="<?php 
			echo $perangkaan['hasil_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|hasil_kini</td><td><input type="text" name="semasa[hasil_kini]" <?php 
			?> data-formula="SUM($F2001,$F2024)" class="input-large"></td><?php
		elseif($key == 'belanja_dulu'):
			?><td><input type="text" name="semasa[belanja_dulu]" value="<?php 
			echo $perangkaan['belanja_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|belanja_kini</td><td><input type="text" name="semasa[belanja_kini]" value="<?php 
			echo $semasa['hasil_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'gaji_dulu'):
			?><td><input type="text" name="semasa[gaji_dulu]" value="<?php 
			echo $perangkaan['gaji_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|gaji_kini</td><td><input type="text" name="semasa[gaji_kini]" value="<?php 
			echo $semasa['gaji_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'aset_dulu'):
			?><td><input type="text" name="semasa[aset_dulu]" value="<?php 
			echo $perangkaan['aset_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|aset_kini</td><td><input type="text" name="semasa[aset_kini]" value="<?php 
			echo $semasa['aset_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'asetsewa_dulu'):
			?><td><input type="text" name="semasa[asetsewa_dulu]" value="<?php 
			echo $perangkaan['asetsewa_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|asetsewa_kini</td><td><input type="text" name="semasa[asetsewa_kini]" value="<?php 
			echo $semasa['asetsewa_kini'] ?>" class="input-large"></td><?php
		else:
			?><td><input type="text" name="semasa[<?php echo $key 
			?>]" value="<?php echo $data ?>" class="input-large"></td><?php
		endif;
		echo "</tr>\r";
	endif;
	
endforeach; ?>
<tr></tr>
</table>
<?php if (Sesi::get('namaPegawai')=='amin007') :?>
<input type="submit" name="Simpan" value="Simpan" class="btn btn-primary btn-large">
<?php endif?>
<input type="submit" name="Simpan" value="Kira" class="btn btn-primary btn-large">
</div>
</form>
<?php } // $this->carian=='sidap' - tamat ?>