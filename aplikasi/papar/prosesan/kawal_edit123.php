<?php
include "../sesi.php";include "../db_buka.php";// buka pangkalan data 
if (!isset($_POST['semua'])) { ?><?php 
	function papartajuk($fields,$result,$myTable)
{// function papartajuk() - mula
	echo "\n".'<tr>'."\n".'<td colspan=2>(Jadual:'.$myTable.')</td>';
	for ($f=1;$f < $fields;$f++)
		{ echo (mysql_field_name($result,$f)=='nama syarikat') ?
		'<td>nama</td>'."\n":
		'<td>'.mysql_field_name($result,$f).'</td>'."\n"; }
	echo '</tr>';
}// function papartajuk() - tamat
	function paparisi($myTable,$row,$result,$fields,$rows,$bil)
{// function paparisi() - mula
	echo($bil%'2'=='0')?"\n<tr bgcolor='#ffffe0'>":"\n<tr bgcolor='#ffe4e1'>";
	if (($myTable=='dtsample') && ($myTable!='mdt_rangka'))
	{$p='href="kawal_tambah.php?cari='.$row[2].'"';}
	else {$p='href="kawal_edit.php?cari='.$row[1].'"';}
	echo "\n<td><a $p>".$bil."</a></td>";
	for($f=0;$f<$fields;$f++){echo "\n<td>".$row[$f]."</td>";}
	echo "\n</tr>";
}// function paparisi() - tamat
	function paparisi2($myTable,$row,$result,$fields,$rows,$bil)
{// function paparisi2() - mula
	echo($bil%'2'=='0')?"\n\t\t<tr bgcolor='#ffffe0'>":"\n\t\t<tr bgcolor='#ffe4e1'>";
	echo "\n\t\t<td>".$bil."</td>";
	for($f=0;$f<$fields;$f++){echo "\n\t\t<td>".$row[$f]."</td>";}
	echo "\n\t\t</tr>\n";
}// function paparisi2() - tamat
	function msic($industri,$industriB)
{// function msic() - mula	
	echo "\r\t<td>\r".
	'<!-- ################################################################### -->';
	
	$MSIC = array('msic','msic2008','msic_v1','msic_nota_kaki','msic_bandingan');
	foreach ($MSIC as $key2 => $jadual)
	{// $MSIC ulang jadual-mula
	$m=($jadual!='msic2008')?'*':
	"seksyen S,bahagian B,kumpulan Kpl,kelas Kls,msic2000,msic,keterangan,notakaki";
	$sql2="SELECT $m\rFROM $jadual WHERE msic='".$industri."' OR msic='".$industriB."'";

	$result = mysql_query($sql2) or die(mysql_error()."<hr>$sql2<hr>"); 
	$fields = mysql_num_fields ($result); $rows = mysql_num_rows ($result);
	
	// nak papar bil. brg
	if ($rows=='0' or $industri==null): echo "\t\t".
	'<span style="background-color: black; color:yellow">'.
	":( $jadual:MSIC=$industri $industriB</span><br>\r";
	else: // kalau jumpa
		$nama_jadual='<span style="background-color: black; color:yellow">'.$jadual.'</span>';
		echo "\r\t\t<table border=1 class='excel' bgcolor='#ffffff'>".
		"\n\t\t<tr>"."\n\t\t<td>#</td>";
		for ( $f = 0 ; $f < $fields ; $f++ )
		{ echo (mysql_field_name($result,$f)=='keterangan') ?
		"\n\t\t<td>keterangan - $nama_jadual</td>":
		"\n\t\t<td>".mysql_field_name($result,$f).",</td>"; }
		echo "\n\t\t</tr>";

		$bil=1;while($row = mysql_fetch_array($result,MYSQL_NUM))
		{paparisi2($myTable,$row,$result,$fields,$rows,$bil);$bil++;}

		echo "\t\t</table>\r";
	endif; //tamat jika jumpa
	}//$MSIC ulang jadual-tamat
	echo "\t".'</td>
<!-- ################################################################### -->';		
}// function msic() - tamat
function cariMedanInput($ubah,$f,$row,$nama) 
{//function cariMedanInput($f,$nama,$input)  - mula
	/*senarai nama medan
	0-nota,1-respon,2-fe,3-tel,4-fax,		
	5-responden,6-email,7-msic,8-msic08,
	9-`id U M`,10-nama,11-sidap,12-status*/
	// papar medan yang terlibat
	$cariMedan=array(0,1,2,3,4,5,6,8);
	$cariText=array(0);// papar jika nota ada
	$cariMsic=array(8); //papar input text msic sahaja 
	$medanR=$ubah.'['.$nama.']';
		
	// tentukan medan yang ada input
	$input=in_array($f,$cariMedan)? 
	(@in_array($f,$cariMsic)? // tentukan medan yang ada msic
		'<input type="text" name="'.$medanR.'" value="'.$row[$f].'" size=6>'
		:(@in_array($f,$cariText)? // tentukan medan yang ada input textarea
			'<textarea name="'.$medanR.'" rows=2 cols=23>'.$row[$f].'</textarea>':
			'<input type="text" name="'.$medanR.'" value="'.$row[$f].'" size=30>')
	):'<label class="papan">'.$row[$f].'</label>';
	
	return $input;

}//function cariMedanInput($f,$nama,$input)  - tamat
function kira($kiraan)
{
	return number_format($kiraan,0,'.',',');
} 
function kira2($dulu,$kini)
{
	return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
}
//@$kiraan=(($kini-$dulu)/$dulu)*100;
function diehard4($bil,$sql) 
{
	$w0=' style="background-color: #fffaf0; color:black" ';
	$w1='<span style="background-color: #fffaf0; color:black">';$w2='</span>';
	echo $w1.mysql_error().$w2.'<hr><pre'.$w0.'>'.$bil."->\r".$sql.'</pre><hr>';
}
function bersih($papar) 
{
	# lepas lari aksara khas dalam SQL
	//$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
	$papar = trim($papar);
	
	return $papar;
}
$pilihan='newss';
$carian=bersih($_GET['cari']);
$_GET['cari']=bersih($_GET['cari']);
?>
<html>
<head><title>Kes MM:<?=$_GET['cari']?></title>
<script type="text/javascript" src="../../../js/datepick/jquery.js"></script>
<link rel="stylesheet" href="../../../js/datepick/datepick.css" type="text/css" />
<link rel="stylesheet" href="../../../js/datepick/flora.datepick.css" type="text/css" />
<script type="text/javascript" src="../../../js/datepick/datepick.js"></script>
<script type="text/javascript" src="../../../js/datepick/datepick-ms.js"></script>

<?php 
//include '../css.txt'; 
include '../gambar_head.txt';
include '../excel.txt';
include '../autocomplete.txt';
?>
</head>
<body>
<img src="../../../bg/bg/<?php include '../gambar2.php';?>" alt="background image" id="bg">
<div id="content">
<fieldset><?php 
echo '<span style="background-color: black; color:yellow">(';
echo 'cari='.$_GET['cari'].")</span>\r";
$w1='<span style="background-color: #fffaf0; color:black">';$w2="</span>";
//$medanSemak[]='*';
$medanSemak[]='newss,ssm,nama,operator,`no-lokasi`,`kawasan-lokasi`,`bandar-lokasi`,' .
'`poskod-lokasi` as poskod,`ng-lokasi` as ng/*,`dp-lokasi`*/';
$medanSemak[]='newss,ssm,nama,`no-lain`,`kawasan-lain`,`bandar-lain`,' .
'`poskod-lain` as poskod,`ng-lain` as ng/*,`dp-lain`*/';
$medanSemak[]='newss,nama,purposive,bco,utama,po,nota';
$medanSemak[]='newss,ssm,nama,tel,fax,responden,' .
'(SELECT keterangan FROM msic WHERE msic=msic2000 LIMIT 1,1) as keterangan,' .
'msic2000,msicB2000,fe,nohp as nohpfe';
$medanSemak[]='newss,nama,msic_lama, 
(SELECT keterangan FROM msic WHERE msic=msic_lama LIMIT 1,1) as keterangan,' . 
'msic_baru,utama,concat(tahun_rujukan,"-",siri_kekerapan) as blnthn'; 

//$medanSemak[]='newss,ssm,nama,concat(tahun_rujukan,"-",siri_kekerapan) as blnthn';
//$medanSemak[]='newss,ssm,nama,fe,respon,terima,hantar,catatan';
for($z=1;$z <= 4;$z++) { $myJadual[]='mm_rangka'; }
$myJadual[]='prosesmm_info';
$myJoin='nama_pegawai';

//------------------------------------------------------------------------------
foreach ($myJadual as $key => $myTable)
{// mula ulang table
	$sambung=($myTable=='mm_rangka')? 'LEFT JOIN ' . $myJoin . ' as fe 
	ON R.fe = fe.namaPegawai':'';

	$sql="SELECT ".$medanSemak[$key]." FROM ".$myTable." R
	$sambung
	WHERE concat(newss,nama) like '%".$_GET['cari']."%' ";

	$result = mysql_query($sql) or diehard4(1,$sql);
	$fields = mysql_num_fields($result); 
	$rows   = mysql_num_rows($result);

	// nak papar bil. brg
	if ($rows=='0' or $_GET['cari']==null): echo "<br><font color=red>Maaflah, " .
		$_GET['cari'] . " tak jumpalah pada jadual :" . $myTable .
		"<font face=Wingdings size=5>L</font></font>";

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
			#0-newss,1-ssm,2-nama,3-tel,4-fax,5-responden,6-email,
			#7-msic2000,8-msicB2000,9-fe,10-nohpfe,
			$bil++;$noID=$row[0];$syarikat=$row[2];
			$namafe=$row[9];$telkawan=$row[10];
		}// tutup papar
		echo "</table>";
	endif; //tamat jika jumpa
}// tamat ulang table
//------------------------------------------------------------------------------?>
</fieldset>
<div align="center"><form method="GET" action="">
<font size="5" color="red"><?=$_GET['ralat']?>&rarr;</font>
<input type="text" name="cari" size="30" value="<?=$_GET['cari']?>" 
id="inputString" onkeyup="lookup(this.value);" onblur="fill();" onchange="this.form.submit()">
<input type="submit" value="mencari">
<div class="suggestionsBox" id="suggestions" style="display: none;">
	<img src="../../../js/autocomplete/upArrow.png" 
	style="position: relative; top: -12px; left: 200px;" alt="upArrow" />
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div>
<form action="kawal_edit.php?cari=<?=$_GET['cari'];?>#bawah" enctype="multipart/form-data" method="POST">
<!-- ----------------------------------------------------------------------------------------------- -->
<table class='excel'>
<?php
$rangkaMM = array('mm_rangka');
$medan2='newss,nama,purposive,bco,utama,po,' .
'fe,tel,fax,responden,email,' .
'respon,msic2000,msicB2000,nota';
$medan='nota,respon,fe,tel,fax,responden,email,msic2000,msicB2000,' . "\r" .
'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' . "\r" .
'substring(newss,7,3),\' \',substring(newss,10,3),\' | \',' . "\r" .
'utama,\' \',msic2000) as ' . '`id U M`,nama,ssm,utama';
foreach ($rangkaMM as $key => $ubah)
{// mula ulang table
	$query='SELECT ' . $medan . ' FROM `' . $ubah . '` WHERE newss like "' . $noID . '" ';
	//diehard4(2,$query);// papar sql
	
	$result = mysql_query($query) or diehard4(2,$query);
	$fields = mysql_num_fields($result); 
	$rows = mysql_num_rows($result);

// nak papar bil. brg
if ($rows=='0'): echo '<tr><td valign="top" colspan="3">' .
	'<span style="background-color: black; color:yellow">' .
	'Maaflah, ' . $noID . ' tak jumpalah pada jadual:' . $ubah .
	'<font face=Wingdings size=5>L</font></span></td></tr>';

else: // kalau jumpa
	while($row = mysql_fetch_array($result,MYSQL_NUM))
	{	
		for ( $f = 0; $f < $fields ; $f++ )
		{// masuk - mula
		/*senarai nama medan
		0-nota,1-respon,2-fe,3-tel,4-fax,		
		5-responden,6-email,7-msic,8-msic08,
		9-`id U M`,10-nama,11-sidap,12-status*/
			# mula set pembolehubah
			$p1='<label class="papan">';
			$p2='</label>';
			$industri=$row[7];
			$industriB=$row[8];
			$sidap=$row[11];
			$status=$row[12];
			
			// nak gabungan 2 msic
			$msic78=$p1 . '7-' . mysql_field_name($result,7) .
			'<br>8-' . mysql_field_name($result,8) . $p2;
						
			// cari input berdasarkan nama
			$nama=mysql_field_name($result,$f);	
			$input=cariMedanInput($ubah,$f,$row,$nama);
			
			# tamat set pembolehubah
			# mula papar output
				//if (($f==7)or($f==10)or($f==11)or($f==12)){ echo '';}	
				if (in_array($f,array(7,10,11,12))) echo '';
				elseif ($f==8)// msic08
				{				
					echo "<tr>\r\t<td>$msic78</td>\r\t".''.
					'<td>'.$p1.$industri.$p2.$input.'</td>';
					msic($industri,$industriB);	
					echo "\r</tr>";
				}
				else
				{
					echo "<tr>\r\t<td>$p1$f-".$nama."$p2</td>".
					"\r\t<td>".$input."</td>".
					"\r\t<td>$p1".$row[$f]."$p2</td>\r</tr>";
				}
			# tamat papar output
		}// masuk - tamat
	}
endif; //tamat jika jumpa
}// tamat ulang table
//-------------------------------------------------------------------------------------------------
// nak buat tab - mula 
$bulanan = array('jan', 'feb', 'mac', 'apr',/* 
'mei', 'jun', 'jul', 'ogo', 
'sep', 'okt', 'nov', 'dis'*/);
?>
</table><script type="text/javascript">
<?php foreach ($bulanan as $tarikh2 => $tarikh ){// mula ulang table ?>
$(function() {$('#terima_mm_<?=$tarikh?>12').datepick({dateFormat: 'yyyy-mm-dd'});});
$(function() {$('#hantar_mm_<?=$tarikh?>12').datepick({dateFormat: 'yyyy-mm-dd'});});
<?}// tamat ulang table?>
</script><?php

	echo "\n<table bgcolor='#ffffff' class='excel' border=1>\n<tr>".
	'<td align=center colspan=1>#newsss-nama</td>';
	$r=array('bulan-fe','terima','hantar','catatan','#');
	//$r=array('newsss','fid','nama','fe','respon','terima','hantar','catatan');
	for ($x=0;$x < count($r);$x++){ echo "\n<td>".$r[$x].",</td>"; }
	echo "\n</tr>";

