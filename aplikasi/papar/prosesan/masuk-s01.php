<?php
$soalan = array(
	'F0002' => 'No SSM',
	'F0003' => 'Thn Mula Niaga',
	'F0004' => 'Awal Tempoh Operasi',
	'F0005' => 'Akhir Tempoh Operasi',
	'F0014' => 'Kod MSIC Mel',
	'F0015' => 'Kod MSIC Semasa',
	'F0012' => 'Poskod',
	'F0017' => 'Rujuk Poskod = Label?',
	'F0016' => 'Melabur luar negara?',
	'F0007' => 'Daftar GST?',
	'F0008' => 'Pembekalan Berkadar Standard',
	'F0009' => 'Pembekalan Berkadar Sifar',
	'F0010' => 'Pembekalan Dikecualikan',
);
?>
<!-- Jadual q01_2010 ########################################### -->
		<table border="1" class="excel" >
<?php foreach($soalan as $medan => $keterangan) :?>
		<tr>
		<td align="right"><?php echo $keterangan ?>|<?php echo $medan ?></td>
		<td><div class="input-prepend"><input type="text" name="proses[<?php echo $medan 
			?>]" id="<?php echo $medan ?>" value="" class="input-medium"></div></td></tr>
<?php endforeach;?>		
		</table>
<!-- Jadual q01_2010 ########################################### -->
