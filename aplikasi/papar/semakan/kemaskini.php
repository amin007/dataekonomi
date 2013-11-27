<?php

function analisisK($perangkaan, $jadual, $key, $data)
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
		$name = 'name="' . $sv . '_' . $jadual . '[' . $key . ']"';
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
		$name = 'name="' . $jadual . '[' . $key . ']"';

	}
	// istihar pembolehubah 
	$input = '<input type="text" ' . $name . ' value="' 
		   . $data . '" class="input-large">' . $value;
	return '<td>' . $input . '</td>' . "\r";
}

if ($this->carian=='[id:0]')
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
	//echo '$cetak:' . $cetak . '|$mencari:' . $mencari;
	//echo '<pre>205::$this->kod_produk='; print_r($this->kod_produk) . '<pre>';
?>
<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<span class="badge"><?php echo $tajuk ?></span>
<a href="<?php echo $cetak ?>"><span class="badge"><i
 class="icon-print icon-white"></i>Cetak</span></a>
<input type="text" name="cari" size="40" value="<?=$ID;?>">
<font size="5" color="red">&rarr;</font>
<input type="submit" value="mencari">
</form></div>

<hr><form method="post" action="<?php echo URL;?>anggaran/ubahSimpan/">
<?php //$cari = 'data_proses'; 
$buangJadual = array(/*'kodOutput','kodInput',*/'semasa'); ?>
<span class="badge">Jadual Prosesan</span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari...</span></a></li>
<?php 
	foreach ($this->kesID as $jadual => $baris):
		if ( count($baris)==0 ): echo '';
		elseif (in_array($jadual,$buangJadual)) : echo '';
		else:?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="label label-success"><?php echo $jadual ?>
	</a></li>
<?php
		endif;
	endforeach;
?>	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="<?php echo $cari ?>">
	<span class="badge badge-success">Mencari <?php echo $cari ?> ya</span>
	</div>
	<?php 
foreach ($this->kesID as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	elseif (in_array($myTable,$buangJadual)) echo '';
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="label label-success">Anda berada di <?php echo $myTable ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table><tr><?php
	// mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	//print the data row ?>
		<td valign="top">
		<table border="1" class="excel" id="example"><?php 
		foreach ( $row[$kira] as $key=>$data ) : 
			$thn = ($key=='thn') ? $data : 2010; 
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
			$keteranganMedan= '<abbr title="' . $keterangan . '">'
				. inputTextMedan($myTable, $key) . '</abbr>';
			if (in_array($key, array('thn','Batch','Estab') ) ):
				echo '';
			else:?>
		<tr>
		<td><?php echo $keteranganMedan ?></td>
		<td align="right"><?php 
		echo (in_array($key, $senaraiMedan)) ? 	$data 
		: semakJenis($this->sv, $key, $data); ?></td>
		<?php echo inputText($myTable, $key, $data) ?>
		</tr><?php endif; endforeach; ?>
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
</div>  <!-- /tab-content-top line:96-->
</div> <!-- /tabbable tabs-top line:80-->

<!-- kawasan button dan nilai2 ditambah kemudian -->
<?php if ($this->sv != null): ?>
<hr><div align="center"><table>
<?php
// papar data semasa
foreach ( $this->kesID['semasa'][0] AS $key=>$data ) :
	if ($key=='catatan'): $catatan = $data;
	else:
		?><tr><td align="right"><input type="text" name="medan[semasa][<?php echo $key 
		?>]" value="<?php echo $key ?>" class="input-medium"></td><?php
		?><td><input type="text" name="semasa[<?php echo $key 
		?>]" value="<?php echo $data ?>" class="input-medium"></td><?php
		echo "<td>$data</td></tr>\r";
	endif;

endforeach; 

if ($catatan == null):
	?><tr><td align="right"><input type="text" 
	name="medan[semasa][catatan]" value="catatan" class="input-mini"></td>
	<td><textarea name="semasa[catatan]" rows="6" cols="40" 
	placeholder="Sila masukkan catatan"></textarea></td><?php
	echo "</tr>\r";
else:
	?><tr><td align="right"><input type="text" 
	name="medan[semasa][catatan]" value="catatan" class="input-mini"></td>
	<td><textarea name="semasa[catatan]" rows="5" cols="30" 
	placeholder="Sila kemaskini catatan"><?php echo $catatan;
	?></textarea></td><?php
	echo "<td>$catatan</td></tr>\r";
endif;

?>
<tr><td align="center" colspan="3">
	<?php if (Sesi::get('namaPegawai')=='amin007') :?>
	<input type="submit" name="Simpan" value="Ubah" class="btn btn-primary btn-large">
	<?php endif?>
	<input type="submit" name="Simpan" value="Kira" class="btn btn-primary btn-large">
</td></tr>
</table></form></div>
<?php endif?>
<?php } // $this->carian=='sidap' - tamat ?>