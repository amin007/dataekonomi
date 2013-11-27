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
?>
<div class="container">
<h1>Pengguna</h1>

<div class="row">
	<div class="col-lg-6">
<!-- ################################################################################## -->	
		<h2>Daftar</h2>
		<form method="post" action="<?php echo URL ?>pengguna/tambahSimpan">
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
foreach ($medan as $kunci => $namaMedan):
	if (in_array($namaMedan,$level)):?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-5">
			<?php echo $paparAmaran ?>
			<select class="form-control mini" name="pilih[<?=$u?>]" <?php echo $amaranID ?> >
			<?php echo $senaraiLevel; ?>
			</select>
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php else:?>
	<div class="row show-grid">
	<?php echo $amaran ?>
		<div class="col-lg-4" align="right">
			<span class="label label-default"><?php echo $namaMedan ?>:</span>
		</div>
		<div class="col-lg-5">
			<?php echo $paparAmaran ?>
			<input type="text" name="cari[1]" class="form-control mini" <?php echo $amaranID ?> >
		</div>
	<?php echo $amaran2 ?>	
	</div>
<?php 
	endif;
endforeach; ?>

</form>

<!-- ################################################################################## -->
	</div>
	<div class="col-lg-6">
<!-- ################################################################################## -->
<?php 
//echo '' . print_r($this->senarai) . ''; 
foreach ($this->senarai as $myTable => $row)
{
	if ( count($row)==0 ) { echo ''; }
	else
	{?>	
	<h2>Papar <span class="badge"><?php echo count($row)?></span> baris</h2>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->	
	<table  border="1" class="excel" id="example">
	<?php
	// mula bina jadual
	$printed_headers = false; 
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{
		//print the headers once: 	
		if ( !$printed_headers ) 
		{
			?><thead><tr><th>#</th>
	<?php
			foreach ( array_keys($row[$kira]) as $tajuk ) 
			{ 
				// anda mempunyai kunci integer serta kunci rentetan
				// kerana cara PHP mengendalikan tatasusunan.
				if ( !is_int($tajuk) ) 
				{ 
					$paparTajuk = ($tajuk=='nama') ?
					$tajuk . ' (jadual:' . $myTable . ')'
					: $tajuk; 
					?><th><?php echo $paparTajuk ?></th>
	<?php		} 
			}

	?></tr></thead>
	<?php
			$printed_headers = true; 
		} 
	#-----------------------------------------------------------------		 
		//print the data row 
		?><tbody><tr>
	<?php
		
		foreach ( $row[$kira] as $key=>$data ) 
		{		
			if ($key=='no')
			{
				$id= $data;
				$p = array(
				'ubah' => URL . 'pengguna/ubah/' . $id,
				'buang' => URL . 'pengguna/buang/' . $id,
				);

				?><td><?php foreach ( $p AS $papar2=>$data2 ) :
				?><a target="_blank" href="<?php echo $data2 
				?>" class="btn btn-info btn-mini"><?php echo $papar2 ?></a><?php
				endforeach; ?></td><?php
			}
			else
				{}
			?><td><?php echo $data ?></td>
	<?php
		} 
		?></tr></tbody>
	<?php
	}
	#-----------------------------------------------------------------
	?>
	</table>
	<!-- Jadual <?php echo $myTable ?> ########################################### -->		
<?php
	} // if ( count($row)==0 )
}
?>	
		
<!-- ################################################################################## -->
	</div>
</div>



<hr />
<?php
 ?>
<!-- <pre></pre> -->


</div><!--container-->