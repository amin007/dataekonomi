<h1>Imej </h1>
<?php
require_once PUSTAKA . 'Fungsi.php';
#########################################################################
//print_r($this->kes);
//echo "<pre>", print_r($_SESSION)."</pre>";
#########################################################################
$ralat = null;
$cari = null;
$js = null;
//<a href="'.URL.'pengguna/edit/'.$value['id'].'">Edit</a> 
?>
<div align="center"><form method="POST" action="<?php echo URL . 'imej/';  ?>">
<font size="5" color="red"><?=$ralat?>&rarr;</font>
<input type="hidden" name="p" value="kawal_imej">
<input type="text" name="cari" size="30" value="<?=$cari?>"
id="inputString" onkeyup="lookup(this.value);" onblur="fill();" onchange="this.form.submit()">
<input type="submit" value="mencari">
<div class="suggestionsBox" id="suggestions" style="display: none;">
	<img src="<?=$js?>/autocomplete/upArrow.png" 
	style="position: relative; top: -12px; left: 200px;" alt="upArrow" />
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div>

<fieldset>
<legend style="background-color: black; color:yellow"><?php 
echo '(cari=' . $cari . ")</legend>\r";
$w1='<span style="background-color: #fffaf0; color:black">';
$w2="</span>";
$medanSemak[]='*';
/*$medanSemak[]='*';
$medanSemak[]='*';
$medanSemak[]='*';
$medanSemak[]='*';
$medanSemak[]='*';
$medanSemak[]='*';*/
//for($z=1;$z <= 4;$z++) { $myJadual[]='mm_rangka'; }
$myJadual[]='kawal_ppmas09';
$myJadual[]='kawal_rpe09';
$myJadual[]='kawal_tani09';
$myJadual[]='sse08_rangka';
$myJadual[]='sse09_buat';
$myJadual[]='sse09_ppt';
$myJadual[]='sse10_kawal';
$myJoin='nama_pegawai';

//------------------------------------------------------------------------------
foreach ($myJadual as $key => $myTable)
{// mula ulang table
	$sambung=($myTable=='mm_rangka')? 'LEFT JOIN ' . $myJoin . ' as fe 
	ON R.fe = fe.namaPegawai':'';

	$sql="SELECT * FROM ".$myTable." R
	WHERE concat(sidap,nama) like '%" . $cari . "%' ";
/*
	$result = mysql_query($sql) or diehard4(1,$sql);
	$fields = mysql_num_fields($result); 
	$rows   = mysql_num_rows($result);

	// nak papar bil. brg
	if ($rows=='0' or $_GET['cari']==null): 
		echo ""; 
	else: // kalau jumpa
		echo "<table border=1 class='excel' bgcolor='#ffffff'>"."\n<tr>".
		"\n<td colspan=2>id (Jadual: ".$myTable.")</td>";
		for ( $f = 1 ; $f < $fields ; $f++ )
		{ 
			echo "\n<td>$f-".mysql_field_name($result,$f).",</td>"; 
		}
		echo "\n</tr>";
		
		$bil=1;while($row = mysql_fetch_array($result,MYSQL_NUM))
		{// mula papar 
			paparisi($myTable,$row,$result,$fields,$rows,$bil);
			$bil++;
			$noID=$row[0];
			$sidap=$row[1];
			$syarikat=$row[2];
		}// tutup papar
		echo "</table>";
	endif; //tamat jika jumpa
*/
}// tamat ulang table
//------------------------------------------------------------------------------
# cari nombor ssm
//$sidap = 'C00000017326200011';
//$ssm = str_split($sidap,12);
$ssm = null; //substr($sidap,0,12);
$syarikat = null;
?>
</fieldset>
<fieldset>
<?php
$ssm = null; //substr($sidap,0,12);
$syarikat = null;
?>
<legend style="background-color: black; color:yellow">
Senarai Imej <?=$ssm?> : <?=$syarikat?></legend>
<?php
if ($ssm==null)
{
	echo $w1 . 'ssm & imej tiada ' . $w2 . '<br>';
}
else
{
	// The location to search for images - the location can be relative to this directory
	$strDir = '../../../imgekonomi/data_tahunan';
	//$strDir ='Z:\data_tahunan';
	$matches=cari_imej($ssm,$strDir);
	// root imej 33,40
	// http img  0,12
	//echo 'imej ' . $tahun  . '| gambar=' . $gambar . ' <br>';
	if (is_array($matches))
	{
		echo "<table border=1 class='excel' bgcolor='#ffffff'>";
		foreach ($matches as $key => $gambar)
		{
			$tahun = substr($gambar,33,4);
			// mula papar
			echo "\r<tr>\r" . 
			'<td>imej <a target="_blank" href="' . $gambar . '">' . $tahun  . '</a>' .
			//'<img src="' . $gambar . '" height="100%" width="100%">' .
			"</td>\r<tr>";
		}
		echo "</table>";
	}
	else
		echo $w1 . 'ssm ada tapi imej tiada ' . $w2 . '<br>';
}
?>
</fieldset>
<fieldset>
<legend style="background-color: black; color:yellow">
Data Prosesan <?=$ssm?> : <?=$syarikat?></legend>
<?php
unset($myJadual);
$myJadual[]='qlain15';
$myJadual[]='qlain16';
$myJadual[]='qlain20';
$myJadual[]='qlain21';
$myJadual[]='qlain35';

if ($ssm==null)
{
	echo $w1 . 'prosesan tiada ' . $w2 . '<br>';
}
else
{
//------------------------------------------------------------------------------
foreach ($myJadual as $key => $myTable)
{// mula ulang table

	$sql="SELECT * FROM " . $myTable . " R
	WHERE Estab like '%" . $ssm . "%' ";
/*
	$result = mysql_query($sql) or diehard4(1,$sql);
	$fields = mysql_num_fields($result); 
	$rows   = mysql_num_rows($result);

	// nak papar bil. brg
	if ($rows=='0' or $_GET['cari']==null or $ssm==null): 
		echo ""; 
	else: // kalau jumpa
		echo "<table border=1 class='excel' bgcolor='#ffffff'>"."\n<tr>".
		"\n<td colspan=2>id (Jadual: ".$myTable.")</td>";
		for ( $f = 1 ; $f < $fields ; $f++ )
		{ 
			echo "\n<td>" . mysql_field_name($result,$f) . "</td>"; 
		}
		echo "\n</tr>";
		
		$bil=1;while($row = mysql_fetch_array($result,MYSQL_NUM))
		{// mula papar 
			isiproses($myTable,$row,$result,$fields,$rows,$bil);
			$bil++;
		}// tutup papar
		echo "</table>";
	endif; //tamat jika jumpa
*/
}// tamat ulang table
//------------------------------------------------------------------------------
}
?>
</fieldset>

</body></html>