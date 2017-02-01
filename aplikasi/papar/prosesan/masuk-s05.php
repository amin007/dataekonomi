<?php
/*
 //Anggar 	 Kod 	 W49 	 XW50 	 L14 	 Gaji-18 		 W49 	 XW50 	 P14 	 Gaji-18 
'F01' => 'Pemilik bekerja & rakan niaga yg aktif | 1 | 21',
'F02' => 'Pekerja keluarga | 2 | 22',
'F12' => 'Pengurusan | 12 | 32',
'F13' => 'Profesional | 13 | 33',
'F14' => 'Penyelidik | 14 | 34',
'F04' => 'Juruteknik dan profesional bersekutu | 4 | 24',
'F05' => 'Kerani | 5 | 25',
'F15' => 'Servis & jualan | 15 | 35',
'F16' => 'Staf kemahiran & pertukangan | 16 | 36',
'F07' => '* Operator - Langsung | 7 | 27',
'F08' => '* Operator - Kontraktur Buruh | 8 | 28',
'F06' => 'Pekerja asas | 6 | 26',
'F17' => 'Jumlah pekerja bergaji (sepenuh masa) | 17 | 27',
'F11' => 'Sambilan | 11 | 31',
'F19' => 'JUMLAH STAF | 19 | 39',

*/
$soalan = array(
	'L01' => 'Pemilik bekerja & rakan niaga yg aktif | 01 | 21',
	'L02' => 'Pekerja keluarga | 02 | 22',
	'L12' => 'Pengurusan | 12 | 32',
	'L13' => 'Profesional | 13 | 33',
	'L14' => 'Penyelidik | 14 | 34',
	'L04' => 'Juruteknik dan profesional bersekutu | 04 | 24',
	'L05' => 'Kerani | 05 | 25',
	'L15' => 'Servis & jualan | 15 | 35',
	'L16' => 'Staf kemahiran & pertukangan | 16 | 36',
	'L07' => '* Operator - Langsung | 07 | 27',
	'L08' => '* Operator - Kontraktur Buruh | 08 | 28',
	'L06' => 'Pekerja asas | 06 | 26',
	'L17' => 'Jumlah pekerja bergaji (sepenuh masa) | 17 | 27',
	'L11' => 'Sambilan | 11 | 31',
	'L19' => 'JUMLAH STAF | 19 | 39',
	'P1' => 'Pemilik bekerja & rakan niaga yg aktif | 01 | 21',
	'P22' => 'Pekerja keluarga | 02 | 22',
	'P32' => 'Pengurusan | 12 | 32',
	'P33' => 'Profesional | 13 | 33',
	'P34' => 'Penyelidik | 14 | 34',
	'P24' => 'Juruteknik dan profesional bersekutu | 04 | 24',
	'P25' => 'Kerani | 05 | 25',
	'P35' => 'Servis & jualan | 15 | 35',
	'P36' => 'Staf kemahiran & pertukangan | 16 | 36',
	'P27' => '* Operator - Langsung | 07 | 27',
	'P28' => '* Operator - Kontraktur Buruh | 08 | 28',
	'P26' => 'Pekerja asas | 06 | 26',
	'P27' => 'Jumlah pekerja bergaji (sepenuh masa) | 17 | 27',
	'P31' => 'Sambilan | 11 | 31',
	'P39' => 'JUMLAH STAF | 19 | 39',
);
$ruang = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '';
$kira = 1;
$bildata = array(31,32,14,18,51);
?>
<!-- Jadual q05_2010 ########################################### -->
<table border="1" class="excel" >
	<thead><tr><th>#</th><th>keterangan-medan<?php echo $ruang ?></th>
		<th>kod</th>
		<th>Msia L31</th><th>Pati L32</th><th>Jum L14</th>
		<th>Gaji L18</th><th>Bekal L51</th>
		</tr></thead>

<?php foreach($soalan as $medan => $keterangan) :
	list($namaMedan, $L1, $P1) = explode(' | ', $keterangan);
	$L = $medan; 
?><tbody><tr>
		<td align="right"><?php echo $kira++; ?></td>
		<td align="right"><?php echo $namaMedan ?></td>
		<td><?php echo $L ?></td>
		<?php foreach($bildata as $n): ?>
		<td><div class="input-prepend"><?php 
		echo '<input type="text" name="proses[' . $n . $L
		. '" id="' . $n . $L . '" value="" class="input-medium"'
		. 'placeholder="F' . $n . $L . '">'; ?></div></td>
		<?php endforeach; ?>
	</tr></tbody>
<?php endforeach;?>
		</table>
<!-- Jadual q05_2010 ########################################### -->
