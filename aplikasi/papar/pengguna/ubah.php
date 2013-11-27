<?php
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
?><pre><?php //print_r($this->pengguna) ?></pre>


<div class="container">
<div class="row">
	<div class="col-lg-6">
<!-- ################################################################################## -->	
		<h2>Ubah</h2>
		<form method="post" action="<?php echo URL ?>pengguna/ubahSimpan">
<?php 
// senarai medan	
	$medan = array('namaPegawai','kataLaluan','level',
	'No_Staf','Nama_Penuh','email','nohp',
	'Jawatan','Kod','Unit','Tetap','CatatNota');
// set level
	$level = array('level');
	$data = array('admin','fe','pegawai','hq');
	$senaraiLevel = null;
	foreach ($data as $key => $value):
		$senaraiLevel .= '<option>' . $value . '</option>';
	endforeach;
// paparkan borang
foreach ($this->pengguna as $namaMedan => $data ):
	if (in_array($namaMedan,$level)):?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-5"><?php echo $paparAmaran . "\n" ?>
			<select class="form-control mini" name="pengguna[<?php echo $namaMedan ?>]"  <?php echo $amaranID ?> >
			<?php echo $senaraiLevel; ?></select>
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php elseif(in_array($namaMedan,array('kataLaluan'))):?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-5"><?php echo $paparAmaran . "\n" ?>
			<input type="text" name="pengguna[<?php echo $namaMedan ?>]" 
			class="form-control mini" <?php echo $amaranID ?> >
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php elseif(in_array($namaMedan,array('Nama_Penuh','email'))):?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-7"><?php echo $paparAmaran . "\n" ?>
			<input type="text" name="pengguna[<?php echo $namaMedan ?>]" 
			value="<?php echo $data ?>" class="form-control mini" <?php echo $amaranID ?> >
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php else:?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-5"><?php echo $paparAmaran . "\n" ?>
			<input type="text" name="pengguna[<?php echo $namaMedan ?>]" 
			value="<?php echo $data ?>"	class="form-control mini" <?php echo $amaranID ?> >
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php 
	endif;
endforeach; ?>
<div class="row show-grid">
	<div class="col-lg-4" align="right">
		<span class="label label-default">Hantar:</span>
	</div>
	<div class="col-lg-6">
		<input type="submit" name="carian" class="btn btn-primary" value="Tambah">
		<input type="reset"  name="kosong" class="btn" value="kosong">
	</div>
</div>
</form>

<!-- ################################################################################## -->
	</div>
</div>

</div><!--container-->