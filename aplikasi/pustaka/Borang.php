<?php

class Borang
{

	private $_postData = array();

	public function __construct() {}

	public function post($field)
	{
		$this->_postData[$field] = $_POST[$field];
	}

	public static function tambahBaru($paparMedan)
	{
		# dapatkan nama_medan,jenis_medan,input_medan dlm class Borang
		//Borang::tambahBaru($paparMedan);
		###################################################################################
		//echo '$paparMedan:'; print_r($paparMedan) . '';
		foreach ($paparMedan as $myTable => $row):
		#-----------------------------------------------------------------
			for ($kira=0; $kira < count($row); $kira++)
			{		 
				foreach ( $row[$kira] as $key=>$data ) :
					if ($key=='Field')
						$nama_medan[$kira] = $data;
					elseif ($key=='Type') 
						$jenis_medan[$kira] = $data;
					else
					{
						$input = paparMedanDaftar($myTable, $nama_medan[$kira], 
							$jenis_medan[$kira], null);
						$inputMedan[$kira] = htmlentities($input);
						$input_medan[$kira] = $input;
					}
				endforeach;
			}
		#-----------------------------------------------------------------
		endforeach; # tamat $row

		###################################################################################	
		/*echo '<pre>';
		//echo '$this->paparMedan:'; print_r($paparMedan) . '';
		//echo '$sesi:'; print_r($sesi);
		echo '$this->jenis_medan:'; print_r($jenis_medan) . '';
		echo '$this->nama_medan:'; print_r($nama_medan) . '';
		//echo '$this->input_data:'; print_r($input_data) . '';
		echo '$this->input_medan:'; print_r($input_medan) . '';
		echo '</pre>';*/
		###################################################################################
		# masukkan dalam tatasusunan dan pulangkan ke class KAWAL
		$inputBorang['jenis_medan'] = $jenis_medan;
		$inputBorang['nama_medan'] = $nama_medan;
		//$inputBorang['input_data'] = $input_data;
		$inputBorang['input_medan'] = $input_medan;
		return $inputBorang;
		###################################################################################
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function tambah($paparMedan)
	{
		# dapatkan nama_medan,jenis_medan,input_medan dlm class Borang
		//Borang::tambah($paparMedan);
		###################################################################################
		//echo '$paparMedan:'; print_r($paparMedan) . '';
		foreach ($paparMedan as $myTable => $row):
		#-----------------------------------------------------------------
			for ($kira=0; $kira < count($row); $kira++)
			{		 
				foreach ( $row[$kira] as $key=>$data ) :
					if ($key=='Field')
						$nama_medan[$kira] = $data;
					elseif ($key=='Type') 
						$jenis_medan[$kira] = $data;
					else
					{
						$input = paparMedanDaftarSesi($myTable, $nama_medan[$kira], 
							$jenis_medan[$kira], null, $sesi);
						$inputMedan[$kira] = htmlentities($input);
						$input_medan[$kira] = $input;
					}
				endforeach;
			}
		#-----------------------------------------------------------------
		endforeach; # tamat $row

		###################################################################################	
		/*echo '<pre>';
		//echo '$this->paparMedan:'; print_r($paparMedan) . '';
		//echo '$sesi:'; print_r($sesi);
		echo '$this->jenis_medan:'; print_r($jenis_medan) . '';
		echo '$this->nama_medan:'; print_r($nama_medan) . '';
		echo '$this->input_data:'; print_r($input_data) . '';
		echo '$this->input_medan:'; print_r($input_medan) . '';
		echo '</pre>';//*/
		###################################################################################
		# masukkan dalam tatasusunan dan pulangkan ke class KAWAL
		$inputBorang['jenis_medan'] = $jenis_medan;
		$inputBorang['nama_medan'] = $nama_medan;
		$inputBorang['input_data'] = $input_data;
		$inputBorang['input_medan'] = $input_medan;
		return $inputBorang;
		###################################################################################
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function tambahSimpan($jadual)
	{
		# semak $_POST dalam class Borang
		//$data = Borang::tambahSimpan($this->_jadual);
		$data = array();

		foreach ($_POST as $key => $value):
			if ($key==$jadual)
			{
				$data['namaJadual'] = $key;
				foreach ($value as $kekunci => $papar):
					$data[$kekunci] = $papar;
				endforeach;
			}
		endforeach;
		
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		//echo '<pre>$data:'; print_r($data) . '</pre>';

		return $data;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function ubah($noAhli, $paparMedan, $pilihMedan)
	{
		# dapatkan nama_medan,jenis_medan,input_medan 
		# dlm class Borang::ubah()
		# pembolehubah : $noAhli, $paparMedan
		###################################################################################
		# cari no Ahli
		foreach ($noAhli as $key => $data):
			$input_data[] = $data;
		endforeach; # tamat $row
		//echo '<pre>$this->input_data:'; print_r($input_data) . '</pre>';
		###################################################################################
		foreach ($paparMedan as $myTable => $row):
		#-----------------------------------------------------------------
			for ($kira=0; $kira < count($row); $kira++)
			{		 
				foreach ( $row[$kira] as $key=>$data ) :
					if ($key=='Field')
						$nama_medan[$kira] = $data;
					elseif ($key=='Type') 
						$jenis_medan[$kira] = $data;
					else
					{
						$input = ubahMedanSesi($myTable, $nama_medan[$kira], 
						$jenis_medan[$kira], $input_data[$kira]);
						//$input_medan[$kira] = htmlentities($input);
						$input_medan[$kira] = $input;
					}
				endforeach;
			}
		#-----------------------------------------------------------------
		endforeach; # tamat $row

		###################################################################################	
		/*echo '<pre>';
		//echo '$this->paparMedan:'; print_r($paparMedan) . '';
		//echo '$this->jenis_medan:'; print_r($jenis_medan) . '';
		echo '$this->nama_medan:'; print_r($nama_medan) . '';
		echo '$this->input_medan:'; print_r($input_medan) . '';
		echo '</pre>';//*/
		###################################################################################
		# masukkan dalam tatasusunan dan pulangkan ke class KAWAL
		$inputBorang['jenis_medan'] = $jenis_medan;
		$inputBorang['nama_medan'] = $nama_medan;
		$inputBorang['input_data'] = $input_data;
		$inputBorang['input_medan'] = $input_medan;
		return $inputBorang;
		###################################################################################
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function ubahSimpan($jadual)
	{
		# semak $_POST dalam class Borang::ubahSimpan($this->_jadual)
		//$data = Borang::ubahSimpan($thid->_jadual);
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		$data = array();
	
		foreach ($_POST as $key => $value):
			if ($key==$jadual)
			{
				$data['namaJadual'] = $key;
				foreach ($value as $kekunci => $papar):
					$data[$kekunci] = $papar;
				endforeach;
			}
		endforeach;
		//echo '<pre>$data:'; print_r($data) . '</pre>';
		//echo '<pre>$jadual:'; print_r($jadual) . '</pre>';

		return $data;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function cariKeterangan($kesID)
	{
		$senarai = array(); # setkan pembolehubah dulu
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
	public static function binaKodOutput($kodProduk, $myTable, $cari)
	{
		# set pembolehubah
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		$SELECT = 'SELECT thn,Batch/*,Estab*/';
		$WHERE = " FROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";

		# mula cari $kira:$cariID dalam kod_produk['q14_2010']
		for ($kira = 1;$kira < 19; $kira++)
		{
			$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT
				. ',F22' . $baris . ' as F2201,F23' . $baris . ' as F2301'
				. ',F24' . $baris . ' as F2401,F25' . $baris . ' as `F2501(RM)`'
				. ',F26' . $baris . ' as `F2601(RM)`,F27' . $baris . ' as `F2701(RM)`'
				. ',F28' . $baris . ' as F2801,F29' . $baris . ' as F2901'
				. ',concat_ws("<br>",F30' . $baris . ',SUBSTRING(F30' . $baris . ',-10)) as F3001' 
				. ',( SELECT concat_ws("-",keterangan,kod_produk) '
				//. ', (SELECT CONCAT("<abbr title=\"", keterangan, "\">", kod_produk, "</abbr>") '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk='
				. 'SUBSTRING(F30' . $baris . ',-10) LIMIT 1) as nama_produk'
				. $WHERE . ')';
		}# tamat ulang $kira:$cariID dalam kod_produk['q14_2010']

		# item FXX41 (25/26/27/30) dalam jadual q14_2010
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

		# item FXX42 (25/26/27) dalam jadual q14_2010
			$medan[] = '(' . $SELECT
				. ',"" as F2201,"" as F2301'
				. ',"Jumlah" as F2401'
				. ',F2542 as `F2501(RM)`'
				. ',F2642 as `F2601(RM)`'
				. ',F2742 as `F2701(RM)`'
				. ',"" as F2801,"" as F2901'
				. ',"" as F3001,"" as produk'
				. $WHERE . ')';

		# papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql output='; print_r($query) . '</pre><hr>';
		return $query;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function binaKodInput($kodProduk, $myTable, $cari)
	{
		# set pembolehubah
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];
		$SELECT = 'SELECT thn,Batch/*,Estab*/';
		$WHERE = " FROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";

		# mula cari $kira:$cariID dalam kod_produk['q15_2010']
		for ($kira = 51;$kira < 68; $kira++)
		{	$baris = kira3($kira, 2);
			$medan[] = '(' . $SELECT
				. ',F22' . $baris . ' as F22,F23' . $baris . ' as `F23(RM)`'
				. ',F24' . $baris . ' as F24'
				. ',LPAD(F25' . $baris . ', 11, "0") as Commodity'
				//. ',concat_ws("<br>",LPAD(F25' . $baris . ', 11, "0")'
				//. ',SUBSTRING(F25' . $baris . ',-10)) as Commodity' 
				. ',( SELECT concat_ws("-",keterangan,kod_produk) '
				//. ', (SELECT CONCAT("<abbr title=\"", keterangan, "\">", kod_produk, "</abbr>") '
				. 'FROM ' . $kodProduk . ' b WHERE b.kod_produk = '
				. 'SUBSTRING(F25' . $baris . ',-10) LIMIT 1) as nama_produk'
				. $WHERE . ')';
		}# tamat ulang $kira:$cariID dalam kod_produk['q15_2010']

		# item F2281 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. ',"Nilai Bahan Mentah Lain2" as F22,'
			. 'F2381 as `F23(RM)`,"" as F24'
			. ',F2581 as Commodity,"" as nama_produk'
			. $WHERE . ')';

		# item F2282 dalam jadual q15_2010
		$medan[] = '(' . $SELECT
			. ',"Jumlah" as F22,F2382 as `F23(RM)`,"" as F24'
			. ',"" as Commodity,"" as nama_produk'
			. $WHERE . ')';

		# papar sql
		$query = implode("\rUNION\r",$medan);
		//echo '<hr><pre>$sql input='; print_r($query) . '</pre>';
		return $query;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function pencamKodProduk($kodProduk, $myTable, $cari)
	{
		# set pembolehubah
		//echo '<hr>$cari<pre>'; print_r($cari); echo '</pre><br>';
		$cariMedan = ( !isset($cari['medan']) ) ? '' : $cari['medan'];
		$cariID = ( !isset($cari['id']) ) ? '' : $cari['id'];
		$thnMula = ( !isset($cari['thn_mula']) ) ? '' : $cari['thn_mula'];
		$thnAkhir = ( !isset($cari['thn_akhir']) ) ? '' : $cari['thn_akhir'];

		return "\rFROM `$myTable` "
			. "WHERE $cariMedan like '$cariID%' "
			. "AND thn BETWEEN $thnMula and $thnAkhir";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
# borang Output
	public static function borangOutput($kodProduk, $myTable, $cari)
	{
		$SELECT = 'SELECT thn,';/* ' "'.$baris.'" as `#`,' Batch,Estab,*/
		$WHERE = Borang::pencamKodProduk($kodProduk, $myTable, $cari);

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
	public static function borangInput($kodProduk, $myTable, $cari)
	{
		$SELECT = 'SELECT thn,/*Batch,Estab*/';
		$WHERE = Borang::pencamKodProduk($kodProduk, $myTable, $cari);

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
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function inputAset($cari)
	{
		# jenis harta
		$jenisHarta = array(71=>'Tanah',
			72=>'Tmpt kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			88=>'Bas',
			89=>'Ambulan',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 84=>'Muhibah',
			86=>'Lain2 harta', 99=>'Jumlah harta', 
			85=>'Kerja dlm pelaksanaan');

		$nilaiBuku= array(1=>'Awal', # 'Nilai buku pada awal tahun'
			2=>'Baru', # 'Pembelian baru termasuk import',
			3=>'Terpakai', # 'Pembelian aset terpakai',
			4=>'DIY', # 'Membuat/membina sendiri',
			5=>'Jual/tamat', # 'Aset dijual/ditamat'
			6=>'+/- jual', # 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', # 'Nilai buku pada akhir tahun'
			9=>'Sewa');

		# semak data
		//echo '<pre>Borang::binaAset($cari)='; print_r($cari) . '</pre><hr>';

		# mula cari 
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

					$akhir = (isset($cari[$baris]) ? $cari[$baris] : '_');

					$aset[$kira][$baris] = 
						($akhir != $jumlahAset) ? $jumlahAset : $akhir;
				}
				else
				{
					$data = isset($cari[$baris]) ? $cari[$baris] : '';

					$aset[$kira][$baris] =  !empty($data) ? $data : '0';
					$jum[$kira][$baris] = !empty($data) ? $data : '0';
				}
			}
			$kira++;
		}
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Borang::binaAset($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////	
	public static function inputAsetAm($cari)
	{
		# jenis harta
		$jenisHarta = array(1=>'Tanah(X71)',
			2=>'Bangunan dan binaan lain(X72,X73,X74,X75)',
			3=>'Kenderaan(X76,X77,X78)',
			4=>'Perkakasan komputer(X79)',
			5=>'Perisian komputer(X80)',
			6=>'Jentera dan kelengkapan(X81)',
			7=>'Perabut dan pemasangan(X82)',
			8=>'Muhibah dsb(X84),Paten(X70),',
			9=>'Lain2 harta(X86)', 0=>'Jumlah harta(X99)',
			81=>'Harta tetap dibuat/dibina sendiri(F04X)',
			82=>'Jumlah harta tetap pada akhir tahun(F0899/M0083)',
			83=>'Semua harta',
			84=>'Jumlah tanggungan(M0084)',
			85=>'Modal Berbayar(F0031/M0085)',
			86=>'Rizab(F0032/M0086)');

		$nilaiBuku= array(6=>'Pelupusan',7=>'Pembelian');
			
		# set pembolehubah awal
		$jumAset_dulu = $jum['aset_dulu'];
		$jumAset_kini = $jum['aset_kini'];

		//echo '<pre>Borang::inputAsetAm($cari)='; print_r($cari) . '</pre><hr>';
		# mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{	
			$aset[$kira]['nama'] = $jenis;
			//$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 1);
				$baris = 'F00' . $lajur . $key;
				//echo '<br>553:'.$baris.'='.$cari[$baris];
				if ($key=='0')
				{
					$aset[$kira]['F0070'] = 
						isset($cari['F0070']) ? $cari['F0070'] : 0;
					$aset[$kira]['F0080'] = 
						isset($cari['F0080']) ? $cari['F0080'] : 0;
				}
				elseif (in_array($key,array(81,82,83,84,85,86)) )
				{
					//$aset[$kira]['F00'.$key] = 
					$aset[$kira]['F00'.$key] = 
						isset($cari['F00'.$key]) ? $cari['F00'.$key] : 0;
				}
				else
				{# mula kiraan bandingan antara 2 tahun
					$aset[$kira][$baris] = isset($cari[$baris]) ?	$cari[$baris] : 0;
				}
			}
			$kira++;
		}
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Borang::binaAsetAm($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
##---------------------------------------------------------------------------------------------------------------------
	public static function tatasusunanAsetBiologi()
	{
		$jenisHartaBenda = array(
			71=>'Tanah',
			72=>'Tmpt Kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			89=>'Ambulan',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 
			84=>'Muhibah',
			86=>'Lain2 harta', 
			99=>'Jumlah harta');

		$jenisHartaTanaman = array(
			71=>'Tanah',
			72=>'Tmpt Kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			89=>'Ambulan',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 
			84=>'Muhibah',
			86=>'Lain2 harta', 
			88=>'Jumlah harta tanaman');

		$jenisHartaPokok = array(	
			60=>'4.3 Kelapa Sawit Matang - 60', # 6 0 1 2 6 1 0 1 0 0 1
			61=>'4.3 Kelapa Sawit Tak Matang - 61', # 6 0 1 2 6 1 0 1 0 0 1
			62=>'4.4 Getah Matang - 62', # 0 8 - 5 0 1 2 9 1 0 1 0 0 1
			63=>'4.4 Getah Tak Matang - 63', # 0 8 - 5 0 1 2 9 1 0 1 0 0 1
			64=>'4.5 Koko Matang - 64', # 0 8 - 7 0 1 2 7 3 0 1 0 0 1
			65=>'4.5 Koko Tak Matang - 65', # 0 8 - 7 0 1 2 7 3 0 1 0 0 1
			66=>'4.6 Durian Matang - 66', #  0 8 - 2 0 1 2 2 3 0 1 0 0 1
			67=>'4.6 Durian Tak Matang - 67', #  0 8 - 2 0 1 2 2 3 0 1 0 0 1
			90=>'4.7 Mangga Matang - 90', #, 0 8 - 3 0 1 2 2 2 0 1 0 0 1
			91=>'4.7 Mangga Tak Matang - 91', #, 0 8 - 3 0 1 2 2 2 0 1 0 0 1
			92=>'4.8 Tanaman Lain2 Matang - 92',
			93=>'4.8 Tanaman Lain2 Tak Matang - 93',
			94=>'4.8 Tanaman Lain2 Matang - 94',
			95=>'4.8 Tanaman Lain2 Tak Matang - 95',
			98=>'4.9 Jumlah Tanaman',
			99=>'Jumlah harta semua');

		$nilaiBuku = array(1=>'Awal', # 'Nilai buku pada awal tahun'
			2=>'Baru', # 'Pembelian baru termasuk import',
			3=>'Terpakai', # 'Pembelian aset terpakai',
			4=>'DIY', # 'Membuat/membina sendiri',
			5=>'Jual|tamat', # 'Aset dijual/ditamat'
			6=>'+/- jual', # 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', # 'Nilai buku pada akhir tahun'
			9=>'Sewa');

			$nilaiBukuTanaman = array(1=>'Awal', # 'Nilai buku pada awal tahun'
			2=>'Baru', # 'Pembelian baru termasuk import',
			3=>'-',
			4=>'Belanja tanaman jangka panjang', # 'Belanja pembangunan tanaman jangka panjang',
			5=>'Jual|Tebang|Rosak', # 'Aset dijual/ditamat'
			6=>'+/- jual', # 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', # 'Nilai buku pada akhir tahun'
			9=>'Kod Produk');

		$dlmBina = array('F7285'=>'Tmpt Kediaman','F7385'=>'Bukan Tmpt Kediaman',
			'F7485'=>'Binaan lain','F8185'=>'Jentera dan kelengkapan',
			'F8685'=>'Lain2 harta','F9985'=>'Jumlah harta');
		$kerjaDlmBinaan = array('Tmpt Kediaman','Bukan Tmpt Kediaman',
				'Binaan lain','Jentera dan kelengkapan','Lain2 harta','Jumlah');

		return array($jenisHartaBenda, $jenisHartaTanaman, $jenisHartaPokok,
			$nilaiBuku, $nilaiBukuTanaman,
			$dlmBina, $kerjaDlmBinaan);
	}
##---------------------------------------------------------------------------------------------------------------------
#----------------------------------------------------------------------------------------------------------------------
	public static function binaAset($cari, $kp)
	{
		# setkan tatasusunan
		list($jenisHartaBenda, $jenisHartaTanaman, $jenisHartaPokok,
			$nilaiBuku, $nilaiBukuTanaman,
			$dlmBina, $kerjaDlmBinaan) = Borang::tatasusunanAsetBiologi();
		$jenisHarta = ($kp=='101') ? $jenisHartaTanaman : $jenisHartaBenda;

		foreach ($dlmBina as $kunci => $tghBina)
		{
			$binaan[$tghBina] = isset($cari[$kunci]) ? $cari[$kunci] : '_';
		}

		# mula bina tatasusunan
		$kira = $calc = 0;
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;

				if ($lajur=='08')
					$data = Borang::kiraHarta04b($jum, $kira, $key, $cari, $baris);
				else
					$data = isset($cari[$baris]) ? $cari[$baris] : '0';

				# buat tatasusunan
					$t0["$tajuk - $key2"] =  !empty($data) ? $data : '';
					$jum[$kira][$baris] = !empty($data) ? $data : '-';
					$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			//if (array_sum($jumlah[$calc]['F']) != 0) # buang data kosong
				$aset[$kira++] = array_merge(
					array('Kerja Dlm Pelaksanaan' => Borang::kiraKerjaDlmPelaksanaan($jenis,$kerjaDlmBinaan,$binaan),
					'nama' => $jenis, 'kod' => $key), $t0);
			//else $calc++;
		endforeach; # foreach ($jenisHarta as $key => $jenis):
		//echo '<pre>$cari='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>line 709:$kp('.$kp.')|$jenisHarta='; print_r($jenisHarta); echo '</pre><hr>';
		//echo '<pre>Borang::binaAset($aset)='; print_r($aset); echo '</pre><hr>';
		return $aset;
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function kiraKerjaDlmPelaksanaan($jenis,$kerjaDlmBinaan,$binaan)
	{
			if(in_array($jenis,$kerjaDlmBinaan)):
				$nilai = $binaan[$jenis] . '';
				$jumHarta += $binaan[$jenis];
			elseif(in_array($jenis,array('Jumlah harta'))):
				$nilai = ($binaan[$jenis]==0) ? '_'
					: $binaan[$jenis] . '|calc=' . $jumHarta . '';
			else: $nilai = null;
			endif;

		return $nilai;
	}
##---------------------------------------------------------------------------------------------------------------------
	function kiraHarta04b($jum, $kira, $key, $cari, $baris, $data)
	{
			$jumlahAset = 
				( $jum[$kira]['F01'.$key]
				+ $jum[$kira]['F02'.$key]
				+ $jum[$kira]['F04'.$key]
				- $jum[$kira]['F05'.$key]
				+ ( $jum[$kira]['F06'.$key]
				) - $jum[$kira]['F07'.$key] );

			$akhir = (isset($cari[$baris]) ? $cari[$baris] : '0');
			$data = ($akhir != $jumlahAset) ? $jumlahAset : $akhir; //*/

		# pulangkan nilai
		return $data;
	}
##---------------------------------------------------------------------------------------------------------------------
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function binaAsetAm($cari, $jum)
	{
		# jenis harta
		$jenisHarta = array(1=>'Tanah(X71)',
			2=>'Bangunan dan binaan lain(X72,X73,X74,X75)',
			3=>'Kenderaan(X76,X77,X78)',
			4=>'Perkakasan komputer(X79)',
			5=>'Perisian komputer(X80)',
			6=>'Jentera dan kelengkapan(X81)',
			7=>'Perabut dan pemasangan(X82)',
			8=>'Muhibah dsb(X84),Paten(X70),',
			9=>'Lain2 harta(X86)', 0=>'Jumlah harta(X99)',
			81=>'Harta tetap dibuat/dibina sendiri(F04X)',
			82=>'Jumlah harta tetap pada akhir tahun(F0899/M0083)',
			83=>'Semua harta',
			84=>'Jumlah tanggungan(M0084)',
			85=>'Modal Berbayar(F0031/M0085)',
			86=>'Rizab(F0032/M0086)');

		$nilaiBuku= array(6=>'Pelupusan',7=>'Pembelian');

		# set pembolehubah awal
		$jumAset_dulu = $jum['aset_dulu'];
		$jumAset_kini = $jum['aset_kini'];
		# mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{
			$aset[$kira]['nama'] = $jenis;
			//$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 1);
				$baris = 'F00' . $lajur . $key;
				//echo '<br>'.$baris.'='.$cari[$baris];
				if ($key=='0')
				{
					$aset[$kira]["Pelupusan"] = 
						isset($cari['F0070']) ? $cari['F0070'] : 0;
					$aset[$kira]["Pembelian"] = 
						isset($cari['F0080']) ? $cari['F0080'] : 0;
				}
				elseif (in_array($key,array(81,82,83,84,85,86)) )
				{
					$aset[$kira]["Pelupusan"] = '-';
					$aset[$kira]["Pembelian"] = 
						isset($cari['F00'.$key]) ? $cari['F00'.$key] : 0;
				}
				else
				{# mula kiraan bandingan antara 2 tahun
					$aset[$kira]["$modal"] = 
						isset($cari[$baris]) ?	$cari[$baris] : 0;
				}
			}
			$kira++;
		}
		//echo '<pre>$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>Borang::binaAsetAm($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function analisaAset($cari, $jum)
	{
		# jenis harta
		$jenisHarta = array(71=>'Tanah',
			72=>'Tmpt kediaman',
			73=>'Bukan Tmpt Kediaman',
			74=>'Binaan lain',
			75=>'Pembangunan tanah',
			76=>'Kereta penumpang',
			88=>'Bas',
			89=>'Ambulan',
			77=>'Kereta perdagangan',
			78=>'Kenderaan lain',
			79=>'Perkakasan komputer',
			80=>'Perisian komputer',
			81=>'Jentera dan kelengkapan',
			82=>'Perabut dan pemasangan',
			70=>'Paten', 84=>'Muhibah',
			86=>'Lain2 harta', 99=>'Jumlah harta',
			85=>'Kerja dlm pelaksanaan');

		$nilaiBuku= array(1=>'Awal', # 'Nilai buku pada awal tahun'
			2=>'Baru', # 'Pembelian baru termasuk import',
			3=>'Terpakai', # 'Pembelian aset terpakai',
			4=>'DIY', # 'Membuat/membina sendiri',
			5=>'Jual/tamat', # 'Aset dijual/ditamat'
			6=>'+/- jual', # 'Untung/Rugi drpd jualan harta'
			7=>'Susut nilai',
			8=>'Akhir', # 'Nilai buku pada akhir tahun'
			9=>'Sewa');

		//$cari['F7285'] = '123456'; $cari['F9985'] = '123456';
		//echo '<pre>Borang::binaAsetAm($aset)='; print_r($cari) . '</pre><hr>';
		# set pembolehubah awal
		$jumAset_dulu = $jum['aset_dulu'];
		$jumAset_kini = $jum['aset_kini'];
		$susut_dulu = $jum['susut_dulu'];
		$susut_kini = $jum['susut_kini'];
		$sewa_dulu = $jum['asetsewa_dulu'];
		$sewa_kini = $jum['asetsewa_kini'];

		# mula cari 
		$kira = 0;
		$kP = array(72,73,74,81,86,99);
		$kPP = array(72=>'Tmpt kediaman',73=>'Bukan Tmpt Kediaman',74=>'Binaan lain',
			81=>'Jentera dan kelengkapan',86=>'Lain2 harta', 99=>'Jumlah harta');
		foreach ($jenisHarta as $key => $jenis)
		{
			/*$xsiap = 'F'.$key.'85';
			$aset[$kira]['KerjaPelaksanaan'] = (in_array($key,$kerjaPelaksanaan))? (# jika dalam list
				isset($cari[$xsiap]) ? $xsiap . '=' . number_format($cari[$xsiap],0,'.',',')
					: "<strong>$xsiap</strong>") : ''; # jika tiada data*/
			$aset[$kira]['nama'] = $jenis;
			$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;
				$dulu = ($modal=='Sewa') ? $sewa_dulu : $susut_dulu;//$jumAset_dulu;
				$kini = ($modal=='Sewa') ? $sewa_kini : $susut_kini;//$jumAset_kini;

				if ($key=='85')
				{
					$k = isset($kP[$lajur-1]) ? $kP[$lajur-1] : null;
					$kunci = 'F'.$k.'85';
					$kenyataan =  isset($cari[$kunci]) ? $kPP[$k] . '-' . $kunci . '<br>' : null;
					$aset[$kira]["$modal - 0$key2"] = isset($cari[$kunci]) ? 
						$kenyataan . number_format($cari[$kunci],0,'.',',') : null;
				}
				elseif ($lajur=='07')
				{
					# buat asas untuk formula kira jumlah aset
					$jum[$kira][$baris] = isset($cari[$baris]) ?
							$cari[$baris] : '0';
					$harta = (isset($cari[$baris]) ?
						$cari[$baris] : '-');
					$susutNilai = $jum[$kira]['F07'.$key];
					$awalTahun = $jum[$kira]['F01'.$key];
					$peratusSusut = ($susutNilai==0 || $awalTahun ==0)? 0 : number_format( 
						(($susutNilai / $awalTahun) * 100),4,'.',',') . '%';
					//echo '<hr>' . $baris . '=' . $harta . '|' . $modal;
					$kiraHarta = ($harta==0)? 0 : number_format($harta,0,'.',',');
					$peratusHarta = ($dulu==0)? 0 : number_format(
						(($harta / $dulu) * 100),4,'.',',') . '%';
					$anggaran = ($dulu==0)? 0 : number_format(
						($harta / $dulu) * $kini,0,'.',',');

					$aset[$kira]["$modal - 0$key2"] =
					($kiraHarta=='0') ? '-' : # kalau harta = 0
					'D:' . $kiraHarta . 
					'<br>H:' . $peratusHarta .
					'<br>A:' . $anggaran;

					$aset[$kira]["% Susutnilai"] = $peratusSusut;
				}
				elseif ($lajur=='08')
				{
					$akhir = (isset($cari[$baris]) ?
						$cari[$baris] : '-');
					$jumlahAset =
						($jum[$kira]['F01'.$key] 
						+ $jum[$kira]['F02'.$key]
						+ $jum[$kira]['F03'.$key]
						+ $jum[$kira]['F04'.$key]
						- $jum[$kira]['F05'.$key]
						+( $jum[$kira]['F06'.$key]
						)- $jum[$kira]['F07'.$key]);
					# setkan pembolehubah awal
					$harta = ($akhir == $jumlahAset) ? $akhir : $jumlahAset;
					//echo '<hr>' . $baris . '=' . $harta . '|' . $modal;
					$kiraHarta = ($harta==0)? 0 : number_format($harta,0,'.',',');
					$peratusHarta = ($dulu==0)? 0 : number_format(
						(($harta / $dulu) * 100),4,'.',',') . '%';
					$anggaran = ($dulu==0)? 0 : number_format(
						($harta / $dulu) * $kini,0,'.',',');

					$aset[$kira]["$modal - 0$key2"] =
					($kiraHarta=='0') ? '-' : # kalau harta = 0
					'D:' . $kiraHarta .
					'<br>H:' . $peratusHarta .
					'<br>A:' . $anggaran;
				}
				else
				{	# buat asas untuk formula kira jumlah aset
					$jum[$kira][$baris] = isset($cari[$baris]) ?
							$cari[$baris] : '0';
					# mula kiraan bandingan antara 2 tahun
					$harta = isset($cari[$baris]) ?	$cari[$baris] : 0;
					//echo '<hr>' . $baris . '=' . $harta . '|' . $modal;
					$kiraHarta = ($harta==0)? 0 : number_format($harta,0,'.',',');
					$peratusHarta = ($dulu==0)? 0 : number_format(
						(($harta / $dulu) * 100),4,'.',',') . '%';
					$anggaran = ($dulu==0)? 0 : number_format(
						($harta / $dulu) * $kini,0,'.',',');

					$aset[$kira]["$modal - 0$key2"] =
					($kiraHarta=='0') ? '-' : # kalau harta = 0
					'D:' . $kiraHarta .
					'<br>H:' . $peratusHarta .
					'<br>A:' . $anggaran;
				}
			}
			$kira++;
		}

		return $aset;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function analisaAsetAm($cari, $jum)
	{
		# jenis harta
		$jenisHarta = array(1=>'Tanah(X71)',
			2=>'Bangunan dan binaan lain(X72,X73,X74,X75)',
			3=>'Kenderaan(X76,X77,X78)',
			4=>'Perkakasan komputer(X79)',
			5=>'Perisian komputer(X80)',
			6=>'Jentera dan kelengkapan(X81)',
			7=>'Perabut dan pemasangan(X82)',
			8=>'Muhibah dsb(X84),Paten(X70),',
			9=>'Lain2 harta(X86)', 0=>'Jumlah harta(X99)', 
			81=>'Harta tetap dibuat/dibina sendiri(F04X)',
			82=>'Harta awal tahun(F0199)',
			83=>'Harta akhir tahun(F0899)',
			84=>'Jumlah tanggungan',
			85=>'Modal Berbayar',
			86=>'Rizab');

		$nilaiBuku= array(6=>'Pelupusan',7=>'Pembelian');
		# mula cari 
		$kira = 0;
		foreach ($jenisHarta as $key => $jenis)
		{
			$aset[$kira]['nama'] = $jenis;
			//$aset[$kira]['kod'] = $key;
			foreach ($nilaiBuku as $key2 => $modal)
			{
				$lajur = kira3($key2, 1);
				$baris = 'F00' . $lajur . $key;
				//echo '<br>'.$baris.'='.$cari[$baris];
				if ($key=='0')
				{
					$aset[$kira]['05:Lupus_Dulu'] = 
						isset($cari['F0070']) ? $cari['F0070'] : 0;
					$aset[$kira]['02:Beli_Dulu'] = 
						isset($cari['F0080']) ? $cari['F0080'] : 0;
					$aset[$kira]['05:Lupus_Anggar'] = 'x';
					$aset[$kira]['02:Beli_Anggar']  = 'x';
				}
				elseif (in_array($key,array(81,82,83,84,85,86)) )
				{
					$aset[$kira]['05:Lupus_Dulu'] = '-';
					$aset[$kira]['02:Beli_Dulu'] = 
						isset($cari['F00'.$key]) ? $cari['F00'.$key] : 0;
					$aset[$kira]['05:Lupus_Anggar'] = '-';
					
					if ($key==82):
						$aset[$kira]['02:Beli_Anggar'] = $jum['aset_dulu'];
					elseif ($key==83): 
						$aset[$kira]['02:Beli_Anggar'] = $jum['aset_kini'];
					elseif ($key==85): 
						$nisbah = ($jum['aset_kini']==0)?1:($jum['aset_dulu'] / $jum['aset_kini'])+1;
						$value = number_format($nisbah,2,'.',',') . '%';
						$anggar = $cari['F0085'] * $nisbah;
						$modalBerbayar = floor($anggar * 1) / 1;
						$aset[$kira]['02:Beli_Anggar'] = $value . ' | ' .$modalBerbayar;
					elseif ($key==86): $aset[$kira]['02:Beli_Anggar'] = 
							isset($cari['F00'.$key]) ? $cari['F00'.$key] : 0;
					else: $aset[$kira]['02:Beli_Anggar'] = 0;
					endif;
				}
				else
				{# mula kiraan bandingan antara 2 tahun
					if ($lajur==6):
						$aset[$kira]['02:Beli_Dulu'] = 
							isset($cari[$baris]) ?	$cari[$baris] : 0;
					else:
						$aset[$kira]['05:Lupus_Dulu'] = 
							isset($cari[$baris]) ?	$cari[$baris] : 0;
						$aset[$kira]['05:Lupus_Anggar'] = 'x';
						$aset[$kira]['02:Beli_Anggar']  = 'x';
					endif;
				}
			}
			$kira++;
		}

/*
		$aset[$kira]['nama'] = 'susutNilai';
		$aset[$kira]['Pelupusan'] = 0;
		$aset[$kira]['Pembelian'] = $susut['F0049'];
		$aset[$kira+1]['nama'] = 'jumlahBelanja';
		$aset[$kira+1]['Pelupusan'] = 0;
		$aset[$kira+1]['Pembelian'] = $susut['F0060'];//*/
		//echo '<pre>923:$jum='; print_r($jum) . '</pre><hr>';
		//echo '<pre>924:$cari='; print_r($cari) . '</pre><hr>';
		//echo '<pre>936:Borang::analisaAsetAm($aset)='; print_r($aset) . '</pre><hr>';
		return $aset;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function binaStaf($jadual, $staf, $cari, $jum = null)
	{		
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 18=>'Gaji');

		//print_r($cari);
		$kira = 0;
		foreach ($staf as $key => $kategori)
		{	
			//echo '<hr>' . $key .'**'. $kategori ;
			$pekerja[$kira]['nama'] = $kategori;
			$pekerja[$kira]['kod'] = $key;
			foreach ($bangsaStaf as $key2 => $bangsa)
			{
				$lajur = kira3($key2, 2);
				$baris = kira3($key, 2);
				$data = 'F' . $lajur . $baris;
				//echo $data.'='.$cari[$data].'|';
				//echo ($key2==18) ? '<br>':'';
				$pilihBangsa = array (/*'Melayu','Cina',*/'Jumlah','Gaji');
				$pilih = (in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa - 0$key2": "0$key2";
				$pekerja[$kira][$pilih] =
					isset($cari[$data]) ?	$cari[$data] : '-';
			}
			$kira++;
		}

		return $pekerja;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function dataStaf($keyJantina, $jadual, $staf, $cari)
	{		
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 18=>'Gaji');
		$buang = array(9,10,29,30);
		//print_r($cari);
		$kira = 0;
		foreach ($staf as $key => $kategori)
		{	
			if(in_array($key,$buang) ): null;
			else:
				//echo '<hr>' . $key .'**'. $kategori ;
				$pekerja[$kira]['nama'] = $kategori;
				$pekerja[$kira]['kod'] = $key;
				foreach ($bangsaStaf as $key2 => $bangsa)
				{
					$lajur = kira3($key2, 2);
					$baris = kira3($key, 2);
					$data = 'F' . $lajur . $baris;
					//if (isset($cari[$data])){
						//echo $data.'='.$cari[$data].'|';
						//echo ($key2==18) ? '<br>':'';}
					$pekerja[$kira][$data] =
						 isset($cari[$data]) ?	$cari[$data] : '-';
				}
				$kira++;
			endif;
		}

		return $pekerja;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function dataPekerja2($jadualStaf,$jenisKerja,$prosesID)
	{		
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 30=>'Purata Staf', 18=>'Gaji');
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

	/*$lelaki:Array						|$wanita:Array
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
	)*/

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
			# set pembolehubah asas
				$lajur = kira3($key1, 2); 
				$kunci = pilihKeyData($key,$keyLelaki,$lelaki);
				$pekerja[$kira]['L'] = $kunci;
				$baris = kira3($kunci, 2); 
				$medan  = 'F' . $lajur . $baris;
				$data = isset($cariL[$medan]) ?	$cariL[$medan] : '_';
			# mula masuk data
				$pilihBangsa = array (/*'Melayu','Cina',*/'Gaji');
				$pekerja[$kira][(in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa|L$lajur": "L$lajur"] =
					 !empty($data) ? $data : '-';
			endforeach;
			//echo 'Lelaki:' . $kategori . '$kunci:' . $kunci . '->' . $data;
			foreach ($bangsaStaf as $key2 => $bangsa):
			# set pembolehubah asas
				$lajur2 = kira3($key2, 2); 
				$kunci2 = pilihKeyData($key,$keyWanita,$wanita);
				$pekerja[$kira]['W'] = $kunci2;
				$baris2 = kira3($kunci2, 2);
				$medan2 = 'F' . $lajur2 . $baris2;
				$data2  = isset($cariW[$medan2]) ?	$cariW[$medan2] : '_';
			# mula masuk data
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
	public static function dataPekerja2016($cariL, $cariP, $kp)
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
			7=>'Mahir-3.5.1',8=>'XMahir-3.5.1',9=>'Buruh Mahir-3.6.1',10=>'Buruh Mahir-3.6.1',
			11=>'Pekerja sambilan-4',19=>'Jumlah pekerja-5');
		$keyLelaki = array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,8=>9,9=>10,10=>11,11=>19);
		$wanita = array(21=>'Pemilik(ROB)-1',22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',26=>'Pekerja Asas-3.4',
			27=>'Mahir-3.5.1',28=>'XMahir-3.5.1',29=>'Buruh Mahir-3.6.1',30=>'Buruh Mahir-3.6.1',
			31=>'Pekerja sambilan-4',39=>'Jumlah pekerja-5');
		$keyWanita = array(0=>21,1=>22,2=>23,3=>24,4=>25,5=>26,6=>27,7=>28,	8=>29,9=>30,10=>31,11=>39);
		$jenisKerja = array(0=>'Pemilik(ROB)-1',1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',3=>'Juruteknik-3.2',4=>'Kerani-3.3',5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',11=>'Jumlah pekerja-5');

/*	$lelaki:Array						|$wanita:Array
	(
		[1]  => Pemilik(ROB)-1			[21] => Pemilik(ROB)-1
		[2]  => Pekerja keluarga(ROB)-2	[22] => Pekerja keluarga(ROB)-2
		[12] => Pengurusan-3.1			[32] => Pengurusan-3.1
		[3]  => Profesional-3.2.1		[23] => Profesional-3.2.1
		[13] => Penyelidik-3.2.2		[33] => Penyelidik-3.2.2
		[4]  => Juruteknik				[24] => Juruteknik
		[5]  => Kerani-3.4				[25] => Kerani-3.4
		[15] => Servis & Jualan-3.5		[35] => Servis & Jualan-3.5
		[07] => Kemahiran-3.6			[27] => Kemahiran-3.6
		[18] => XKemahiran-3.6			[38] => XKemahiran-3.6
		[16] => Mesin & Operator-3.7	[36] => Mesin & Operator-3.7
		[6]  => Pekerja Asas-3.8		[26] => Pekerja Asas-3.8
		[7]  => -3.5					[27] => -3.5
		[8]  => -3.6					[28] => -3.6
		[17] => Jum Staf Bergaji-3.9	[37] => Jum Staf Bergaji-3.9
		[11] => Pekerja sambilan-4		[31] => Pekerja sambilan-4
		[19] => Jumlah pekerja-5		[39] => Jumlah pekerja-5
	)
		01-09 - Msia (in_array($lajur, array('01','02','03','04','05','06','07','08','09') ))
		10-13 - Pati (in_array($lajur, array('10','11','12','13') ))
		14 - Jumlah
		30 - Purata
		*/
		$cari = array_merge($cariL,$cariP);
		$msia = $pati = $mengira = $kira = 0;
		# staf dan gaji
		$cari = array_merge($cariL,$cariP);
		$msia = $pati = $mengira = $kira = 0;
		//echo '<pre>$jenisKerja ->'; print_r($jenisKerja); echo '</pre>';
		foreach ($jenisKerja as $key => $kategori):
			$data = null; $data2 = null;
			//echo "<br>\$key = $key| \$kategori = $kategori";
			$pekerja[$kira]['nama'] = $kategori;
			$WargaL = $PatiL = $jumStafL = $gajiL = 0;
			foreach ($bangsaStaf as $key1 => $bangsa):
			//echo "<br>\$key1 = $key1 | \$bangsa = $bangsa";
			# set pembolehubah asas
				$lajur = kira3($key1, 2); 
				$kunci = pilihKeyData($key,$keyLelaki,$lelaki);
				$pekerja[$kira]['L'] = $kunci;
				$baris = kira3($kunci, 2); 
				$medan = 'F' . $lajur . $baris; 
				$data = isset($cari[$medan]) ? $cari[$medan] : '&nbsp;';
			# tambah jika data wujud 
				if(in_array($lajur, array('01','02','03','04','05','06','07','08','09') )):
					$WargaL += $data;
				/*elseif(in_array($lajur, array('01','02','03','04','05','06') )):
					$pekerja[$kira]['Bumi'] += $data; 
				elseif(in_array($lajur, array('07','08','09') )):
					$pekerja[$kira]['XBumi'] += $data; //*/ 
				elseif(in_array($lajur, array('10','11','12','13') )):
					$PatiL += $data;
				elseif(in_array($lajur, array('14') )):
					$jumStafL = !empty($data) ? $data : '-';
				elseif(in_array($lajur,array('18'))):
					$gajiL = !empty($data) ? $data : '-';
				endif;
				# ubahsuai data
				$pekerja[$kira]['WargaL'] = ($WargaL==0) ? '' : $WargaL;
				$pekerja[$kira]['PatiL'] = ($PatiL==0) ? '' : $PatiL;
				$pekerja[$kira]['Jum|L14'] = $jumStafL;
				$pekerja[$kira]['Gaji|L18']  = $gajiL;
			endforeach;
			//echo '<br>Lelaki:' . $kategori . '$kunci:' . $kunci . '->' . $data;
			# perempuan
			$WargaP = $PatiP = $jumStafP = $gajiP = 0;
			foreach ($bangsaStaf as $key2 => $bangsa):
			# set pembolehubah asas
				$kunci2 = pilihKeyData($key,$keyWanita,$wanita);
				$pekerja[$kira]['W'] = $kunci2;
				$lajur2 = kira3($key2, 2); 
				$baris2 = kira3($kunci2, 2);
				$medan2 = 'F' . $lajur2 . $baris2;
				$data2  = isset($cari[$medan2]) ? $cari[$medan2] : '&nbsp;';
			# tambah jika data wujud 
				if(in_array($lajur2, array('01','02','03','04','05','06','07','08','09') )):
					$WargaP += $data2; 
				/*elseif(in_array($lajur, array('01','02','03','04','05','06') )):
					$pekerja[$kira]['Bumi'] += $data; 
				elseif(in_array($lajur, array('07','08','09') )):
					$pekerja[$kira]['XBumi'] += $data; //*/ 
				elseif(in_array($lajur2, array('10','11','12','13') )):
					$PatiP += $data2; 
				elseif(in_array($lajur2, array('14') )):
					$jumStafP = !empty($data2) ? $data2 : '-';
				elseif(in_array($lajur2, array('18') )):
					$gajiP = !empty($data2) ? $data2 : '-';
				endif;
			# ubahsuai data
				$pekerja[$kira]['WargaP'] = ($WargaP==0) ? '' : $WargaP;
				$pekerja[$kira]['PatiP'] = ($PatiP==0) ? '' : $PatiP;
				$pekerja[$kira]['Jum|P14'] = $jumStafP;
				$pekerja[$kira]['Gaji|P18'] = $gajiP;
			endforeach;
			//echo '|Wanita:' . $kategori . '$kunci:' . $kunci2 . '->' . $data2;
			$kira++;
		endforeach;//*/

		//echo '<pre>$jadualStaf ->'; print_r($jadualStaf); echo '</pre>';
		//echo '<pre>pekerja dalam fungsi dataPekerja2015 ->'; print_r($pekerja); echo '</pre>';
		return $pekerja;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function borangAmStaf($prosesID)
	{
		//echo '1121:<pre>Borang::borangAmStaf($prosesID)='; print_r($prosesID) . '</pre><hr>';
		#L	Msia|L	Pati|L	JumL|L14	Gaji|L18	W	Msia|W	Pati|W	JumW|W14	Gaji|W18
		$kategori[] = 'Pemilik(ROB)-1 / 6.3';
		$kategori[] = 'Wanita - Pemilik(ROB)-1 / 6.3';
		$kategori[] = 'Pekerja keluarga(ROB)-2 / 6.4';
		$kategori[] = 'Wanita - Pekerja keluarga(ROB)-2 / 6.4';
		$kategori[] = '<b>Jum pekerja bergaji -5.3.6 / 6.5</b>';
		$kategori[] = '<b>Wanita - Jum pekerja bergaji -5.3.6 / 6.5</b>';
		$kategori[] = 'Pengurusan-3.1 / 6.5.A';
		$kategori[] = 'Wanita - Pengurusan-3.1 / 6.5.A';
		$kategori[] = 'Juruteknik-3.2 / 6.5.B';
		$kategori[] = 'Wanita - Juruteknik-3.2 / 6.5.B';
		$kategori[] = 'Kerani-3.3 / 6.5.C';
		$kategori[] = 'Wanita - Kerani-3.3 / 6.5.C';
		$kategori[] = 'pekerja am';
		$kategori[] = 'Wanita - pekerja am';
		$kategori[] = 'Pekerja sambilan-4 / 6.6';
		$kategori[] = 'Wanita - Pekerja sambilan-4 / 6.6';
		$kategori[] = 'Jumlah pekerja-5 / 6.7';
		$kategori[] = 'Wanita - Jumlah pekerja-5 / 6.7';

		$sijil[] = 'Pascasiswazah';
		$sijil[] = 'Bacelor';
		$sijil[] = 'Diploma';
		$sijil[] = 'STPM';
		$sijil[] = 'SPM';
		$sijil[] = 'Bawah SPM';
		$sijil[] = 'Jumlah Sijil';
		$sijil[] = 'Bumiputera';
		$sijil[] = 'Cina';
		$sijil[] = 'India';
		$sijil[] = 'Lain-lain';
		$sijil[] = 'Pati';
		$sijil[] = 'Jumlah Bangsa';

		for ($kira = 1; $kira <= 18; $kira++):
			$kiraan = kira3($kira,2);
			#L	Msia|L	Pati|L	JumL|L14	Gaji|L18	W	Msia|W	Pati|W	JumW|W14	Gaji|W18
			if (($kira%2)!=0):
				$L = $kiraan;
				$P = $kiraan+1;
				$staf[] = array(
					'kategori' => ($kategori[$kira-1]),
					'L' => $kiraan,
					'Msia|L' => (isset($prosesID[0]['F10'.$L]) ? $prosesID[0]['F10'.$L] : null),
					'Pati|L' => (isset($prosesID[0]['F11'.$L]) ? $prosesID[0]['F11'.$L] : null),
					'Jum|L14' => (isset($prosesID[0]['F12'.$L]) ? $prosesID[0]['F12'.$L] : null),
					'Gaji|L18' => (isset($prosesID[0]['F13'.$L]) ? $prosesID[0]['F13'.$L] : null),
					'W' => $kiraan+1,
					'Msia|W'=> (isset($prosesID[0]['F10'.$P]) ? $prosesID[0]['F10'.$P] : null),
					'Pati|W'=> (isset($prosesID[0]['F11'.$P]) ? $prosesID[0]['F11'.$P] : null),
					'Jum|W14'=> (isset($prosesID[0]['F12'.$P]) ? $prosesID[0]['F12'.$P] : null),
					'Gaji|W18'=> (isset($prosesID[0]['F13'.$P]) ? $prosesID[0]['F13'.$P] : null),
					//'Sijil'=> (isset($sijil[$kira-1]) ? $sijil[$kira-1] : null),
					//'JumS'=> (isset($prosesID[0]['F01'.$L]) ? $prosesID[0]['F01'.$L] : null)
					);
			endif;
		endfor;

		//echo '<pre>$prosesID:'; print_r($prosesID) . '</pre>';
		//echo '<pre>$staf:'; print_r($staf) . '</pre>';
		return $staf;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	public static function borangStaf($info)
	{
		//echo '<pre>Borang::borangStaf($info)='; print_r($info) . '</pre><hr>';
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
		/*$info
		[11] => Array
		(
		[nama] => Jumlah pekerja-5
		[L] => 19
		[L01] => - [L02] => - [L03] => - [L04] => - [L05] => -
		[L06] => - [L07] => - [L08] => - [L09] => - 
		[L10] => - [L11] => - [L12] => - [L13] => - 
		[L14] => - [Gaji|L18] => -
		[W] => 39
		[W01] => 3 [W02] => - [W03] => - [W04] => - [W05] => -
		[W06] => - [W07] => - [W08] => - [W09] => -
		[W10] => - [W11] => - [W12] => - [W13] => -
		[W14] => 3 [Gaji|W18] => 20000
		)*/

		foreach ($info as $kira => $row):
			$pekerja[$kira]['nama'] = $info[$kira]['nama'];
			$pekerja[$kira]['L'] = $info[$kira]['L'];
			$pekerja[$kira]['Msia|L'] = $info[$kira]['L01'] + $info[$kira]['L02'] + $info[$kira]['L03'] + $info[$kira]['L04'] 
				+ $info[$kira]['L05'] + $info[$kira]['L06'] + $info[$kira]['L07'] + $info[$kira]['L08'] + $info[$kira]['L09'];
			$pekerja[$kira]['Pati|L'] = $info[$kira]['L10'] + $info[$kira]['L11'] + $info[$kira]['L12'] + $info[$kira]['L13'];
			$pekerja[$kira]['Jum|L14'] = $info[$kira]['L14'];
			$pekerja[$kira]['Gaji|L18'] = $info[$kira]['Gaji|L18'];
			$pekerja[$kira]['W'] = $info[$kira]['W'];
			$pekerja[$kira]['Msia|W'] = $info[$kira]['W01'] + $info[$kira]['W02'] + $info[$kira]['W03'] + $info[$kira]['W04'] 
				+ $info[$kira]['W05'] + $info[$kira]['W06'] + $info[$kira]['W07'] + $info[$kira]['W08'] + $info[$kira]['W09'];
			$pekerja[$kira]['Pati|W'] = $info[$kira]['W10'] + $info[$kira]['W11'] + $info[$kira]['W12'] + $info[$kira]['W13'];
			$pekerja[$kira]['Jum|W14'] = $info[$kira]['W14'];
			$pekerja[$kira]['Gaji|W18'] = $info[$kira]['Gaji|W18'];
		endforeach;

		//echo '<pre>Borang::borangStaf($pekerja)='; print_r($pekerja) . '</pre><hr>';
		return $pekerja;

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
#####################################################################################################
}