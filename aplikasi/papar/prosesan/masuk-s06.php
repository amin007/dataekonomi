<?php
/*

0 => 'Pascasiswazah	| 06',
1 => 'Ijazah - Akademik	| 31',
2 => 'Ijazah - Teknikal* | 32',
3 => 'Diploma  - Akademik | 33',
4 => 'Diploma - Teknikal* | 34',
5 => 'STPM atau yang setaraf | 03',
6 => 'Sijil - Akademik | 35',
7 => 'SKM 3 | 36',
8 => 'SKM 1 & 2 | 37',
9 => 'Sijil Kemahiran Lain | 38',
10 => 'SPM / SPM(V) | 04',
11 => 'Bawah SPM / SPM(V) | 05',
12 => 'JUMLAH (6.1 hingga 6.7) | 09',

*/
$soalan = array(
0 => 'Pascasiswazah | 06',
1 => 'Ijazah - Akademik | 31',
2 => 'Ijazah - Teknikal* | 32',
3 => 'Diploma  - Akademik | 33',
4 => 'Diploma - Teknikal* | 34',
5 => 'STPM atau yang setaraf | 03',
6 => 'Sijil - Akademik | 35',
7 => 'SKM 3 | 36',
8 => 'SKM 1 & 2 | 37',
9 => 'Sijil Kemahiran Lain | 38',
10 => 'SPM / SPM(V) | 04',
11 => 'Bawah SPM / SPM(V) | 05',
12 => 'JUMLAH (6.1 hingga 6.7) | 09',
);
$ruang = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
	. '';
$bildata = array(15,16);
?>
<!-- Jadual q05_2010 ########################################### -->
<table border="1" class="excel" >
	<thead><tr><th>#</th><th align="center">keterangan-medan<?php echo $ruang ?></th>
		<th>kod</th><th>L15</th><th>P16</th>
		</tr></thead>

<?php foreach($soalan as $kira => $keterangan) :
	list($namaMedan, $kod) = explode(' | ', $keterangan);

?><tbody><tr>
		<td align="right"><?php echo $kira+1; ?></td>
		<td align="right"><?php echo $namaMedan ?></td>
		<td><?php echo $kod ?></td>
		<?php foreach($bildata as $n): ?>
		<td><div class="input-prepend"><?php 
		echo '<input type="text" name="proses[' . $n . $kod
		. '" id="' . $n . $kod . '" value="" class="input-medium"'
		. 'placeholder="F' . $n . $kod . '">'; ?></div></td>
		<?php endforeach; ?>
	</tr></tbody>
<?php endforeach;?>
		</table>
<!-- Jadual q05_2010 ########################################### -->
