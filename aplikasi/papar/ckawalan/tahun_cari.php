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
	<?php	endforeach;
	?><th>Jadual:<?php echo $myTable ?></th>
	</tr></thead><?php 
			$printed_headers = true; 
		endif;
	#-----print the data row------------------------------------------------?>
	<tbody><tr>
	<td><?php echo $kira+1 ?></td><?php
		foreach ( $row[$kira] AS $key=>$data ) :
			if ($key=='sidap'): $paparID['ssm'] = substr($data,0,12); 
			elseif ($key=='newss'): $paparID['id'] = substr($data,0,12); 
			endif; ?>
	<td><?php echo $data ?></td><?php
		endforeach;	?>	
	<td><?php pautan($paparID, $myTable, $this->levelPegawai) ?></td>
	</tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
<?php
}# tamat ulang $row
?>

<?php } # $this->carian - tamat ?>
<?php
function pautan($paparID, $jadual, $levelPegawai)
{
	$ssm = !isset($paparID['ssm']) ? '000000000000' : $paparID['ssm'];
	$id  = !isset($paparID['id'])  ? '000000000000' : $paparID['id'];
	$kawalNewss = array('sse2010_kawal','alamat_newss_2013');
	$kawalID = (in_array($jadual, $kawalNewss)) ? $id : $ssm;
	$urlClass = '../cprosesan/ubah/';
	$thnLama = '/2004/2013';
	$sse2010 = '/' . $id . '/2010/2015';
	$k = dataK($kawalID, $id, $jadual);
	$p = dataP($urlClass, $id, $ssm, $sse2010);
	$kawal = ( $levelPegawai == 'pegawai') ?
		array(
		'kawalan' => '../ckawalan/ubah/' . $kawalID,
		'Data 205 Pembuatan Tahun Sebelum 2009' => $urlClass . '205/' . $ssm . '/2004/2009',
		'Data 205 Pembuatan Tahun 2010-2015' => $urlClass . '205' . $sse2010
		) : $k;
	$proses = ( $levelPegawai == 'pegawai') ? array() : $p;
	foreach ( $kawal AS $key=>$data ) :
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
		echo $data2 ?>">survey <?php echo $key2 ?></a></li><?php
		endforeach;
	?></ul></div><?php
}

function dataK($kawalID, $id, $kp)
{
	//$kp = '328';
	return array(
		'kawalan' => '../ckawalan/ubah/' . $kawalID,
		'semakan' => '../semakan/ubah/'.$kp.'/' . $id . '/2010/2012',
		'anggaran' => '../anggaran/semak/' . $id,
		//'imej' => '../cimej/imej/' . $ssm,
		//'tahun sv205' => '../cprosesan205/tahun/' . $ssm
	);
}

function dataP($urlClass, $id, $ssm, $sse2010)
{
	return array (		
		//'surveyAm <-2009' => '../cprosesan/ubah/' . $ssm . '/2004/2009',
		//'surveyAm 2010->' => '../cprosesan/ubah/' . $id . '/2010/2012',
		'205 Pembuatan <-2009' => $urlClass . '205/' . $ssm . '/2004/2009',
		'205 Pembuatan 2010-2012' => $urlClass . '205' . $sse2010,
		'CDT 2009->' => $urlClass . 'cdt/' . $ssm . '/2004/2013',
		'ICDT 2012->' => $urlClass . 'icdt/' . $id . '/2004/2013',
		'100 2010-2012' => $urlClass . '100' . $sse2010,
		'101 2010-2012' => $urlClass . '101' . $sse2010,
		'103 2010-2012' => $urlClass . '103' . $sse2010,
		'104 2010-2012' => $urlClass . '104' . $sse2010,
		'105 2010-2012' => $urlClass . '105' . $sse2010,
		'201 2010-2012' => $urlClass . '201' . $sse2010,
		'202 2010-2012' => $urlClass . '202' . $sse2010,
		'203 2010-2012' => $urlClass . '203' . $sse2010,
		'206 2010-2012' => $urlClass . '206' . $sse2010,
		'301 2010-2012' => $urlClass . '301' . $sse2010,
		'302 2010-2012' => $urlClass . '302' . $sse2010,
		'303 2010-2012' => $urlClass . '303' . $sse2010,
		'304 2010-2012' => $urlClass . '304' . $sse2010,
		'305 2010-2012' => $urlClass . '305' . $sse2010,
		'306 2010-2012' => $urlClass . '306' . $sse2010,
		'307 2010-2012' => $urlClass . '307' . $sse2010,
		'308 2010-2012' => $urlClass . '308' . $sse2010,
		'309 2010-2012' => $urlClass . '309' . $sse2010,
		'310 2010-2012' => $urlClass . '310' . $sse2010,
		'311 2010-2012' => $urlClass . '311' . $sse2010,
		'312 2010-2012' => $urlClass . '312' . $sse2010,
		'313 2010-2012' => $urlClass . '313' . $sse2010,
		'314 Bas 2010-2012' => $urlClass . '314' . $sse2010,
		'315 2010-2012' => $urlClass . '315' . $sse2010,
		'316 2010-2012' => $urlClass . '316' . $sse2010,
		'317 2010-2012' => $urlClass . '317' . $sse2010,
		'318 Lori 2010-2012' => $urlClass . '318' . $sse2010,
		'319 2010-2012' => $urlClass . '319' . $sse2010,
		'320 2010-2012' => $urlClass . '320' . $sse2010,
		'322 2010-2012' => $urlClass . '322' . $sse2010,
		'323 2010-2012' => $urlClass . '323' . $sse2010,
		'324 2010-2012' => $urlClass . '324' . $sse2010,
		'325 Kiriman Cepat 2010-2012' => $urlClass . '325' . $sse2010,
		'328 FNB 2010-2012' => $urlClass . '328' . $sse2010,
		'331 2010-2012' => $urlClass . '331' . $sse2010,
		'332 2010-2012' => $urlClass . '332' . $sse2010,
		'333 2010-2012' => $urlClass . '333' . $sse2010,
		'334 2010-2012' => $urlClass . '334' . $sse2010,
		'335 2010-2012' => $urlClass . '335' . $sse2010,
		'391 2010-2012' => $urlClass . '391' . $sse2010,
		'392 2010-2012' => $urlClass . '392' . $sse2010,
		'393 2010-2012' => $urlClass . '393' . $sse2010,
		'800 2010-2012' => $urlClass . '800' . $sse2010,
		'810 2010-2012' => $urlClass . '810' . $sse2010,
		'840 2010-2012' => $urlClass . '840' . $sse2010,
		'850 2010-2012' => $urlClass . '850' . $sse2010,
		'890 2010-2012' => $urlClass . '890' . $sse2010,
		'999 2010-2012' => $urlClass . '999' . $sse2010,
	);
}
?>