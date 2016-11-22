<!-- kawasan button dan nilai2 ditambah kemudian -->
<hr><div align="center">
<table>
<?php
# kira IO
if ( isset($this->output) && isset($this->input) )
{
	$Output = kira($this->output);
	$Input = kira($this->input);
	$NilaiTambah = kira($this->output - $this->input);
	$NilaiIO = ($Input == 0) ? 0 : kiraPerpuluhan( ($this->input/$this->output) , 4);

	echo 'Nilai Output : ' . $Output 
		. ' | Nilai Input : ' . $Input
		. ' | Nilai Tambah : ' . $NilaiTambah
		. ' | Nilai IO : ' . $NilaiIO . '<br>';
}
# nilai untuk input2 khas
$perangkaan['newss'] = $ID;
$perangkaan['nama'] = isset($this->perangkaan['nama']) ? $this->perangkaan['nama'] : null;
   $perangkaan['hasil_dulu'] = isset($this->perangkaan['hasil']) ?	$this->perangkaan['hasil'] : null;
 $perangkaan['belanja_dulu'] = isset($this->perangkaan['belanja']) ? $this->perangkaan['belanja'] : null;
    $perangkaan['gaji_dulu'] = isset($this->perangkaan['gaji']) ? $this->perangkaan['gaji'] : null;
   $perangkaan['susut_dulu'] = isset($this->perangkaan['susut']) ?	$this->perangkaan['susut'] : null;
    $perangkaan['aset_dulu'] = isset($this->perangkaan['aset']) ? $this->perangkaan['aset'] : null;
$perangkaan['asetsewa_dulu'] = isset($this->perangkaan['asetsewa']) ? $this->perangkaan['asetsewa'] : null;

$nisbah = ($this->peratus!=null) ? ($this->peratus)/100 : rand(-30, 30)/100;
//$nisbah = rand(-30, 30)/100;
$nisbah = 1 + $nisbah;
$nilaiNisbah = 1;

$perangkaan['hasil_kini'] = ($nilaiNisbah!=0) ?	$nisbah * $perangkaan['hasil_dulu'] : null;
$perangkaan['belanja_kini'] = ($nilaiNisbah!=0) ? $nisbah * $perangkaan['belanja_dulu'] : null;
$perangkaan['gaji_kini'] = ($nilaiNisbah!=0) ? $nisbah * $perangkaan['gaji_dulu'] : null;
$perangkaan['susut_kini'] = ($nilaiNisbah!=0) ?	$nisbah * $perangkaan['susut_dulu'] : null;
$perangkaan['aset_kini'] = ($nilaiNisbah!=0) ? 	$nisbah * $perangkaan['aset_dulu'] : null;
$perangkaan['asetsewa_kini'] = ($nilaiNisbah!=0) ? $nisbah *  $perangkaan['asetsewa_dulu'] : null;

$semasa = array(
	'sv' => $this->sv,
	'newss' => $perangkaan['newss'],
	'nama' => $perangkaan['nama'] ,
	/*1*/'hasil_dulu' => $perangkaan['hasil_dulu'],
	/*2*/'belanja_dulu' => $perangkaan['belanja_dulu'],
	/*3*/'gaji_dulu' => $perangkaan['gaji_dulu'],
	/*4*/'susut_dulu' => $perangkaan['susut_dulu'],
	/*5*/'aset_dulu' => $perangkaan['aset_dulu'],
	/*6*/'asetsewa_dulu' => $perangkaan['asetsewa_dulu'],
	/*1*/'hasil_kini' => abs($perangkaan['hasil_kini']),
	/*2*/'belanja_kini' => abs($perangkaan['belanja_kini']),
	/*3*/'gaji_kini' => abs($perangkaan['gaji_kini']),
	/*4*/'susut_kini' => abs($perangkaan['susut_kini']),
	/*5*/'aset_kini' => abs($perangkaan['aset_kini']),
	/*6*/'asetsewa_kini' => abs($perangkaan['asetsewa_kini']),
	'catatan' => 'nisbah=' . $nisbah,
	);