foreach ($bulanan as $kunci => $bln)
{// mula ulang table
	$bulan='mm_'.$bln.'12';
	
	$medan='concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \','.
	'substring(newss,7,3),\' \',substring(newss,10,3) )' . "\r" .
	'as fid,newss,nama,fe,terima,hantar,catatan,\''.$bln.'\'';

	$sql2[]='SELECT '.$medan."\r".'FROM '.$bulan.' WHERE newss="'.$noID.'" ';
	
}// tamat ulang table
	$query=implode("\rUNION\r",$sql2);
	//diehard4('cantum bulan-',$query);

// jalankan sql
	$result = mysql_query($query) or diehard4('$result-',$query);
	$fields = mysql_num_fields($result); 
	$rows   = mysql_num_rows($result);

// nak papar bil. brg
if ($rows=='0' or $_GET['cari']==null or $noID==null): echo '<br><font color=red>
Maaflah, '.$noID.' tak jumpalah pada jadual :'.$bulan.'
<font face=Wingdings size=5>L</font></font>';

else: // kalau jumpa
    while($row = mysql_fetch_array($result,MYSQL_NUM)) // isi medan
    {// mula papar 
	## baris input #####################################################################
	$bln=$row[7];
	$bulan='mm_'.$bln.'12';
	$kira++;
    #0-fid,1-newss,2-nama,3-fe,4-terima,5-hantar,6-catatan,7-bulan
	echo "\n<tr>\n" . '<td align=center colspan=1>'.$row[2].'</td>';
	for ( $f = 3 ; $f < $fields-1 ; $f++ )
        {$name=mysql_field_name($result,$f);
		//if ($f >= 3 && $f <= 4){//fid,newsss,nama,fe
		if ($f==3){//fid,newsss,nama,fe,respon
		$input=$bulan.'-'.$row[3].'&nbsp;';
		}elseif($f==4){//terima
		$input="<input type='text' name='".$bulan."[$name]' value='".$row[$f]."' size=6 ". 
		'id="terima_'.$bulan.'" readonly style="font-family:sans-serif;font-size:11px;">';
		}elseif($f==5){//hantar
		$input="<input type='text' name='".$bulan."[$name]' value='".$row[$f]."' size=6 ". 
		'id="hantar_'.$bulan.'" readonly style="font-family:sans-serif;font-size:11px;">';
		}elseif ($f==6){//catatan
		$input="<textarea name='".$bulan."[$name]' rows='2' cols='20'>".
		$row[$f]."</textarea>";
		}        
		echo "\n".'<td align=right>'.$input.'</td>';
        }
		$input2="<input type='text' size=5 align=right>";
		echo "\n".'<td align=right>Klik & enter sini<br>'.$input2.'</td>';
		echo "\n</tr>";
	## baris input #####################################################################
	## baris papar #####################################################################
        echo "\n<tr bgcolor='plum'>\n".
		'<td align=center colspan=1>'.$row[0].'-'.$row[3].'</td>';
		for( $f = 3 ; $f < $fields-1 ; $f++ )
		{
			echo "\n".'<td>'.$row[$f].'</td>';
		}
		echo "\n</tr>";
	## baris papar #####################################################################
    }
