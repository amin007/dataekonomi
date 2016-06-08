<?php
if ($this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan: data kosong </span></h1>';
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian; 
	$ID = $this->paparID; 
	$tahun = $this->thn_mula . ' hingga ' . $this->thn_akhir;
	$paparKesID = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir . '/cetak';
	$paparKesID2 = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir . '';
	$tajuk = 'Prosesan' . $this->sv . ' : Dari tahun ' . $tahun;
	$cetak = URL . $this->kelas . 'ubah/' . $this->sv . '/' . $paparKesID;
	$semakan = URL . 'semakan/ubah/' . $this->sv . '/' . $paparKesID2;
	$mencari = URL . $this->kelas . 'ubahCetak/' . $this->sv;
	$senaraiMedan = array('thn','Estab','F0002','F0014','F0015');
	//echo '$cetak:' . $cetak . '|$mencari:' . $mencari;
	//echo '<pre>205::$this->kod_produk='; print_r($this->kod_produk) . '<pre>';
?>
<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<span class="badge"><?php echo $tajuk ?></span>
<a href="<?php echo $cetak ?>"><span class="badge"><i class="glyphicon glyphicon-print"></i>Cetak</span></a>
<a href="<?php echo $semakan ?>"><span class="badge"><i class="glyphicon glyphicon-print"></i>Semakan</span></a>
<input type="text" name="cari" size="40" value="<?=$ID;?>">
<font size="5" color="red">&rarr;</font>
<input type="submit" value="mencari">
</form></div>

<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari...</span></a></li>
<?php 
	foreach ($this->kesID as $jadual => $baris):
		if ( count($baris)==0 ): echo '';
		else:?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="badge badge-success">Jadual <?php echo $jadual ?></span></a></li>
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
	else
	{?>
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
	<?php paparData($this->sv, $myTable, $row, $this->keterangan, $senaraiMedan)?>	
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>
</div>
</div> <!-- /tab-content -->
<hr>
<span class="badge">Jadual Kod <?php $cari = 'kod_produk';
//echo '<pre>$this->kod_produk=' . print_r($this->kod_produk, 1) . '</pre>'; ?></span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari ...</span></a></li>
<?php 
foreach ($this->kod_produk as $jadual => $baris)
{
	if ( count($baris)==0 ) echo '';
	else {?>	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="badge badge-success"><?php echo $jadual ?></span></a></li>
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
	<?php paparKodProduk($this->sv, $myTable, $row); ?>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>
</div>

</div> <!-- /tab-content -->
<?php
if ( isset($this->output) && isset($this->input) )
{
	?><hr><pre><?php
	$Output = kira($this->output);
	$Input = kira($this->input);
	$NilaiTambah = kira($this->output - $this->input);
	$NilaiIO = ($Input == 0) ? 0 : kiraPerpuluhan( ($this->input/$this->output) , 4);

	echo 'Nilai Output : ' . $Output . '<br>';
	echo 'Nilai Input : ' . $Input . '<br>';
	echo 'Nilai Tambah : ' . $NilaiTambah . '<br>';
	echo 'Nilai IO : ' . $NilaiIO. '<br>';
	?></pre><?php
}
?>

<?php } // $this->carian=='sidap' - tamat ?>