<?php

class Semakan extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();
		// lokasi fail PAPAR untuk survey
		$this->papar->js = array('jquery-calx-1.1.8.js');
		$this->papar->_folder = 'semakan/'; 
		$this->papar->kelas = 'semakan/'; 
		$this->_pptAsetPenuh = array(101,301,302,303,305,306,307,308,309,312,314,316,318,325,331);
		$this->papar->ppt['AsetPenuh'] = $this->_pptAsetPenuh;
		$this->papar->ppt['BrgAm'] = array(328,334,335,393,890);
		$this->_pptBrgAm = array(328,334,335,393);
		$this->_pptBrgAm2 = array(890);

	}
	
	private function semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses)
	{
		//echo '<pre>$kawalID='; print_r($kawalID) . '<hr>'; # data kawalan
		$this->papar->kawalID = array();
		foreach ($kawalID as $jadual => $key):
			foreach ($key as $key2 => $data):
				foreach ($data as $medan => $nilai):
					if ($kawalID[$jadual][$key2][$medan]!=null) 
						$this->papar->kawalID[$jadual][$key2][$medan] = $nilai;
				endforeach;
		   endforeach;
		endforeach; //*/
		
		// echo '<pre>$prosesID='; print_r($prosesID) . '<hr>'; # data prosesan 
		# senarai aset untuk 205/206
		$asetIndustri = array('s04','q04_2010','s206_q04_2010','s'.$sv.'_q04_2010');

		foreach ($prosesID as $jadual => $key):
			//if (in_array($jadual, $asetIndustri)) $aset = $jadual;
			foreach ($key as $key2 => $data):
				foreach ($data as $medan => $nilai):
					
					if ($prosesID[$jadual][$key2][$medan]!=null) 
					{
						$this->papar->prosesID[$jadual][$key2][$medan] = $nilai;
						//echo (in_array($jadual, $asetIndustri)) ? $jadual . ' ada<br>' : '';
						if (in_array($jadual, $asetIndustri)) $aset = $jadual;
					}
					
				endforeach;
		   endforeach;
		endforeach;
			
		/* hasil data
		echo '<pre>semakKawalProses()<br>'; //echo '$namaJadual='; print_r($namaJadual) . '<hr>';
		//echo '$this->papar->kawalID='; print_r($this->papar->kawalID) . '<hr>';
		echo '$this->papar->prosesID='; print_r($this->papar->prosesID) . '<hr>';//*/

		if (isset($this->papar->prosesID) && $this->papar->prosesID != null):
			if ($sv=='205')// semak kod produk untuk survey 205 sahaja
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
				$this->papar->perangkaan['hasil']    = $this->papar->prosesID['q08_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja']  = $this->papar->prosesID['q09_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji']     = $this->papar->prosesID['q09_2010'][0]['F2148'];
				$this->papar->perangkaan['susut']    = $this->papar->prosesID['q04_2010'][0]['F0799'];
				$this->papar->perangkaan['aset']     = $this->papar->prosesID['q04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] = $this->papar->prosesID['q04_2010'][0]['F0999'];	

				# bentuk soalan 4 - aset 
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				# bentuk soalan staf lelaki dan perempuan 
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
				# bentuk soalan s14 & s15
				//$this->semak_produk($kawalID);
				
			}
			elseif($sv=='206')
			{
				$this->papar->kod_produk = array();
				$kp = 's' . $sv . '_q'; //echo '111: kp ' . $kp . '<br>';
				$jadualStaf = array($kp.'05a_2010',$kp.'05b_2010');
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = $sv;
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil']    = $this->papar->prosesID[$kp.'08_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja']  = $this->papar->prosesID[$kp.'09_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji']     = $this->papar->prosesID[$kp.'09_2010'][0]['F2145'];
				$this->papar->perangkaan['susut']    = $this->papar->prosesID[$kp.'04_2010'][0]['F0799'];
				$this->papar->perangkaan['aset']     = $this->papar->prosesID[$kp.'04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] = $this->papar->prosesID[$kp.'04_2010'][0]['F0999'];	
					
				// bentuk soalan 4 - aset
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				// bentuk soalan staf lelaki dan perempuan
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
			}
			elseif($sv=='101')
			{
				$this->papar->kod_produk = array();
				$kp = 's' . $sv . '_q'; //echo '111: kp ' . $kp . '<br>';
				$jadualStaf = array($kp.'05a_2010',$kp.'05b_2010');
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = $sv;
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil']    = $this->papar->prosesID[$kp.'07_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja']  = $this->papar->prosesID[$kp.'08_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji']     = $this->papar->prosesID[$kp.'08_2010'][0]['F2145'];
				$this->papar->perangkaan['susut']    = 0; //$this->papar->prosesID[$kp.'04_2010'][0]['F0799'];
				$this->papar->perangkaan['aset']     = 0; //$this->papar->prosesID[$kp.'04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] = 0; //$this->papar->prosesID[$kp.'04_2010'][0]['F0999'];	
					
				// bentuk soalan 4 - aset
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				// bentuk soalan staf lelaki dan perempuan
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
			}			
			elseif(in_array($sv,$this->_pptAsetPenuh))
			{
				$this->papar->kod_produk = array(); 
				$kp = 's' . $sv . '_q'; //echo '111: kp ' . $kp . '<br>';
				# bentuk soalan staf lelaki dan perempuan
				$jadualStaf = array($kp.'05a_2010',$kp.'05b_2010');
				$this->semak_staf($jadualStaf, $this->papar->prosesID, $sv);
				# bentuk soalan 4 - aset
				//$this->semak_aset($senaraiAset = array($kp.'04_2010'),null, $prosesID);
				$this->semak_aset($asetIndustri,$aset,$prosesID);
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = $sv;
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil']    = $this->papar->prosesID[$kp.'08_2010'][0]['F2099'];
				$this->papar->perangkaan['belanja']  = $this->papar->prosesID[$kp.'09_2010'][0]['F2199'];
				$this->papar->perangkaan['gaji']     = $this->papar->prosesID[$kp.'09_2010'][0]['F2163'];
				$this->papar->perangkaan['susut']    = $this->papar->prosesID[$kp.'04_2010'][0]['F0799'];
				$this->papar->perangkaan['aset']     = $this->papar->prosesID[$kp.'04_2010'][0]['F0899'];
				$this->papar->perangkaan['asetsewa'] = $this->papar->prosesID[$kp.'04_2010'][0]['F0999'];	
			}			
			else
			{
				$this->papar->kod_produk = array();
				$kp = 's'.$sv.'_q0';
				# bentuk soalan staf lelaki dan perempuan
				$jadualStaf = $kp.'6_2010';
				if( isset($this->papar->prosesID[$jadualStaf]) )
				{	$this->papar->kod_produk['pekerjaan'] = 
						Data::dataPekerjaBrgAm($this->papar->prosesID[$jadualStaf]);
					$this->papar->kod_produk['teamgenius'] = 
						//Data::dataPekerjaBrgAm($this->papar->prosesID[$jadualStaf]);
						Borang::borangAmStaf($this->papar->prosesID[$jadualStaf]);
				} else { echo '<hr>'.$jadualStaf.'<pre>semak data $this->papar->kod_produk[pekerjaan]:'; 
					print_r($this->papar->kod_produk['pekerjaan']) . '</pre>';	}
				# bentuk soalan 4 - aset
				$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					null, $prosesID);
				// cari sv, jumlah pendapatan dan pembelanjaan
				$rangkaNewss = 'alamat_newss_2013';
				$this->papar->perangkaan['sv'] = $sv;
				$this->papar->perangkaan['newss'] = !isset($namaJadual[$rangkaNewss]) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['newss'];
				$this->papar->perangkaan['nama'] = !isset($this->papar->kawalID[$rangkaNewss][0]['nama']) ? '' :
					$this->papar->kawalID[$rangkaNewss][0]['nama'];
				$this->papar->perangkaan['hasil']    = $this->papar->prosesID[$kp.'2_2010'][0]['F0040'];
				$this->papar->perangkaan['belanja']  = $this->papar->prosesID[$kp.'3_2010'][0]['F0060'];
				$this->papar->perangkaan['gaji']     = $this->papar->prosesID[$kp.'3_2010'][0]['F0043'];
				$this->papar->perangkaan['susut']    = $this->papar->prosesID[$kp.'3_2010'][0]['F0049'];
				$this->papar->perangkaan['aset']     = $this->papar->prosesID[$kp.'4_2010'][0]['F0083'];
				$this->papar->perangkaan['asetsewa'] = $this->papar->prosesID[$kp.'3_2010'][0]['F0057'];
			}			
				/*echo '<pre>';
				echo '<hr>$this->papar->perangkaan='; print_r($this->papar->perangkaan); 
				//echo '<hr>$this->papar->carian: ' . $this->papar->carian . '<br>';
				echo '</pre>';//*/		

			$this->papar->carian = $cariProses['medan'];
			//unset($this->kod_produk['harta_301_q04_2010']);
			//$this->cari_keterangan_medan($sv, $this->papar->prosesID); // cari keterangan medan
		else: $this->papar->prosesID = array();
		endif; // tamat semak if (isset($this->papar->prosesID) && $this->papar->prosesID != null):
//*/	
	} //semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses)
	
	public function index($cetak = null) 
	{	
		# dapatkan semua data
			$myTable = 'data_anggaran';
			$prosesID[$myTable] = $this->tanya->cariData($myTable);

		# paparkan data kesID yang ada nilai sahaja
			$this->semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses);

			/*echo '<pre>';
			echo '<hr>$this->papar->kawalID='; print_r($this->papar->kawalID);
			echo '<hr>$this->papar->prosesID='; print_r($this->papar->prosesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			echo '</pre>';//*/
		
		# memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
		//	$this->papar->baca($this->papar->_folder . 'cetak', 0);
		if ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->_folder . 'index', 1);			
		else //echo 'ubah';
			$this->papar->baca($this->papar->_folder . 'index', 0);
		//*/
	}
	
	function ubah($sv=null, $cariID = null, $mula = null, $akhir = null, $cetak = null, $peratus = 0)
	{	//echo '<br>Anda berada di class Cprosesan extends Kawal:ubah($cari,$mula,$akhir,$cetak, $peratus)<br>';
		# setkan semua pembolehubah
		$medan = '*'; # senarai nama medan
		$cariKawal = array (
			'sv' => $sv, # senarai survey
			'id' => (isset($cariID) ? $cariID : null) # benda yang dicari
			);
		$cariProses = array (
			'sv' => $sv, # senarai survey
			'medan' => 'estab', # cari dalam medan apa
			'id' => (isset($cariID) ? $cariID : null), # benda yang dicari
			'thn_mula' => $mula, # tahun mula
			'thn_akhir' => $akhir # tahun akhir
			);
				
		if (!empty($cariKawal['id'])&& !empty($sv)) 
		{	
			foreach (dpt_senarai('kawalan_tahunan') as $key => $myTable) 
				$kawalID[$myTable] = $this->tanya->cariKawal($myTable, $cariKawal);

			foreach ($this->senarai_jadual($sv) as $key => $myTable)
				$prosesID[$myTable] = $this->tanya->cariEstab($myTable, $cariProses);
			
			# paparkan data kesID yang ada nilai sahaja
			$this->semakKawalProses($sv, $kawalID, $prosesID, $cariKawal, $cariProses);
			//echo '<pre><hr>$kawalID='; print_r($kawalID); echo '<hr>$prosesID='; print_r($prosesID) . '</pre>';//*/
			# cari kod io $this->paparIO($sv, $this->papar->prosesID, $cariProses);
			
			$this->papar->carian = $cariKawal['id'];
			$this->papar->sv = $sv;
			$this->papar->thn_mula = $cariProses['thn_mula'];
			$this->papar->thn_akhir = $cariProses['thn_akhir'];
		} 
		else 
			$this->papar->carian='[id:0]'; 
			
			/*# semak pembolehubah
			echo '<pre><hr>$this->papar->kawalID='; print_r($this->papar->kawalID);
			echo '<hr>$this->papar->prosesID='; print_r($this->papar->prosesID);
			echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			echo '<hr>$this->papar->perangkaan='; print_r($this->papar->perangkaan); 
			echo '<hr>$this->papar->carian: ' . $this->papar->carian . '<br>';
			echo '</pre>';//*/		
			
		# memilih antara papar dan cetak
		$this->papar->peratus = $peratus; 
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
					
			/*echo "<pre><hr>$_POST->'; print_r($_POST);
			//echo '<hr>$posmen->'; print_r($posmen);
			//echo '<hr>$posLaju:'; var_dump($posmen,$posLaju);
			echo "posLaju:", $posLaju, "\n<br>";
			//echo "</pre>"; //*/
			
			$data = array(
				'newss' => $posmen['semasa']['newss'],
				'nama' => $posmen['semasa']['nama'],
				'data' => json_encode($posmen)
				);
			$jadual = 'data_anggaran';
			
			$this->tanya->tambahSimpan($data, $jadual);
			$lokasi = 'location: ' . URL . 'anggaran/semak/' . $this->_newss;
			header($lokasi);//*/
		}
		elseif ($semak == 'Kira')
		{
			$kiraan = array($sv . '_q08_2010',$sv . '_q09_2010',
				's' . $sv . '_q02_2010', 's' . $sv . '_q03_2010',
				's' . $sv . '_q08_2010', 's' . $sv . '_q09_2010',
				'semasa');
			//$senaraiHarta = array('harta_q04_2010','harta_s'.$this->sv.'_q04_2010');
			$senaraiHarta = array('jadualHarta','jadualHartaAm');
			
			foreach ($_POST as $myTable => $value)
			{		
				if ( in_array($myTable,$kiraan) )
				{
					foreach ($value as $kekunci => $papar)
						$this->papar->kesID[$myTable][0][$kekunci] = bersih($papar);
				}
				elseif ( in_array($myTable,$senaraiHarta) )
				{
					$jadualAset = $myTable; //echo '346:' . $myTable . '<br>';
					foreach ($value as $kekunci => $papar)
						$cariHarta[$kekunci] = bersih($papar);
				}
				elseif ( $myTable == 'teamgenius')
				{
					foreach ($value as $kekunci => $papar)
						foreach ($papar as $namaMedan => $papar2)
							$this->papar->staf[$myTable][$kekunci][$namaMedan] = bersih($papar2);				
				}
				elseif ( in_array($myTable, array('output','input') ) )
				{
					foreach ($value as $kekunci => $papar)
						foreach ($papar as $namaMedan => $papar2)
							$this->papar->borang[$myTable][$kekunci][$namaMedan] = bersih($papar2);
				}
				elseif ( $myTable == 'proses')
				{
					foreach ($value as $kekunci => $papar)
						$prosesData[$myTable][0][$kekunci] = bersih($papar);
				}
			}
					
			# cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->semak_prosesMedan($sv, $prosesData, 'proses'); 
			
			# cari perbandingan aset dulu dan kini //echo "\$jadualHarta = $jadualHarta <br>"; 
			if (isset($cariHarta) && $jadualAset=='jadualHarta'):
				$this->papar->kod_aset['harta'] = 
				Borang::analisaAset($cariHarta, 
				array(
					'aset_dulu' => $this->papar->kesID['semasa'][0]['aset_dulu'],
					'aset_kini' => $this->papar->kesID['semasa'][0]['aset_kini'],
					'susut_dulu' => $this->papar->kesID['semasa'][0]['susut_dulu'],
					'susut_kini' => $this->papar->kesID['semasa'][0]['susut_kini'],
					'asetsewa_dulu' => $this->papar->kesID['semasa'][0]['asetsewa_dulu'],
					'asetsewa_kini' => $this->papar->kesID['semasa'][0]['asetsewa_kini'],
				));
			else:
				//echo '375:Borang Aset Am';
				$susutDulu = $this->papar->kesID['s' . $sv . '_q03_2010'][0]['F0049'];
				$BelanjaDulu = $this->papar->kesID['s' . $sv . '_q03_2010'][0]['F0060'];
				$this->papar->kod_aset['harta'] = 
				Borang::analisaAsetAm($cariHarta, 
				array(
					'aset_dulu' => $this->papar->kesID['semasa'][0]['aset_dulu'],
					'aset_kini' => $this->papar->kesID['semasa'][0]['aset_kini'],
					'susut_dulu' => $this->papar->kesID['semasa'][0]['susut_dulu'],
					'susut_kini' => $this->papar->kesID['semasa'][0]['susut_kini'],
				));
			endif;
			//*/
			# untuk pastikan tiada orang hack
			$this->papar->paparID = $this->papar->kesID['semasa'][0]['newss'];
			$this->papar->carian = 'newss';
						
			/*echo '<pre>';
			//echo '<hr>$_POST->'; print_r($_POST);
			//echo '<hr>$staf->'; print_r($this->papar->staf);
			//echo '<hr>$cariHarta->'; print_r($this->papar->kod_aset);
			//echo '<hr>$this->papar->borang->'; print_r($this->papar->borang);
			//echo '<hr>$this->papar->kesID->'; print_r($this->papar->kesID);
			//echo '<hr>$this->papar->kod_produk->'; print_r($this->papar->kod_produk);
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			//echo '<hr>$this->papar->carian: ' . $this->papar->carian;
			//echo '<hr>$this->papar->keterangan->', print_r($this->papar->keterangan, 1);
			echo '</pre>';//*/
			
			# pergi ke fail analisis di PAPAR
			$this->papar->paparNilai = bersih($_POST['paparNilai']) == 'Tidak' ? '-' : '+';
			$this->papar->baca('semakan/analisis', 1);//*/
		
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
	{
		// senaraikan tatasusunan jadual prosesan
		if ($sv == null) $myJadual = array();
		elseif ($sv=='cdt')
		{
			$myJadual[] = 'data_cdt2009';
			$myJadual[] = 'data_cdt2009_a';
			$myJadual[] = 'data_cdt2009_c';
			$myJadual[] = 'data_cdt2009_b';
		}
		elseif ($sv=='icdt')
		{
			$jadual = array('asas','struktur','msic','aset','bangsa','staf',
			'hasil','belanja','stok','cawangan');
			foreach ($jadual as $key => $data)
				$myJadual[] = 'data_' . $sv . '2012_' . $data . '';
		}
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
		elseif (in_array($sv,$this->_pptAsetPenuh))
		{	// prosesan 2010
			$jadual = array('q01','q02','q03','q04','q05a','q05b','q06',
			'q07','q08','q09','q10','q11','qsa','qsb','qsc','qsd','qse','qsf',
			/*,'tblDataReviewTemp2'*/
			'tblDataReview','tblDataReviewTemp','tblDataReviewTemp3');
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
	{
		// senaraikan tatasusunan jadual
		// prosesan
		$myJadual[]='s14';
		$myJadual[]='s15';
		$myJadual[]='q14_2010';
		$myJadual[]='q15_2010';
		
		return $myJadual;
	}
	
	// semak IO
	private function paparIO($sv, $paparID, $cari) 
	{
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
			$harta = array('s04','q04_2010','s'.$sv.'_q04_2010');
			$stok = array('s10','q10_2010');
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
	
	//
	private function semakYangAda($sv, $paparID, $cari) 
	{
		$this->papar->paparID = $cari['id'];
		//echo '<pre>'; //echo '$nilai='; print_r($paparID);
		// senarai aset untuk 205/206
		$asetIndustri = array('s04','q04_2010','s206_q04_2010');
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
		{	if ($sv=='205') 
			{
				$this->semak_produk($cari); 
				$jadualStaf = array('s05a','s05b','q05a_2010','q05b_2010');
			}
			else 
			{
				$this->papar->kod_produk = array();
				$jadualStaf = array('s206_q05a_2010','s206_q05b_2010');
			}
			// bentuk soalan staf lelaki dan perempuan
			$this->semak_staf($jadualStaf, $this->papar->kesID);
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			// bentuk soalan 4 - aset
			if (isset($aset) && $aset != null)
			{	//echo '<pre>$aset='; print_r($aset) . '</pre>';
				$this->semak_aset($asetIndustri, $aset, $paparID);
			}
		}
		elseif ($sv=='cdt')
		{
			$this->papar->kod_produk = array();
			$this->cdt_pecah_soalan(
				'data_cdt2009', 'data_cdt2009_a', 
				'data_cdt2009_b', 'data_cdt2009_c', 
				$this->papar->kesID);
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			// buang jadual 'data_cdt2009_b'
			unset($this->papar->kesID['data_cdt2009_b']);
		}
		elseif ($sv=='icdt')
		{
			$this->papar->kod_produk = array();
			$this->icdt_pecah_soalan($this->papar->kesID);
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			// buang jadual 'data_icdt2012_aset/ data_icdt2012_staf/data_icdt2012_stok'
			foreach (array('asas','struktur',/*'msic',*/'aset','staf',/*'hasil','belanja',*/'stok') as $buanglah)
				unset($this->papar->kesID['data_icdt2012_' . $buanglah]); 


		}
		elseif (in_array($sv,$this->_pptAsetPenuh))
		{
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			// bentuk soalan staf lelaki dan perempuan
			$jadualStaf = array('s'.$sv.'_q05a_2010','s'.$sv.'_q05b_2010');
			$this->semak_staf($jadualStaf, $this->papar->kesID);
			// bentuk soalan 4 - aset
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					's'.$sv.'_q04_2010', $paparID);		
		}
		else
		{
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					null, $paparID);
			// bentuk soalan staf lelaki dan perempuan
			$jadualStaf = 's'.$sv.'_q06_2010';
			if( isset($this->papar->kesID[$jadualStaf]) )
				$this->papar->kod_produk['pekerjaan'] = 
					Data::dataPekerjaBrgAm($this->papar->kesID[$jadualStaf]);
			//echo '<hr>'.$jadualStaf.'<pre>semak data $this->papar->kod_produk[pekerjaan]:'; 
			//print_r($this->papar->kod_produk['pekerjaan']) . '</pre>';
					
		}
	
	}
	
	private function semak_produk($cari) # khas untuk survey 205
	{
		$medan = '*';
		$kodProduk = 'kod2010_output';
		$kodProduk2 = 'mcpa2009_tr2014'; 
		# mula cari $cariID dalam $kod_produk
		foreach ($this->kod_produk() as $key => $myTable)
		{# mula ulang table
			if ($myTable=='q14_2010')
			{
				$sql = Borang::borangOutput($kodProduk, $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariProdukBaru($myTable, $sql);
				$this->papar->kod_produk['output'] =
					Data::produkOutput($this->papar->kod_produk[$myTable]);
			}
			elseif ($myTable=='q15_2010')
			{
				$sql = Borang::borangInput($kodProduk, $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariProdukBaru($myTable, $sql);
				$this->papar->kod_produk['input'] =
					Data::produkInput($this->papar->kod_produk[$myTable]);
			}
			elseif ($myTable == 's14') 
			{
				$kod = 'concat(substring(kod_produk_lama,1,5),substring(kod_produk_lama,8,12))';
				$produk = 'concat(substring(F3001,1,5))';
				$medan2 = '*, (SELECT concat('.$kod.',keterangan)
					FROM kodproduk_mei2011 b WHERE '.$kod.' like '.$produk.') as nama_produk
					,(SELECT CONCAT("<abbr title=\"", keterangan, "\">", kod_produk, "</abbr>") 
					FROM kodproduk_aup b WHERE b.kod_produk = F3001) as nama_produk2';
					//concat(substring(kod_produk_lama,1,5),"",substring(kod_produk_lama,8,12)) as kod_produk,
					//18101 01 004 23
				$medan = '*';
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariSemuaMedan($myTable, $medan, $cari);
			}
			else
			{
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariSemuaMedan($myTable, $medan, $cari);
			}
			
		}# tamat ulang table
		
		//echo '<pre>$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
	}
	
	private function cari_keterangan_medan($sv, $kesID)
	{
		$senarai = Borang::cariKeterangan($kesID);
		
		# cari keterangan medan yang lain				
		foreach ($senarai as $myTable => $papar)
		{# mula ulang table
			foreach ($papar as $namaMedan => $data)
			{# mula ulang table
				//echo '$namaMedan['.$data.']['.$myTable.']:'.$namaMedan.'<br>';
				$cari[0] = array('medan' => 'kod_medan','id' => $namaMedan);
				$cari[1] = array('medan' => 'kod_survey','id' => $sv);
				$this->papar->keterangan[$myTable][$namaMedan] = 
					$this->tanya->keterangan_medan('kod_sv_prosesan', $cari);
			}# tamat ulang table
		}# tamat ulang table

	}

	private function semak_prosesMedan($sv, $prosesData, $jadual)
	{
		$this->cari_keterangan_medan($sv, $prosesData); 
		foreach ( $prosesData[$jadual][0] as $key=>$data ) : 
			if($data != 0):
				$proses2[$jadual][0][$key] = $data;		
			endif;
		endforeach;	//*/
		$kira = count($proses2[$jadual][0]);
		$jumlah = number_format( ($kira / 2), 0,'.',',');
		//echo "line896: kira : $kira | jumlah = $jumlah | ";
		$bilMedan = 1;
		foreach ( $proses2[$jadual][0] as $key=>$data ) : 
			if ($bilMedan++ <= $jumlah) $this->papar->dataAsal['asal'][0][$key] = $data;		
			else $this->papar->dataAsal['asal2'][0][$key] = $data;		
		endforeach;	//*/
		
		//echo "line904: bilMedan : $bilMedan <br>";
		//echo "905:<pre>:\$proses2:", print_r($this->papar->dataAsal, 1) . "</pre>";		
	}
	
	private function semak_aset($asetIndustri, $aset, $paparID) 
	{# khas untuk soalan aset
		//echo "<pre>880:senaraiAset:", print_r($asetIndustri, 1) . '| jadual:', print_r($aset, 1) . "<br>";
		//echo "<pre>paparID:", print_r($paparID, 1) . "<br>";
		
		foreach ($asetIndustri as $key => $myTable):
			//echo ($myTable!=$aset) ? null : "myTable:$myTable | aset:$aset|<br>";
			if ($aset==$myTable && in_array($aset,$asetIndustri) )
			{
				//echo "<pre>887:senaraiAset:", print_r($asetIndustri, 1) . '| jadual:', print_r($aset, 1) . "<br>";
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAset($paparID[$myTable][0]);
				@$this->papar->kod_produk['jadualHarta'] = 
					Borang::inputAset($paparID[$myTable][0]);
			}
			elseif ($aset==null)
			{
				//echo "<pre>895:senaraiAset:", print_r($asetIndustri, 1) . '| jadual:', print_r($aset, 1) . "<br>";
				@$this->papar->kod_produk['harta_' . $myTable] = 
					Borang::binaAsetAm($paparID[$myTable][0]);
				@$this->papar->kod_produk['jadualHartaAm'] = 
					Borang::inputAsetAm($paparID[$myTable][0]);
			}
		endforeach;

	}

	private function semak_staf($jadualStaf, $prosesID)
	{# khas untuk soalan staf
			$jenisPekerjaan = array(0=>'Pemilik(ROB)-1',1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',3=>'Juruteknik-3.2',4=>'Kerani-3.3',5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',11=>'Jumlah pekerja-5');

		$this->papar->kod_produk['pekerjaan'] = 
			Data::dataPekerja($jadualStaf,$jenisPekerjaan,$prosesID);
		$this->papar->kod_produk['teamgenius'] = 
			Borang::borangStaf($this->papar->kod_produk['pekerjaan']);
	}
	
	private function cdt_pecah_soalan($Am,$A,$B,$C,$paparID)
	{
		if(isset($paparID[$A][0]) ):
			foreach( array('asas','struktur','msic','aset','staf','hasil','belanja','stok','tambahan') 
			as $key => $myTable)
			{# mula ulang tatasusunan
				$jadual = substr($myTable, 0, 14);
				$Jadual2 = 'cdt' . huruf('Besar', $jadual);
				$this->papar->kod_produk[$jadual] = (in_array($jadual,array('asas'))) ?
					Data::$Jadual2($paparID[$A][0],$paparID[$C][0])
					: Data::$Jadual2($paparID[$B][0]);
			}# tamat ulang tatasusunan
		endif;
	}
	
	private function icdt_pecah_soalan($paparID)
	{
		if(isset($paparID['data_icdt2012_asas'][0]) ):
			foreach($this->senarai_jadual('icdt') as $key => $myTable)
			{# mula ulang tatasusunan
				$jadual = substr($myTable, 14, 14);
				$Jadual2 = 'icdt' . huruf('Besar', $jadual);
				if(in_array($jadual,array('asas','struktur','aset','staf','hasil','belanja','stok','cawangan'))) 
					$this->papar->kod_produk[$jadual] = 
						Data::$Jadual2($paparID[$myTable][0]);
			}# tamat ulang tatasusunan
		endif;
	}
###	
}