endif; //tamat jika jumpa

echo "\n";
?>
<tr><td valign="top" colspan="<?php echo $fields+1; ?>">
<a name="bulan"></a>
<?php $ip=$_SERVER['REMOTE_ADDR'];
echo "<input type='hidden' name='ip' size='10' value=$ip>\n";
$pc = gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo "<input type='hidden' name='pc' size='10' value=$pc>\n";
?><input type="hidden" name="pilihan" value="<?=$pilihan?>">
<input type="hidden" name="carian" value="<?=$noID;?>">
<input type="hidden" name="syarikat" value="<?=$syarikat?>">
<input type="hidden" name="kawan" value="<?=$namafe?>">
<input type="hidden" name="telkawan" value="<?=$telkawan?>">
<font size="5" color="red"><?=$_GET['ralat']?>&rarr;</font>
<a target='_blank' href="../forum/sms.php?kawan=<?=$kawan?><?=$telkawan?>&cari=<?=urlencode($syarikat)?>">Hantar sms</a> | 
<a target='_blank' href="./kawal_proses.php?cari=<?=$noID?>">Bandingan Bulanan</a> | 
<input type="submit" value="Proses" name="semua" id="semua">
</td></tr>
</table>
<!-- --------------------------------------------------------------------------------------------------------- -->
</form></body></html><?php 
} else {// data baru mula proses
/*
foreach ($bulan as $key => $myTable){$_POST[$myTable]['fe']=$_POST['mm_rangka']['fe'];
if ($_POST[$myTable]['terima']=='0000-00-00'){$_POST[$myTable]['terima']=null;}
if ($_POST[$myTable]['hantar']=='0000-00-00'){$_POST[$myTable]['hantar']=null;}}
*/
// Mula Isytihar Fungsi ********************************************************************************** -->
function update_table( $the_table, $data) 
{
	// cek $data
	//echo '<pre>$data['.$the_table.']', print_r($data) . '</pre>';
	
	// set blank values
	$primary_id = null;
	$fields = array();

	// find fields from table
	$sql = "show columns from $the_table";
	$res = mysql_query($sql) or diehard4('papar medan-',$sql);//die('query error 1');

	while ($field = mysql_fetch_array($res)) 
	{
	//$fields[] = $field['Field'];if ($field['Key'] == 'PRI') { $primary_id = $field['Field']; }
		if ($field['Key'] == 'PRI')
			$primary_key = $field['Field'];
		else
			$fields[] = $field['Field'];
	}
 
	$fields = array_flip( $fields ); // flip db field array
	$filtered = array_intersect_key( $data, $fields );// remove non exist array on post data
	array_walk($filtered, create_function('&$val', '$val = mysql_real_escape_string(trim($val));') ); // clean up value 
	
	foreach ($filtered as $medan => $papar)
	{
		//$senarai[]=($papar==null || $papar=='0') 
		$senarai[]=($papar==null) ? " $medan=null" : " $medan='$papar'"; 
	}
	
	$statment=implode(",\r",$senarai);
	/*
	$satu=implode( "='%s',\r", array_keys( $filtered ) );
	$statment = vsprintf( 
	$satu . "='%s'", array_values( $filtered ) 
	); // create statement update
	*/
	// check if primary key exists
	if ($primary_key && $data[$primary_key])
		$where = "$primary_key = '$data[$primary_key]'";
	 
	$full_sql = " UPDATE $the_table SET \r" .
	"$statment \r WHERE $where";
		
	return $full_sql;
}
function bersih($papar) 
{
	# lepas lari aksara khas dalam SQL
	$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
	$papar = trim($papar);

	return $papar;
}
function diehard4($bil,$sql) 
{
	$w0=' style="background-color: #fffaf0; color:black" ';
	$w1='<br><span style="background-color: #fffaf0; color:black">';
	$w2='</span>';
	echo $w1 . mysql_error() . $w2 . '<hr><pre' . $w0 . '>' .
	$bil . "->\r" . $sql . '</pre><hr>';
}
function ubah($ubah,$masalah,$nama_anda) 
{
	$result = mysql_query($ubah) or diehard4($masalah,$ubah);
	logxtvx($nama_anda,$ubah);
}
function logxtvx($nama_anda,$ubah)
{# nak log aktiviti user=========================
	$_POST['user'] = $nama_anda;
	$_POST['aktiviti'] = 'kemaskini mm2012';
	$_POST['arahan_sql'] = "<pre>($ubah)</pre>";
	include '../log_xtvt.php';
}#===============================================
function sms_kawan($myTable)
{
	// bersihkan pembolehubah
	$m['kes']    = bersih($_POST['syarikat']);
	$m['kawan']  = bersih($_POST['kawan']);
	// mula parameter sms
	$p['userid'] = 'amin77';
	$p['passwd'] = 'amin@@7';
	$p['message']= $m['kawan'] . ', kes ' . $m['kes'] .
	' sudah sampai pada ' .	date('j \hb M Y, \j\a\m g:i a') .
	' hari ini.'; //Cepat sampai kes??? Harap2 dapat anugerah cemerlang tahun ini. ';
	$p['mobile_no']='6' . bersih($_POST['telkawan']);
	$p['token']='i1d04568126feca38d0d7957abc377f6d';
	//$p['mobile_no']='60122159410';// amin punya hp
	$url='http://202.171.45.205/blast/sms_gwy.php?' . data_get($p);
	
	//echo '<pre>', print_r($p) . '</pre><br>' . $url . '<br>';
	return $papar = file_get_contents($url);
}
function data_get($data)
{
	$dataGet = '';
	foreach($data as $key=>$val)
	{
		if (!empty($dataGet)) $dataGet .='&';
		$dataGet .=$key . '=' . urlencode($val);
	}

	return $dataGet;
}
// Tamat Isytihar Fungsi ********************************************************************************** -->

// Mula Proses Kawalan ****************************************************************************** -->
	//echo '<pre>', print_r($_POST) . '</pre>';
	# buat peristiharan
	$_POST['mm_rangka']['respon']=strtoupper($_POST['mm_rangka']['respon']);
	$_POST['mm_rangka']['fe']=strtolower($_POST['mm_rangka']['fe']);
	$_POST['mm_rangka']['email']=strtolower($_POST['mm_rangka']['email']);
	$_POST['mm_rangka']['responden']=mb_convert_case($_POST['mm_rangka']['responden'], MB_CASE_TITLE);

	$m['pilih'] = bersih($_POST['pilihan']);
	$m['cari']  = bersih($_POST['carian']);
	$m['fe']    = bersih($_POST['mm_rangka']['fe']);

	$bulan = array('rangka',
		'jan', 'feb', 'mac', 'apr', /*
		'mei', 'jun', 'jul', 'ogo', 
		'sep', 'okt', 'nov', 'dis'*/);
	
	# if ($m['cari']==null) - mula -----------------------------------------------------------
	if ($m['cari']==null) :
		echo '<br><font color=blue>Maaflah,(newss=' . $m['cari'] . ') tak isi <br>' .
		'<font face=Wingdings size=5>L</font><a href="../">Menu Utama</a></font>';
	else :
	#-- Mula Lihat Dlm Kawalan  
		#ulang jadual
		foreach ($bulan as $key => $bln)
		{// mula ulang jadual -------------------------------------------------------
			#set primary key
			$myTable=($bln=='rangka')?'mm_' . $bln:'mm_' . $bln . '12';
			$data=$_POST[$myTable];
			$data[$m['pilih']] = $m['cari'];
			$data['fe'] = $m['fe'];
			//echo "<pre>$myTable-", print_r($data) . '</pre>';
			
			$ubah=update_table($myTable, $data);
			//diehard4('$ubah',$ubah); // papar $ubah
			ubah($ubah,'ubah ' . $myTable,$nama_anda);
		}// tamat ulang jadual -------------------------------------------------------
	#-- Tamat Lihat Dlm Kawalan dan pergi ke borang kawal_edit.php
	$ralat='Selesai';#$ralat=sms_kawan($myTable);
	header('Location:./kawal_edit.php?cari=' . $m['cari'] . '&ralat=' . $ralat . '#bulan');
	endif;
	# if ($m['cari']==null) - tamat -----------------------------------------------------------
// Tamat Proses Kawalan ****************************************************************************** -->
}// data baru tamat proses ?>