<?php

class Cprosesan extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();
		// lokasi fail PAPAR untuk survey
		$this->papar->dataAm = 'cprosesan/'; 
		$this->papar->kelas = 'cprosesan/'; 
		$this->_pptAsetPenuh = array(101,301,302,303,305,306,307,308,309,312,314,316,318,325,331);
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

	// ubah & cetak
	function ubah($sv=null, $id = null, $mula = null, $akhir = null, $cetak = null)
	{	//echo '<br>Anda berada di class Cprosesan extends Kawal:ubah($cari,$mula,$akhir,$cetak)<br>';
		
		// setkan semua pembolehubah
		$medan = '*'; // senarai nama medan
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
			
		}
		else
		{
			$this->papar->carian='[id:0]';
		}
			/*echo '<pre>';
			//echo '<hr>$this->papar->keterangan='; print_r($this->papar->keterangan);
			echo '<hr>$this->papar->kesID='; print_r($this->papar->kesID);
			echo '<hr>$this->papar->kod_produk='; print_r($this->papar->kod_produk); // khas untuk survey 205
			//echo '<hr>$this->papar->paparID=' . $this->papar->paparID;
			echo '<hr>$this->papar->carian: ' . $this->papar->carian . '<br>';
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
		// bersihkan data $_POST
		$dataID = 'ubah/' . bersih($sv) . '/' . bersih($_POST['cari']);
		
		// paparkan ke fail 
		$lokasi = 'location: ' . URL . $this->papar->dataAm . $dataID . '/2010/2012';
		header($lokasi);

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
		elseif (in_array($sv,$this->_ppt2015))
		{	// prosesan 2010
			$jadual = array('q01','q02','q03','q04','q05a','q05b','q06',
			'q07','q08','q09','q10','q11','qsa','qsb','qsc','qsd','qse','qsf',
			/*,'tblDataReviewTemp2'*/
			'tblDataReview','tblDataReviewTemp','tblDataReviewTemp3');
			foreach ($jadual as $key => $data):
				$myJadual[] = 's' . $sv . '_' . $data . '_2010';
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
	
	private function semak_produk($cari) // khas untuk survey 205
	{
		$medan = '*';
		// mula cari $cariID dalam $kod_produk
		foreach ($this->kod_produk() as $key => $myTable)
		{// mula ulang table
			if ($myTable=='q14_2010')
			{
				$sql = Borang::binaKodOutput('kod2010_output', $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukBaru($myTable, $sql);
				/* ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodOutput'] = Data::kodOutput($info);
				$baris = $this->papar->kod_produk['kodOutput'];*/
			}
			elseif ($myTable=='q15_2010')
			{
				$sql = Borang::binaKodInput('kod2010_input', $myTable, $cari);
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukBaru($myTable, $sql);
				/* ubahsuai tatasusunan $info
				$info = $this->tanya->cariProdukLama($myTable, $medan, $cari);
				$this->papar->kod_produk['kodInput'] = Data::kodInput($info);
				$baris = $this->papar->kod_produk['kodInput'];*/			
				//echo '<pre>($baris Input)='; print_r($baris) . '</pre><hr>';				
				
				
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
				$this->tanya->cariProdukLama($myTable, $medan, $cari);
			}
			else
			{
				$this->papar->kod_produk[$myTable] = 
				$this->tanya->cariProdukLama($myTable, $medan, $cari);
			}
			
		}// tamat ulang table
		
		//echo '<pre>$this->papar->kod_produk='; print_r($this->papar->kod_produk) . '<pre>';
	}
	
	private function cari_keterangan_medan($sv, $kesID)
	{
		$senarai = Borang::cariKeterangan($kesID);
		
		// cari keterangan medan yang lain				
		foreach ($senarai as $myTable => $papar)
		{// mula ulang table
			foreach ($papar as $namaMedan => $data)
			{// mula ulang table
				//echo '$namaMedan['.$data.']['.$myTable.']:'.$namaMedan.'<br>';
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
			$jenisPekerjaan = array(0=>'Pemilik(ROB)-1',1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',3=>'Juruteknik-3.2',4=>'Kerani-3.3',5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',11=>'Jumlah pekerja-5');

		$this->papar->kod_produk['pekerjaan'] = 
			Data::dataPekerja($jadualStaf,$jenisPekerjaan,$prosesID);
			
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