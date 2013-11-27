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

<div class="row">
	<div class="col-lg-4">
<!-- ################################################################################## -->	
		<h2>Daftar Pengguna</h2>
		<form method="post" action="<?php echo URL ?>pengguna/tambahSimpan">
<?php 
// senarai medan	
	$medan = array('namaPegawai','kataLaluan','level',
	'No_Staf','Nama_Penuh','email','nohp',
	'Jawatan','Kod','Unit','Tetap','CatatNota');
// set level
	$level = array('level');
	$data = array('fe','pegawai','hq','admin');
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
		<div class="col-lg-5"><?php echo $paparAmaran . "\n" ?>
			<select class="form-control mini" name="pengguna[level]" <?php echo $amaranID ?> >
			<?php echo $senaraiLevel; ?></select>
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
			class="form-control mini" <?php echo $amaranID ?> >
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
			<input type="text" name="pengguna[<?php echo $namaMedan ?>]" class="form-control mini" <?php echo $amaranID ?> >
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
	<div class="col-lg-8">
<!-- ################################################################################## -->
<?php 
//echo '' . print_r($this->senarai) . ''; 
foreach ($this->senarai as $myTable => $row)
{
	if ( count($row)==0 ) { echo ''; }
	else
	{?>	
	<h2>Papar Pengguna <span class="badge"><?php echo count($row)?></span> baris</h2>
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
				'ubah' => array(
					'href' => URL . 'pengguna/ubah/' . $id,
					'class' => 'btn btn-info btn-mini',
					'id' => ' data-toggle="modal" rel="tooltip" title="Ubah"',
					),
				'buang' => array(
					'href' => URL . 'pengguna/buang/' . $id,
					'class' => 'btn btn-danger msgbox-confirm',
					'id' => ' onclick="if(!confirm('
						. "'Pasti mahu buang data ini?'"
						. '))return false" title="Buang"',
					)
				);
				
				// bentuk link
				$link = null;
				foreach ( $p AS $p2 => $d2 ) :
					$link .= '<a target="_blank" href="' . $p[$p2]['href']
						  . '" class="' . $p[$p2]['class'] . '" '
						  . $p[$p2]['id'] . '>' . $p2 . '</a>' . "\n\t";
				endforeach; 
				
				// papar link
				?><td><?php echo $link ?></td><?php
				
			}
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
</div><!--container-->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Buang Data</h4>
      </div>
      <div class="modal-body">
      Mahu Buang?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary">Ya</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->