# nota nisbah 
		if ($this->peratus==0):
			$notaNisbahPeratus = 'nisbah=' . $nisbah . ' diberi boleh komputer';
		else:
			$notaNisbahPeratus = 'nisbah=' . $nisbah . ' dan peratus=' . $this->peratus . '%';
		endif;
		?><tr><td align="right">Nisbah & Peratus</td><?php
		?><td align="center"><?php echo $notaNisbahPeratus ?></td></tr><?php
foreach ( $semasa AS $key=>$data ) :
	if (in_array($key,array('hasil_kini','belanja_kini','gaji_kini','susut_kini','aset_kini','asetsewa_kini',))): echo '';
	elseif($key == 'belanja_dulu' && $data==null): echo '';
	else:
		?><tr><td align="right"><?php echo $key ?></td><?php
		if ($key=='catatan'):
		//'<textarea ' . $name . ' rows="1" cols="20">' . $data . '</textarea>';
			?><td valign="center"><textarea name="semasa[<?php echo $key 
			?>]" rows="5" cols="30"><?php echo $data ?></textarea></td><td><?php
			?>Papar Semua Nilai</td><td><select name="paparNilai"><?php
			?><option>Ya</option><option>Tidak</option></select></td><?php
		elseif($key == 'hasil_dulu'):
			?><td><input type="text" name="semasa[hasil_dulu]" value="<?php 
			echo $perangkaan['hasil_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|hasil_kini</td><td><input type="text" name="semasa[hasil_kini]" value="<?php 
			echo (int) $semasa['hasil_kini'] ?>" data-formula="SUM($F2001,$F2024)" class="input-large"></td><?php
		elseif($key == 'belanja_dulu'):
			?><td><input type="text" name="semasa[belanja_dulu]" value="<?php 
			echo $perangkaan['belanja_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|belanja_kini</td><td><input type="text" name="semasa[belanja_kini]" value="<?php 
			echo (int) $semasa['belanja_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'gaji_dulu'):
			?><td><input type="text" name="semasa[gaji_dulu]" value="<?php 
			echo $perangkaan['gaji_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|gaji_kini</td><td><input type="text" name="semasa[gaji_kini]" value="<?php
			echo (int) $semasa['gaji_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'susut_dulu'):
			?><td><input type="text" name="semasa[susut_dulu]" value="<?php 
			echo $perangkaan['susut_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|susut_kini</td><td><input type="text" name="semasa[susut_kini]" value="<?php
			echo (int) $semasa['susut_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'aset_dulu'):
			?><td><input type="text" name="semasa[aset_dulu]" value="<?php
			echo $perangkaan['aset_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|aset_kini</td><td><input type="text" name="semasa[aset_kini]" value="<?php
			echo (int) $semasa['aset_kini'] ?>" class="input-large"></td><?php
		elseif($key == 'asetsewa_dulu'):
			?><td><input type="text" name="semasa[asetsewa_dulu]" value="<?php 
			echo $perangkaan['asetsewa_dulu'] ?>" class="input-large"></td><td><?php
			echo ($perangkaan['hasil_dulu']==null) ? null : 
				number_format($data / $perangkaan['hasil_dulu'],4,'.',',') . "\n";
			?>|asetsewa_kini</td><td><input type="text" name="semasa[asetsewa_kini]" value="<?php
			echo (int) $semasa['asetsewa_kini'] ?>" class="input-large"></td><?php
		else:
			?><td colspan="3"><input type="text" name="semasa[<?php echo $key 
			?>]" value="<?php echo $data ?>" class="input-large"><?php echo $data ?></td><?php
		endif;
		echo "</tr>\r";
	endif;

endforeach; ?>
<tr></tr>
</table>
<?php if (Sesi::get('namaPegawai')=='amin007') :?>
<input type="submit" name="Simpan" value="Simpan" class="btn btn-primary btn-large">
<?php endif?>
<input type="submit" name="Simpan" value="Kira" class="btn btn-primary btn-large">
</div>
