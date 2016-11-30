<?php

class Test extends Kawal 
{
#**************************************************************************************************************
	function __construct() 
	{
		parent::__construct();
	}

	function index() 
	{
		echo 'class Test::index() extends Kawal ';
	}

	public function binasql($kpLama = null, $kpBaru = null) 
    {
		# mula papar semua dalam $myTable
		$myTable = 'kod_sv_prosesan';
		$medan = '`kod_medan`,`kod_survey`,`2010`';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'kod_survey','apa'=>$kpLama,'akhir'=>null);
		$jum = pencamSqlLimit(600, 600, 1);
		$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'kod_medan') );
		# sql guna limit 
		$cariApa[$myTable] = $this->tanya->
			//cariSql($myTable, $medan, $carian, $cantumSusun);
			cariSemuaData($myTable, $medan, $carian, $cantumSusun);

		# bentuk tatasusunan
		$senarai = array();
		foreach ($cariApa[$myTable] as $key => $dataS):
			$senarai[] = "('" 
				. $dataS['kod_medan'] . "', '" 
				. $kpBaru . "', '" 
				. $dataS['2010'] . "')";
		endforeach;

		# sql insert
		$this->tanya->tambahSql($myTable, $senarai, $medan);
		# semak pembolehubah $this->papar->cariApa
		//echo '<pre>', print_r($cariApa, 1) . '</pre><br>';
	}

	public function binasql2($kpLama = null, $kpBaru = null) 
    {
		# mula papar semua dalam $myTable
		$myTable = 'kod_sv_prosesan';
		$medan = '`kod_medan`,`kod_survey`,`2010`';

		# bentuk tatasusunan
		$cariApa[] = array('kod_medan'=>'F2001','2010'=>'Perkhidmatan profesional doktor / pakar penjagaan kesihatan');
		$cariApa[] = array('kod_medan'=>'F2002','2010'=>'Perkhidmatan ujian makmal, X-Ray dsb.');
		$cariApa[] = array('kod_medan'=>'F2023','2010'=>'Ubat-ubatan dan bekalan ubatan lain untuk pesakit');
		$cariApa[] = array('kod_medan'=>'F2010','2010'=>'Kemudahan katil, wad dsb.');
		$cariApa[] = array('kod_medan'=>'F2084','2010'=>'Perkhidmatan Dialisis');
		$cariApa[] = array('kod_medan'=>'F2094','2010'=>'Perkhidmatan kesihatan kemanusiaan lain (cth. Perkhidmatan ambulans)');
		$cariApa[] = array('kod_medan'=>'F2026','2010'=>'Cukai perkhidmatan yang diterima');
		$cariApa[] = array('kod_medan'=>'F2038','2010'=>'Keuntungan daripada pertukaran mata wang asing / aset kewangan');
		$cariApa[] = array('kod_medan'=>'F2101','2010'=>'Ubat-ubatan');
		$cariApa[] = array('kod_medan'=>'F2102','2010'=>'Bekalan perubatan lain yang digunakan');
		$cariApa[] = array('kod_medan'=>'F2103','2010'=>'Bahan pembungkusan');
		$cariApa[] = array('kod_medan'=>'F2115','2010'=>'Makanan dan minuman (untuk pesakit dalam hospital atau rumah bersalin)');
		$cariApa[] = array('kod_medan'=>'F2128','2010'=>'Bayaran pengurusan');
		$cariApa[] = array('kod_medan'=>'F2129','2010'=>'Komisen dan bayaran agensi');
		$cariApa[] = array('kod_medan'=>'F2138','2010'=>'Bayaran perkhidmatan dobi');
		$cariApa[] = array('kod_medan'=>'F2153','2010'=>'Cukai perkhidmatan');
		$cariApa[] = array('kod_medan'=>'F2176','2010'=>'Bayaran levi pekerja');
		$cariApa[] = array('kod_medan'=>'F2177','2010'=>'Lain-lain (belanja staf)');
		//$cariApa[] = array('kod_medan'=>'F21','2010'=>'');
		$senarai = array();
		
		foreach ($cariApa as $key => $dataS):
			$senarai[] = "('" 
				. $dataS['kod_medan'] . "', '" 
				. $kpBaru . "', '" 
				. $dataS['2010'] . "')";
		endforeach;

		# sql insert
		$this->tanya->tambahSql($myTable, $senarai, $medan);
		# semak pembolehubah $this->papar->cariApa
		//echo '<pre>', print_r($cariApa, 1) . '</pre><br>';
	}

	public function semaknewss() 
    {
		# mula papar semua dalam $myTable
		$myTable = 'alamat_newss_2013';
		$medan = '*';
		$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'newss','apa'=>null,'akhir'=>null);
		$jum = pencamSqlLimit(50, 50, 1);
		$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>null) );
		# sql guna limit 
		$this->papar->cariNama[$myTable] = $this->tanya->
			//cariSql($myTable, $medan, $carian, $cantumSusun);
			cariSemuaData($myTable, $medan, $carian, $cantumSusun);

		# paparan
		$this->_t = 'tahun_';
		$this->papar->carian='newss'; # set pembolehubah untuk LIHAT => $this->carian
		$this->papar->apa = 'kosong' ; # set pembolehubah untuk LIHAT => $this->apa
		$this->papar->baca('ckawalan/' . $this->_t . 'cari');
	}

	public function tukarmedan() 
    {
		#pilih medan
		$database = '\'rahsia\'';
		$myTable = '\'jadual\'';
			$this->papar->cariApa[$database] = $this->tanya->
				pilihMedan($database,$myTable);

		echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

		# ubahmedan
		$myTable = 'jadual';
		$medan['asal'] = 'kp';
		$medan['baru'] = 'kp';
		$medan['jenis'] = 'VARCHAR( 255 )';
		$medan['selepas'] = 'operator';

		$this->papar->cariApa[$myTable] = $this->tanya->
			ubahMedan($myTable, $medan);

		# paparan
		//$this->papar->baca('test/cari');
	}

	public function bacafail($fail = "*.txt")
	{
		//$URL_DATA = '';
		$lokasi = URL_DATA . $fail; echo $lokasi . '|' . $fail . '<hr>';
		if (file_exists($lokasi)) 
		{
			$myTable = substr($fail, 0, -4);  # returns "abcde"
			echo "The file $lokasi exists | ";
			echo "\$myTable = $myTable | ";
			###############################################################################
			$f = fopen($lokasi, "r");
			while(!feof($f)) 
			{ 
				$data[] = explode("|", fgets($f));
			}
			fclose($f);

			$buang = count($data)-1;
			unset($data[$buang]);

			$senarai = array(); 
			$cantumMedan = null;
			foreach ($data as $key => $papar):
				foreach ($papar as $key2 => $papar2):
					$senarai[] = $paparan = bersih($papar2);
					if ($key==0)
					{
						if (in_array($key2,array(0,2,3,4,5,11,16,17,18)))
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " varchar(".strlen($paparan)."),";
						elseif (strlen($paparan) < 7)
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " int(10),";
						elseif (is_numeric($papar2))
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " bigint(20),";
						else
							$cantumMedan .= 'F' .  sprintf("%04d", $key2) . " varchar(".strlen($paparan)."),"; #$paparan
						$kira = $key2;
					}
				endforeach;
				$cantumData[] = "('" . implode("','", $senarai) . "')";
				$senarai = null;
			endforeach;
			##################################################################################
			$this->tanya->tambahJadual($myTable, $kira, $cantumMedan, $cantumData);//*/
		}
		else
			echo "The file $lokasi does not exist |";//*/

	}
	
	public function paparfail($folder = "*.txt")
	{
		$lokasi = URL_DATA . $folder; echo $lokasi . '<hr>';
		if (file_exists($lokasi)) 
		{
			$dh = opendir($lokasi); //echo '<pre>';print_r($dh);echo '</pre>';
			$i  = 1;
			while (($file = readdir($dh)) !== false) 
			{
				if	(!in_array(
						$file, array(".","..","Thumbs.db","index.html","index.php") 
					)) 
				{
					if ($file=='index.php') {echo "";}
					elseif (is_dir($file)==false) 
					{ 
						echo "\n" . $i++ . ')<a target="_blank" href="'
							. URL . 'test/bacafail/' . $folder . '/'
							. $file . '">' . $folder . '/' . $file 
							. '</a>: ' . filesize($file) . ' bytes'
							. '<br>';
					}
				}
			}//*/
			closedir($dh);
		}
		else
			echo "The file $lokasi does not exist |";

	}

	public function paparorang()
	{
		$pegawai = unserialize(PEGAWAI);
		echo '<pre>', print_r($pegawai, 1) . '</pre><br>';
	}
#**************************************************************************************************************
}