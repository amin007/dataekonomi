<?php
//echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
//echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';

$kotak[0]='fancybox'; 
$kotak[1]='colorbox'; 
$login=$kotak[rand(0,1)];

$isi=$this->isi;
$urlLogin = URL . 'index/login/';
$urlLoginAutomatik = URL . 'index/login_automatik/';
?>
<html><head><title><?php echo Tajuk_Muka_Surat ?></title>
<link rel="stylesheet" href="<?php echo JS ?>public/css/gambar_head.css" />
<?php if ($login='fancybox') : ?>
<!-- FancyBox Mula -->
<script type="text/javascript" src="<?php echo JS ?>jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JS ?>fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="<?php echo JS ?>fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("a.zoom").fancybox();
	$("a.zoom").fancybox({ 'hideOnContentClick': false}); 
	});
</script>
<!-- FancyBox Tamat -->
<?php elseif ($login='colorbox') : ?>
<!-- Colorbox Mula  -->
<link media="screen" rel="stylesheet" href="<?php echo JS ?>colorbox/example5/colorbox.css" />
<script src="<?php echo JS ?>jquery/jquery.js"></script>
<script src="<?php echo JS ?>colorbox/jquery.colorbox.js"></script>
<script type="text/javascript">
$(document).ready(function()
{//Examples of how to assign the ColorBox event to elements
	$(".zoom").colorbox({transition:"fade", width:"50%", height:"50%"});
});
</script>
<!-- Colorbox Tamat -->
<?php endif ?>
</head>
<body background="<?php echo GAMBAR ?>">
<div id="content">
<table border="0" height="90%" width="90%">
<tr><td align="center" valign="middle"> 
<!-- ----------------------------------------------------------------------------------- -->
<table border="0" align="center">
<tr><td align="center" valign="top"  colspan=2>
	<a style="font-size: 20pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff" href="<?php echo URL
	?>">Untuk <?php echo Tajuk_Muka_Surat ?></a>
	</td></tr>
<tr><td width="1000" align="center" valign="top">
	<a style="font-size: 20pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff" class="zoom" 
	title="Apa Kabar Pentadbir" href="<?php echo $urlLogin ?>admin">Pentadbir</a>
	</td></tr>
<tr><td align="center" valign="top">
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">FE</a>
<?php 
unset($pegawai);	
$pegawai=array('adam','amin007','amran','ali','ariff','azim','norita',
'fendi','khairi','musa','mustaffa','shukor','suhaida',
'viara','zaharah','hanim');

foreach ($pegawai as $key => $nama)
{	
	$urlMasuk = ($nama == 'amin007') ? $urlLogin : $urlLoginAutomatik;
	$gambar = ($nama == 'amin007') ? 'amin' : $nama;
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' 
	. ucwords($nama) . '" href="' . $urlMasuk . $nama . '">' 
	. "\n\t" . '<img src="' . STAF . $gambar . '.jpg"></a>';
	
	$isi.=($key!=0 && $key%5==0)? "<br>\n":"\n";
}
	echo $isi;
?>	
	</td></tr>
<tr><td align="center" valign="top"  colspan=2>
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">Prosesan</a>
	<a class="zoom" title="Apa Kabar Azizah" href="<?php echo $urlLogin ?>azizah"> 
	<img src="<?php echo STAF ?>azizah.jpg"></a><?php
$prosesan=array('rahima','zainap');
$isi=null;
foreach ($prosesan as $key => $nama)
{	
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' .
	ucwords($nama) . '" href="' . $urlLoginAutomatik . $nama . '">' .
	"\n\t" . '<img src="' . STAF . $nama . '.jpg"></a>';
	
	$isi.=($key!=0 && $key%5==0)? "<br>\n":"\n";
}
echo $isi;
?>
	<br><br><a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">KUP</a><?php 
unset($kup);
$isi=null;
$kup=array('murad','sujana');
foreach ($kup as $key => $nama)
{	
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' .
	ucwords($nama) . '" href="' . $urlLogin . $nama . '">' .
	"\n\t" . '<img src="' . STAF . $nama . '.jpg"></a>';
	
	$isi.=($key==5)? "<br>\n":"\n";
}
	echo $isi;?><br>
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">PEGAWAI</a>
<?php 
unset($pegawai);
$isi=null;	
$pegawai=array('safie' => 'En Safie',
'razak' => 'En Abdul Razak',
'shima' => 'Pn Shima','fareza' => 'En Fareza');

foreach ($pegawai as $nama => $namaPenuh)
{	
	$urlMasuk = ($nama == 'amin007') ? $urlLogin : $urlLoginAutomatik;
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' 
	. ucwords($namaPenuh) . '" href="' . $urlMasuk . $nama . '" ' . "\n\t" 
	. 'style="font-size: 20pt; background-color: #ffff00; color:#ff0000">'
	. $namaPenuh . '</a>';
	
	$isi.=($key!=0 && $key%5==0)? "<br>\n":"\n";
}
	echo $isi;
?>	
	</td></tr>
</table>
<!-- ----------------------------------------------------------------------------------- -->
</td></tr></table>
</div>
</body>
</html>
