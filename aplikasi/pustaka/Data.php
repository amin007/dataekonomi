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
	public static function cdtAsas($A,$C)
	{
		$soal['0001'] = 'Negeri';
		$soal['0002'] = 'Daerah';
		$soal['0003'] = 'DB';
		$soal['0004'] = 'Strata';
		$soal['0005'] = 'No. BP';
		$soal['0006'] = 'No. Siri';
		$soal['0007'] = 'Soalan 1.1: Nombor SSM';
		$soal['0008'] = 'Soalan 1.2: Jenis pertubuhan ? <br>1-Bebas <br> 2-HQ <br> 3-Cawangan/Pjbt Operasi) ';
		$soal['0009'] = 'Soalan 1.3: Akaun? 1-Ya | 2-Tidak';
		$soal['0010'] = 'Soalan 1.4: Tahun mula perniagaan bila';
		$soal['0011'] = 'Soalan 1.5: Tarikh mula operasi akaun';
		$soal['0012'] = 'Soalan 1.6: Tarikh akhir operasi akaun';
		$soal['0013'] = 'Soalan 1.7: Melabur luar negara ? 1-Ya | 2-Tidak';
				
		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			# ubah data dalam medan
			if (in_array($kiraan, array('0011','0012')) ) 
			{
				$data = preg_replace('/(\d{1,2})(\d{2})(\d{4})$/', 
					'$3-$2-$1', $A['F'.$kiraan]).PHP_EOL;
				$paparData = date('d M Y',strtotime($data));
			}
			elseif($kiraan=='0008')
				$paparData = (isset($C['F0008']) ? $C['F0008'] : null);
			else
				$paparData = (isset($A['F'.$kiraan]) ? $A['F'.$kiraan] : null);
			# masuk dalam array
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparData) ? $paparData : null),
				);
		endforeach;

		//echo '<pre>$C:'; print_r($C) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	}

	public static function cdtStruktur($paparID)
	{
		$soal['2001'] = 'Soalan 2: Taraf sah ?'
			. '1-Hak milik perseorangan<br>'
			. '2-Perkongsian<br>'
			. '3-Syarikat Sdn Bhd<br>'
			. '4-Syarikat Awam Bhd<br>'
			. '5-Syarikat koperasi<br>'
			. '6-Perbadanan awam<br>'
			. '7-NGO | 8-Lain2';
		$soal['3001'] = 'Soalan 3(Modal Berbayar):';
		$soal['3002'] = 'Soalan 3(Rizab)';
		$soal['3003'] = 'Struktur Hak Milik(Residen M`sia): Melayu';
		$soal['3004'] = 'Struktur Hak Milik(Residen M`sia): Iban';
		$soal['3005'] = 'Struktur Hak Milik(Residen M`sia): Bidayuh';
		$soal['3006'] = 'Struktur Hak Milik(Residen M`sia): Bajau';
		$soal['3007'] = 'Struktur Hak Milik(Residen M`sia): Kadazan';
		$soal['3008'] = 'Struktur Hak Milik(Residen M`sia): Bumiputra Lain';
		$soal['3009'] = 'Struktur Hak Milik(Residen M`sia): Cina';
		$soal['3010'] = 'Struktur Hak Milik(Residen M`sia): India';
		$soal['3011'] = 'Struktur Hak Milik(Residen M`sia): Lain2';
		$soal['3012'] = 'Struktur Hak Milik(Residen M`sia): Institusi: Bumiputra';
		$soal['3013'] = 'Struktur Hak Milik(Residen M`sia): Institusi: Lain2';
		$soal['3013'] = 'Struktur Hak Milik(Agensi Kerajaan Persekutuan,Negeri,Tempatan)';
		$soal['3013'] = 'Struktur Hak Milik(Bukan Residen M`sia)';
		
		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparID['F'.$kiraan]) ? $paparID['F'.$kiraan] : null)
				);
		endforeach;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	
	}

	public static function cdtMSIC($paparID)
	{
		$soal['4001'] = 'Aktiviti Utama Pertubuhan ? 1-Borong | 2-Runcit | 3-Kenderaaan Bermotor ';
		$soal['5001'] = 'Borong - Jenis Operasi ? 1-Pemborong | 2-Pjbt Jualan/Cawangan | 3-Agen/Broker ';
		$soal['5002'] = 'Borong - Msic 2008 ';
		$soal['5003'] = 'Borong - % jualan utama ikut msic 2008';
		$soal['6001'] = 'Runcit - Jenis Operasi ? 1-Peruncit | 2-Rangkaian/Cawangan | 3-Agen/Broker ';
		$soal['6002'] = 'Runcit - Msic 2008 ';
		$soal['6003'] = 'Runcit - % jualan utama ikut msic 2008';
		$soal['7001'] = 'Kenderaaan Bermotor - Jenis Operasi ? 1-Pusat Servis | 2-Pjbt Jualan/Cawangan | 3-Agen/Broker ';
		$soal['7002'] = 'Kenderaaan Bermotor - Msic 2008 ';
		$soal['7003'] = 'Kenderaaan Bermotor - % jualan utama ikut msic 2008';
		
		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparID['F'.$kiraan]) ? $paparID['F'.$kiraan] : null)
				);
		endforeach;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	
	}
	
	public static function cdtAset($cari)
	{
		// jenis harta
		$jenisHarta = array('01'=>'Tanah',
			'02'=>'Tmpt Kediaman',
			'03'=>'Bukan Tmpt Kediaman',
			'04'=>'Binaan lain',
			'05'=>'Kenderaan lain',
			'06'=>'Perkakasan komputer',
			'07'=>'Perisian komputer',
			'08'=>'Jentera dan kelengkapan',
			'09'=>'Perabut dan pemasangan',
			'10'=>'Lain2 harta', '11'=>'Jumlah harta');

		$nilaiBuku= array(80=>'Awal', // 'Nilai buku pada awal tahun'
			81=>'Baru', //'Pembelian baru termasuk import',
			82=>'Terpakai', //'Pembelian aset terpakai',
			83=>'DIY', //'Membuat/membina sendiri',
			84=>'Jual/tamat', // 'Aset dijual/ditamat'
			85=>'+/- jual', // 'Untung/Rugi drpd jualan harta'
			86=>'Akhir', // 'Nilai buku pada akhir tahun'
			);
		$dlmBina = array('F8012'=>'Tmpt Kediaman','F8112'=>'Bukan Tmpt Kediaman',
			'F8212'=>'Binaan lain','F8313'=>'Jentera dan kelengkapan','F8412'=>'Lain2 harta');
			foreach ($dlmBina as $kunci => $tghBina)
			{
				$binaan[$tghBina] = isset($cari[$kunci]) ? $cari[$kunci] : '_';
			}
		$kerjaDlmBinaan = array('Tmpt Kediaman','Bukan Tmpt Kediaman',
				'Binaan lain','Jentera dan kelengkapan','Lain2 harta','Jumlah');	
		# semak data //echo '<pre>Borang::binaAset($cari)='; print_r($cari) . '</pre><hr>';
		# mula cari 
		$kira = 0; 
		foreach ($jenisHarta as $key => $jenis)
		{
			if(in_array($jenis,$kerjaDlmBinaan))
				$aset[$kira]['Kerja Dlm Pelaksanaan'] = $binaan[$jenis];
			else $aset[$kira]['Kerja Dlm Pelaksanaan'] = null;
		
			//echo '<br>$key=' . $key;
			$aset[$kira]['nama'] = $jenis;
			$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;
				if ($lajur=='08')
				{/*
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
					*/	
					$aset[$kira]["$key2"] = 
						($akhir != $jumlahAset) ? $jumlahAset : $akhir;
				}
				else
				{
					$data = isset($cari[$baris]) ? $cari[$baris] : '_';
					$aset[$kira]["$key2-$modal"] =  !empty($data) ? $data : '-';
					$jum[$kira][$baris] = !empty($data) ? $data : '-';
				}
			}
			$kira++;
		}
		
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Borang::cdtAset($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;	 
	}
	
	public static function cdtStaf($prosesID)
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
				'malaysia' => (isset($prosesID['F90'.$kiraan]) ? $prosesID['F90'.$kiraan] : null),
				'pati' => (isset($prosesID['F91'.$kiraan]) ? $prosesID['F91'.$kiraan] : null),
				'jum' => (isset($prosesID['F92'.$kiraan]) ? $prosesID['F92'.$kiraan] : null),
				'gaji' => (isset($prosesID['F93'.$kiraan]) ? $prosesID['F93'.$kiraan] : null)
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($staf) . '</pre>';
		return $staf;
	
	}
	
	public static function cdtHasil($prosesID)
	{
		$kategori[] = 'Jualan barang-barang';
		$kategori[] = 'Jualan kenderaan bermotor';
		$kategori[] = 'Komisen dan yuran yang diterima';
		$kategori[] = 'Pendapatan dari perkhidmatan pembaikan, pemasangan dan penyelenggaraan';
		$kategori[] = 'Pendapatan dari jualan alat ganti dan aksesori';
		$kategori[] = 'Yuran francais / royalti diterima';
		$kategori[] = 'Pendapatan Sewa Tanah';
		$kategori[] = 'Pendapatan Sewa Lain2';
		$kategori[] = 'Pendapatan operasi lain(Perkhidmatan pengurusan, bayaran perkhidmatan yg diterima)';
		$kategori[] = 'Pendapatan bukan operasi';
		$kategori[] = 'Jumlah Besar';

		for ($kira = 1; $kira <= 11; $kira++):
			$kiraan = kira3($kira,2);
			$hasil[] = array(
				'nama_medan' => ($kategori[$kira-1]), 
				'kod' => 'F10' . $kiraan,
				'data' => (isset($prosesID['F10'.$kiraan]) ? $prosesID['F10'.$kiraan] : null)
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($hasil) . '</pre>';
		return $hasil;
	
	}

	public static function cdtBelanja($prosesID)
	{
		$kategori[] = 'Pembelian bahan & bekalan';
		$kategori[] = 'Kos barangan yang dijual';
		$kategori[] = 'Kos pembaikan dan penyelenggaraan';
		$kategori[] = 'Yuran francais / royalti dibayar';
		$kategori[] = 'Air yang digunakan';
		$kategori[] = 'Tenaga elektrik yang dibeli';
		$kategori[] = 'Bahan pembakar, pelincir dan gas';
		$kategori[] = 'Bayaran tel';
		$kategori[] = 'Pembelian perkhidmatan pengangkutan';
		$kategori[] = 'Pengiklanan dan promosi';
		$kategori[] = 'Kos percetakan';
		$kategori[] = 'Bayaran sewa tanah';
		$kategori[] = 'Bayaran Sewa Lain2';
		$kategori[] = 'Perbelanjaan operasi lain';
		$kategori[] = 'Cukai langsung (cth. cukai syarikat, cukai kemajuan)';
		$kategori[] = 'Cukai tidak langsung : Cukai jualan, cukai perkhidmatan, taksiran (ke atas tanah & bangunan), '
			. 'cukai tanah dan cukai tidak langsung lain';
		$kategori[] = 'Bayaran faedah';
		$kategori[] = 'Susut nilai';
		$kategori[] = 'Perbelanjaan bukan operasi';
		$kategori[] = 'Gaji dan upah yang dibayar';
		$kategori[] = 'caruman (cth kwsp,perkeso)';
		$kategori[] = 'kos latihan kepada staf';
		$kategori[] = 'bayaran staf lain2';
		$kategori[] = 'Jumlah Besar';

		for ($kira = 1; $kira <= 24; $kira++):
			$kiraan = kira3($kira,2);
			$belanja[] = array(
				'nama_medan' => ($kategori[$kira-1]), 
				'kod' => 'F11' . $kiraan,
				'data' => (isset($prosesID['F11'.$kiraan]) ? $prosesID['F11'.$kiraan] : null)
				);
		endfor;

		return $belanja;
	}

	public static function cdtStok($prosesID)
	{
		$kategori[] = 'Stok perdagangan';
		$kategori[] = 'Lain2 stok';
		$kategori[] = 'Jumlah Besar';
		$senarai = null;
		$senarai[] = array(
			'nama_medan' => ($kategori[0]), 
			'awal' => (isset($prosesID['F1201']) ? $prosesID['F1201'] : null),
			'akhir' => (isset($prosesID['F1202']) ? $prosesID['F1202'] : null)
			);
		$senarai[] = array(
			'nama_medan' => ($kategori[1]), 
			'awal' => (isset($prosesID['F1203']) ? $prosesID['F1203'] : null),
			'akhir' => (isset($prosesID['F1204']) ? $prosesID['F1204'] : null)
			);
		$senarai[] = array(
			'nama_medan' => ($kategori[2]), 
			'awal' => (isset($prosesID['F1205']) ? $prosesID['F1205'] : null),
			'akhir' => (isset($prosesID['F1206']) ? $prosesID['F1206'] : null)
			);


		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	}
	
	public static function cdtTambahan($prosesID)
	{
		$soal['1301'] = 'Soalan 13(Jenis organisasi): Francias ? 1-Ya / 2-Tidak';
		$soal['1302'] = 'Soalan 13(Jenis organisasi): Jenis Francias ? 1-Francaisi / 2-Francaisor ';
		$soal['1402'] = 'Soalan 14(EDagang): Beli Barang Online ? 1-Ya / 2-Tidak';
		$soal['1404'] = 'Soalan 14(EDagang): Jual Barang Online ? 1-Ya / 2-Tidak';
		$soal['1405'] = 'Soalan 14(EDagang): Perkhidmatan IT ? 1-Emal/2-Web/3-SMS/4-Lain/5-Tiada kaitan';
		$soal['1501'] = 'Soalan 15(Pemasaran): Kaedah Pemasaran? 1-Media/2-Internet/3-(Katalog/Risalah)/4-Lain/5-Tiada kaitan';
		$soal['1502'] = 'Soalan 15(Pemasaran): Teknologi ? 1-Barcode/2-POS/3-FRID/4-sistem pengurusan logistil/5-lain2 perisian/6-Tiada kaitan';
		$soal['1601'] = 'Soalan 16(Lokasi)? '
			. '1-Dlm kompleks beli belah/2-Dlm bangunan persendirian/<br>'
			. '3-Dlm rumah kediaman/4-Premis pasar raya besar jenis bangunan bersendirian/<br>'
			. '5-Dlm hotel/6-Gerai pasar/7-Lain-lain';

		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($prosesID['F'.$kiraan]) ? $prosesID['F'.$kiraan] : null)
				);
		endforeach;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
