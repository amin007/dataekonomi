<h1>Cari Imej Pada Senarai Kawalan</h1>
<?php 
//echo '<pre>$this:'; print_r($this) . '</pre>'; 
//echo '<pre>$_POST:'; print_r($_POST) . '</pre>'; 
//echo '<pre>$this->cariNama:'; print_r($this->cariNama) . '</pre>';
//echo '<pre>$this->carian:'; print_r($this->carian) . '</pre>';
?>

Anda mencari <?php echo $this->carian ?><hr>
<?php
foreach ($this->cariNama as $myTable => $row)
{// mula ulang $row
	
	if ( count($row)==0 ): echo '';
	else:?>
	
	<table  border="1" class="excel" id="example">
	<?php // mula bina jadual
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
	<td><?php pautan($paparID) ?></td>
	</tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
<?php
	endif;
}// tamat ulang $row
?>

<?php 
function pautan($paparID)
{
	$ssm = !isset($paparID['ssm']) ? '000000000000' : $paparID['ssm'];
	$id  = !isset($paparID['id'])  ? '000000000000' : $paparID['id'];

	$p = array(
		'imejSSM' => '../cimej/imej/ssm/' . $ssm,
		'imejNewss' => '../cimej/imej/newss/' . $id,
		'kawalan' => '../ckawalan/ubah/' . $ssm,
		'imej' => '../cimej/imej/' . $ssm,
	);
	$proses = array (
		//'surveyAm <-2009' => '../cprosesan/ubah/' . $ssm . '/2004/2009',
		//'surveyAm 2010->' => '../cprosesan/ubah/' . $id . '/2010/2012',
		'survey205 2004-2006' => '../cprosesan/ubah/205/' . $ssm . '/2004/2006',
		'survey205 2007-2009' => '../cprosesan/ubah/205/' . $ssm . '/2007/2009',
		'survey205 2010-2012' => '../cprosesan/ubah/205/' . $id . '/2010/2012',
		'survey206 2010-2012' => '../cprosesan/ubah/206/' . $id . '/2010/2012',
		'survey328 2010-2012' => '../cprosesan/ubah/328/' . $id . '/2010/2012',
		'survey334 2010-2012' => '../cprosesan/ubah/334/' . $id . '/2010/2012',
		'survey335 2010-2012' => '../cprosesan/ubah/335/' . $id . '/2010/2012',
		'survey800 2010-2012' => '../cprosesan/ubah/800/' . $id . '/2010/2012',
		'survey850 2010-2012' => '../cprosesan/ubah/850/' . $id . '/2010/2012',
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
		echo $data2 ?>"><?php echo $key2 ?></a></li><?php
		endforeach;
	?></ul></div><?php
}
