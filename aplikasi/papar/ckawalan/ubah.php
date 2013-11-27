<h1>Kawalan: Terperinci</h1>
<?php 
//print_r($this->kesID); 
//print_r($this->carian); 

if ($this->carian=='[id:0]')
{
	echo 'data kosong<br>';
}
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian;
	/*
	foreach ($this->kesID as $myTable => $row)
	{// mula ulang $row
		require 'ubah_jadual';
	}// tamat ulang $row
	*/
?>
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
	<span class="badge badge-info">Mencari <?php echo $cari ?> ya</span>
	</div>
	<?php 
foreach ($this->kesID as $myTable => $row)
{
	if ( count($row)==0 ) :	echo '';
	else:?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<span class="badge badge-info">Anda berada di <?php echo $myTable ?></span>
	<?php echo papar_jadual($row, $myTable, 3) ?>
	</div>
<?php
	endif; // if ( count($row)==0 )
}
?>	
</div>
</div> <!-- /tabbable -->

<?php } // $this->carian=='sidap' - tamat ?>
