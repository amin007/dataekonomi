<h1><span style="background-color:black;color:white">Senarai Kes Kawalan Operasi</span></h1>
<?php 
//echo '<pre>$this->cariNama:'; print_r($this->cariNama) . '</pre>';
//echo '<pre>$this->carian:'; print_r($this->carian) . '</pre>';
//echo '<pre>$this->apa:'; print_r($this->apa) . '</pre>';
	
// setkan pembolehubabh
$cari = $this->carian . '=' . $this->apa; ?>
Anda mencari <?php echo $cari ?><hr>
<?php
foreach ($this->cariNama as $myTable => $row)
{// mula ulang $row
?>
	<table  border="1" class="excel" id="example">
	<?php
	// mula bina jadual
	$printed_headers = false; 
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	//print the headers once: 	
		if ( !$printed_headers ) : ?><thead><tr>
	<th>#</th>
	<?php	foreach ( array_keys($row[$kira]) AS $tajuk ) : 
			// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
				if ( !is_int($tajuk) ) :
					?><th><?php echo $tajuk ?></th>
	<?php		endif;
			endforeach;
	?><th>Jadual:<?php echo $myTable ?></th>
	</tr></thead><?php 
			$printed_headers = true; 
		endif;
	#-----------------------------------------------------------------		 
		//print the data row ?>
	<tbody><tr>
	<td><?php echo $kira+1 ?></td><?php
		foreach ( $row[$kira] AS $key=>$data ) :
			if ($key=='sidap')
				$ssm = substr($data,0,12); ?>
	<td><?php echo $data ?></td><?php
		endforeach;	?>
	<td><?php	
		$p = array(
			'kawalan' => '../ckawalan/ubah/' . $ssm,
			'imej' => '../cimej/imej/' . $ssm,
			'prosesan' => '../cprosesan/ubah/' . $ssm,
			'tahun' => '../cprosesan/tahun/' . $ssm
			);

		foreach ( $p AS $key=>$data ) :
			//echo '$key='.$key.' | $data='.$data.'|<br>';
			?><a target="_blank" href="<?php echo $data 
			?>" class="btn btn-info btn-mini"><?php echo $key 
			?></a><?php
		endforeach;
		?></td>
	</tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
<?php
}// tamat ulang $row
?>