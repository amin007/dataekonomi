<?php
$soalan = array(
	'F0031' => 'Modal berbayar',
	'F0032' => 'Rizab',
	'F0048' => 'Hak milik : Individu & Syarikat',
	'F0044' => 'Hak milik : Persekutuan,Negeri,Tmptan & Badan Berkanon',
	'F0045' => 'Hak milik : Bukan Residen Malaysia & Syarikat',
	'F0046' => 'Modal berbayar : negara syarikat induk muktamad'
);
?>
<!-- Jadual q03_2010 ########################################### -->
		<table border="1" class="excel" >
<?php foreach($soalan as $medan => $keterangan) :?>
		<tr>
		<td align="right"><?php echo $keterangan ?>|<?php echo $medan ?></td>
		<td><div class="input-prepend"><input type="text" name="proses[<?php echo $medan 
			?>]" id="<?php echo $medan ?>" value="" class="input-medium"></div></td></tr>
<?php endforeach;?>		
		</table>
<!-- Jadual q03_2010 ########################################### -->
