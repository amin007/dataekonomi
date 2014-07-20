<h1><span style="background-color:black;color:white">Senarai Kes Kawalan Operasi</span></h1>
<?php 
//echo '<pre>$this->cariNama:'; print_r($this->cariNama) . '</pre>';
//echo '<pre>$this->carian:'; print_r($this->carian) . '</pre>';
//echo '<pre>$this->apa:'; print_r($this->apa) . '</pre>';
	
if ($this->carian=='[id:0]')
	echo 'Maaf data yang anda cari tiada dalam maklumat kami.<br>';
else
{ // $this->carian - mula
	// setkan pembolehubah
	$cari = $this->carian . '=' . $this->apa;
?>
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
			if ($key=='sidap'):
				$paparID['ssm'] = substr($data,0,12); 
			elseif ($key=='newss'):
				$paparID['id'] = substr($data,0,12); 
			endif; ?>
	<td><?php echo $data ?></td><?php
		endforeach;	?>	
	<td><?php pautan($paparID, $myTable) ?></td>
	</tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
<?php
}// tamat ulang $row
?>

<?php } // $this->carian - tamat ?>
<?php
function pautan($paparID, $jadual)
{
	$ssm = !isset($paparID['ssm']) ? '000000000000' : $paparID['ssm'];
	$id  = !isset($paparID['id'])  ? '000000000000' : $paparID['id'];
	$kawalNewss = array('sse2010_kawal','alamat_newss_2013');
	$kawalID = (in_array($jadual, $kawalNewss)) ? $id : $ssm;
	$p = array(
		'kawalan' => '../ckawalan/ubah/' . $kawalID,
		'semakan' => '../semakan/ubah/205/' . $id . '/2010/2012',
		'anggaran' => '../anggaran/semak/' . $id,		
		//'imej' => '../cimej/imej/' . $ssm,
		//'tahun sv205' => '../cprosesan205/tahun/' . $ssm
		);
	$proses = array (
		//'surveyAm <-2009' => '../cprosesan/ubah/' . $ssm . '/2004/2009',
		//'surveyAm 2010->' => '../cprosesan/ubah/' . $id . '/2010/2012',
		'205 <-2009' => '../cprosesan/ubah/205/' . $ssm . '/2004/2009',
		' CDT 2009->' => '../cprosesan/ubah/cdt/' . $ssm . '/2004/2013',
		' ICDT 2012->' => '../cprosesan/ubah/icdt/' . $id . '/2004/2013',
		//'survey205 2004-2006' => '../cprosesan/ubah/205/' . $ssm . '/2004/2006',
		//'survey205 2007-2009' => '../cprosesan/ubah/205/' . $ssm . '/2007/2009',
		'205 2010-2012' => '../cprosesan/ubah/205/' . $id . '/2010/2012',
		'206 2010-2012' => '../cprosesan/ubah/206/' . $id . '/2010/2012',
		'305 2010-2012' => '../cprosesan/ubah/305/' . $id . '/2010/2012',
		'306 2010-2012' => '../cprosesan/ubah/306/' . $id . '/2010/2012',
		'308 2010-2012' => '../cprosesan/ubah/308/' . $id . '/2010/2012',
		'311 2010-2012' => '../cprosesan/ubah/311/' . $id . '/2010/2012',
		'312 2010-2012' => '../cprosesan/ubah/312/' . $id . '/2010/2012',
		'316 2010-2012' => '../cprosesan/ubah/316/' . $id . '/2010/2012',
		'328 2010-2012' => '../cprosesan/ubah/328/' . $id . '/2010/2012',
		'331 2010-2012' => '../cprosesan/ubah/331/' . $id . '/2010/2012',
		'334 2010-2012' => '../cprosesan/ubah/334/' . $id . '/2010/2012',
		'335 2010-2012' => '../cprosesan/ubah/335/' . $id . '/2010/2012',
		'800 2010-2012' => '../cprosesan/ubah/800/' . $id . '/2010/2012',
		'850 2010-2012' => '../cprosesan/ubah/850/' . $id . '/2010/2012',
		);

	foreach ( $p AS $key=>$data ) :
		//echo '$key='.$key.' | $data='.$data.'|<br>';
		?><a target="_blank" href="<?php echo $data 
		?>" class="btn btn-info btn-mini"><?php echo $key ?></a><?php
	endforeach;
	?><div class="btn-group">
	<button class="btn dropdown-toggle btn-mini" data-toggle="dropdown">
	Data Prosesan<span class="caret"></span></button>
	<ul class="dropdown-menu"><?php 	
		foreach ( $proses AS $key2=>$data2 ):?>
		<li><a target="_blank" href="<?php 
		echo $data2 ?>">survey<?php echo $key2 ?></a></li><?php
		endforeach;
	?></ul></div><?php
}
?>