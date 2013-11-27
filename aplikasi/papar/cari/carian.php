<?php include '../sesi.php'; include '../db_buka.php'; if (! isset($_GET['page'])){ ?>
<!-- Cari Borang -->
<html>
<head>
<title>Cari <?=($_GET['jadual']=='msic')? "Kod Industri":"SK"; ?></title>
<script type="text/javascript" src="../../../js/datepick/jquery.js"></script>
<?php 
include '../css.txt'; 
include '../css2.txt'; 
include '../gambar_head.txt';
include '../excel.txt';
include '../autocomplete.txt';
?>
</head>
<body background="../../../bg/bg/<?php include '../gambar2.php';?>">
<div id="content">
<?php
#######################################
include '../daftar_fungsi.php'; 
$pegawai=senarai_kakitangan($pegawai);
include '../daftar_keluar.php'; 
##############################################
if ($_GET['jadual']==null) {$_GET['jadual']=$_POST['jadual'];}
elseif ($_GET['jadual']=='msic') 
	{
		$myTable='msic';
		$myMedan='*';
	}
elseif  ($_GET['jadual']=='rangka') 
	{
		$myTable='mdt_'.$_GET['jadual'].'';
		$myMedan='*';
	}
else 
	{
		$myTable='mdt_'.$_GET['jadual'].'';
		$myMedan='newss,sidap,nama,status,'.
		'msic08,terima,hasil,dptLain,web,stok,staf,gaji,outlet,sebab';
	}
if ($_GET['item']==null) {$_GET['item']=300;}
##############################################
$query ='select ' . $myMedan . ' from ' . $myTable . ' ';

$result = @mysql_query($query) or die (mysql_error()."<hr>$query<hr>"); 
$fields = mysql_num_fields($result);
for ( $f = 0 ; $f < $fields ; $f++ )
	{ 
	$pilihMedan.="<option>".
	mysql_field_name($result,$f).
	"</option>\n";
	}
//echo $pilihMedan;
?>
<form method="POST" action="carian.php?jadual=<?=$_GET['jadual']?>&item=<?=$_GET['item']?>&page=1">
<script language="JavaScript" type="text/javascript">if(document.getElementById) document.getElementById('carian').focus();</script>
<table border="0" class="excel" width="387">

<tr bgcolor='#ffffff'>
<td>Jadual</td>
<td width="140"><select size="1" name="jadual"><option><? echo $_GET[jadual]; ?></option></select></td>
<td width="170">Carian</td><td>fix</td>
<td>(AntaraKurungan)</td><td>PilihanAntaraAtau&amp;Dan</td>
</tr>

<tr>
<td bgcolor="#33CC33">Pilih U</td>
<td><select size="1" name="pilihan">
<?php echo $pilihMedan; ?>
</select></td>
<td><input type="text" name="carian" id="carian" size="20" value="<?php echo $_GET['cari']; ?>"></td>
<td><input type="checkbox" name="fix1" value="1"></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<?php
for ( $u = 2 ; $u < $_GET['u'] ; $u++ )
{?><tr>
<td bgcolor='#ffffff'>Pilih<?=$u?></td>
<td><select size="1" name="pilih<?=$u?>">
<?php echo $pilihMedan; ?>
</select></td>
<td><input type="text" name="cari<?=$u?>" id="cari" size="20" value=""></td>
<td><input type="checkbox" name="fix<?=$u?>" value="1"></td>
<td><label class="papan"><input type="radio" name="mula<?=$u?>" value="(">(</label>
	<label class="papan"><input type="radio" name="tmt<?=$u?>" value=")">)</label></td>
<td><label class="papan"><input type="radio" name="atau<?=$u?>" value="or">atau</label>
	<label class="papan"><input type="radio" name="atau<?=$u?>" value="and">dan</label></td>
</tr>

<?php } ?>
<tr><td bgcolor='#ffffff'>Susun</td><td><select size="1" name="susun">
<?php echo $pilihMedan; ?>
</select></td>
<td>
<input type="submit" name="cari" value="cari sk"/>
<input type="reset" name="kosong" value="kosong">
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><label class="papan"><input type="radio" name="ikut" value="">ASC</label>
	<label class="papan"><input type="radio" name="ikut" value="DESC">DESC</label></td>
</tr>
</table>
</form></div>

</body>
</html>
<!-- Cari Borang -->
<?php } else { 
//<!-- Jumpa Borang -->
session_start();//session_unset();session_destroy();
?><html>
<head>
<title>Cari <? echo ($_GET['jadual']=='msic')? "Kod Industri":"SK"; ?></title>
<script type="text/javascript" src="../../../js/datepick/jquery.js"></script>
<script type="text/javascript" src="../../../js/filter/jquery-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../js/filter/susun.style.css" />
<script type="text/javascript" src="../../../js/filter/susun.application.js"></script>
<?php 
include '../css.txt'; 
include '../css2.txt'; 
include '../gambar_head.txt';
include '../excel.txt';
include '../autocomplete.txt';
?>
</head>
<body background="../../../bg/bg/<?php include '../gambar2.php';?>">
<div id="content">
<?php
#######################################
include '../daftar_fungsi.php'; 
$pegawai=senarai_kakitangan($pegawai);
include '../daftar_keluar.php'; 
#######################################
##############################################
if ($_GET['jadual']==null) {$_GET['jadual']=$_POST['jadual'];}
elseif ($_GET['jadual']=='msic') {$myTable='msic';}
else {$myTable='mdt_'.$_GET['jadual'].'';}
if ($_GET['item']==null) {$_GET['item']=300;}
#################################################
// mula fungsi
	function nl2brr($text)
{	return preg_replace("/\r\n|\n|\r/", "<br>\n", $text);	}
	function kira($kiraan)
{	return number_format($kiraan, 0, '.', ',');	} 
	function dudukkanan($align)
{	if (is_int($align))return " align=right>$align";
	else return " style='word-wrap:break-word;'>$align";
}
	function takjumpa($warna1,$warna2,$bil_semua,$myTable)
{// function takjumpa() - mula
	echo "\n<div align=left>$warna1" .
	"Bil Kes:($bil_semua), tak jumpa untuk Jadual $myTable" .
	"\n$warna2</div>\n";
}// function takjumpa() - tamat
	function halaman2($warna1,$warna2,$page,$bil_semua,$muka_surat,$senarai_medan,$myTable)
{// function halaman() - mula
	echo "\n<div align=left>$warna1 Jadual : $myTable | Bil Kes:($bil_semua) Papar halaman "; 
	if($page > 1) // Bina halaman sebelum
		{echo "\r<a href='?page=".($page-1)."&$senarai_medan'>Sebelum</a> |";}
	for($i = 1; $i <= $muka_surat; $i++) // Bina halaman terkini
		{echo ($page==$i)? " ($i) |":"\r<a href='?page=$i&$senarai_medan'>$i</a>|";}
	if($page < $muka_surat) // Bina halaman akhir
		{echo "\r<a href='?page=".($page+1)."&$senarai_medan'>Lagi</a>";}
	echo "\n$warna2</div>\n";
}// function halaman() - tamat
	function industri($query2,$result2,$fields,$rows,$myTable,$bil) 
{// function industri() - mula
	echo "\n".'<table border="1" class="excel" id="example">'.
	"\n<thead><tr>\n<th>#</th>\n";
		for($f=0;$f<$fields;$f++)
		{echo '<th>'.mysql_field_name($result2,$f)."</th>\n";}
	echo '</tr>'."\n</thead><tbody>\n";
		
	while($row = mysql_fetch_array($result2))
	{// mula papar 
		echo "<tr>\n<td>".$bil++."</td>\n"; ;
		for ( $f = 0 ; $f < $fields ; $f++ )
		{echo "<td>".nl2brr($row[$f])."&nbsp;</td>\n";}
		echo "</tr>\n";
	}// tutup papar
	echo "</tbody>\n</table>\n";
}// function industri() - tamat
	function ulangMSIC($warna1,$warna2,
	$myJadual,$page,$baris_max,$dari_baris,$pilihan,$carian,
	$p2,$p3,$p4,$p5,$c2,$c3,$c4,$c5,
	$a2,$a3,$a4,$a5,$m2,$m3,$m4,$m5,
	$t2,$t3,$t4,$t5,$f1,$f2,$f3,$f4,$f5)
{// function ulangMSIC() - mula
	foreach ($myJadual as $key => $myTable)
	{// mula  ulang msic
//--------------------------------------------------------------------------------------------------------------------//	
	$pilihMedan = ($myTable=='msic2008') ?
	'seksyen s,bahagian b,kumpulan kump, kelas,msic,msic2000,keterangan,notakaki':'*';
	$sql ="SELECT $pilihMedan FROM `$myTable` WHERE \r";
	if ($myTable=='msic2008') 
		{
		if ($pilihan=='msic')
			{
			$sql.=($f1==1)?"\r$pilihan='$carian' \ror msic2000='$carian'":
			"\r$pilihan like '%$carian%' \ror msic2000 like '%$carian%'";
			}
		else 
			{
			$sql.=($f1==1)?"\r$pilihan='$carian' \ror notakaki='$carian'":
			"\r$pilihan like '%$carian%' \ror notakaki like '%$carian%'";
			}
		}
	else 
		$sql.=($f1==1)?"\r$pilihan='$carian'":"\r$pilihan like '%$carian%'";
	$sql.=($c2==null)?'':($f2==1?"\r$a2 $m2 $p2='$c2' $t2":"\r$a2 $m2 $p2 like '%$c2%' $t2");
	$sql.=($c3==null)?'':($f3==1?"\r$a3 $m3 $p3='$c3' $t3":"\r$a3 $m3 $p3 like '%$c3%' $t3");
	$sql.=($c4==null)?'':($f4==1?"\r$a4 $m4 $p4='$c4' $t4":"\r$a4 $m4 $p4 like '%$c4%' $t4");
	##########---------- Mula- Bina hyperlink untuk nombor halaman----------##########
	$result = mysql_query($sql) or diehard4('1:'.$myTable,$sql);
	$bil_semua  = mysql_num_rows($result); // Tentukan bilangan baris di dalam DB:
	$muka_surat = ceil($bil_semua / $baris_max);// Tentukan bilangan halaman. 
	$senarai_medan="jadual=$myTable&pilihan=$pilihan&carian=$carian&item=$baris_max";
	##########----------Tamat- Bina hyperlink untuk nombor halaman----------##########
	##########---------- Mula- query MySQL (LIMIT ".$dari_baris.", ".$baris_max.")-----#####
	$query = $sql . ' LIMIT ' . $dari_baris . ', ' . $baris_max; 
	
	$result2 = mysql_query($query) or diehard4('2:'.$myTable,$query);
	$fields = mysql_num_fields($result2); 
	$rows = mysql_num_rows($result2);
	##########----------Tamat- query MySQL (LIMIT ".$dari_baris.", ".$baris_max.")-----#####	
	########## mula - cari $bil_semua
	if ($bil_semua=='0'): takjumpa($warna1,$warna2,$bil_semua,$myTable);
	else: // mula kalau jumpa
		//echo '<fieldset>';
		halaman($warna1,$warna2,$page,$bil_semua,$muka_surat,$myTable,$baris_max);
		industri($query,$result2,$fields,$rows,$myTable,$bil);
		halaman($warna1,$warna2,$page,$bil_semua,$muka_surat,$myTable,$baris_max);
		//echo '</fieldset>';
	endif; //tamat jika jumpa
	##########  tamat - cari $bil_semua
//--------------------------------------------------------------------------------------------------------------------//
	}// tamat ulang msic
}// function ulangMSIC() - tamat
	function ulangPAPAR($warna1,$warna2,
	$senarai,$pilihan,$carian,$thn,
	$p2,$p3,$p4,$p5,$c2,$c3,$c4,$c5,
	$a2,$a3,$a4,$a5,$m2,$m3,$m4,$m5,
	$t2,$t3,$t4,$t5,$f1,$f2,$f3,$f4,$f5)
{// function ulangPAPAR() - mula
	foreach ($senarai as $key => $myTable)
	{// mula ulang table
//--------------------------------------------------------------------------------------------------------------------//
	$msic='if(msic08 is null,msic,msic08)';
	if ($myTable=='rangka')
		{
		$q='SELECT newss,nama,status U,fe,' . 
		'msic,msic08,' . "\r" .
		'tel,responden,respon,nota,catatan,' . "\r" .
		'ssm,alamat1,alamat2,poskod' . "\r" .
		'FROM `mdt_rangka` r WHERE ';
		$pilih=($pilihan=='msic08')?'r.msic':'r.'.$pilihan;
		}
	else 
		{
		$q='SELECT b.newss,b.nama,fe,b.status U,b.msic08,"' . 
		$myTable . '" bln,' . 'b.terima ' . $myTable . ',' . "\r" .
		'FORMAT(b.hasil, 0) as jualan, b.dptLain, b.web,' . "\r" .
		'FORMAT(b.stok,  0) as stok, b.staf,' . "\r" .
		'FORMAT(b.gaji,  0) as gaji, b.outlet, b.sebab' . "\r" .
		'FROM mdt_' . $myTable . $thn . ' b INNER JOIN mdt_rangka r ' . "\r" .
		'ON b.newss=r.newss WHERE ';
		
		$pilih=($pilihan=='msic')?'b.msic08':'r.'.$pilihan;
		}

	$q.=($f1==1)?"\r$pilih='$carian' " :"\r$pilih like '%$carian%' ";
	$q.=($c2==null)?'':(($f2==1)?"\r$a2 $m2 $p2='$c2' $t2":"\r$a2 $m2 $p2 like '%$c2%' $t2");
	$q.=($c3==null)?'':(($f3==1)?"\r$a3 $m3 $p3='$c3' $t3":"\r$a3 $m3 $p3 like '%$c3%' $t3");
	$q.=($c4==null)?'':(($f4==1)?"\r$a4 $m4 $p4='$c4' $t4":"\r$a4 $m4 $p4 like '%$c4%' $t4");
	$q.=($c5==null)?'':(($f5==1)?"\r$a5 $m5 $p5='$c5' $t5":"\r$a5 $m5 $p5 like '%$c5%' $t5");
	$q.="\r".'ORDER BY '.$_POST['susun'].' '.$_POST['ikut'].' ';

	//diehard4($t,$q); 
	##########---------- Mula- query MySQL -----#####
	$result = mysql_query($q) or diehard4($myTable,$q); 
	$fields = mysql_num_fields($result); 
	$rows = mysql_num_rows($result);
	##########----------Tamat- query MySQL -----#####
	########## mula - cari bil. brg
	// nak papar bil. brg
	if ($rows=='0'): echo '<table border=1 class="excel">' . "\r" .
		'<tr bgcolor="#ffffff"><td colspan=' . $fields. '>' . $q. '' .
		'<pre $warna0><font color=red>Maaflah, ' . $carian .
		' tak jumpalah pada jadual ' . $myTable . 
		'</font></pre><br>'.
		'</td></tr>' . "\r" . '</table>';
	else: // kalau jumpa
		$bil=1;paparBulan($q,$result,$fields,$rows,$myTable,$bil);
	endif; //tamat jika jumpa	
	##########  tamat - cari bil. brg
//--------------------------------------------------------------------------------------------------------------------//
	}// tamat ulang table

}// function ulangPAPAR() - tamat
	function paparBulan($q,$result,$fields,$rows,$myTable,$bil) 
{// function paparBulan() - mula
	echo "\n".'<table border="1" class="excel" id="example">'.
	"\n<thead><tr>\n<th>#</th>\n";
		for($f=0;$f<$fields;$f++)
		{echo '<th>'.mysql_field_name($result,$f)."</th>\n";}
	echo '</tr>'."\n</thead><tbody>\n";
		
	while($row = mysql_fetch_array($result))
	{// mula papar 
		echo "<tr>\n<td>".$bil++."</td>\n"; ;
			for ( $f = 0 ; $f < $fields ; $f++ )//{echo "<td>".nl2brr($row[$f])."&nbsp;</td>\n";}
			{
				if($f=='4') $papar="><a target='blank' ".
				'href="carian.php?jadual=msic&item=300&susun=1&u=6'.
				'&cari=' . $row[4] . '">' . $row[4].'</a>';
				elseif( ($f=='1') || ($f=='12')) $papar=dudukkanan($row[$f]); 
				else $papar=">".nl2brr($row[$f]);
			
				echo "\r<td align=right".$papar."&nbsp;</td>";
			}
		echo "</tr>\n";
	}// tutup papar
	echo "</tbody>\n</table>\n";
}// function paparBulan() - tamat

///////////////////////////////////////////////////////////////////////////////////////////
$warna0=' style="background-color: black; color:yellow" ';
$warna1='<span style="background-color: #fffaf0; color:black">';
$warna2='</span>';
#################################################
$pilihan = $_REQUEST['pilihan'];$carian = $_REQUEST['carian'];
$p2=$_POST['pilih2'];$c2=$_POST['cari2'];$a2=$_POST['atau2'];
$p3=$_POST['pilih3'];$c3=$_POST['cari3'];$a3=$_POST['atau3'];
$p4=$_POST['pilih4'];$c4=$_POST['cari4'];$a4=$_POST['atau4'];
$p5=$_POST['pilih5'];$c5=$_POST['cari5'];$a5=$_POST['atau5'];
$m2=$_POST['mula2'];$t2=$_POST['tmt2'];
$m3=$_POST['mula3'];$t3=$_POST['tmt3'];
$m4=$_POST['mula4'];$t4=$_POST['tmt4'];
$m5=$_POST['mula5'];$t5=$_POST['tmt5'];
$f1=$_POST['fix1'];$f2=$_POST['fix2'];$f3=$_POST['fix3'];
$f4=$_POST['fix4'];$f5=$_POST['fix5'];

	//echo "<pre style='background-color: black; color:yellow' >";
	//echo print_r($_)."</pre>\r";
if ($_GET['jadual']=='msic'):
//------------------------------------------------------------------------------------------
	$page =( !isset($_REQUEST['page']) )? 1: $_REQUEST['page'];
	$baris_max = ( !isset($_REQUEST['item']) )? 300: $_REQUEST['item'];
	$dari_baris = (($page * $baris_max) - $baris_max); $bil = $dari_baris+1; 
	$myJadual = array('msic2008','msic_v1','msic','msic_nota_kaki','msic_bandingan');
	
	// buat ulangan
	ulangMSIC($warna1,$warna2,
	$myJadual,$page,$baris_max,$dari_baris,$pilihan,$carian,
	$p2,$p3,$p4,$p5,$c2,$c3,$c4,$c5,
	$a2,$a3,$a4,$a5,$m2,$m3,$m4,$m5,
	$t2,$t3,$t4,$t5,$f1,$f2,$f3,$f4,$f5);
//------------------------------------------------------------------------------------------
else: // kalau bukan if (($_POST[myTable]=='msic') or ($_POST[myTable]=='msic_nota_kaki') ):
//------------------------------------------------------------------------------------------
	$senarai=array('rangka',
	'jan', 'feb', 'mac', 'apr', 
    'mei', 'jun', 'jul', 'ogo', 
    'sep', 'okt', 'nov', 'dis');
	$tahun='12';

	// buat ulangan
	ulangPAPAR($warna1,$warna2,
	$senarai,$pilihan,$carian,$tahun,
	$p2,$p3,$p4,$p5,$c2,$c3,$c4,$c5,
	$a2,$a3,$a4,$a5,$m2,$m3,$m4,$m5,
	$t2,$t3,$t4,$t5,$f1,$f2,$f3,$f4,$f5);
//------------------------------------------------------------------------------------------
endif;?>
</div>
</body>
</html>
<?php
//<!-- Jumpa Borang -->
} 
?>