<?php

class Cprosesan101 extends Kawal 
{
#----------------------------------------------------------------------------------------------------------------------------#
	public function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();
		# lokasi fail PAPAR untuk survey
		$this->papar->dataAm = 'cprosesan/'; 
		$this->papar->kelas = 'cprosesan/'; 
		$this->_pptAsetPenuh = array(301,302,303,305,306,307,308,309,312,314,316,318,325,331);
		$this->_ppt2015 = array('fnb');
		$this->papar->ppt['AsetPenuh'] = $this->_pptAsetPenuh;
		$this->papar->ppt['BrgAm'] = array(328,334,335,890);
		$this->_pptBrgAm = array(328,334,335);
		$this->_pptBrgAm2 = array(890);
	}

	public function index() 
	{	
		$this->papar->baca($this->papar->dataAm . 'index');
	}

	# ubah & cetak
	function ubah($sv=null, $id = null, $mula = null, $akhir = null, 
	$cetak = null, $namaSyarikat = null)
	{	//echo '<br>Anda berada di class Cprosesan extends Kawal:ubah($cari,$mula,$akhir,$cetak)<br>';
		
		# setkan semua pembolehubah
		$medan = '*'; # senarai nama medan
		$cari = array (
			'sv' => $sv, // senarai survey
			'medan' => ($sv!='cdt' ? 'estab' : 'sidap'), // cari dalam medan apa
			'id' => (isset($id) ? $id : null) , // benda yang dicari
			'thn_mula' => $mula, // tahun mula
			'thn_akhir' => $akhir // tahun akhir
			);//echo '<pre>$cari::'; print_r($cari) . '</pre>';
		$this->papar->sv = $sv;
		$this->papar->carian = (!empty($cari['id'])) ? $cari['medan'] : '[id:0]';
		$this->papar->kesID = array();
		$this->papar->paparID = null;
		$this->papar->thn_mula = $cari['thn_mula'];
		$this->papar->thn_akhir = $cari['thn_akhir'];

		if (!empty($cari['id']) && !empty($sv)) 
		{
			# mula cari $cari dalam $this->senarai_jadual(($sv)
			//echo '<pre>$this->senarai_jadual('.$cari['sv'].')::'; print_r($this->senarai_jadual($sv)) . '</pre>';

			foreach ($this->senarai_jadual($cari['sv']) as 
				$key => $myTable)
			{# mula ulang table
				//echo "\$myTable = $myTable<br>"; # semak nama $myTable
				$nilai[$myTable] = $this->tanya->cariEstab($myTable, $medan, $cari);
			}# tamat ulang table

			# paparkan data kesID yang ada nilai sahaja
			//echo '<pre>$nilai='; print_r($nilai);
			$this->semakYangAda($sv, $nilai, $cari);
			# cari kod io
			$this->paparIO($sv, $this->papar->kesID, $cari);
			# paparkan nama syarikat
			$this->papar->namaSyarikat = $namaSyarikat; //*/
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			/*echo '<pre>'; # proses debug
			//echo '<hr>$this->papar->keterangan='; print_r($this->papar->keterangan);
			//echo '<hr>$this->papar->kesID='; print_r($this->papar->kesID);
			//echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			echo '<hr>$this->papar->carian: ' . $this->papar->carian . '<br>';
			echo '<hr>$this->papar->namaSyarikat: ' . $this->papar->namaSyarikat . '<br>';
			echo '</pre>';//*/

		# memilih antara papar dan cetak
		if ($cetak == 'cetak') //echo 'cetak';
			$this->papar->baca($this->papar->dataAm . 'cetak', 0);
		elseif ($cetak == 'papar') //echo 'papar';
			$this->papar->baca($this->papar->dataAm . 'ubah', 1);
		else //echo 'ubah';
			$this->papar->baca($this->papar->dataAm . 'ubah', 0);
		//*/
	}

	public function ubahCetak($sv)
	{
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		# bersihkan data $_POST
		$dataID = 'ubah/' . bersih($sv) . '/' . bersih($_POST['cari']);

		# menukar arah pautan $lokasi 
		$lokasi = 'location: ' . URL . $this->papar->dataAm . $dataID . '/2010/2012';
		header($lokasi);
	}
#----------------------------------------------------------------------------------------------------------------------------#
# senarai jadual
	private function senarai_jadual($sv)
	{	# senaraikan tatasusunan jadual prosesan
		//echo 'senarai_jadual(' . $sv . ')<br>';
		
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
		elseif (in_array($sv,array('101')))
		{	# tanaman sahaja
			$jadual = array('q01','q01a','q02','q03','q04','q04b','q05a','q05b','q06',
			'q07','q08','q09','q10','q11','q12','q13a','q13b','q14','q14','q15','q16',
			'qsa','qsb','qsc','qsd','qse','qsf',
			/*,'tblDataReviewTemp2'*/
			'tblDataReview','tblDataReviewTemp','tblDataReviewTemp3');
			foreach ($jadual as $key => $data)
				$myJadual[] = 's' . $sv . '_' . $data . '_2010';
		}
		elseif ($sv == '205')
		{
			$myJadual = array ( # prosesan sebelum 2010
			'q01','q02','s04','s05a','s05b','s06_s07','qlain15','qlain16','qlain20','qlain21','qlain35',
			# prosesan selepas 2010
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
		elseif (in_array($sv,$this->_ppt2015))
		{	// prosesan 2010
			$jadual = array('q01','q02','q03','q04','q05','q06',
			'q07','q08','q09','q10','q11','qsa','qsb','qsc','qsd','qse','qsf',
			/*,'tblDataReviewTemp2'*/
			/*'tblDataReview','tblDataReviewTemp','tblDataReviewTemp3'*/);
			foreach ($jadual as $key => $data):
				//$myJadual[] = 's' . $sv . '_' . $data . '_2010';
				$myJadual[] = 's' . $sv . '_' . $data . '_2015';
			endforeach;
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

	private function kod_produk($kp) // khas untuk survey 205
	{
		# senaraikan tatasusunan jadual prosesan
		if($kp=='101')
			$myJadual = array(
				0=>'s' . $kp . '_q12_2010',
				1=>'s' . $kp . '_q13_2010',
				2=>'s' . $kp . '_q14_2010',
			);
		elseif($kp=='205')
			$myJadual = array(
				0=>'s14',
				1=>'s15',
				2=>'q14_2010',
				3=>'q15_2010',
			);
		else
			$myJadual = array();

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
		elseif ($sv=='206') {}
		else {}
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

		# asingkan ikut kp/sv
		if (in_array($sv,array('101')))
		{# kod 101
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			# bentuk soalan staf lelaki dan perempuan
			$jadualStaf = array('s'.$sv.'_q05a_2010','s'.$sv.'_q05b_2010');
			$this->semak_staf($jadualStaf, $this->papar->kesID,$sv);
			# bentuk soalan 4a - aset biasa
			//$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
			//		's'.$sv.'_q04_2010', $paparID, $sv);
			# semak kod produk
			//$this->semak_produk($cari, $sv); 
			//echo '<pre>line300 : semak_staf_aset_produk:'; print_r($this->papar->kod_produk) . '</pre><hr>';
			# bentuk soalan 4b - aset biologi
			$this->semak_aset_biologi($sv, $paparID, $cari);
			//echo '<pre>line303 : semak_aset_biologi:'; print_r($this->papar->kod_produk) . '</pre><hr>';
		}
		// semak kod produk untuk survey 205 sahaja
		elseif ($sv=='205')
		{
			$this->semak_produk($cari, $sv); 
			# bentuk soalan staf lelaki dan perempuan
			$jadualStaf = array('s05a','s05b','q05a_2010','q05b_2010');
			$this->semak_staf($jadualStaf, $this->papar->kesID,$sv);
			# cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			# bentuk soalan 4 - aset
			if (isset($aset) && $aset != null)
			{	//echo '<pre>$aset='; print_r($aset) . '</pre>';
				$this->semak_aset($asetIndustri, $aset, $paparID, $sv);
			}
		}
		elseif ($sv=='206')
		{
			# cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			# bentuk soalan 4 - aset
			if (isset($aset) && $aset != null)
			{	//echo '<pre>$aset='; print_r($aset) . '</pre>';
				$this->semak_aset($asetIndustri, $aset, $paparID, $sv);
			}
			# bentuk soalan untuk binaan
			$this->semak_produk_206($sv, $this->papar->kesID);
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
			$this->semak_staf($jadualStaf, $this->papar->kesID,$sv);
			// bentuk soalan 4 - aset
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
				's'.$sv.'_q04_2010', $paparID, $sv);
		}
		elseif (in_array($sv,$this->_ppt2015))
		{
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			# bentuk soalan staf lelaki dan perempuan
			$jadualStaf = 's'.$sv.'_q05_2015';
			//echo '$this->papar->kesID[$jadualStaf] -><pre>'; print_r($this->papar->kesID[$jadualStaf]) . '</pre><hr>';
			$this->semak_staf($jadualStaf, $this->papar->kesID,$sv);
			# bentuk soalan 4 - aset
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2015'),
				's'.$sv.'_q04_2015', $paparID, $sv); //*/
		}
		else
		{
			// cari keterangan medan
			$this->cari_keterangan_medan($sv, $this->papar->kesID); 
			$this->papar->kod_produk = array();
			$this->semak_aset($senaraiAset = array('s'.$sv.'_q04_2010'),
					null, $paparID, $sv);
			// bentuk soalan staf lelaki dan perempuan
			$jadualStaf = 's'.$sv.'_q06_2010';
			if( isset($this->papar->kesID[$jadualStaf]) )
				$this->papar->kod_produk['pekerjaan'] = 
					Data::dataPekerjaBrgAm($this->papar->kesID[$jadualStaf]);
			//echo '<hr>'.$jadualStaf.'<pre>semak data $this->papar->kod_produk[pekerjaan]:'; 
			//print_r($this->papar->kod_produk['pekerjaan']) . '</pre>';

		}

	}

	private function semak_produk($cari, $kp) // khas untuk survey 205
	{
		$medan = '*';
		# mula cari $cariID dalam $kod_produk
		foreach ($this->kod_produk($kp) as $key => $myTable)
		{// mula ulang table
			
			if ($myTable=='q14_2010')
			{
				//echo $myTable . '<br>';
				$sql = Borang101::binaKodOutput('kod2010_output', $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariProdukBaru($myTable, $sql);
				/* ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodOutput'] = Data::kodOutput($info);*/
							}
			elseif ($myTable=='q15_2010')
			{
				//echo $myTable . '<br>';
				$sql = Borang101::binaKodInput('kod2010_input', $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
					$this->tanya->cariProdukBaru($myTable, $sql);
				/* ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodInput'] = Data::kodInput($info);*/
				//echo '<pre>($baris Input)='; print_r($baris) . '</pre><hr>';
			}
			elseif ($myTable == 's14')
			{
				//echo $myTable . '<br>';
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
				$this->tanya->cariProdukLama($myTable, $medan, $cari);
			}
			elseif ($myTable == 's101_q12_2010') 
			{
				//echo $myTable . '<br>';
				$jA = 's101_q12_2010';
				$jB = '';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				//$sql = Borang101::bina101Output13a($mcpaA, $jA, $jB, $cari);
				$sql = Borang101::bina101Output12($mcpaB, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r($sql) . '<pre>';
				$this->papar->kod_produk['kodXtxtTaniLain'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}
			elseif ($myTable == 's101_q13_2010') 
			{
				//echo $myTable . '<br>';
				$jA = 's101_q13a_2010';
				$jB = 's101_q13b_2010';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				//$sql = Borang101::bina101Output13a($mcpaA, $jA, $jB, $cari);
				$sql = Borang101::bina101Output13a($mcpaB, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r($sql) . '<pre>';
				$this->papar->kod_produk['kodOutput'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}
			elseif ($myTable == 's101_q14_2010')
			{
				//echo $myTable . '<br>';
				$jA = 's101_q14_2010';
				$jB = '';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				//$sql = Borang101::binaKodInput101($mcpaA, $myTable, $cari);
				$sql = Borang101::binaKodInput101($mcpaC, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r($sql) . '<pre>';
				$this->papar->kod_produk['kodInput'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
				//$baris = $this->papar->kod_produk['kodInput'];
				//echo '<pre>($baris Input)='; print_r($baris) . '</pre><hr>';
			}//*/
			else
			{
				//echo '<hr>Lain2:' . $myTable . '<br>';
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukLama($myTable, $medan, $cari);
			}
			
		}# tamat ulang table

		//echo '<pre>$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
	}

	private function cari_keterangan_medan($sv, $kesID)
	{
		$senarai = Borang101::cariKeterangan($kesID);
		if ($sv=='fnb')	:
			$this->papar->keterangan[][]=array();
		else:# cari keterangan medan yang lain				
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
		endif;
	}

	private function semak_aset($asetIndustri, $aset, $paparID, $kp) 
	{// khas untuk soalan aset
		//echo "<pre>senaraiAset:"; print_r($asetIndustri); 
		//echo'| jadual:'; print_r($aset); echo '</pre><br>';

		foreach ($asetIndustri as $key => $myTable):
			//echo ($myTable!=$aset) ? null : "myTable:$myTable | aset:$aset|<br>";
			if ($aset==$myTable && in_array($aset,$asetIndustri) )
				@$this->papar->kod_produk['harta'] = 
					Borang101::binaAset($paparID[$myTable][0], $kp);
			elseif ($aset==null)
				@$this->papar->kod_produk['harta'] = 
					Borang101::binaAsetAm($paparID[$myTable][0], $kp);
		endforeach;
	}

	private function semak_aset_biologi($kp, $paparID, $cari)
	{# khas untuk soalan aset biologi

		$kira = '';
		$asetBiologi = array(
				'04'=>'harta', # aset harta biasa
				'04b'=>'harta_biologi', # aset biologi
				'11'=>'luas_tanaman', # luas tanaman
				'12'=>'xtvt_tani_lain2', # PENDAPATAN DARIPADA AKTIVITI PERTANIAN LAIN DALAM TAHUN 2015 (Tidak termasuk CBP)
				'13a'=>'luas_jualA', # P '13b'=>'luas_jualB', # P
				'14'=>'kos_bahan', # Kos bahan langsung yang digunakan
				'16'=>'cawangan', # maklumat hq/cawangan
			);
		//echo "<pre>asetBiologi:"; print_r($asetBiologi); echo "</pre><hr>";

		foreach ($asetBiologi as $key => $soalan):
			if($key=='04')
				@$this->papar->kod_produk[$soalan] = 
					Borang101::binaAset($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
			if($key=='04b')
				@$this->papar->kod_produk[$soalan] = 
					//Borang101::bina04b($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
					Borang101::binaAsetBiologi($paparID['s' . $kp . '_q04_2010'][0], 
					$paparID['s' . $kp . '_q04b_2010'][0], $kp);
			if($key=='11')
			{
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina11($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
				$kira = count($this->papar->kod_produk[$soalan]);
				//echo '<pre>line567:this->papar->kod_produk['.$soalan.']:'; print_r($kira); echo '</pre><hr>';
				if ($kira != 0)
					@$this->semak_sql_produk('kodLuasTanaman', $cari, $kp);
			}
			if($key=='12')
			{
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina12($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
				$kira = count($this->papar->kod_produk[$soalan]);
				//echo '<pre>line567:this->papar->kod_produk['.$soalan.']:'; print_r($kira); echo '</pre><hr>';
				if ($kira != 0)
					@$this->semak_sql_produk('kodXtxtTaniLain', $cari, $kp);
			}
			if($key=='13a')
			{# kod produk output
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina13($paparID['s' . $kp . '_q13a_2010'][0], 
						$paparID['s' . $kp . '_q13b_2010'][0],$kp);
				//echo '<pre>line577:this->papar->kod_produk['.$soalan.']:'; print_r($kira); echo '</pre><hr>';
				$kira = count($this->papar->kod_produk[$soalan]);
				if ($kira != 0)
					@$this->semak_sql_produk('kodOutput', $cari, $kp);
			}
			if($key=='13b')
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina13b($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
			if($key=='14')
			{#  kod produk input
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina14($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
				$kira = count($this->papar->kod_produk[$soalan]);
				//echo '<pre>line588:this->papar->kod_produk['.$soalan.']:'; print_r($kira); echo '</pre><hr>';
				if ($kira != 0)
					@$this->semak_sql_produk('kodInput', $cari, $kp);
			}
			if($key=='16')
				@$this->papar->kod_produk[$soalan] = 
					Borang101::bina16($paparID['s' . $kp . '_q' . $key . '_2010'][0], 
						$paparID['s' . $kp . '_q15_2010'][0], $kp);
		endforeach;
		//echo '<pre>line589:semak_aset_biologi:'; print_r($this->papar->kod_produk); echo '</pre><hr>';
	}

	private function semak_sql_produk($soalan, $cari, $kp)
	{
			if ($soalan == 'kodLuasTanaman') 
			{
				$myTable = 's101_q11_2010';
				$jA = 's101_q11_2010';
				$jB = '';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				$sql = Borang101::bina101Output11($mcpaB, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r(htmlentities($sql)); echo '</pre>';
				$this->papar->kod_produk['kodLuasTanaman'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}
			elseif ($soalan == 'kodXtxtTaniLain')
			{
				$myTable = 's101_q12_2010';
				$jA = 's101_q12_2010';
				$jB = '';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				$sql = Borang101::bina101Output12($mcpaB, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r($sql); echo '</pre>';
				$this->papar->kod_produk['kodXtxtTaniLain'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}
			elseif ($soalan == 'kodOutput') 
			{
				$myTable = 's101_q13_2010';
				$jA = 's101_q13a_2010';
				$jB = 's101_q13b_2010';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';
				$sql = Borang101::bina101Output13a($mcpaB, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r(htmlentities($sql)); echo '</pre>';
				$this->papar->kod_produk['kodOutput'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}
			elseif ($soalan == 'kodInput') 
			{
				$myTable = 's101_q14_2010';
				$jA = 's101_q14_2010';
				$jB = '';
				$mcpaA = 'kod2010_output';
				$mcpaB = 'mcpa2009_input';
				$mcpaC = 'mcpa2009_tr2014';				
				$sql = Borang101::binaKodInput101($mcpaC, $jA, $jB, $cari);
				//echo '<pre>$sql='; print_r($sql); echo '</pre>';
				$this->papar->kod_produk['kodInput'] =
					$this->tanya->cariProdukBaru($myTable, $sql);
			}//*/

	}

#- untuk binaan 206
	private function semak_produk_206($kp, $paparID)
	{
		# set data pekerja
		$cariL = 's' . $kp . '_q05a_2010';
		$cariP = 's' . $kp . '_q05b_2010';

		$asetBinaan = array(
			'staf2010'=>'pekerjaan',
			'staf2016'=>'staf2016',
			'11'=>'air-api-pelincir-bhn-pembakar', # luas tanaman
			'13'=>'ikut-daerah', # Nilai-Kerja-Pembinaan-Di
			'15'=>'ikut-jenis', # NILAI KERJA PEMBINAAN YANG TELAH DIBUAT MENGIKUT JENIS (Tidak termasuk CBP)
			'16'=>'kos_bahan-binaan', # Kos bahan langsung yang digunakan
			//'16salin'=>'kos_binaan-salin', # Kos bahan langsung yang digunakan
		); //echo '<pre>asetBinaan |'; print_r($asetBinaan); echo '</pre>';

		foreach ($asetBinaan as $key => $soalan):
			//echo "key:$key | soalan:$soalan<br>";
			if($key=='staf2010')
				@$this->papar->kod_produk[$soalan] = 
					(!isset($paparID[$cariL][0])) ? array():
					Borang206::dataPekerja($paparID[$cariL][0], 
					$paparID[$cariP][0], $kp);
			if($key=='staf2016')
			{
				@$this->papar->kod_produk[$soalan] = 
					(!isset($paparID[$cariL][0])) ? array():
					Borang206::dataPekerja2016($paparID[$cariL][0], 
					$paparID[$cariP][0], $kp);
			}
			if($key=='11')
				@$this->papar->kod_produk[$soalan] = 
					Borang206::soalan11($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
			if($key=='13')
				@$this->papar->kod_produk[$soalan] = 
					Borang206::soalan13($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
			if($key=='15') 
				@$this->papar->kod_produk[$soalan] = 
					Borang206::soalan15($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
			if($key=='16')
			{
				@$this->papar->kod_produk[$soalan] = 
					Borang206::soalan16($paparID['s' . $kp . '_q' . $key . '_2010'][0], $kp);
				@$this->papar->kod_produk['kos_binaan-salin'] = 
					Borang206::soal16salin($paparID['s' . $kp . '_q16_2010'][0], $kp);
			}
			//*/
		endforeach;
		//echo '<pre>semak:'; print_r($this->papar->kod_produk) . '</pre><hr>';
	}

	private function semak_staf($jadualStaf, $prosesID, $kp=null)
	{# khas untuk soalan staf
		$mula = 'q05a';
		foreach ($jadualStaf as $key => $myTable):
			if (isset($prosesID[$myTable][0])):
				$pos = strpos($myTable,$mula);
				if ($pos !== false) 
					//echo "<br>The string '$mula' was found in the string '$myTable' and exists at position $pos";
					$cariL = $prosesID[$myTable][0];	
				else //echo "<br>The string '$mula' was not found in the string '$myTable'";
					$cariP = $prosesID[$myTable][0];
			else:
				$cariL = $cariP = array();
			endif;
		endforeach;

		$q06 = ($kp!='205') ? 's' . $kp . '_q06_2010' : 'q06_2010';
		$cariSijil = (!isset($prosesID[$q06][0])) ? array() : $prosesID[$q06][0];

		//echo '$cariL = '.count($cariL).' | $cariP = '.count($cariP).' | $cariSijil  = '.count($cariSijil).' <br>';
		if(count($cariL) != '0' && count($cariP) != '0' && count($cariSijil) != '0'):
			$this->papar->kod_produk['staf2016'] = 
				Borang101::dataPekerja2016($cariL, $cariP, $kp, $cariSijil);
		endif;

		//echo '<pre>semak_staf:'; print_r($this->papar->kod_produk['pekerjaan']); echo '</pre><hr>';	
	}
	
	private function semak_staf2015($jadualStaf, $prosesID, $kp=null)
	{
		//echo '<pre>jadualStaf dalam fungsi semak_staf2015 ->'; print_r($jadualStaf) . '</pre>';

		$jenisPekerjaan = array(0  => 'Pemilik(ROB)-1',	1  => 'Pekerja keluarga(ROB)-2',
			2 => 'Pengurusan-3.1',	3  => 'Profesional-3.2.1',	4 => 'Penyelidik-3.2.2',
			5  => 'Juruteknik',	6  => 'Kerani-3.4',	7 => 'Servis & Jualan-3.5',
			8 => 'Kemahiran-3.6', 9 => 'Mesin & Operator-3.7', 10  => 'Pekerja Asas-3.8',
			11 => 'Jum Staf Bergaji-3.9',
			12 => 'Pekerja sambilan-4', 13 => 'Jumlah pekerja-5');
		
		//echo '<pre>jenisPekerjaan dalam fungsi semak_staf2015 ->'; print_r($jenisPekerjaan) . '</pre>';
		
		$this->papar->kod_produk['staf2015'] = 
			Data::dataPekerja2015($jadualStaf,$jenisPekerjaan, $prosesID);

	}

	private function cdt_pecah_soalan($Am,$A,$B,$C,$paparID)
	{
		if(isset($paparID[$A][0]) ):
			foreach( array('asas','struktur','msic','aset','staf','hasil','belanja','stok','tambahan') 
			as $key => $myTable)
			{// mula ulang tatasusunan
				$jadual = substr($myTable, 0, 14);
				$Jadual2 = 'cdt' . huruf('Besar', $jadual);
				$this->papar->kod_produk[$jadual] = (in_array($jadual,array('asas'))) ?
					Data::$Jadual2($paparID[$A][0],$paparID[$C][0])
					: Data::$Jadual2($paparID[$B][0]);
			}// tamat ulang tatasusunan
		endif;
	}
	
	private function icdt_pecah_soalan($paparID)
	{
		if(isset($paparID['data_icdt2012_asas'][0]) ):
			foreach($this->senarai_jadual('icdt') as $key => $myTable)
			{// mula ulang tatasusunan
				$jadual = substr($myTable, 14, 14);
				$Jadual2 = 'icdt' . huruf('Besar', $jadual);
				if(in_array($jadual,array('asas','struktur','aset','staf','hasil','belanja','stok','cawangan'))) 
					$this->papar->kod_produk[$jadual] = 
						Data::$Jadual2($paparID[$myTable][0]);
			}// tamat ulang tatasusunan
		endif;
	}

	private function tukarjadual($sv)
	{
		echo '<pre>'; $sv=800;
		// mula cari $cariID dalam $myJadual
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
#----------------------------------------------------------------------------------------------------------------------------#
}