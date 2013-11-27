<?php
# semak url
//echo '$this->url:'; print_r($this->url);
$url = $this->url;
$class  = isset($url[0]) ? $url[0] : null;
$fungsi = isset($url[1]) ? $url[1] : 'entah';
$jadual = isset($url[2]) ? $url[2] : 1;
$ulang  = isset($url[3]) ? $url[3] : 1;
/*
echo '
$class  = ' . $class . '|
$fungsi = ' . $fungsi . '|
$jadual = ' . $jadual . '|
$ulang  = ' . $ulang . '<br>';
*/
//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
//echo '<pre>$_SESI->', print_r($_SESSION, 1) . '</pre>';

//echo '$this:'; print_r($this);
/*array(
    [0] => array ([Field] => msic)
    [1] => array ([Field] => keterangan)
)*/
$pilihMedan = null;
foreach ($this->medan as $key => $row)
{// mula ulang $row

	$pilihMedan .= ($jadual == 'johor' && $row['Field'] == 'DAERAH PENTADBIRAN') ? 
	'<option selected>' . $row['Field'] . '</option>':
	'<option>' . $row['Field'] . '</option>';
	
}// tamat ulang $row

$pilihMedan2 = null;
foreach ($this->medan as $key => $row)
{// mula ulang $row

	$pilihMedan2 .= ($jadual == 'johor' && $row['Field'] == 'LOKALITI UNTUK INDEKS') ? 
	'<option selected>' . $row['Field'] . '</option>':
	'<option>' . $row['Field'] . '</option>';
	
}// tamat ulang $row

$pilihMedanSusun = null;
foreach ($this->medan as $key => $row)
{// mula ulang $row

	$pilihMedanSusun .= ($jadual == 'johor' && $row['Field'] == 'KOD NGDBBP 2010') ? 
	'<option selected>' . $row['Field'] . '</option>':
	'<option>' . $row['Field'] . '</option>';
	
}// tamat ulang $row

if (isset($_SESSION['mesej'])) 
{
	/*echo '<div class="alert alert-danger alert-dismissable">'
		. '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
		. '<strong>Amaran!</strong> ' . $_SESSION['mesej'] 
		. '</div>';
	echo ' <div class="alert alert-danger fade in">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
		<h4>Amaran!</h4> 
        <p>' . $_SESSION['mesej'] . '</p>
      </div>';
	
		*/
	$amaran = '<div class="form-group has-error">'; 
	$paparAmaran = '<label class="control-label" for="inputError">' 
		. $_SESSION['mesej'] . '</label>';
	$amaranID = 'id="inputError"';
	$amaran2 = '</div>';

	unset($_SESSION['mesej']);
}
else
{
	$amaran = '<div class="form-group has-success">';
	$paparAmaran = '';
	$amaranID = 'id="inputSuccess"';
	$amaran2 = '</div>';

}

$open = '<span class="glyphicon glyphicon-plus"></span>';
$close = '<span class="glyphicon glyphicon-minus"></span>';
?>
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<form class="container" method="POST" action="<?php echo URL ?>cari/pada/300/1">
<div class="alert alert-info fade in">
Nota:<br>
Pastikan butang [atau] [dan] dipilih untuk carian.<br>
Boleh guna % antara 2 perkataan untuk carian yang lebih tepat.<br>
Carian dihadkan pada 300 baris sahaja pasal bajet kewangan terhad huhuhu.
</div>
<div class="row show-grid">
	<div class="col-lg-4" align="right">
	<span class="label label-info">Jadual</span>
		<select class="form-control" name="namajadual">
		<option><?php echo $jadual ?></option>
		</select>
	</div>
	<div class="col-lg-6">
		<span class="label label-info">Carian/Fix/(AntaraKurungan)</span>
	</div>
	</span>
</div>
<div class="row show-grid">
<?php echo $amaran ?>
	<div class="col-lg-4" align="right">
		<span class="label label-default">Medan1:</span>
		<select class="form-control small" name="pilih[1]" <?php echo $amaranID ?> >
		<?php echo $pilihMedan; ?>
		</select>
	</div>
	<div class="col-lg-6">
		<?php echo $paparAmaran ?><span class="label label-info">
			Pilih1:<input type="checkbox" name="fix[1]" value="x">
		</span>
		<?php echo $open . (pecah_url(1)) . $close ?>
		<input type="text" name="cari[1]" class="form-control mini" <?php echo $amaranID ?> >
	</div>
<?php echo $amaran2 ?>	
</div>
<?php
//$ulang = 6; 
for ( $u = 2 ; $u <= $ulang ; $u++ )
{?>
<div class="row show-grid">
<?php echo $amaran ?>
	<div class="col-lg-4" align="right">
		<span class="label label-info">
			<input type="radio" name="atau[<?=$u?>]" value="or">atau
			<input type="radio" name="atau[<?=$u?>]" value="and" checked>dan
		</span>
		<span class="label label-default">Medan<?php echo $u ?>:</span>
			<select class="form-control span2" name="pilih[<?=$u?>]" <?php echo $amaranID ?> >
			<?php echo $pilihMedan2; ?>
			</select>
	</div>
	<div class="col-lg-6">
		<?php echo $paparAmaran ?>
		<span class="label label-info">Pilih<?=$u?>:
			<input type="checkbox" name="fix[<?=$u?>]" value="x">
			<input type="radio" name="mula[<?=$u?>]" value="(">(
			<input type="radio" name="tmt[<?=$u?>]" value=")">)
		</span>
		<?php echo $open . (pecah_url($u)) . $close ?>
		<input type="text" name="cari[<?=$u?>]" class="form-control mini" <?php echo $amaranID ?> >
	</div>
<?php echo $amaran2 ?>	
</div>
<?php
}?>
<div class="row show-grid">
	<div class="col-lg-4" align="right">
	<span class="label label-info">
		Susun <select class="form-control col-lg-2" name="susun">
		<?php echo $pilihMedanSusun; ?>
		</select>
		<input type="radio" name="ikut">ASC
		<input type="radio" name="ikut" value="DESC">DESC 
	</span>
	</div>
	<div class="col-lg-6">
		<span class="label label-info">Sila tekan butang "cari <?php echo $jadual ?>"</span><br>
		<input type="submit" name="carian" class="btn btn-primary" value="cari <?php echo $jadual ?>">
		<input type="reset"  name="kosong" class="btn" value="kosong">
	</div>
</div>
</form>
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->