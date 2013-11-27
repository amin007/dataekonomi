<?php

class Anggaran extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();
		// lokasi fail PAPAR untuk survey
		$this->papar->_folder = 'semakan/'; 
		//echo $this->papar->_folder . "<br>Anggaran::";

	}
	
	public function index($cetak = null) 
	{
		// setkan semua pembolehubah
		$this->papar->carian = 'Data';
		$this->papar->apa = 'semua';
		$myJadual = array('data_anggaran'); // senarai jadual
		$medan = 'newss,nama'; // senarai nama medan
		// mula cari dalam database
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->paparjadual($myTable, $medan);
			}// tamat ulang table
		// tamat cari dalam database
		
		
		// memilih antara papar dan cetak
		if ($cetak == 'index') //echo 'index';
			$this->papar->baca($this->papar->_folder . 'index', 0);
		elseif ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'index', 1);
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'data_anggaran', 0);
		//*/
		//$this->papar->baca($this->papar->_folder . 'index');
		//$this->papar->baca($this->papar->_folder . 'data_anggaran');
	}

	public function simpan($mesej) 
	{
		$this->papar->mesej = $mesej;
		$this->papar->baca($this->papar->_folder . 'berjaya');
	}

	public function semak($id, $cetak = null) 
	{
		//echo "semak($id,$mula,$tamat,$cetak)<br>";
		// setkan semua pembolehubah
		$myJadual = array('data_anggaran'); // senarai jadual
		$medan = '*'; // senarai nama medan
		$cari = array (
			'medan' => 'newss', // cari dalam medan apa
			'id' => (isset($id) ? $id : null) , // benda yang dicari
			);
		$this->papar->kesID = array();
		$this->papar->paparID = null;
		
		if (!empty($cari['id'])) 
		{	
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$papar[$myTable] = 
				$this->tanya->cariEstab($myTable, $cari);
			}// tamat ulang table

			// paparkan data kesID yang ada nilai sahaja
			$this->papar->carian = $cari['medan'];
			// jika data anggaran wujud		
			if ( isset($papar['data_anggaran'][0]['data']) )
			{
				// masukkan nombor bewss
				$this->papar->paparID = $papar['data_anggaran'][0]['newss'];
				// dari json kepada array
				$data_anggaran = $papar['data_anggaran'][0]['data'];
				$paparID = json_decode($data_anggaran, true);
				// set survey apa
				$sv = isset($paparID['semasa']['sv']) ?
					$paparID['semasa']['sv'] : null;
				$this->papar->sv = $sv;
				// buat tatasusunan yang ada nilai
				$this->semakYangAda($sv, $paparID, $cari);
				// tambah nama syarikat
				$this->papar->kesID['semasa'][0]['nama'] = isset($papar['data_anggaran'][0]['nama']) ?
					$papar['data_anggaran'][0]['nama'] : null;
				// cari kod io
				$this->paparIO($sv, $this->papar->kesID, $cari);
			}
			else
			{// jika data anggaran tidak wujud
				$this->papar->sv = null;
				$this->papar->kod_produk = array();
			}
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			// set pemboleh ubah		
			$this->papar->thn_mula = 2010;
			$this->papar->thn_akhir = 2012;
			$this->papar->kelas = null;
			$this->papar->dataAm = array();
						
			/*echo '<pre>hai';
			//echo '<hr>$paparID='; print_r($paparID);
			//echo '<hr>$papar='; print_r($papar);
			echo '<hr>$this->papar->kesID='; print_r($this->papar->kesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk);
			//echo '<hr>$this->papar->sv:' . $this->papar->sv;
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/
		
		
		$this->papar->_folder = 'cprosesan/';
		// memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
			$this->papar->baca($this->papar->_folder . 'cetak', 0);
		elseif ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'ubah', 1);
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'ubah', 0);
		//*/
		
	}

	public function kemaskini($id, $cetak = null) 
	{
		//echo "semak($id,$mula,$tamat,$cetak)<br>";
		// setkan semua pembolehubah
		$myJadual = array('data_anggaran'); // senarai jadual
		$medan = '*'; // senarai nama medan
		$cari = array (
			'medan' => 'newss', // cari dalam medan apa
			'id' => (isset($id) ? $id : null) , // benda yang dicari
			);
		$this->papar->kesID = array();
		$this->papar->paparID = null;
		
		if (!empty($cari['id'])) 
		{			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$papar[$myTable] = 
				$this->tanya->cariEstab($myTable, $cari);
			}// tamat ulang table

			// paparkan data kesID yang ada nilai sahaja
			$this->papar->carian = $cari['medan'];
			// paparkan data kesID yang ada nilai sahaja
			$this->papar->carian = $cari['medan'];
			// jika data anggaran wujud		
			if ( isset($papar['data_anggaran'][0]['data']) )
			{
				// masukkan nombor bewss
				$this->papar->paparID = $papar['data_anggaran'][0]['newss'];
				// dari json kepada array
				$data_anggaran = $papar['data_anggaran'][0]['data'];
				$paparID = json_decode($data_anggaran, true);
				// set survey apa
				$sv = isset($paparID['semasa']['sv']) ?
					$paparID['semasa']['sv'] : null;
				$this->papar->sv = $sv;
				// buat tatasusunan yang ada nilai
				$this->semakYangAda($sv, $paparID, $cari);
				// tambah nama syarikat
				$this->papar->kesID['semasa'][0]['nama'] = 
					isset($papar['data_anggaran'][0]['nama']) ?
					$papar['data_anggaran'][0]['nama'] : null;
			}
			else
			{// jika data anggaran tidak wujud
				$this->papar->sv = null;
				$this->papar->kod_produk = array();
			}
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			// set pemboleh ubah
			$this->papar->thn_mula = 2010;
			$this->papar->thn_akhir = 2012;
			$this->papar->kelas = null;
			$this->papar->dataAm = array();
						
			/*echo '<pre>hai';
			//echo '<hr>$paparID='; print_r($paparID);
			//echo '<hr>$papar='; print_r($papar);
			echo '<hr>$this->papar->kesID='; print_r($this->papar->kesID);
			echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk);
			//echo '<hr>$this->papar->sv:' . $this->papar->sv;
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/
		
		// dalam function kemaskini($id, $cetak = null) 
		$this->papar->_folder = 'semakan/';
		// memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
			$this->papar->baca($this->papar->_folder . 'cetak', 0);
		elseif ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'kemaskini', 1);
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'kemaskini', 0);
		//*/
		
	}
	
	public function ubahSimpan()
    {
		$sv = bersih($_POST['semasa']['sv']);
		$semak = bersih($_POST['Simpan']);
		// semak untuk Kira atau Simpan
		if ($semak == 'Ubah')
		{
			$semua = array($sv . '_q04_2010',
				$sv . '_q08_2010',
				$sv . '_q09_2010',
				'harta','kodInput','kodOutput',
				's' . $sv . '_q02_2010',
				's' . $sv . '_q03_2010',
				's' . $sv . '_q04_2010',
				'proses','semasa');
			//echo '<pre>$_POST->'; print_r($_POST) . '</pre>';
			$posmen = semakDataPOST($semua);
		
			// paparkan newss dan nama syarikat
			$this->_newss = $posmen['semasa']['newss'];
			$posmen['semasa']['nama'] = $_POST['semasa']['nama'];	
			$this->_nama = $posmen['semasa']['nama'];	
			// json_encode() untuk $posmen 
			$posLaju = json_encode($posmen);
			
			/*echo '<pre>';
			echo "_newss : $this->_newss <br>";
			echo "_nama : $this->_nama <br>";
			//echo '<hr>$posmen->'; print_r($posmen);
			//echo '<hr>$posLaju:'; var_dump($posmen,$posLaju);
			echo "posLaju:", $posLaju, "\n";
			//echo "</pre>"; //*/
			
			$data = array(
				'newss' => $this->_newss,
				'nama' => $this->_nama,
				'data' => $posLaju);
			$jadual = 'data_anggaran';
			$this->tanya->ubahSimpan($data, $jadual);
			
			// pergi ke lokasi lain
			$lokasi = 'location:' . URL . 'anggaran/simpan/berjaya';
			//$lokasi = 'location:' . URL . 'anggaran/semak/' . $this->_newss . '/berjaya';
			header($lokasi);//*/
		}
		elseif ($semak == 'Kira')
		{
			$kiraan = array($sv . '_q08_2010',$sv . '_q09_2010',
				's' . $sv . '_q02_2010', 's' . $sv . '_q03_2010',
				'semasa');
			$senaraiHarta = array($sv . '_q04_2010','s' . $sv . '_q04_2010');
			
			foreach ($_POST as $myTable => $value)
			{		
				if ( in_array($myTable,$kiraan) )
				{
					foreach ($value as $kekunci => $papar)
						$this->papar->kesID[$myTable][0][$kekunci] = bersih($papar);
				}
				elseif ( in_array($myTable,$senaraiHarta) )
				{
					$jadualHarta = $myTable;
					foreach ($value as $kekunci => $papar)
						$cariHarta[$kekunci] = bersih($papar);
				}
			}
					
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			
			// cari perbandingan aset dulu dan kini
			$this->papar->kod_produk['harta'] = ($jadualHarta=='205_q04_2010' 
				|| $jadualHarta=='s206_q04_2010') ?
			Borang::analisaAset($cariHarta, 
			array(
				'aset_dulu' => $this->papar->kesID['semasa'][0]['aset_dulu'],
				'aset_kini' => $this->papar->kesID['semasa'][0]['aset_kini'],
				'asetsewa_dulu' => $this->papar->kesID['semasa'][0]['asetsewa_dulu'],
				'asetsewa_kini' => $this->papar->kesID['semasa'][0]['asetsewa_kini'],
			)) : // 
			Borang::analisaAsetAm($cariHarta, 
			array(
				'aset_dulu' => $this->papar->kesID['semasa'][0]['aset_dulu'],
				'aset_kini' => $this->papar->kesID['semasa'][0]['aset_kini'],
			));

			// untuk pastikan tiada orang hack
			$this->papar->paparID = $this->papar->kesID['semasa'][0]['newss'];
			$this->papar->carian = 'newss';
						
			/*echo '<pre>';
			//echo '<hr>$_POST->'; print_r($_POST);
			echo '<hr>$cariHarta->'; print_r($cariHarta);
			echo '<hr>$this->papar->kesID->'; print_r($this->papar->kesID);
			echo '<hr>$this->papar->kod_produk->'; print_r($this->papar->kod_produk);
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			//echo '<hr>$this->papar->keterangan->', print_r($this->papar->keterangan, 1);
			echo '</pre>';//*/
			
			// pergi ke fail analisis di PAPAR
			$this->papar->baca('semakan/analisis', 0);
		
		}
		
    }

