<?php

class Semakan extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();
		// lokasi fail PAPAR untuk survey
		$this->papar->_folder = 'semakan/'; 
		$this->papar->kelas = 'semakan/'; 
		$this->papar->js = array('jquery-calx-1.1.8.js');
		$this->_pptAsetPenuh = array(305,306,308,312,316,331);
	}
	
	public function index($cetak = null) 
	{	
		// dapatkan semua data
			$myTable = 'data_anggaran';
			$prosesID[$myTable] = $this->tanya->cariData($myTable);

			// paparkan data kesID yang ada nilai sahaja
			$this->papar->kawalID=array();
			$this->semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses);

			/*echo '<pre>';
			echo '<hr>$this->papar->kawalID='; print_r($this->papar->kawalID);
			echo '<hr>$this->papar->prosesID='; print_r($this->papar->prosesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/
		
		// memilih antara papar dan cetak
		//if ($cetak == 'cetak') //echo 'cetak';
		//	$this->papar->baca($this->papar->_folder . 'cetak', 0);
		if ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'index', 1);			
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'index', 0);
		//*/
	}
	
	function ubah($sv=null, $cariID = null, $mula = null, $akhir = null, $cetak = null)
	{	//echo '<br>Anda berada di class Cprosesan extends Kawal:ubah($cari,$mula,$akhir,$cetak)<br>';
		// setkan semua pembolehubah
		$medan = '*'; // senarai nama medan
		$cariKawal = array (
			'sv' => $sv, // senarai survey
			'id' => (isset($cariID) ? $cariID : null) , // benda yang dicari
			);
		$cariProses = array (
			'sv' => $sv, // senarai survey
			'medan' => 'estab', // cari dalam medan apa
			'id' => (isset($cariID) ? $cariID : null) , // benda yang dicari
			'thn_mula' => $mula, // tahun mula
			'thn_akhir' => $akhir // tahun akhir
			);
		$this->papar->sv = $sv;
		$this->papar->kesID = array();
		$this->papar->thn_mula = $cariProses['thn_mula'];
		$this->papar->thn_akhir = $cariProses['thn_akhir'];
		
		/* semak
		echo '<hr><pre>';
		echo '<br>$cariKawal='; print_r($cariKawal);
		echo '<br>$cariProses='; print_r($cariProses);
		echo '</pre>';//*/
		
		if (!empty($cariKawal['id'])&& !empty($sv)) 
		{	
			$myJadual['kawal'] = dpt_senarai('kawalan_tahunan');
			// mula cari $cariID dalam $myJadual['kawal']
			foreach ($myJadual['kawal'] as $key => $myTable)
			{// mula ulang table
				$kawalID[$myTable] = 
				$this->tanya->cariKawal($myTable, $cariKawal);
			}// tamat ulang table

			$myJadual['proses'] = $this->senarai_jadual($sv); 
			// mula cari $cariID dalam $myJadual['proses']
			foreach ($myJadual['proses'] as $key => $myTable)
			{// mula ulang table
				$prosesID[$myTable] = 
				$this->tanya->cariEstab($myTable, $cariProses);
			}// tamat ulang table

			// paparkan data kesID yang ada nilai sahaja
			$this->papar->kawalID=array();
			$this->semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses);
			// cari kod io
			$this->paparIO($sv, $this->papar->prosesID, $cariProses);
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			/*echo '<pre>';
			echo '<hr>$this->papar->kawalID='; print_r($this->papar->kawalID);
			echo '<hr>$this->papar->prosesID='; print_r($this->papar->prosesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/
		
		// memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
			$this->papar->baca($this->papar->_folder . 'cetak', 0);
		elseif ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'ubah', 1);			
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'ubah', 0);
		//*/
	}// tamat function ubah($sv, $cariID = null, $mula = null, $akhir = null, $cetak = null)
	
	public function ubahCetak($sv)
	{
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		// bersihkan data $_POST
		$dataID = 'ubah/' . bersih($sv) . '/' . bersih($_POST['cari']);
		
		// paparkan ke fail 
		$lokasi = 'location: ' . URL . $this->papar->dataAm . $dataID . '/2010/2012';
		header($lokasi);

	}
	
	public function simpan()
    { 
		$sv = bersih($_POST['semasa']['sv']);
		$semak = bersih($_POST['Simpan']);
		// semak untuk Kira atau Simpan
		if ($semak == 'Simpan')
		{
			$semua = array(	$sv . '_q08_2010',
				$sv . '_q09_2010',
				'harta','kodInput','kodOutput',
				's' . $sv . '_q02_2010',
				's' . $sv . '_q03_2010',
				's' . $sv . '_q04_2010',
				'proses','semasa');
			foreach ($_POST as $myTable => $value)
			{	
				if ( in_array($myTable,$semua) )
				{	//echo "myTable : $myTable <br>";
					foreach ($value as $kekunci => $papar)
						$posmen[$myTable][$kekunci] = bersih($papar);
				}
			}
			
			// paparkan newss dan nama syarikat
			$this->_newss = $posmen['semasa']['newss'];
			$this->_nama = $posmen['semasa']['nama'];
			// json_encode() untuk $posmen 
			$posLaju = json_encode($posmen);
			
			/*echo "<pre>";
			echo "_newss : $this->_newss <br>";
			echo "_nama : $this->_nama <br>";
			//echo '<hr>$_POST->'; print_r($_POST);
			//echo '<hr>$posmen->'; print_r($posmen);
			//echo '<hr>$posLaju:'; var_dump($posmen,$posLaju);
			echo "posLaju:", $posLaju, "\n<br>";
			//echo "</pre>"; //*/
			
			$data = array(
				'newss' => $this->_newss,
				'nama' => $this->_nama,
				'data' => $posLaju
				);
			$jadual = 'data_anggaran';
			
			$this->tanya->tambahSimpan($data, $jadual);
			$lokasi = 'location: ' . URL . 'anggaran/semak/' . $this->_newss;
			header($lokasi);//*/
		}
		elseif ($semak == 'Kira')
		{
			$kiraan = array($sv . '_q08_2010',$sv . '_q09_2010',
				//'s' . $sv . '_q02_2010', 's' . $sv . '_q03_2010',
				'semasa');
			$senaraiHarta = array('harta');
			
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
			
			$this->papar->kod_produk['harta'] = ($jadualHarta=='harta' 
				|| $jadualHarta=='harta') ?
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
			//*/
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
			$this->papar->paparNilai = ( 
				bersih($_POST['paparNilai']) == 'Tidak'
				) ?	'-' : '+';
			$this->papar->baca('semakan/analisis', 0);//*/
		
		}
		
    }
	
	public function ubahSimpan($sv, $dataID)
    {
		$myJadual['proses'] = $this->senarai_jadual($sv); // senarai jadual
		$myJadual['kawal'] = dpt_senarai('kawalan_tahunan');
        $posmen = array();
        $id = 'newss';
		    
        foreach ($_POST as $key => $value)
        {
            if ( in_array($key,$bulanan) )
            {
                $myTable = $sv . $key;
                foreach ($value as $kekunci => $papar)
                {
                    if ( in_array($kekunci,array('terimax','hantarx')) )
					{
						$posmen[$myTable]['terima'] = null;
						//$posmen[$myTable]['hantar'] = null;
					}
					elseif ( in_array($kekunci,array('fe','email')) )
						$posmen[$myTable][$kekunci]=strtolower(bersih($papar)); // huruf kecil
					elseif ( in_array($kekunci,array('respon')) )
						$posmen[$myTable][$kekunci]=strtoupper(bersih($papar)); // HURUF BESAR
					elseif ( in_array($kekunci,array('responden')) )
						$posmen[$myTable][$kekunci] = // Huruf Besar Pada Depan Sahaja
							mb_convert_case(bersih($papar), MB_CASE_TITLE); 
					else
						$posmen[$myTable][$kekunci] = bersih($papar);
                }
                $posmen[$myTable][$id] = $dataID;
            }
        }
        
			# buat peristiharan
			$rangka = 'mdt_rangka13'; // rangka kawalan kes
			//echo '<br>$dataID=' . $dataID . '<br>';
			//echo '<pre>$_POST='; print_r($_POST) . '</pre>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
        // mula ulang $bulanan
        
        foreach ($bulanan as $kunci => $jadual)
        {// mula ulang table
            $myTable = $sv . $jadual;
			$posmen[$myTable]['fe'] = $posmen[$rangka]['fe'];
            $data = $posmen[$myTable];
            $this->tanya->ubahSimpan($data, $myTable);
        }// tamat ulang table
        
        //$this->lihat->baca('kawalan/ubah/' . $dataID);
        header('location: ' . URL . 'kawalan/ubah/' . $dataID);
        
    }

	public function tambah($sv=null, $cariID = null, $mula = null, $akhir = null, $cetak = null)
	{				
        // senaraikan tatasusunan jadual dan setkan pembolehubah
		$myJadual['kawal'] = dpt_senarai('kawalan_tahunan');
		$myJadual['proses'] = $this->senarai_jadual($sv); 
		$medan = '*'; // senarai nama medan
		$cariKawal = array (
			'sv' => $sv, // senarai survey
			'id' => (isset($cariID) ? $cariID : null) , // benda yang dicari
			);
		$cariProses = array (
			'sv' => $sv, // senarai survey
			'medan' => 'estab', // cari dalam medan apa
			'id' => (isset($cariID) ? $cariID : null) , // benda yang dicari
			'thn_mula' => $mula, // tahun mula
			'thn_akhir' => $akhir // tahun akhir
			);
		$this->papar->sv = $sv;
		$this->papar->kesID = array();
		$this->papar->thn_mula = $cariProses['thn_mula'];
		$this->papar->thn_akhir = $cariProses['thn_akhir'];

		if (!empty($cariKawal['id'])&& !empty($sv)) 
		{	
			// mula cari $cariID dalam $myJadual['kawal']
			foreach ($myJadual['kawal'] as $key => $myTable)
			{// mula ulang table
				$kawalID[$myTable] = 
				$this->tanya->cariKawal($myTable, $cariKawal);
			}// tamat ulang table

			// mula cari $cariID dalam $myJadual['proses']
			foreach ($myJadual['proses'] as $key => $myTable)
			{// mula ulang table
				$prosesID[$myTable] = 
				$this->tanya->cariEstab($myTable, $cariProses);
			}// tamat ulang table

			// paparkan data kesID yang ada nilai sahaja
			$this->semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses);
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			/*echo '<pre>';
			echo '<hr>$this->papar->kawalID='; print_r($this->papar->kawalID);
			echo '<hr>$this->papar->prosesID='; print_r($this->papar->prosesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/

		/* Set pemboleubah utama
		$this->papar->kelas = 'semakan/ubah/' . $sv . '/';
		// memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
			$this->papar->baca($this->papar->_folder . 'cetak', 0);
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'ubah', 0);
		//*/
	}
	
	public function tambahSimpan($dataID) 
	{	
		$myJadual['proses'] = $this->senarai_jadual($sv); // senarai jadual
		$myJadual['kawal'] = dpt_senarai('kawalan_tahunan');
        $posmen = array();
        $id = 'newss';
    
        foreach ($_POST as $key => $value)
        {
			//echo '$key:' . $key . '<br>';
            if ( in_array($key,$bulanan) )
            {
				$myTable = $key;
				foreach ($value as $kekunci => $papar)
                {
                    $posmen[$myTable][$kekunci] = bersih($papar);
                }
            }
        }
        			
        //echo '<br>$dataID=' . $dataID . '<br>';
        //echo '<pre>$_POST='; print_r($_POST) . '</pre>';
        //echo '<pre>$posmen='; print_r($posmen) . '</pre>';
        
        // mula ulang $bulanan
		$this->tanya->ubahSimpan(
			$data = array('kawalan'=>'sudah', 'newss'=>$dataID), 
			$myTable = 'dtsample_takatfeb13');
        foreach ($bulanan as $kunci => $jadual)
        {// mula ulang table
            $myTable = $jadual;
            $data = $posmen[$myTable];
            $this->tanya->tambahSimpan($data, $myTable);
        }// tamat ulang table
		
		
		// pergi papar kandungan
		//echo 'location: ' . URL . 'kawalan/ubah/' . $dataID;
		header('location: ' . URL . 'kawalan/ubah/' . $dataID);

	}

