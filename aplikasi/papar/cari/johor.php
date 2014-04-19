<div class="alert alert-dismissable alert-info">
<h1>Senarai Localiti Johor</h1>Anda mencari<?php 
//echo '<br>$this->carian:'; print_r($this->carian);
//echo '<br>$this->cariNama:'; print_r($this->cariNama);
$cari = ' <font color="red">';
foreach ($this->carian as $kunci => $nilai)
{
	$cari .= ( count($nilai)==0 ) ?
	$nilai : $nilai . ' | </font>';
}
echo "$cari\r<br>Jadual<br>";
//echo "\r" . '$this->cariNama:'; print_r($this->cariNama);
foreach ($this->cariNama as $key => $value)
{
	echo ( count($value)==0 ) ?	$key . ' Kosong<br>' 
	: $key . ' Ada <span class="badge">' . count($value) . '</span><br>';
}
?>
</div>

<?php
//$papar = 'bawah';
$papar = 'lintang';

if ($papar=='bawah')
{// if ($papar=='bawah')
?>

<?php
foreach ($this->cariNama as $myTable => $row)
{// mula ulang $row
/////////////////////////////////////////////////////////////////
?>
<table  border="1" class="excel" id="example">
<?php
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	//print the headers once: 	
	if ( !$printed_headers ) 
	{	?><thead><tr>
<th>#</th>
<?php	foreach ( array_keys($row[$kira]) as $tajuk ) 
		{ 	// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
			if ( !is_int($tajuk) ) 
			{ 
				?><th><?php echo (($tajuk=='nama') ?
				$tajuk . ' (jadual:' . $myTable . ')'
				: $tajuk) ?></th>
<?php		} 
		}?></tr></thead>
<?php	$printed_headers = true; 
	} 
#-----------------------------------------------------------------		 
	//print the data row 
	?><tbody><tr<?php echo ($kira % 2==0) ? ' class="success"' : ' class="warning"' ?>>
<td><?php echo $kira+1 ?></td>	
<?php foreach ( $row[$kira] as $key=>$data ) :
	?><td><?php echo $data ?></td>
<?php endforeach; ?></tr></tbody>
<?php
}
#-----------------------------------------------------------------
?>
</table>

<?php
////////////////////////////////////////////////////////////////////
}// tamat ulang $row
?>

<?php
}// if ($papar=='bawah')
else 
{// if ($papar!='bawah')	
?>
<div class="tabbable tabs-top">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#cari" data-toggle="tab">Cari...</a></li>
<?php 
foreach ($this->cariNama as $jadual => $baris)
{
	if ( count($baris)==0 )	echo '';
	else
	{?><li><a href="#<?php echo $jadual; ?>" data-toggle="tab"><?php echo $jadual 
	?><span class="badge"><?php echo count($baris)?></span></a></li>
<?php
	}
}
?>	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="cari">
	<p>Mencari <?php echo $cari ?> ya<br>
	<img src="<?php echo HALAMAN ?>peta_ngdbbp.jpg"></p>
	</div>
	<?php 
foreach ($this->cariNama as $myTable => $row)
{
	if ( count($row)==0 )
	{
		echo '';
	}
	else
	{?>	
	<div class="tab-pane" id="<?php echo $myTable ?>">
	<p>Anda berada di <?php echo $myTable ?>.</p>
<!-- Jadual <?php echo $myTable ?> ########################################### -->	
<table class="table table-bordered table-hover">
<?php
// <table border="1" class="excel" id="example">
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{	//print the headers once: 	
	if ( !$printed_headers ) 
	{	?><thead><tr>
<th>#</th>
<?php	foreach ( array_keys($row[$kira]) as $tajuk ) 
		{ 	// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
			if ( !is_int($tajuk) ) 
			{ 
				?><th><?php echo (($tajuk=='nama') ?
				$tajuk . ' (jadual:' . $myTable . ')'
				: $tajuk) ?></th>
<?php		} 
		}?></tr></thead>
<?php	$printed_headers = true; 
	} 
#-----------------------------------------------------------------		 
	//print the data row 
	?><tbody><tr<?php echo ($kira % 2==0) ? ' class="success"' : ' class="warning"' ?>>
<td><?php echo $kira+1 ?></td>	
<?php foreach ( $row[$kira] as $key=>$data ) :
	?><td><?php echo $data ?></td>
<?php endforeach; ?></tr></tbody>
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
</div>
</div> <!-- /tabbable -->

<?php
}// if ($papar!='bawah')
?>