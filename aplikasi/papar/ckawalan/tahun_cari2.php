<h1><span style="background-color:black;color:white">Senarai Kes Kawalan Operasi</span></h1>
<?php 
//echo '<pre>$this->cariNama:'; print_r($this->cariNama) . '</pre>';
//echo '<pre>$this->carian:'; print_r($this->carian) . '</pre>';
//echo '<pre>$this->apa:'; print_r($this->apa) . '</pre>';
	
if ($this->carian=='[id:0]')
	echo 'Maaf data yang anda cari tiada dalam maklumat kami.<br>';
else
{ # $this->carian - mula
	# setkan pembolehubah
	$cari = $this->carian . '=' . $this->apa; ?>
Anda mencari <?php echo $cari ?><hr>
<?php
foreach ($this->cariNama as $myTable => $row)
{# mula ulang $row ?>
	<table  border="1" class="excel" id="example">
	<?php
	$printed_headers = false; # mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	# print the headers once:
		if ( !$printed_headers ) : ?><thead><tr>
	<th>#</th>
	<?php	foreach ( array_keys($row[$kira]) AS $tajuk ) : 
			# anda mempunyai kunci integer serta kunci rentetan
			# kerana cara PHP mengendalikan tatasusunan.
			?><th><?php echo $tajuk ?></th>
	<?php	endforeach; ?>
	</tr></thead><?php $printed_headers = true; 
		endif;
	#-----print the data row------------------------------------------------?>
	<tbody><tr>
	<td><?php echo $kira+1 ?></td><?php
		foreach ( $row[$kira] AS $key=>$data ) : ?>
	<td><?php echo $data ?></td><?php
		endforeach;	?>	
	</tr></tbody>
	<?php
	}#-----------------------------------------------------------------?>
	</table>
<?php
}# tamat ulang $row
?>

<?php } # $this->carian - tamat ?>