// senarai jadual
	private function senarai_jadual($sv)
	{	// senaraikan tatasusunan jadual prosesan
		if ($sv == null) $myJadual = array();
		elseif ($sv == '205')
		{	
			$myJadual = array ( // prosesan sebelum 2010
			'q01','q02','s04','s05a','s05b','s06_s07','qlain15','qlain16','qlain20','qlain21','qlain35',
			// prosesan selepas 2010
			'q01_2010','q02_2010','q03_2010','q04_2010','q05a_2010','q05b_2010','q06_2010','q07_2010',
			'q08_2010','q09_2010','q10_2010','q11_2010','q12_2010','q13_2010','q16a_2010','q16b_2010',
			'q17_2010');
		}
		elseif ($sv=='206')
		{
			$jadual = array('q01','q02','q03','q04','q05a','q05b','q06',
			'q07','q08','q09','q10','q11','q12','q13','q14','q15','q16',
			'q17','q18','q20');
			foreach ($jadual as $key => $data)
				$myJadual[] = 's' . $sv . '_' . $data . '_2010';
		}
		else
		{	// prosesan 2010
			$jadual = array('q01','q02','q03','q04','q05','q06','q07',
			'qsa','qsb','qsc','qsd','qse','qsf','tblDataReview');
			/*,'tblDataReviewTemp','tblDataReviewTemp2','tblDataReviewTemp3'*/
			foreach ($jadual as $key => $data)
				$myJadual[] = 's' . $sv . '_' . $data . '_2010';
		}

		return $myJadual;
	}
	
	private function kod_produk() // khas untuk survey 205
	{	// senaraikan tatasusunan jadual prosesan
		$myJadual[]='s14';
		$myJadual[]='s15';
		$myJadual[]='q14_2010';
		$myJadual[]='q15_2010';
		
		return $myJadual;
	}

	// semak IO
	private function paparIO($sv, $paparID, $cari) 
	{
		//echo '<pre>$paparID '; print_r($paparID) . '</pre>';
		if ($sv=='205') 
		{
			$Belanja = 'q09_2010';
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

			$Hasil = 'q08_2010';
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
			$no = 1; 
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

	
	private function semakYangAda($sv, $paparID, $cari) 
	{
		$this->papar->paparID = $cari['id'];
		//echo '<pre>'; //echo '$nilai='; print_r($paparID);
		
		foreach ($paparID as $jadual => $key):
			foreach ($key as $key2 => $data):
				foreach ($data as $medan => $nilai2):
					if ($paparID[$jadual][$key2][$medan]!='0'):
						$this->papar->kesID[$jadual][$key2][$medan] = $nilai2;
						//echo (in_array($jadual, $asetIndustri)) ? $jadual . ' ada<br>' : '';
						if (in_array($jadual, $asetIndustri)) $aset = $jadual;
					endif;
				endforeach;
		   endforeach;
		endforeach;

		// semak kod produk untuk survey 205 sahaja
		if ($sv=='205' || $sv=='206')
		{	// cari produk input dan output
			if ($sv=='205') $this->semak_produk($cari); 
			else $this->papar->kod_produk = array();
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			// bentuk soalan 4 - aset
			if (isset($aset) && $aset != null)
			{
				//echo '<hr>$aset' . print_r($aset);
				$this->semak_aset($senaraiAset = array('s04','q04_2010','s206_q04_2010'),
				$aset, $paparID);
			}
		}
		else
		{
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
		}
	
	}

	private function semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses)
	{
		$this->papar->paparID = $cariKawal['id'];
		// data kawalan =>	echo '<pre>$kawalID='; print_r($kawalID) . '<hr>';
		foreach ($kawalID as $jadual => $key):
			foreach ($key as $key2 => $data):
				foreach ($data as $medan => $nilai):
							
					if ($kawalID[$jadual][$key2][$medan]!=null) 
					{
						$this->papar->kawalID[$jadual][$key2][$medan] = $nilai;
					}
					
				endforeach;
		   endforeach;
		endforeach;
		// data prosesan => echo '<pre>$prosesID='; print_r($prosesID) . '<hr>';
		// senarai aset untuk 205/206
		$asetIndustri = array('s04','q04_2010','s206_q04_2010');

		foreach ($prosesID as $jadual => $key):
			if (in_array($jadual, $asetIndustri)) $aset = $jadual;
			foreach ($key as $key2 => $data):
				foreach ($data as $medan => $nilai):
					
					if ($prosesID[$jadual][$key2][$medan]!=null) 
					{
						$svApa = ($sv=='205') ? $jadual : substr($jadual, 1);
						$this->papar->prosesID[$svApa][$key2][$medan] = $nilai;
						//echo (in_array($jadual, $asetIndustri)) ? $jadual . ' ada<br>' : '';
						if (in_array($jadual, $asetIndustri)) $aset = $jadual;
					}
					
				endforeach;
		   endforeach;
		endforeach;
			
		/* hasil data
		echo '<pre>semakKawalProses()<br>';
		//echo '$namaJadual='; print_r($namaJadual) . '<hr>';
		//echo '$this->papar->kawalID='; print_r($this->papar->kawalID) . '<hr>';
		echo '$this->papar->prosesID='; print_r($this->papar->prosesID) . '<hr>';//*/

		if (isset($this->papar->prosesID) && $this->papar->prosesID != null):
			$this->papar->carian = $cariProses['medan'];
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->prosesID); 
			// semak kod produk untuk survey 205 sahaja
			if ($sv=='205')
			{	
				$this->semak_produk($cariProses); 
				$jadualStaf = array('q05a_2010','q05b_2010');
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = '205';
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil'] =
					$this->papar->prosesID['q08_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja'] =
					$this->papar->prosesID['q09_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji'] = 
					$this->papar->prosesID['q09_2010'][0]['F2148'];
				$this->papar->perangkaan['aset'] =
					$this->papar->prosesID['q04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] =
					$this->papar->prosesID['q04_2010'][0]['F0999'];	

					// bentuk soalan 4 - aset
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				// bentuk soalan staf lelaki dan perempuan
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
			}
			elseif($sv=='206')
			{
				$this->papar->kod_produk = array();
				$jadualStaf = array('206_q05a_2010','206_q05b_2010');
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = '206';
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil'] =
					$this->papar->prosesID['206_q08_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja'] =
					$this->papar->prosesID['206_q09_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji'] = 
					$this->papar->prosesID['206_q09_2010'][0]['F2145'];
				$this->papar->perangkaan['aset'] =
					$this->papar->prosesID['206_q04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] =
					$this->papar->prosesID['206_q04_2010'][0]['F0999'];	
					
				// bentuk soalan 4 - aset
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				// bentuk soalan staf lelaki dan perempuan
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
			}
			else
			{
				$this->papar->kod_produk = array();
				$kp = 's'.$sv.'_q0';
				$jadualStaf = array($kp.'5a_2010',$kp.'5b_2010');
				// bentuk soalan 4 - aset
				$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					null, $prosesID);
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = $sv;
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil'] = 
					$this->papar->prosesID[$kp.'2_2010'][0]['F0040'];
				$this->papar->perangkaan['belanja'] = 
					$this->papar->prosesID[$kp.'3_2010'][0]['F0060'];
				$this->papar->perangkaan['gaji'] = 
					$this->papar->prosesID[$kp.'3_2010'][0]['F0043'];
				$this->papar->perangkaan['aset'] = 
					$this->papar->prosesID[$kp.'4_2010'][0]['F0083'];
				$this->papar->perangkaan['asetsewa'] = 0;
			}
		
		else: $this->papar->prosesID = array();
		endif; // tamat semak if (isset($this->papar->prosesID) && $this->papar->prosesID != null):
	
	} //semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses)
	
	private function semak_produk($cari) // khas untuk survey 205
	{
		// mula cari $cariID dalam $kod_produk
		foreach ($this->kod_produk() as $key => $myTable)
		{// mula ulang table
			if ($myTable=='q14_2010')
			{	// cantum $sql
				$sql = Data::sqlOutput('kod2010_output', $myTable, $cari);		
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukBaru($myTable, $sql);
				// ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodOutput'] = Data::kodOutput($info);
				$baris = $this->papar->kod_produk['kodOutput'];					
				//echo '<pre>($baris)='; print_r($baris) . '</pre><hr>';				
			}
			elseif ($myTable=='q15_2010')
			{	// cantum $sql
				$sql = Data::sqlInput('kod2010_input', $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukBaru($myTable, $sql);
				// ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodInput'] = Data::kodInput($info);
				$baris = $this->papar->kod_produk['kodInput'];					
				//echo '<pre>($baris Input)='; print_r($baris) . '</pre><hr>';				
			}
			else
			{
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukLama($myTable, $medan = '*', $cari);
			}
			
		}// tamat ulang table
		
		//echo '<pre>$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
	}
	
	private function cari_keterangan_medan($sv, $kesID)
	{
		$senarai = Borang::cariKeterangan($kesID);
		// cari keterangan medan					
		foreach ($senarai as $myTable => $papar)
		{// mula ulang table
			foreach ($papar as $namaMedan => $data)
			{// mula ulang table
				//echo '$namaMedan['.$myTable.']:'.$namaMedan.'<br>';
				$cari[0] = array('medan' => 'kod_medan','id' => $namaMedan);
				$cari[1] = array('medan' => 'kod_survey','id' => $sv);
				$this->papar->keterangan[$myTable][$namaMedan] = 
					$this->tanya->keterangan_medan('kod_sv_prosesan', $cari);
					
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
			{
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAset($paparID[$myTable][0]);
				@$this->papar->kod_produk['harta'] = 
					Data::sqlAset($paparID[$myTable][0]);					
			}	
			elseif ($aset==null)
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAsetAm($paparID[$myTable][0]);
		endforeach;

	}
	
	private function semak_staf($jadualStaf, $prosesID, $sv)
	{// khas untuk soalan staf
	
		//echo '<pre>SEMAK_STAF()::$prosesID='; print_r($prosesID) . '</pre>';
		$jenisPekerjaan = array(0=>'Pemilik(ROB)-1',
			1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',
			3=>'Juruteknik-3.2',
			4=>'Kerani-3.3',
			5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',
			7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.3',
			9=>'Upah XMahir-3.5.4',
			10=>'Pekerja sambilan-4',
			11=>'Jumlah pekerja-5');

		$this->papar->kod_produk['pekerjaan'] = 
			Data::dataPekerja($jadualStaf,$jenisPekerjaan,$prosesID);
		
		$mula = 'q05a';
		foreach ($jadualStaf as $key => $myTable):
			//$cari = $prosesID[$myTable][0];
			if (isset($prosesID[$myTable][0])):
				if(strpos($myTable,$mula) !== false)
				{	//echo 'lelaki';
					$cariL = $prosesID[$myTable][0];}
				else
				{	//echo 'perempuan';
					$cariW = $prosesID[$myTable][0];}
			endif;
		endforeach;

		$lelaki = $jadualStaf[0];
		$jenisPekerjaan = array(1=>'Pemilik(ROB)-1',2=>'Pekerja keluarga(ROB)-2',
			3=>'Pengurusan-3.1',4=>'Juruteknik-3.2',
			5=>'Kerani-3.3',6=>'Pekerja Asas-3.4',
			7=>'Operator Loji-3.5',8=>'Operator Loji Buruh-3.6',9=>'',10=>'',
			11=>'Pekerja sambilan-4',19=>'Jumlah pekerja-5');
		$keyLelaki = array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,
			8=>9,9=>10,10=>11,11=>19);
		$this->papar->kod_produk['lelaki'] = Borang::dataStaf($keyLelaki,$lelaki,$jenisPekerjaan,$cariL);
		
		$wanita = $jadualStaf[1];
		$jenisPekerjaan = array(21=>'Pemilik(ROB)-1',22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',26=>'Pekerja Asas-3.4',
			27=>'Operator Loji-3.5',28=>'Operator Loji Buruh-3.6',29=>'',30=>'',
			31=>'Pekerja sambilan-4',39=>'Jumlah pekerja-5');
		$keyWanita = array(0=>21,1=>22,2=>23,3=>24,4=>25,5=>26,6=>27,7=>28,
			8=>29,9=>30,10=>31,11=>39);
		$this->papar->kod_produk['wanita'] = Borang::dataStaf($keyWanita,$wanita,$jenisPekerjaan,$cariW);
	
	}
	
}