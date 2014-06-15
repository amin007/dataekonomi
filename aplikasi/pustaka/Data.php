<?php

class Data
{
	
	private $_postData = array();
	
	public function __construct() {}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function cariKeterangan($kesID)
	{
		$senarai = array(); // setkan pembolehubah dulu
		foreach ($kesID as $jadual => $kunci):
			foreach ($kunci as $kunci2):
				foreach ($kunci2 as $namaMedan => $data):
					//echo '$namaMedan:'.$namaMedan.' | $jadual:'.$jadual.' <br>';
					$senarai[$jadual][$namaMedan] = $data;
				endforeach;
			endforeach;
		endforeach;
		
		return $senarai;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////	
	public static function sqlAset($cari)
	{
		// jenis harta
		$jenisHarta = array(71=>'Tanah',
			72=>'Tmpt kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 84=>'Muhibah',
			86=>'Lain2 harta', 99=>'Jumlah harta');

		$nilaiBuku= array(1=>'Awal', // 'Nilai buku pada awal tahun'
			2=>'Baru', //'Pembelian baru termasuk import',
			3=>'Terpakai', //'Pembelian aset terpakai',
			4=>'DIY', //'Membuat/membina sendiri',
			5=>'Jual/tamat', // 'Aset dijual/ditamat'
			6=>'+/- jual', // 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', // 'Nilai buku pada akhir tahun'
			9=>'Sewa',85=>'Kerja dlm pelaksanaan');
		
		// semak data
		//echo '<pre>Borang::binaAset($cari)='; print_r($cari) . '</pre><hr>';
		
		// mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{
			//echo '<br>$key=' . $key;
			$aset[$kira]['nama'] = $jenis;
			$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;
				if ($lajur=='08')
				{
					$jumlahAset = 
						( $jum[$kira]['F01'.$key] 
						+ $jum[$kira]['F02'.$key]
						+ $jum[$kira]['F03'.$key] 
						+ $jum[$kira]['F04'.$key]
						- $jum[$kira]['F05'.$key] 
						+ ( $jum[$kira]['F06'.$key] 
						) - $jum[$kira]['F07'.$key] );

					$akhir = (isset($cari[$baris]) ?
						$cari[$baris] : '_');
						
					$aset[$kira][$baris] = 
						($akhir != $jumlahAset) ? $jumlahAset : $akhir;
				}
				elseif ($lajur == '85')
				{
					$pilihKey = array('F71','F75','F76','F77','F78','F79','F80','F82','F70','F84');
					$kunci = 'F' . $key;
					$baris2 = 'F' . $key . $lajur;
					$aset[$kira][$baris2] = (in_array($kunci, $pilihKey)) ? '-' : null;
				}
				else
				{
					$data = isset($cari[$baris]) ? $cari[$baris] : '_';

					$aset[$kira][$baris] =  !empty($data) ? $data : '-';
					$jum[$kira][$baris] = !empty($data) ? $data : '-';
				}
			}
			$kira++;
		}
		
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Data::sqlAset($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;
	 
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////	
	public static function sqlOutput($kodProduk, $myTable, $cari)
	{
		// set pembolehubah
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		$SELECT = 'SELECT thn,Batch/*,Estab*/';
		$WHERE = " FROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";

		// mula cari $kira:$cariID dalam kod_produk['q14_2010']
		for ($kira = 1;$kira < 19; $kira++)
		{
			$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT
				. ',F22' . $baris . ' as F2201,F23' . $baris . ' as F2301'
				. ',F24' . $baris . ' as F2401,F25' . $baris . ' as `F2501(RM)`'
				. ',F26' . $baris . ' as `F2601(RM)`,F27' . $baris . ' as `F2701(RM)`'
				. ',F28' . $baris . ' as F2801,F29' . $baris . ' as F2901'
				. ',concat_ws("<br>",F30' . $baris . ',SUBSTRING(F30' . $baris . ',-10)) as F3001' 
				//',( SELECT concat_ws("-",kod_produk, keterangan) '
				. ', (SELECT CONCAT(keterangan, "-", kod_produk) '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk='
				. 'SUBSTRING(F30' . $baris . ',-10) LIMIT 1) as nama_produk'	
				. $WHERE . ')';
		}// tamat ulang $kira:$cariID dalam kod_produk['q14_2010']

		// item FXX41 (25/26/27/30) dalam jadual q14_2010
			$medan[] = '(' . $SELECT
				. ',"" as F2201,"" as F2301'
				. ',"Nilai Produk Lain2" as F2401'
				. ',F2541 as `F2501(RM)`'
				. ',F2641 as `F2601(RM)`'
				. ',F2741 as `F2701(RM)`'
				. ',"" as F2801,"" as F2901'
				. ',F3041 as F3001'
				. ',"" as produk'
				. $WHERE . ')';

		// item FXX42 (25/26/27) dalam jadual q14_2010
			$medan[] = '(' . $SELECT
				. ',"" as F2201,"" as F2301'
				. ',"Jumlah" as F2401'
				. ',F2542 as `F2501(RM)`'
				. ',F2642 as `F2601(RM)`'
				. ',F2742 as `F2701(RM)`'
				. ',"" as F2801,"" as F2901'
				. ',"" as F3001,"" as produk'
				. $WHERE . ')';

		// papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql output='; print_r($query) . '</pre><hr>';
		return $query;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function sqlInput($kodProduk, $myTable, $cari)
	{
		// set pembolehubah
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		$SELECT = 'SELECT thn,Batch/*,Estab*/';
		$WHERE = " FROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";
			 
		// mula cari $kira:$cariID dalam kod_produk['q15_2010']
		for ($kira = 51;$kira < 68; $kira++)
		{	$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT
				. ',F22' . $baris . ' as F22,F23' . $baris . ' as `F23(RM)`'
				. ',F24' . $baris . ' as F24'
				. ',LPAD(F25' . $baris . ', 11, "0") as Commodity'
				//. ',concat_ws("<br>",LPAD(F25' . $baris . ', 11, "0")'
				//. ',SUBSTRING(F25' . $baris . ',-10)) as Commodity' 
				. ', (SELECT CONCAT(keterangan, "-", kod_produk) '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk = '
				. 'SUBSTRING(F25' . $baris . ',-10) LIMIT 1) as nama_produk'	
				. $WHERE . ')';
		}// tamat ulang $kira:$cariID dalam kod_produk['q15_2010']

		// item F2281 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. ',"Nilai Bahan Mentah Lain2" as F22,'
			. 'F2381 as `F23(RM)`,"" as F24'
			. ',F2581 as Commodity,"" as nama_produk'
			. $WHERE . ')';
		
		// item F2282 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. ',"Jumlah" as F22,F2382 as `F23(RM)`,"" as F24'
			. ',"" as Commodity,"" as nama_produk'
			. $WHERE . ')';
		
		// papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql input='; print_r($query) . '</pre>';
		return $query;
			 
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function KodOutput($info)
	{
		if (isset($info)) 
		{
			$data = $info[0]; //echo '<hr><pre>$data='; print_r($data) . '</pre>';
			/*[thn] => 2010 | [Batch] => J0193 |  [Estab] => 000000321060*/
			$lajur = array(22=>'Bhn mentah luar',23=>'Bhn mentah sendiri',
				24=>'Kuatiti jualan',25=>'Nilai Jualan',
				26=>'Stok Awal',27=>'Stok Akhir',28=>'% export',
				29=>'Kod unit',30=>'Kod produk');
			$rm = array(25,26,27);
			// mula cari 
			$b = 0;
			for ($kira = 0;$kira < 18; $kira++):
				$no = kira3($kira+1, 2);
				//if ($data['F30' . $no] != 0):
					$baris[$b]['thn'] = $data['thn'];
					//$baris[$b]['Batch'] = $data['Batch'];
					//$baris[$b]['Estab'] = $data['Estab'];
					foreach ($lajur as $key => $nama):
						$m = 'F' . $key . $no;
						$papar = (!isset($data[$m]) ) ? '' : $data[$m];
						//if (in_array($key,$rm)) $baris[$b][$f . '(RM)'] = $papar;
						if ($key==30)
							$baris[$b]['Commodity'] = $papar;
						else
							$baris[$b][$m] = $papar;
					endforeach;
					// pecahan untuk nama produk
					$baris[$b]['nama_produk'] = substr($data['F30' . $no],-10);
					$b++;
				//endif;
			endfor;
				// item FXX41 (25/26/27/30) dalam jadual q14_2010
				$b2 = $b;
				$lajur2 = array(25,26,27,30);
				$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '41';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					if ($key == 24) 
						$baris[$b2][$f] = 'Nilai Produk Lain2';
					elseif ($key==30)
						$baris[$b]['Commodity'] = $papar;
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $papar;
					elseif (in_array($key,$lajur2))
						$baris[$b2][$m] =  $papar;
					else $baris[$b2][$f] = null;
				endforeach;
				$baris[$b]['nama_produk'] = $data['F3041'];
				// item FXX42 (25/26/27) dalam jadual q14_2010
				$b2 = $b+1;
				$lajur3 = array(25,26,27);
				$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '42';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					if ($key == 24) 
						$baris[$b2][$f] = 'Jumlah';
					elseif ($key==30)
						$baris[$b]['Commodity'] = null;
					elseif (in_array($key,$lajur3))
						$baris[$b2][$m] = $papar;
					else $baris[$b2][$f] = null;
				endforeach;

			//echo '<pre>Borang::kodOutput($baris)='; print_r($baris) . '</pre><hr>';
			return $baris;
		}
		else
			return $baris = null;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function KodInput($info)
	{
		if (isset($info)) 
		{
			$data = $info[0]; //echo '<hr><pre>$data='; print_r($data) . '</pre>';
			/*[thn] => 2010 | [Batch] => J0193 |  [Estab] => 000000321060*/
			$lajur = array(22=>'Kuantiti',23=>'Kos bhn mentah',
				24=>'Kod unit',25=>'Commodity');
			$rm = array(23);
			// mula cari $kira:$cariID dalam kod_produk['q15_2010']
			$b = 0;
			for ($kira = 51;$kira < 68; $kira++):
				$no = kira3($kira, 2);
				//if ($data['F25' . $no] != 0):
					$baris[$b]['thn'] = $data['thn'];
					//$baris[$b]['Batch'] = $data['Batch'];
					//$baris[$b]['Estab'] = $data['Estab'];
					foreach ($lajur as $key => $nama):
						$m = 'F' . $key . $no;
						$f = ($key==25) ? 'Commodity' : $m;
						$papar = (!isset($data[$m]) ) ? '' : $data[$m];
						//if (in_array($key,$rm))
						//	$baris[$b][$f . '(RM)'] = $data[$m];
						//else
							$baris[$b][$f] = $papar;
					endforeach;
					// cari nama produk
					$baris[$b]['nama_produk'] = substr($data['F25' . $no],-10);
					$b++;			
				//endif;		
			endfor;// tamat ulang $kira:$cariID dalam kod_produk['q15_2010']

			// item F2381, F2581 dalam jadual q15_2010
				$b2 = $b;
				$lajur2 = array(23,25); // F2381, F2581
				$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '81';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					if ($key == 22) 
						$baris[$b2][$f] = 'Nilai Bahan Mentah Lain2';
					elseif ($key == 23)
						$baris[$b2][$m] = $papar;
					elseif ($key == 24)
						$baris[$b2][$f] = null;
					elseif ($key == 25) 						
						$baris[$b2]['Commodity'] = $papar;
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $data[$m];
				endforeach;
				$baris[$b2]['nama_produk'] = $data['F2581'];
			// item F2382 dalam jadual q15_2010
				$b2 = $b+1;
				$lajur3 = array(23); // F2382
				$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '82';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					if ($key == 22) 
						$baris[$b2][$f] = 'Jumlah';
					elseif ($key == 23)			
						$baris[$b2][$m] = $papar;
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $data[$m];
					//else $baris[$b2][$f] = null;
				endforeach;

			//echo '<pre>Borang::kodOutput($baris)='; print_r($baris) . '</pre><hr>';
			return $baris;
		}
		else
			return $baris = null;
			
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function daftarAset($cari)
	{
		// jenis harta
		$jenisHarta = array(71=>'Tanah',
			72=>'Tmpt kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 84=>'Muhibah',
			86=>'Lain2 harta', 99=>'Jumlah harta', 
			85=>'Kerja dlm pelaksanaan');

		$nilaiBuku= array(1=>'Awal', // 'Nilai buku pada awal tahun'
			2=>'Baru', //'Pembelian baru termasuk import',
			3=>'Terpakai', //'Pembelian aset terpakai',
			4=>'DIY', //'Membuat/membina sendiri',
			5=>'Jual/tamat', // 'Aset dijual/ditamat'
			6=>'+/- jual', // 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', // 'Nilai buku pada akhir tahun'
			9=>'Sewa');
		
		// semak data
		//echo '<pre>Borang::binaAset($cari)='; print_r($cari) . '</pre><hr>';
		
		// mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{
			//echo '<br>$key=' . $key;
			$aset[$kira]['nama'] = $jenis;
			$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;
				if ($lajur=='08')
				{
					$jumlahAset = 
						( $jum[$kira]['F01'.$key] 
						+ $jum[$kira]['F02'.$key]
						+ $jum[$kira]['F03'.$key] 
						+ $jum[$kira]['F04'.$key]
						- $jum[$kira]['F05'.$key] 
						+ ( $jum[$kira]['F06'.$key] 
						) - $jum[$kira]['F07'.$key] );

					$akhir = (isset($cari[$baris]) ?
						$cari[$baris] : '_');
						
					$aset[$kira]["0$key2"] = 
						($akhir != $jumlahAset) ? $jumlahAset : $akhir;
				}
				else
				{
					$data = isset($cari[$baris]) ? $cari[$baris] : '_';

					$aset[$kira]["0$key2"] =  !empty($data) ? $data : '-';
					$jum[$kira][$baris] = !empty($data) ? $data : '-';
				}
			}
			$kira++;
		}
		
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Borang::binaAset($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;	 
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function produkOutput($info)
	{
		if (isset($info)) 
		{
			$data = $info[0]; //echo '<hr><pre>$data='; print_r($data) . '</pre>';
			/*[thn] => 2010 | [Batch] => J0193 |  [Estab] => 000000321060*/
			$lajur = array(22=>'Bhn mentah luar',23=>'Bhn mentah sendiri',
				24=>'Kuatiti jualan',25=>'Nilai Jualan',
				26=>'Stok Awal',27=>'Stok Akhir',28=>'% export',
				29=>'Kod unit',30=>'Kod produk');
			$rm = array(25,26,27);
			// mula cari 
			$b = 0;
			for ($kira = 0;$kira < 18; $kira++):
				$no = kira3($kira+1, 2);
				//if ($data[$kod] != 0):
					//$baris[$b]['thn'] = $data['thn'];
					//$baris[$b]['Batch'] = $data['Batch'];
					//$baris[$b]['Estab'] = $data['Estab'];
					foreach ($lajur as $key => $nama):
						$m = 'F' . $key . $no;
						$papar = (!isset($data[$m]) ) ? '' : $data[$m];
						// untuk kod Commodity
						$kod = 'F30'.($no); 
						$kodCommodity = (!isset($data[$kod]) ) ? '' : $data[$kod];
						//if (in_array($key,$rm)) $baris[$b][$f . '(RM)'] = $papar;
						if ($key==30)
							$baris[$b]['Commodity'] = $kodCommodity;
						else
							$baris[$b][$m] = $papar;
					endforeach;
					// pecahan untuk nama produk
					//$baris[$b]['nama_produk'] = substr($data['F30' . $no],-10);
					$b++;
				//endif;
			endfor;
				// item FXX41 (25/26/27/30) dalam jadual q14_2010
				$b2 = $b;
				$lajur2 = array(25,26,27,30);
				//$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '41';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					// untuk kod Commodity
						$kod = 'F3041'; 
						$kodCommodity = (!isset($data[$kod]) ) ? '' : $data[$kod];
					if ($key == 24) 
						$baris[$b2][$f] = 'Nilai Produk Lain2';
					elseif ($key==30)
						$baris[$b]['Commodity'] = $kodCommodity;
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $papar;
					elseif (in_array($key,$lajur2))
						$baris[$b2][$m] =  $papar;
					else $baris[$b2][$f] = null;
				endforeach;
				//$baris[$b]['nama_produk'] = $data['F3041'];
				// item FXX42 (25/26/27) dalam jadual q14_2010
				$b2 = $b+1;
				$lajur3 = array(25,26,27);
				//$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '42';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;					
					if ($key == 24) 
						$baris[$b2][$f] = 'Jumlah';
					elseif ($key==30)
						$baris[$b]['Commodity'] = null;
					elseif (in_array($key,$lajur3))
						$baris[$b2][$m] = $papar;
					else $baris[$b2][$f] = null;
				endforeach;

			//echo '<pre>Borang::kodOutput($baris)='; print_r($baris) . '</pre><hr>';
			return $baris;
		}
		else
			return $baris = null;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function produkInput($info)
	{
		if (isset($info)) 
		{
			$data = $info[0]; //echo '<hr><pre>$data='; print_r($data) . '</pre>';
			/*[thn] => 2010 | [Batch] => J0193 |  [Estab] => 000000321060*/
			$lajur = array(22=>'Kuantiti',23=>'Kos bhn mentah',
				24=>'Kod unit',25=>'Commodity');
			$rm = array(23);
			// mula cari $kira:$cariID dalam kod_produk['q15_2010']
			$b = 0;
			for ($kira = 51;$kira < 68; $kira++):
				$no = kira3($kira, 2);
				//if ($data[$kod] != 0):
					//$baris[$b]['thn'] = $data['thn'];
					//$baris[$b]['Batch'] = $data['Batch'];
					//$baris[$b]['Estab'] = $data['Estab'];
					foreach ($lajur as $key => $nama):
						$m = 'F' . $key . $no;					
						$f = ($key==25) ? 'Commodity' : $m;
						$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					// untuk kod Commodity
						$kod = 'F25'.($no); 
						$kodCommodity = (!isset($data[$kod]) ) ? '' : $data[$kod];
						
						if ($key==25)
							$baris[$b][$f] = $kodCommodity;
						elseif (in_array($key,$rm))
							$baris[$b][$f . '(RM)'] = $papar;				
						else
							$baris[$b][$f] = $papar;
					endforeach;
					// cari nama produk
					//$baris[$b]['nama_produk'] = substr($data['F25' . $no],-10);
					$b++;			
				//endif;
			endfor;// tamat ulang $kira:$cariID dalam kod_produk['q15_2010']

			// item F2381, F2581 dalam jadual q15_2010
				$b2 = $b;
				$lajur2 = array(23,25); // F2381, F2581
				//$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '81';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					// untuk kodCommodity
						$kod = 'F3081'; 
						$kodCommodity = (!isset($data[$kod]) ) ? '' : $data[$kod];					
					if ($key == 22) 
						$baris[$b2][$f] = 'Nilai Bahan Mentah Lain2';
					elseif ($key == 23)
						$baris[$b2][$m] = $papar;
					elseif ($key == 24)
						$baris[$b2][$f] = null;
					elseif ($key == 25)
					{	
						$baris[$b2]['Commodity'] = $kodCommodity;
					}
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $data[$m];
				endforeach;
				//$baris[$b2]['nama_produk'] = $data['F2581'];
			// item F2382 dalam jadual q15_2010
				$b2 = $b+1;
				$lajur3 = array(23); // F2382
				//$baris[$b2]['thn'] = $data['thn'];
				//$baris[$b2]['Batch'] = $data['Batch'];
				//$baris[$b2]['Estab'] = $data['Estab'];
				foreach ($lajur as $key => $nama):
					$m = 'F' . $key . '82-jum';
					//$jumBesar = 'F2382-jum';
					$papar = (!isset($data[$m]) ) ? '' : $data[$m];
					$f = 'F' . $key;
					if ($key == 22) 
						$baris[$b2][$f] = 'Jumlah';
					elseif ($key == 23)			
						$baris[$b2][$m] = $papar;
					//elseif (in_array($key,$rm))
					//	$baris[$b2][$f . '(RM)'] = $data[$m];
					//else $baris[$b2][$f] = null;
				endforeach;

			//echo '<pre>Borang::kodOutput($baris)='; print_r($baris) . '</pre><hr>';
			return $baris;
		}
		else
			return $baris = null;
			
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function dataPekerja($jadualStaf,$jenisKerja,$prosesID)
	{		
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 18=>'Gaji');
		$lelaki = array(1=>'Pemilik(ROB)-1',2=>'Pekerja keluarga(ROB)-2',
			3=>'Pengurusan-3.1',4=>'Juruteknik-3.2',
			5=>'Kerani-3.3',6=>'Pekerja Asas-3.4',
			7=>'-3.5',8=>'-3.6',9=>'',10=>'',
			11=>'Pekerja sambilan-4',19=>'Jumlah pekerja-5');
		$keyLelaki = array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,8=>9,9=>10,10=>11,11=>19);
		$wanita = array(21=>'Pemilik(ROB)-1',22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',26=>'Pekerja Asas-3.4',
			27=>'-3.5',	28=>'-3.6',29=>'',30=>'',
			31=>'Pekerja sambilan-4',39=>'Jumlah pekerja-5');
		$keyWanita = array(0=>21,1=>22,2=>23,3=>24,4=>25,5=>26,6=>27,7=>28,	8=>29,9=>30,10=>31,11=>39);

	/*		
	$lelaki:Array						|$wanita:Array
	(
		[1] => Pemilik(ROB)-1			[21] => Pemilik(ROB)-1
		[2] => Pekerja keluarga(ROB)-2	[22] => Pekerja keluarga(ROB)-2
		[3] => Pengurusan-3.1			[23] => Pengurusan-3.1
		[4] => Juruteknik-3.2			[24] => Juruteknik-3.2
		[5] => Kerani-3.3				[25] => Kerani-3.3
		[6] => Pekerja Asas-3.4			[26] => Pekerja Asas-3.4
		[7] => -3.5						[27] => -3.5
		[8] => -3.6						[28] => -3.6
		[11] => Pekerja sambilan-4		[31] => Pekerja sambilan-4
		[19] => Jumlah pekerja-5		[39] => Jumlah pekerja-5
	)

	*/
		$mula = 'q05a';
		foreach ($jadualStaf as $key => $myTable):
			//$cari = $prosesID[$myTable][0];
			if (isset($prosesID[$myTable][0])):
				if(strpos($myTable,$mula) !== false)
					//echo 'lelaki';
					$cariL = $prosesID[$myTable][0];
				else
					//echo 'perempuan';
					$cariW = $prosesID[$myTable][0];
			endif;
		endforeach;
		$kira=0;
		foreach ($jenisKerja as $key => $kategori):
			$data = null; $data2 = null;
			$pekerja[$kira]['nama'] = $kategori;
			foreach ($bangsaStaf as $key1 => $bangsa):
			// set pembolehubah asas
				$lajur = kira3($key1, 2); 
				$kunci = pilihKeyData($key,$keyLelaki,$lelaki);
				$pekerja[$kira]['L'] = $kunci;
				$baris = kira3($kunci, 2); 
				$medan  = 'F' . $lajur . $baris;
				$data = isset($cariL[$medan]) ?	$cariL[$medan] : '_';
			// mula masuk data
				$pilihBangsa = array (/*'Melayu','Cina',*/'Gaji');
				$pekerja[$kira][(in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa|L$lajur": "L$lajur"] =
					 !empty($data) ? $data : '-';
			endforeach;
			//echo 'Lelaki:' . $kategori . '$kunci:' . $kunci . '->' . $data;
			foreach ($bangsaStaf as $key2 => $bangsa):
			// set pembolehubah asas
				$lajur2 = kira3($key2, 2); 
				$kunci2 = pilihKeyData($key,$keyWanita,$wanita);
				$pekerja[$kira]['W'] = $kunci2;
				$baris2 = kira3($kunci2, 2); 		
				$medan2 = 'F' . $lajur2 . $baris2;
				$data2  = isset($cariW[$medan2]) ?	$cariW[$medan2] : '_';
			// mula masuk data
				$pilihBangsa = array (/*'Melayu','Cina',*/'Gaji');
				$pekerja[$kira][(in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa|W$lajur2": "W$lajur2"] =
					 !empty($data2) ? $data2 : '-';
			endforeach;
			//echo '|Wanita:' . $kategori . '$kunci:' . $kunci2 . '->' . $data2;
			//$pekerja[$kira]['Wanita'] = $kategori;
			//echo '<hr>';
			$kira++;
		endforeach;
	
	return $pekerja;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function dataPekerjaBrgAm($prosesID)
	{

		$kategori[] = 'Lelaki - Pemilik(ROB)-1 / 6.3';
		$kategori[] = 'Wanita - Pemilik(ROB)-1 / 6.3';
		$kategori[] = 'Lelaki - Pekerja keluarga(ROB)-2 / 6.4';
		$kategori[] = 'Wanita - Pekerja keluarga(ROB)-2 / 6.4';
		$kategori[] = '<b>Lelaki - Jum pekerja bergaji -5.3.6 / 6.5</b>';
		$kategori[] = '<b>Wanita - Jum pekerja bergaji -5.3.6 / 6.5</b>';
		$kategori[] = 'Lelaki - Pengurusan-3.1 / 6.5.A';
		$kategori[] = 'Wanita - Pengurusan-3.1 / 6.5.A';
		$kategori[] = 'Lelaki - Juruteknik-3.2 / 6.5.B';
		$kategori[] = 'Wanita - Juruteknik-3.2 / 6.5.B';
		$kategori[] = 'Lelaki - Kerani-3.3 / 6.5.C';
		$kategori[] = 'Wanita - Kerani-3.3 / 6.5.C';
		$kategori[] = 'Lelaki - pekerja am';
		$kategori[] = 'Wanita - pekerja am';
		$kategori[] = 'Lelaki - Pekerja sambilan-4 / 6.6';
		$kategori[] = 'Wanita - Pekerja sambilan-4 / 6.6';
		$kategori[] = 'Lelaki - Jumlah pekerja-5 / 6.7';
		$kategori[] = 'Wanita - Jumlah pekerja-5 / 6.7';

		for ($kira = 1; $kira <= 18; $kira++):
			$kiraan = kira3($kira,2);
			$staf[] = array(
				'kategori' => ($kategori[$kira-1]), 
				'malaysia' => (isset($prosesID[0]['F10'.$kiraan]) ? $prosesID[0]['F10'.$kiraan] : null),
				'pati' => (isset($prosesID[0]['F11'.$kiraan]) ? $prosesID[0]['F11'.$kiraan] : null),
				'jum' => (isset($prosesID[0]['F12'.$kiraan]) ? $prosesID[0]['F12'.$kiraan] : null),
				'gaji' => (isset($prosesID[0]['F13'.$kiraan]) ? $prosesID[0]['F13'.$kiraan] : null)
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($staf) . '</pre>';
		return $staf;
	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
} // tamat class Data