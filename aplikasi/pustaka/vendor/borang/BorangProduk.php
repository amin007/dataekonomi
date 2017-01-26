<?php

class BorangProduk
{
#///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function pencamKodProduk($kodProduk, $myTable, $cari)
	{
		# set pembolehubah
		//echo '<hr>$cari<pre>'; print_r($cari); echo '</pre><br>';
		$cariMedan = 'estab';
		$cariID = ( !isset($cari['cariID']) ) ? '' : $cari['cariID'];
		$thnMula = ( !isset($cari['mula']) ) ? '' : $cari['mula'];
		$thnAkhir = ( !isset($cari['akhir']) ) ? '' : $cari['akhir'];

		return "\rFROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
# borang Output
	public static function brgOutput($kodProduk, $myTable, $cari)
	{
		$SELECT = 'SELECT thn,';/* ' "'.$baris.'" as `#`,' Batch,Estab,*/
		$WHERE = BorangProduk::pencamKodProduk($kodProduk, $myTable, $cari);

		# mula cari $kira:$cariID dalam kod_produk['q14_2010']
		for ($kira = 1;$kira < 19; $kira++)
		{
			$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT 
				. 'F22' . $baris . ' as F22,F23' . $baris . ' as F23'
				. ',F24' . $baris . ' as F24'
				. ',concat_ws("-",F25' . $baris . ',F2542) as `F25`'
				. ',concat_ws("-",F26' . $baris . ',F2642) as `F26`'
				. ',concat_ws("-",F27' . $baris . ',F2742) as `F27`'
				. ",\r" . 'F28' . $baris . ' as `%export F28`,F29' . $baris . ' as `kodUnit`'
				. ',concat_ws("-",F30' . $baris . ',SUBSTRING(F30' . $baris . ',-10)) as `kodProduk`' 
				. ",\r" . '(IFNULL('
				. '( SELECT concat_ws("-",keterangan,kod_produk) '
				//. ', (SELECT CONCAT("<abbr title=\"", keterangan, "\">", kod_produk, "</abbr>") '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk='
				. 'SUBSTRING(F30' . $baris . ',-10) LIMIT 1)'
				. ',"kosong")) as nama_produk'	
				. $WHERE . ')';
		}# tamat ulang $kira:$cariID dalam kod_produk['q14_2010']

		# item FXX41 (25/26/27/30) dalam jadual q14_2010
			$medan[] = '(' . $SELECT
				. '"" as F22,"" as F23'
				. ',"Nilai Produk Lain2" as F24'
				. ',concat_ws("-",F2541,F2542) as `F25`'
				. ',concat_ws("-",F2641,F2642) as `F26`'
				. ',concat_ws("-",F2741,F2742) as `F27`'
				. ',"" as `%export F28`,"" as `kodUnit`'
				. ',F3041 as `kodProduk`'
				. ',"" as produk'
				. $WHERE . ')';

		/* item FXX42 (25/26/27) dalam jadual q14_2010
			$medan[] = '(' . $SELECT
				. '"" as F22,"" as F23'
				. ',"Jumlah" as F24'
				. ',F2542 as `F25`'
				. ',F2642 as `F26`'
				. ',F2742 as `F27`'
				. ',"" as `%export F28`,"" as `kodUnit`'
				. ',"" as `kodProduk`,"" as produk'
				. $WHERE . ')';
		//*/

		# papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql output='; print_r($query) . '</pre><hr>';
		return $query;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function brgInput($kodProduk, $myTable, $cari)
	{
		$SELECT = 'SELECT thn,/*Batch,Estab*/';
		$WHERE = BorangProduk::pencamKodProduk($kodProduk, $myTable, $cari);

		# mula cari $kira:$cariID dalam kod_produk['q15_2010']
		for ($kira = 51;$kira < 68; $kira++)
		{	$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT
				. 'F22' . $baris . ' as F22'
				. ',concat_ws("-",F23' . $baris . ',F2382) as `F23`'
				. ',F24' . $baris . ' as `kodUnit`'
				//. ',LPAD(F25' . $baris . ', 11, "0") as Commodity'
				. ',concat_ws("-",LPAD(F25' . $baris . ', 11, "0")'
				. ',SUBSTRING(F25' . $baris . ',-10)) as kodProduk'
				. ',( SELECT concat_ws("-",keterangan,kod_produk) '
				//. ', (SELECT CONCAT("<abbr title=\"", keterangan, "\">", kod_produk, "</abbr>") '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk = '
				. 'SUBSTRING(F25' . $baris . ',-10) LIMIT 1) as nama_produk'
				. $WHERE . ')';
		}# tamat ulang $kira:$cariID dalam kod_produk['q15_2010']

		# item F2281 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. '"Nilai Bahan Mentah Lain2" as F22,'
			. 'concat_ws("-",F2381,F2382) as `F23`,"" as `kodUnit`'
			. ',F2581 as kodProduk,"" as nama_produk'
			. $WHERE . ')';

		/* item F2282 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. '"Jumlah" as F22,F2382 as `F23`,"" as Jum,"" as `kodUnit`'
			. ',"" as kodProduk,"" as nama_produk'
			. $WHERE . ')';
		//*/

		# papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql input='; print_r($query) . '</pre>';
		return $query;
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////
#///////////////////////////////////////////////////////////////////////////////////////////////////////
}