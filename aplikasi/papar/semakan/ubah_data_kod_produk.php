<?php 
//echo '<pre>$this->kod_produk=' . print_r($this->kod_produk, 1) . '</pre>';
$cari = 'kod_produk'; if (isset($this->kod_produk)) : ?>
<hr><span class="badge">Jadual Kod</span>
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
	</span></a></li><?php
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
# mula bina jadual
	$io = array('thn','Batch','Estab'/*,'nama_produk'*/,'Commodity',
	'F3001','%export F28','nama','kod');
	$jadual= array('q14_2010','q15_2010','harta_q04_2010','harta_s'.$this->sv.'_q04_2010','pekerjaan');
	$jum = count($row);	
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	if (isset($row[$kira])): # print the headers once: 
		if ( !$printed_headers ):?><thead><tr><th>#</th><?php
		foreach ( array_keys($row[$kira]) as $tajuk ) : 
			if ( !is_int($tajuk) ) ?><th><?php 
			echo BorangPapar::pilihTajuk($tajuk, $myTable); ?></th><?php
		endforeach ?></tr></thead><?php
			$printed_headers = true; 
		endif; echo "\r\t";
#-print the data row----------------------------------------------
?><tbody><tr>
	<td><?php echo $kira+1 ?></td>
	<?php foreach ( $row[$kira] as $key=>$data ) :?>
	<td align="right"><?php
	$papar = (in_array($key, $io)) ? 
		$data : BorangPapar::semakJenis($this->sv, $key, $data);
	list($f25,$jum) = ($myTable=='output') ? 
		explode('-',$row[$kira]['F25']): array('x','x');
	if (in_array($myTable, $jadual)):
		echo $papar;
	else:
		echo BorangPapar::inputText2($kira, $jum, $io, $myTable, $key, $data);
	endif;
?></td>
	<?php endforeach ?>
	</tr></tbody>
<?php
	else:echo '<tbody><tr>' . "\r" . '<td colspan=10>'
		. " $kira $key $data "
		. '</td></tr></tbody>';

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
<?php endif; # if (isset($this->kod_produk)) :?>