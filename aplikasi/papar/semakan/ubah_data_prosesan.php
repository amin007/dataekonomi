<hr><?php $cari = 'data_proses'; 
if (count($this->prosesID)!='0') : ?>
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
		if (in_array($myTable,array('q08_2010','206_q08_2010','s'.$this->sv.'_q08_2010'))):
			$kiraJumlah = ' id="kirahasil"';
		elseif (in_array($myTable,array('q09_2010','206_q09_2010','s'.$this->sv.'_q09_2010'))):
			$kiraJumlah = ' id="kirabelanja"';
		else:
			$kiraJumlah = '';
		endif;
	?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->
	<table><tr><?php # mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++) # print the data row
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
			$data : BorangPapar::semakJenis($this->sv, $key, $data) ?></td>
		<?php $jadualAnalisa = array('q04_2010','q08_2010','q09_2010',
			's'.$this->sv.'_q02_2010','s'.$this->sv.'_q03_2010',
			'206_q08_2010','206_q09_2010','s'.$this->sv.'_q04_2010',
			's'.$this->sv.'_q07_2010','s'.$this->sv.'_q08_2010','s'.$this->sv.'_q09_2010');

			echo (in_array($myTable, $jadualAnalisa ) ) ?
				analisis($this->perangkaan, $this->ppt, $myTable, $key, $data)
				: BorangPapar::inputText('proses', $key, $data); ?>
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
<?php endif; # if (count($this->prosesID)) :?>
