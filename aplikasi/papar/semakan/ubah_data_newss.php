<?php if (count($this->kawalID)!='0') : ?>
<span class="badge">Jadual Kawalan</span>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#<?php echo $cari ?>" data-toggle="tab">
	<span class="badge badge-success">Cari...</span></a></li>
<?php foreach ($this->kawalID as $jadual => $baris): ?>
	<li><a href="#<?php echo $jadual; ?>" data-toggle="tab">
	<span class="badge badge-success"><?php echo $jadual ?></span></a></li>
<?php endforeach; ?>
	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="<?php echo $cari ?>">
	<span class="badge badge-success">Mencari <?php echo $cari ?> ya</span>
	</div>
	<?php 
foreach ($this->kawalID as $myTable => $row)
{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-success">Anda berada di <?php echo $myTable ?></span>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->
	<table><tr><?php
	#--mula bina jadual-----------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{# print the data row ?>
		<td valign="top">
		<table border="1" class="excel" id="example">
		<?php foreach ( $row[$kira] as $key=>$data ) :
			$thn = ($key=='thn') ? $data : 2010;
			$keterangan = !isset($this->keterangan[$myTable][$key][$thn]) ?
				'tiada maklumat' : $this->keterangan[$myTable][$key][$thn];
		?><tr>
		<td><abbr title="<?php echo $keterangan ?>"><?php echo $key ?></abbr></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ?
			$data : BorangPapar::semakJenis($this->sv, $key, $data) ?></td>
		<?php echo BorangPapar::inputText('kawal', $key, $data) ?>
		</tr><?php endforeach ?>
		</table>
		</td><?php
	}
	#-----------------------------------------------------------------?>
	</tr></table>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->
	</div>
<?php
}
?>
</div>
</div> <!-- /tab-content -->
<?php endif; # if (count($this->kawalID)) :?>
