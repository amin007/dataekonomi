<?php
// set pembolehubah
$w1='<span style="background-color: #fffaf0; color:black">';
$w2="</span>";
$sidap = isset($sidap) ? $sidap : null;
$ssm = substr($sidap,0,11);
$syarikat = isset($syarikat) ? $syarikat : null;
?>
<fieldset>
<legend style="background-color: black; color:yellow">
Senarai Imej sidap:<?php echo $sidap . ' | ssm:' . $ssm . 
' | syarikat=' . $syarikat ?></legend><?php
if (empty($ssm)) //if ($cariSsm==null)
{
	echo $w1 . 'ssm & imej tiada ' . $w2 . '<br>';
}
else
{
	// The location to search for images - the location can be relative to this directory
	//$strDir = '../../../imgekonomi/data_tahunan';
	$strDir = '../../../imgekonomi/data_tahunan';
	//$strDir ='Z:\data_tahunan';
	//$matches=null;
	$cariImej=cari_imej($ssm,$strDir);
	// root imej 33,40
	// http img  0,12
	//echo 'imej ' . $tahun  . '| gambar=' . $gambar . ' <br>';
	if (is_array($cariImej))
	{
		echo '<table border="1" class="excel" bgcolor="#ffffff">';
		foreach ($cariImej as $key => $gambar)
		{
			$tahun = substr($gambar,33,4);
			// mula papar
			echo "\r<tr>\r" . '<td>imej <a target="_blank" href="../../' . 
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
