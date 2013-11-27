<?php 
//print_r($this->url);
//print_r($this->cariApa); 
//print_r($this->carian); 

if ($this->carian=='[id:0]')
	echo 'data kosong<br>';
else
{ // $this->carian=='sidap' - mula
$cari = $this->carian;
?>

<div class="tabbable tabs-left">
	<ul class="nav nav-tabs putih">
<?php 
foreach ($this->cariApa as $jadual => $baris)
{
	if ( count($baris)==0 )
		echo '';
	else
	{
	?>
	<li><a href="#<?php echo $jadual ?>" data-toggle="tab"><?php echo $jadual ?></a></li>
<?php
	}
}
?>	</ul>
<div class="tab-content">
<?php 
foreach ($this->cariApa as $myTable => $row)
{
	if ( count($row)==0 )
		echo '';
	else
	{
		$mula2 = ($jadual=='rangka') ? ' active' : '';
	?>
	<div class="tab-pane<?php echo $mula2?>" id="<?php echo $myTable ?>">
	<!--<p>Jadual </p>-->
<!-- Jadual <?php echo $myTable ?> ########################################### -->	
<table border="1" class="excel" id="example">
<?php
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{
	//print the headers once: 	
	if ( !$printed_headers ) 
	{
		?><thead><tr><th>#</th><?php
		foreach ( array_keys($row[$kira]) as $tajuk ) 
		{ 
			// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
			if ( !is_int($tajuk) ) 
			{ 
				?><th><?php echo $tajuk ?></th><?php
			} 
		}
		?><th><?php echo $myTable ?></th></tr></thead>
<?php
		$printed_headers = true; 
	} 
#-----------------------------------------------------------------		 
	//print the data row 
	?><tbody><tr><?php
	foreach ( $row[$kira] as $key=>$data ) 
	{		
		if ($key=='newss')
		{
			$id = $data; 
			$p0 = $p1 = URL . 'prosesan/ubah/' . $id;
			?><td><?php echo $kira+1 ?>)<a href="<?php echo $p0 ?>">Proses</a></td><?php
		}
		else
			?><td><?php echo $data ?></td><?php
	} 

	$p1 = URL . 'prosesan/ubah/' . $id;
	//$p2 = URL . 'prosesan/buang/' . $id;
	$p3 = URL . 'prosesan/cetak/' . $id;
	//<a href="$p2" class="btn btn-danger btn-mini">
	//<i class="icon-trash icon-white"></i> Buang</a>
	?><td><a href="<?php echo $p1 ?>" class="btn btn-primary btn-mini"><i class="icon-pencil icon-white"></i>Ubah</a><a href="<?php echo $p3 ?>" class="btn btn-success btn-mini"><i class="icon-print icon-white"></i>Cetak</a></td></tr></tbody>
<?php
}
#-----------------------------------------------------------------
?>
</table>

<!-- Jadual <?php echo $myTable ?> ########################################### -->		
	</div>
<?php
	} // if ( count($row)==0 )
}
?>	
</div><!-- class="tab-content" -->
</div><!-- /tabbable -->

<?php } // $this->carian=='sidap' - tamat ?>