## Data icdt 2012

	public static function icdtAsas($A)
	{
		$soal['0001'] = 'Negeri';
		$soal['0002'] = 'Daerah';
		$soal['0003'] = 'DB';
		$soal['0004'] = 'No BP';
		$soal['0005'] = 'Soalan 1.1: Nombor SSM';
		$soal['0006'] = 'Soalan 1.2: Jenis pertubuhan ? <br>1-Bebas <br> 2-HQ <br> 3-Cawangan/Pjbt Operasi) ';
		$soal['0007'] = 'Soalan 1.4: Tahun mula perniagaan bila';
		$soal['0008'] = 'Soalan 1.5: Tarikh mula operasi akaun';
		$soal['0009'] = 'Soalan 1.6: Tarikh akhir operasi akaun';
		$soal['0010'] = 'Soalan 1.7: Melabur luar negara ? 1-Ya | 2-Tidak';
		$soal['2001'] = 'Soalan 2.1: Taraf sah ?'
			. '1-Hak milik perseorangan<br>'
			. '2-Perkongsian<br>'
			. '3-Syarikat Sdn Bhd<br>'
			. '4-Syarikat Awam Bhd<br>'
			. '5-Syarikat koperasi<br>'
			. '6-Perbadanan awam<br>'
			. '7-NGO | 8-Lain2';
		$soal['2002'] = 'Soalan 2.2: Milikan wanita ?';
		$senarai = null;
		
		foreach ($soal as $kiraan => $soalan):
			# ubah data dalam medan
			if (in_array($kiraan, array('0008','0009')) ) 
			{
				$data = preg_replace('/(\d{1,2})(\d{2})(\d{4})$/', 
					'$3-$2-$1', $A['F'.$kiraan]).PHP_EOL;
				$paparData = date('d M Y',strtotime($data));
			}
			else
				$paparData = (isset($A['F'.$kiraan]) ? $A['F'.$kiraan] : null);
			# masuk dalam array
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparData) ? $paparData : null),
				);
		endforeach;

		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	}

	public static function icdtStruktur($paparID)
	{
		$soal['3001'] = 'Soalan 3(Modal Berbayar):';
		$soal['3002'] = 'Soalan 3(Rizab)';
		$soal['3003'] = 'Struktur Hak Milik(Residen M`sia): Melayu';
		$soal['3004'] = 'Struktur Hak Milik(Residen M`sia): Cina';
		$soal['3005'] = 'Struktur Hak Milik(Residen M`sia): India';
		$soal['3006'] = 'Struktur Hak Milik(Residen M`sia): Lain2';
		$soal['3007'] = 'Struktur Hak Milik(Residen M`sia): Institusi: Bumiputra';
		$soal['3008'] = 'Struktur Hak Milik(Residen M`sia): Institusi: Lain2';
		$soal['3009'] = 'Struktur Hak Milik(Agensi Kerajaan Persekutuan,Negeri,Tempatan)';
		$soal['3010'] = 'Struktur Hak Milik(Bukan Residen M`sia)';
		
		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparID['F'.$kiraan]) ? $paparID['F'.$kiraan] : null)
				);
		endforeach;

		//echo '<pre>$senarai:'; print_r($senarai) . '</pre>';
		return $senarai;
	
	}

	public static function icdtMSIC($paparID)
	{
		$soal['subsektor'] = 'Aktiviti Utama Pertubuhan ? 1-Borong | 2-Runcit | 3-Kenderaaan Bermotor ';
		$soal['msic2008'] = 'msic 2008';
		
		$senarai = null;
		foreach ($soal as $kiraan => $soalan):
			$namaMedan = $kiraan; //'F'.$kiraan;
			$senarai[] = array(
				'nama_medan' => ($soal[$kiraan]), 
				'kod' => 'F' . $kiraan,
				'data' => (isset($paparID[$namaMedan]) ? $paparID[$namaMedan] : null)
				);
		endforeach;

		//echo '<pre>$senarai:'; print_r($senarai) . '</pre>';
		return $senarai;
	
	}

	public static function icdtAset($cari)
	{
		// jenis harta
		$jenisHarta = array('01'=>'Tanah',
			'02'=>'Tmpt Kediaman',
			'03'=>'Bukan Tmpt Kediaman',
			'04'=>'Binaan lain',
			'05'=>'Kenderaan lain',
			'06'=>'Perkakasan komputer',
			'07'=>'Perisian komputer',
			'08'=>'Jentera dan kelengkapan',
			'09'=>'Perabut dan pemasangan',
			'10'=>'Paten', '11'=>'Muhibbah', 
			'12'=>'Lain2 harta','13'=>'Jumlah');

		$nilaiBuku= array(60=>'Awal', // 'Nilai buku pada awal tahun'
			61=>'Baru', //'Pembelian baru termasuk import',
			62=>'Terpakai', //'Pembelian aset terpakai',
			63=>'Pembaikan dan pengubahsuaian', //'Ubahsuai',
			64=>'DIY', //'Membuat/membina sendiri',
			65=>'Jual/tamat', // 'Aset dijual/ditamat'
			66=>'+/- jual', // 'Untung/Rugi drpd jualan harta'
			67=>'Susut nilai', // 'Susut nilai'
			68=>'Akhir');// 'Nilai buku pada akhir tahun'
		
		$dlmBina = array('F1480'=>'Tmpt Kediaman','F1580'=>'Bukan Tmpt Kediaman',
			'F1680'=>'Binaan lain','F1780'=>'Jentera dan kelengkapan','F1880'=>'Lain2 harta','F1980'=>'Jumlah');
			foreach ($dlmBina as $kunci => $tghBina)
			{
				$binaan[$tghBina] = isset($cari[$kunci]) ? $cari[$kunci] : '_';
			}
		$kerjaDlmBinaan = array('Tmpt Kediaman','Bukan Tmpt Kediaman',
				'Binaan lain','Jentera dan kelengkapan','Lain2 harta','Jumlah');
		# semak data  //echo '<pre>Borang::binaAset($cari)='; print_r($cari) . '</pre><hr>';
		# mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{	
			if(in_array($jenis,$kerjaDlmBinaan))
				$aset[$kira]['Kerja Dlm Pelaksanaan'] = $binaan[$jenis];
			else $aset[$kira]['Kerja Dlm Pelaksanaan'] = null;
			
			$aset[$kira]['nama'] = $jenis;
			$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;
				if ($lajur=='68')
				{
					$jumlahAset = 
						( $jum[$kira]['F60'.$key] // Awal
						+ $jum[$kira]['F61'.$key] // Baru
						+ $jum[$kira]['F62'.$key] // Terpakai
						+ $jum[$kira]['F63'.$key] // Ubahsuai
						+ $jum[$kira]['F64'.$key] // DIV
						- $jum[$kira]['F65'.$key] // jual/tamat
						+ ( $jum[$kira]['F66'.$key] // +/- jual
						) - $jum[$kira]['F67'.$key] ); // Susut nilai
					$akhir = (isset($cari[$baris]) ? $cari[$baris] : '_');
					$aset[$kira]["$key2-$modal"] = 
						($akhir != $jumlahAset) ? $jumlahAset : $akhir;
				}
				else
				{
					$data = isset($cari[$baris]) ? $cari[$baris] : '_';
					$aset[$kira]["$key2-$modal"] =  !empty($data) ? $data : '-';
					$jum[$kira][$baris] = !empty($data) ? $data : '-';
				}
			}
			$kira++;
		}
		
		//echo '<pre>Borang::cdtAset($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;	 
	}
	
	public static function icdtStaf($prosesID)
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
				'malaysia' => (isset($prosesID['F80'.$kiraan]) ? $prosesID['F80'.$kiraan] : null),
				'pati' => (isset($prosesID['F81'.$kiraan]) ? $prosesID['F81'.$kiraan] : null),
				'jum' => (isset($prosesID['F82'.$kiraan]) ? $prosesID['F82'.$kiraan] : null),
				'gaji' => (isset($prosesID['F83'.$kiraan]) ? $prosesID['F83'.$kiraan] : null)
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($staf) . '</pre>';
		return $staf;
	
	}
	
	public static function icdtHasil($prosesID)
	{

		$kategori[] = 'Jualan barang-barang';
		$kategori[] = 'Jualan kenderaan bermotor';
		$kategori[] = 'Komisen dan yuran yang diterima';
		$kategori[] = 'Pendapatan dari perkhidmatan pembaikan, pemasangan dan penyelenggaraan';
		$kategori[] = 'Pendapatan dari jualan alat ganti dan aksesori';
		$kategori[] = 'Yuran francais / royalti diterima';
		$kategori[] = 'Pendapatan Sewa Tanah';
		$kategori[] = 'Pendapatan Sewa Lain2';
		$kategori[] = 'Pendapatan operasi lain(Perkhidmatan pengurusan, bayaran perkhidmatan yg diterima)';
		$kategori[] = 'Pendapatan bukan operasi';
		$kategori[] = 'Jumlah Besar';

		for ($kira = 1; $kira <= 11; $kira++):
			$kiraan = kira3($kira,2);
			$namaMedan = 'F11' . $kiraan;
			$hasil[] = array(
				'nama_medan' => ($kategori[$kira-1]), 
				'kod' => $namaMedan,
				'data' => (isset($prosesID[$namaMedan]) ? $prosesID[$namaMedan] : null)
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($hasil) . '</pre>';
		return $hasil;
	
	}

	public static function icdtBelanja($prosesID)
	{
		$kategori[] = 'Pembelian bahan & bekalan'; // 1
		$kategori[] = 'Kos barangan yang dijual'; // 2
		$kategori[] = 'Kos pembaikan dan penyelenggaraan'; //3
		$kategori[] = 'Yuran francais / royalti dibayar'; // 4
		$kategori[] = 'Air yang digunakan'; // 5
		$kategori[] = 'Tenaga elektrik yang dibeli'; // 6
		$kategori[] = 'Bahan pembakar, pelincir dan gas'; // 7
		$kategori[] = 'Bayaran tel'; // 8
		$kategori[] = 'Pembelian perkhidmatan pengangkutan'; // 9
		$kategori[] = 'Pengiklanan dan promosi'; // 10
		$kategori[] = 'Kos percetakan'; // 11
		$kategori[] = 'Bayaran sewa tanah'; // 12
		$kategori[] = 'Bayaran Sewa Lain2'; // 13
		$kategori[] = 'Perbelanjaan operasi lain'; // 14
		//$kategori[] = 'Perbelanjaan berkaitan ICT'; // 15	
		$kategori[] = 'Cukai langsung (cth. cukai syarikat, cukai kemajuan)'; // 16
		$kategori[] = 'Cukai tidak langsung : Cukai jualan, cukai perkhidmatan, taksiran (ke atas tanah & bangunan), '
			. 'cukai tanah dan cukai tidak langsung lain'; // 17
		$kategori[] = 'Bayaran faedah'; // 18
		$kategori[] = 'Susut nilai'; // 19
		$kategori[] = 'Perbelanjaan bukan operasi'; // 20
		$kategori[] = 'Gaji dan upah yang dibayar'; // 21

		for ($kira = 1; $kira <= 20; $kira++):
			$kiraan = kira3($kira,2);
			$kodMedan = 'F12' . $kiraan;
			$belanja[] = array(
				'nama_medan' => ($kategori[$kira-1]), 
				'kod' => $kodMedan,
				'data' => (isset($prosesID[$kodMedan]) ? $prosesID[$kodMedan] : null)
				);
		endfor;
		# kena buat asing
		$kategori2['F1225'] = 'caruman (cth kwsp,perkeso)'; // 22
		$kategori2['F1222'] = 'kos pakaian percuma kepada staf'; // 23
		$kategori2['F1229'] = 'Bayaran pengarah tidak bekerja'; // 24
		$kategori2['F1232'] = 'bayaran staf lain2'; // 25
		$kategori2['F1233'] = 'Jumlah Besar'; // 26
		
		//echo '<pre>'; print_r($kategori2) . '</pre>';
		foreach ($kategori2 as $kodMedan2 => $keterangan):
			$belanja[] = array(
				'nama_medan' => $keterangan, 
				'kod' => $kodMedan2,
				'data' => (isset($prosesID[$kodMedan2]) ? $prosesID[$kodMedan2] : null)
				);
		endforeach;

		return $belanja;
	}

	public static function icdtStok($prosesID)
	{
		$kategori[] = 'Stok perdagangan';
		$kategori[] = 'Lain2 stok';
		$kategori[] = 'Jumlah Besar';
		$senarai = null;
		$senarai[] = array(
			'nama_medan' => ($kategori[0]), 
			'awal' => (isset($prosesID['F1001']) ? $prosesID['F1001'] : null),
			'akhir' => (isset($prosesID['F1004']) ? $prosesID['F1004'] : null)
			);
		$senarai[] = array(
			'nama_medan' => ($kategori[1]), 
			'awal' => (isset($prosesID['F1002']) ? $prosesID['F1002'] : null),
			'akhir' => (isset($prosesID['F1005']) ? $prosesID['F1005'] : null)
			);
		$senarai[] = array(
			'nama_medan' => ($kategori[2]), 
			'awal' => (isset($prosesID['F1003']) ? $prosesID['F1003'] : null),
			'akhir' => (isset($prosesID['F1006']) ? $prosesID['F1006'] : null)
			);


		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($senarai) . '</pre>';
		return $senarai;
	}
	
	public static function icdtCawangan($prosesID)
	{
		$kategori[] = 'Johor';
		$kategori[] = 'Kedah';
		$kategori[] = 'Kelantan';
		$kategori[] = 'Melaka';
		$kategori[] = 'Negeri Sembilan';
		$kategori[] = 'Pahang';
		$kategori[] = 'Pulau Pinang';
		$kategori[] = 'Perak';
		$kategori[] = 'Perlis';
		$kategori[] = 'Selangor';
		$kategori[] = 'Terengganu';
		$kategori[] = 'Sabah';
		$kategori[] = 'Sarawak';
		$kategori[] = 'W.P. Kuala Lumpur';
		$kategori[] = 'W.P. Labuan';
		$kategori[] = 'W.P. Putrajaya';
		$kategori[] = 'Jumlah Besar';
		$kategori[] = 'Entah';
		$kategori[] = 'Entah2';
		
		$senarai = null;
		for ($kira = 1; $kira <= 19; $kira++):
			$kiraan = kira3($kira,2);
			$senarai[] = array(
				'kategori' => ($kategori[$kira-1]), 
				'jumlah jualan' => (isset($prosesID['F15'.$kiraan]) ? $prosesID['F15'.$kiraan] : null),
				'cawangan' => (isset($prosesID['F16'.$kiraan]) ? $prosesID['F16'.$kiraan] : null),
				'entah' => (isset($prosesID['F17'.$kiraan]) ? $prosesID['F17'.$kiraan] : null),
				);
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		return $senarai;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
} // tamat class Data