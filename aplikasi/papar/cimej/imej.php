<h1>Imej: Terperinci</h1>
<?php 
//echo '$this->kesID=' . print_r($this->kesID, 1);
//echo '<br>$this->carian=' . print_r($this->carian, 1);

if ($this->carian=='[tiada id diisi]')
{
	echo 'data kosong<br>';
}
else
{ // $this->carian=='sidap' - mula

	foreach ($this->kesID as $jadual => $kirabaris)
	{// mula ulang $this->kesID
		if ( count($kirabaris)==0 )
			echo '';
		else
			$senarai = $jadual . '=' . 
			count($kirabaris) . ' baris';
	
// mula bina jadual
#-----------------------------------------------------------------
		for ($kira=0; $kira < count($kirabaris); $kira++)
		{	//print the data row ?>
<table border="1" class="excel" id="example">
<caption><?php echo $senarai ?></caption>	
<?php 	foreach ( $kirabaris[$kira] as $key=>$data ):
		if ($key=='sidap') $sidap = $data;
		elseif ($key=='newss') $newss = $data;
		elseif ($key=='nama') $syarikat = $data; ?>
<tr>
	<td><?php echo $key ?>:<?php echo $data ?></td>
</tr><?php endforeach ?>
</table><?php
		}
#-----------------------------------------------------------------
	}// tamat ulang $this->kesID

// set pembolehubah
$w1='<span style="background-color: #fffaf0; color:black">';
$w2='</span>';
$sidap = isset($sidap) ? $sidap : null;
$ssm = substr($sidap,0,11);
$newss = isset($newss) ? $newss : null;
$syarikat = isset($syarikat) ? $syarikat : null;
?>
<fieldset>
<legend style="background-color: black; color:yellow">
Senarai Imej<br>sidap:<?php echo $sidap . 
'<br> ssm:' . $ssm . 
'<br> newss:' . $newss .
'<br> syarikat:' . $syarikat ?>
</legend><?php
// The location to search for images - the location can be relative to this directory
	$lokasi = '../../../';
	$strDir = '../imgekonomi/data_tahunan';

if ( empty($ssm) && empty($newss)) //if ($cariSsm==null)
{
	echo $w1 . 'ssm/newss & imej tiada ' . $w2 . '<br>';
}
elseif ($this->carian == 'newss' && !empty($newss) )
{
	//$strDir ='Z:\data_tahunan';
	//$matches=null;
	$cariNewss = cari_imej($newss,$strDir);
	$cariSsm = (empty($ssm)) ? null : cari_imej($ssm,$strDir);
	// root imej 33,40 | http img  0,12
	//echo 'imej ' . $tahun  . '| gambar=' . $gambar . ' <br>';
	if (is_array($cariNewss))
	{
		echo '<table border="1" class="excel" bgcolor="#ffffff">'
			. '<caption>Ssm</caption>';
		foreach ($cariSsm as $key => $gambar)
		{
			#../imgekonomi/data_tahunan/be06/SURVEY20/J1033/J1033_C000001885620011.tif
			$tahun = substr($gambar,27,4);
			// mula papar
			echo "\r<tr>\r" . '<td>imej <a target="_blank" href="' . $lokasi . 
			$gambar . '">' . $tahun  . '</a>' .
			//'<img src="' . $gambar . '" height="100%" width="100%">' .
			"</td>\r<tr>";
		}
		echo '</table>';
		echo '<table border="1" class="excel" bgcolor="#ffffff">'
			. '<caption>NEWSS</caption>';
		foreach ($cariNewss as $key => $gambar)
		{
			#../imgekonomi/data_tahunan/be06/SURVEY20/J1033/J1033_C000001885620011.tif
			$tahun = substr($gambar,27,4);
			// mula papar
			echo "\r<tr>\r" . '<td>imej <a target="_blank" href="'. $lokasi . 
			$gambar . '">' . $tahun  . '</a>' .
			//'<img src="' . $gambar . '" height="100%" width="100%">' .
			"</td>\r<tr>";
		}
		echo '</table>';
	}
	else
		echo $w1 . 'ssm ada tapi imej tiada ' . $w2 . '<br>';
}
else
{
	//$strDir ='Z:\data_tahunan';
	//$matches=null;
	$cariImej=cari_imej($ssm,$strDir);
	// root imej 33,40 | http img  0,12
	//echo 'imej ' . $tahun  . '| gambar=' . $gambar . ' <br>';
	if (is_array($cariImej))
	{
		echo '<table border="1" class="excel" bgcolor="#ffffff">'
			. '<caption>SIDAP</caption>';
		foreach ($cariImej as $key => $gambar)
		{
			#../imgekonomi/data_tahunan/be06/SURVEY20/J1033/J1033_C000001885620011.tif
			$tahun = substr($gambar,27,4);
			// mula papar
			echo "\r<tr>\r" . '<td>imej <a target="_blank" href="'. $lokasi . 
			$gambar . '">' . $tahun  . '</a>' .
			//'<img src="' . $gambar . '" height="100%" width="100%">' .
			"</td>\r<tr>";
		}
		echo '</table>';
	}
	else
		echo $w1 . 'ssm ada tapi imej tiada ' . $w2 . '<br>';
}

?></fieldset>

<?php } // $this->carian=='sidap' - tamat ?>