// senarai jadual
	private function kod_produk() // khas untuk survey 205
	{	// senaraikan tatasusunan jadual prosesan
		/*$myJadual[]='s14';
		$myJadual[]='s15';
		$myJadual[]='q14_2010';
		$myJadual[]='q15_2010';*/
		$myJadual[]='kodOutput';
		$myJadual[]='kodInput';
		
		return $myJadual;
	}
	// semak IO
	private function paparIO($sv, $paparID, $cari) 
	{
		if ($sv=='205') 
		{
			$Belanja = '205_q09_2010';
			$input = 0;
			$medanInput = array('F2101','F2102','F2103','F2104','F2105','F2106','F2107','F2108',
			'F2110','F2111','F2112','F2113','F2114','F2115','F2116','F2117','F2118','F2119','F2120',
			'F2121','F2122','F2123','F2124','F2125','F2126','F2127','F2128',
			'F2133','F2145','F2146','F2147','F2156','F2157','F2158');

			foreach ($medanInput as $kira1)
			{
				$input += isset($paparID[$Belanja][0][$kira1]) ?
					$paparID[$Belanja][0][$kira1] : 0;
			}

			$Hasil = '205_q08_2010';
			$jumlahHasil = 0;
			$medanOutputTambah = array('F2001','F2002','F2003','F2004','F2005',
			'F2006','F2007','F2008','F2009','F2010',
			'F2011','F2012','F2013','F2014','F2024');

			foreach ($medanOutputTambah as $kira2)
			{
				$jumlahHasil += isset($paparID[$Hasil][0][$kira2]) ?
					$paparID[$Hasil][0][$kira2] : 0;
			}
			$harta = array('s04','q04_2010','harta','s'.$sv.'_q04_2010');
			$stok = array('s10','q10_2010','proses');
			$no = 2; 
			// + DIY (0499)
			$F0499 = isset($paparID[$harta[$no]][0]['F0499']) ? $paparID[$harta[$no]][0]['F0499'] : 0;
			// + Stok akhir barangan dalam proses (1622)	
			$F1622 = isset($paparID[$stok[$no]][0]['F1622']) ? $paparID[$stok[$no]][0]['F1622'] : 0; 
			// + Stok akhir barangan siap (pembuatan sendiri) (1623)
			$F1623 = isset($paparID[$stok[$no]][0]['F1623']) ? $paparID[$stok[$no]][0]['F1623'] : 0; 
			$outputTambah = $jumlahHasil + $F0499 + $F1622 + $F1623;

			// - Kos barang yang dijual (barang/bahan yang dibeli untuk dijual semula tanpa proses selanjutnya)
			$F2109 = isset($paparID[$Belanja][0]['F2109']) ? $paparID[$Belanja][0]['F2109'] : 0; 
			// - Stok awal barangan dalam proses (1522)
			$F1522 = isset($paparID[$stok[$no]][0]['F1522']) ? $paparID[$stok[$no]][0]['F1522'] : 0; 
			// - Stok awal barangan siap (pembuatan sendiri) (1523)
			$F1523 = isset($paparID[$stok[$no]][0]['F1523']) ? $paparID[$stok[$no]][0]['F1523'] : 0; 
			$outputTolak =  $F2109 + $F1522 + $F1523;

			// muka kiraan
			$output = $outputTambah - $outputTolak;
			// isytihar pada PAPAR
			$this->papar->output = $output;
			$this->papar->input = $input; 

		}
		elseif ($sv=='206')
		{
	
		}
		else
		{
		
		}
	}
	
	// 
	private function semakYangAda($sv, $paparID, $cari) 
	{
		$this->papar->paparID = $cari['id'];
		//echo '<pre>'; //echo '$nilai='; print_r($paparID);
		// senarai aset untuk 205/206
		$asetIndustri = array('s04','q04_2010','s'.$sv.'_q04_2010');
	
		foreach ($paparID as $jadual => $key):
			foreach ($key as $medan => $nilai):
				
				if ($paparID[$jadual][$medan]!='0')
				{
					$this->papar->kesID[$jadual][0][$medan] = $nilai;
					echo (in_array($jadual, $asetIndustri)) ? $jadual . ' ada<br>' : '';
					if (in_array($jadual, $asetIndustri)) $aset = $jadual;
				}
				if (in_array($jadual,array('kodInput','kodOutput'))) 
				{	//echo $jadual . ' ada<br>';
					$cariProduk[$jadual][0][$medan] = $nilai;
				}
		   endforeach;
		endforeach;

		// semak kod produk untuk survey 205 sahaja
		if ($sv=='205' || $sv=='206')
		{	if ($sv=='205') 
			{
				$this->papar->kod_produk = $this->pecahProduk($cariProduk); 
				//echo '<pre>205::$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
				$jadualStaf = array('s05a','s05b','q05a_2010','q05b_2010');
			}
			else 
			{
				$this->papar->kod_produk = array();
				$jadualStaf = array('s206_q05a_2010','s206_q05b_2010');
			}
			// bentuk soalan staf lelaki dan perempuan
			//$this->semak_staf($jadualStaf, $this->papar->kesID);
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			// bentuk soalan 4 - aset
			if (isset($aset) && $aset != null)
			{	//echo '<pre>$aset='; print_r($aset) . '</pre>';
				$this->semak_aset($asetIndustri, $aset, $paparID);
			}
		}
		else
		{
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					null, $paparID);
		}
	}
	
	private function pecahProduk($cari) // khas untuk survey 205
	{
		//echo '<pre>$cari='; print_r($cari) . '</pre>';
		// mula cari $cariID dalam $kod_produk
		foreach ($this->kod_produk() as $key => $myTable)
		{// mula ulang table
			if ($myTable=='kodOutput')
			{	//echo '$myTable:' . $myTable . '<br>';
				$produk['output'] = Data::produkOutput($cari['kodOutput']);
			}
			elseif ($myTable=='kodInput')
			{	//echo '$myTable:' . $myTable . '<br>';
				$produk['input'] = Data::produkInput($cari['kodInput']);
			}
			else
			{ //echo 'tak ada $myTable:' . $myTable . '<br>';
			}
			
		}// tamat ulang table
		
		//echo '<pre>$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
		//echo '<pre>$produk='; print_r($produk) . '<pre>';
		return $produk;
	}
	
	private function cari_keterangan_medan($sv, $kesID)
	{
		//echo '<pre>$kesID='; print_r($kesID) . '<pre>';
		$senarai = Data::cariKeterangan($kesID);
		
		// cari keterangan medan yang lain				
		foreach ($senarai as $myTable => $papar)
		{// mula ulang table
			foreach ($papar as $namaMedan => $data)
			{// mula ulang table
				//echo '$namaMedan['.$namaMedan.']['.$myTable.']:'.$data.'|'.$sv.'<br>';
				$cari[0] = array('medan' => 'kod_medan','id' => $namaMedan);
				$cari[1] = array('medan' => 'kod_survey','id' => $sv);
				$this->papar->keterangan[$myTable][$namaMedan] = 
					$this->tanya->keterangan_medan('kod_sv_prosesan', $cari);//*/
			}// tamat ulang table
		}// tamat ulang table

	}

	private function semak_aset($asetIndustri, $aset, $paparID) 
	{// khas untuk soalan aset
		//echo "<pre>senaraiAset:", print_r($asetIndustri, 1) 
		//	. '| jadual:', print_r($aset, 1) . "<br>";
		
		foreach ($asetIndustri as $key => $myTable):
			//echo ($myTable!=$aset) ? null : "myTable:$myTable | aset:$aset|<br>";
			if ($aset==$myTable && in_array($aset,$asetIndustri) )
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAset($paparID[$myTable][0]);
			elseif ($aset==null)
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAsetAm($paparID[$myTable][0]);
		endforeach;

	}

	private function semak_staf($jadualStaf, $prosesID)
	{// khas untuk soalan staf
	/*
		$lelaki = '05a';
		$stafLelaki = array(1=>'Pemilik(ROB)-1',
			2=>'Pekerja keluarga(ROB)-2',
			3=>'Pengurusan-3.1',
			4=>'Juruteknik-3.2',
			5=>'Kerani-3.3',
			6=>'Pekerja Asas-3.4',
			7=>'-3.5',
			8=>'-3.6',
			//9=>'',
			11=>'Pekerja sambilan-4',
			19=>'Jumlah pekerja-5',
			);

		$stafPerempuan = array(21=>'Pemilik(ROB)-1',
			22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',
			24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',
			26=>'Pekerja Asas-3.4',
			27=>'-3.5',
			28=>'-3.6',
			//9=>'',
			31=>'Pekerja sambilan-4',
			39=>'Jumlah pekerja-5',
			);

		foreach ($jadualStaf as $key => $myTable):
			if (isset($prosesID[$myTable][0])):
				$cari = $prosesID[$myTable][0];
				if(strpos($myTable,$lelaki) !== false)
				{
					//echo "<br>Jumpa $lelaki dalam $myTable<br>";
					//echo '$prosesID['.$myTable.'][0]'; print_r($prosesID[$myTable][0]);
					@$this->papar->kod_produk['lelaki'] = 
						Borang::binaStaf($myTable,$stafLelaki,$cari);
				}
				else
				{
					//echo "<br>Tak jumpa $lelaki dalam $myTable<br>";
					//echo '$prosesID['.$myTable.'][0]'; print_r($prosesID[$myTable][0]);				
					@$this->papar->kod_produk['wanita'] = 
						Borang::binaStaf($myTable,$stafPerempuan,$cari);
				}
			endif;
		endforeach;*/
			$jenisPekerjaan = array(0=>'Pemilik(ROB)-1',
			1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',
			3=>'Juruteknik-3.2',
			4=>'Kerani-3.3',
			5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',
			7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',
			9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',
			11=>'Jumlah pekerja-5');

		$this->papar->kod_produk['perkerjaan'] = 
			Borang::binaStaf2($jadualStaf,$jenisPekerjaan,$prosesID);

	
	}
	
	private function tukarjadual($sv)
	{
		echo '<pre>'; $sv=800;
		// mula cari $cariID dalam $myJadual
		//foreach ($this->senarai_jadual($sv) as 
		foreach ($this->senarai_jadual($sv) as $key => $myTable)
		{// mula ulang table
				
			$j = substr($myTable,-12);
			echo "\r".'RENAME TABLE `pom_dataekonomi`.`'.$j.'` TO `pom_dataekonomi`.`s'.$j.'`;';

		}// tamat ulang table
		echo ''
		. "\r" . 'RENAME TABLE `pom_dataekonomi`.`'.$sv.'_tbldatareview_2010` TO `pom_dataekonomi`.`s'.$sv.'_tbldatareview_2010`;'
		. "\r" . 'RENAME TABLE `pom_dataekonomi`.`'.$sv.'_tbldatareviewtemp_2010` TO `pom_dataekonomi`.`s'.$sv.'_tbldatareviewtemp_2010`;'
		. "\r" . 'RENAME TABLE `pom_dataekonomi`.`'.$sv.'_tbldatareviewtemp2_2010` TO `pom_dataekonomi`.`s'.$sv.'_tbldatareviewtemp2_2010`;'
		. "\r" . 'RENAME TABLE `pom_dataekonomi`.`'.$sv.'_tbldatareviewtemp3_2010` TO `pom_dataekonomi`.`s'.$sv.'_tbldatareviewtemp3_2010`;';

	}

}