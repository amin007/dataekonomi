<?php
if ($this->carian=='[id:0]')
	echo '<h1><span class="badge">Prosesan' . $this->sv . ': data kosong </span></h1>';
else
{ // $this->carian=='sidap' - mula
	$cari = $this->carian; 
	$ID = $this->paparID; 
	$tahun = $this->thn_mula . ' hingga ' . $this->thn_akhir;
	$tempohtahun = $ID . '/' . $this->thn_mula . '/' . $this->thn_akhir;
	$cetak = URL . $this->kelas . 'ubah/' . $this->sv . '/' . $tempohtahun;
	$tajuk = 'Prosesan' . $this->sv . ' : Dari tahun ' . $tahun;
	$mencari = URL . $this->kelas . 'ubahCetak/';
	$senaraiMedan = array('thn','Estab','F0002','F0014','F0015');
	//echo '$cetak:' . $cetak . '|$mencari:' . $mencari;
?>

<div align="center"><form method="POST" action="<?php echo $mencari ?>" autocomplete="off">
<span class="badge"><?php echo $tajuk ?></span>
<a href="<?php echo $cetak ?>"><span class="badge">
<i class="icon-file icon-white"></i>Papar</span></a>
<input type="text" name="cari" size="40" value="<?=$ID?>">
<font size="5" color="red">&rarr;</font>
<input type="submit" value="mencari">
</form></div>


<?php
/*
$mula = 1;
echo '<table><tr>';
foreach ($this->kawalID as $myTable => $row)
{	//if ( count($row)==0 ) { echo ''; }
	if ( count($row)!=0 )
	{
		if ($mula++%10==0)
		{ // mula kalau baki 0
			?><td valign="top" align="center">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparData($this->sv, $myTable, $row, 
				$this->keterangan, $senaraiMedan);
			echo "</td>\n</tr>\n<tr>";
		} // tamat kalau baki 0
		else
		{ // mula kalau baki bukan 0
			?><td valign="top" align="center">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparData($this->sv, $myTable, $row, 
				$this->keterangan, $senaraiMedan);
			echo "</td>\n";
		} // tamat kalau baki bukan 0
	}
}
echo '</tr></table>';
*/
?>

<table><tr>
<?php
$mula = 1;
$lajur = ($this->sv==205) ? 10 : 9;
foreach ($this->prosesID as $myTable => $row)
{	//if ( count($row)==0 ) { echo ''; }
	if ( count($row)!=0 )
	{
		if ($mula++%$lajur==0)
		{ // mula kalau baki 0
			?><td valign="top" align="center">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparData($this->sv, $myTable, $row, 
				$this->keterangan, $senaraiMedan);
			echo "</td>\n</tr>\n<tr>";
		} // tamat kalau baki 0
		else
		{ // mula kalau baki bukan 0
			?><td valign="top" align="center">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparData($this->sv, $myTable, $row, 
				$this->keterangan, $senaraiMedan);
			echo "</td>\n";
		} // tamat kalau baki bukan 0
	}
}
?>
</tr></table>

<hr>
<table><tr>
<?php 
$mula = 1;
foreach ($this->kod_produk as $myTable => $row)
{
	if ( count($row)==0 ) echo '';
	else
	{
		if ($mula++%2==0)
		{ // mula kalau baki 0
			?><td valign="top" align="left">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparKodProduk($this->sv, $myTable, $row);
			echo "</td>\n</tr>\n<tr>";
		} // tamat kalau baki 0
		else
		{ // mula kalau baki bukan 0
			?><td valign="top" align="left">
<span class="badge badge-success"><?php echo $myTable ?></span><?php
			paparKodProduk($this->sv, $myTable, $row);
			echo "</td>\n";
		} // tamat kalau baki bukan 0
		
	} // if ( count($row)==0 )
}
?>

</tr></table>

<?php } // $this->carian=='sidap' - tamat ?>