<?php
include 'ubah_fungsi.php';
/*echo '<pre>';#  mula - semak pembolehubah 
echo '<br>\$this->peratus = ' . $this->peratus;
echo '<br>\$this->carian = ' . $this->carian;
echo '<br>\$this->sv = ' . $this->sv;
echo '<br>\$this->kawalID = '; print_r($this->kawalID);
echo '<br>\$this->thn_mula = ' . $this->thn_mula;
echo '<br>\$this->thn_akhir =  ' . $this->thn_akhir;
echo '</pre>';# tamat - semak pembolehubah //*/

if ( !isset($this->carian) || $this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan: data kosong </span></h1>';
else
{ # $this->carian=='sidap' - mula
	$ID = $cari = $this->carian; 
	$tahun = $this->thn_mula . ' hingga ' . $this->thn_akhir;
	$cetakID = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir . '/cetak';
	$paparID = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir;
	$tajuk = 'Prosesan' . $this->sv . ' : Dari tahun ' . $tahun;
	$cetak = URL . $this->kelas . 'ubah/' . $this->sv . '/' . $cetakID;
	$prosesan = URL . 'cprosesan/ubah/' . $this->sv . '/' . $paparID;
	$mencari = URL . $this->kelas . 'ubahCetak/' . $this->sv;
	$senaraiMedan = array('thn','Estab','F0002','F0014','F0015');
	$buangJadual = array('q04_2010','q05a_2010','q05b_2010',
		's' . $this->sv . '_q04_2010','s' . $this->sv . '_q05a_2010',
		's' . $this->sv . '_q05b_2010','lelaki','wanita'); 
	echo "\n" . paparInputCarian($mencari, $tajuk, $prosesan, $cetak, $ID) . "\n";
?><hr><form method="post" action="<?php echo URL;?>semakan/simpan/" target="_blank">

<?php include 'ubah_data_newss.php'; 
include 'ubah_data_prosesan.php';
include 'ubah_data_kod_produk.php';
if ( isset($this->perangkaan['belanja']) )
	include 'ubah_borang.php';
?>
</form>

<?php } // $this->carian=='sidap' - tamat ?><?php
function paparInputCarian($mencari, $tajuk, $prosesan, $cetak, $ID)
{?>
<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<span class="badge"><?php echo $tajuk ?></span>
<a href="<?php echo $prosesan ?>"><span class="badge"><i
 class="icon-print icon-white"></i>Cprosesan</span></a>
<a href="<?php echo $cetak ?>"><span class="badge"><i
 class="icon-print icon-white"></i>Cetak</span></a>
<input type="text" name="cari" size="40" value="<?=$ID?>">
<font size="5" color="red">&rarr;</font>
<input type="submit" value="mencari">
</form></div><?php
}