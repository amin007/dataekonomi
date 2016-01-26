<?php

class Cari extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();		
	}
	
	public function index() 
	{	
		//echo '<br>public function index() class Cari extends Kawal ';
		$this->papar->medan = null;
		// Set pemboleubah utama
		//$this->papar->pegawai = senarai_kakitangan();
		$this->papar->url = dpt_url();

		// pergi papar kandungan
		$this->papar->baca('cari/index');
	}
	
	public function semua($borang, $bil=1, $mesej=null) 
	{	
		/* fungsi ini memaparkan borang
		 * untuk carian msic & produk sahaja
		  echo 'mana ko pergi daa ' . $borang . '<br>';
		 */
		
		$this->papar->medan = ($borang=='msic') ?
			$this->tanya->paparMedan('msic2000')
			: // jika $borang!='msic'
			$this->tanya->paparMedan('kodproduk_mei2011');
		//echo '<pre>$this->papar->medan:<br>'; print_r($this->papar->medan); 
		
		// Set pemboleubah utama
		//$this->papar->pegawai = senarai_kakitangan();
		$this->papar->url = dpt_url();
		$this->papar->mesej = $mesej;

		// pergi papar kandungan
		$this->papar->baca('cari/index');
	}

	public function lokaliti($negeri, $bil=1, $mesej=null) 
	{	
		/* fungsi ini memaparkan borang
		 * untuk carian lokaliti($negeri) sahaja
		   echo 'mana ko pergi daa lokaliti($negeri)<br>';
		 */
		
		$this->papar->medan = $this->tanya->paparMedan('pom_lokaliti.'.$negeri);
		//echo '<pre>$this->papar->medan:<br>'; print_r($this->papar->medan); 

		// Set pemboleubah utama
		$this->papar->url = dpt_url();
		$this->papar->mesej = $mesej;

		// pergi papar kandungan
		$this->papar->baca('cari/index');	
	}
	
	public function prosesan() 
	{	
		/* fungsi ini memaparkan borang
		 * untuk carian syarikat sahaja
		 */
		$this->papar->medan = $this->tanya->paparMedan('data_mm_prosesan');
		//echo '<pre>$this->papar->medan:<br>'; print_r($this->papar->medan); 
		$url = dpt_url();
		$this->papar->url = $url;
		
		// set latarbelakang
		//$this->papar->gambar=gambar_latarbelakang('../../');
		// Set pemboleubah utama
		//$this->papar->pegawai = senarai_kakitangan();
		
		// pergi papar kandungan
		$this->papar->baca('cari/index', 0);
	}

	public function data() 
	{	
		// Set pemboleubah utama
		//$this->papar->pegawai = senarai_kakitangan();

		// pergi papar kandungan
		$this->papar->baca('cari/index');
	}

	function pada($bil = 400, $muka = 1) 
	{
		/* fungsi ini memaparkan hasil carian
		 * untuk jadual msic2000 dan msic2008
		 */
		$had = '0, ' . $bil; # setkan $had untuk sql
		$kira = pecah_post($_POST); //echo '<pre>$kira->'; print_r($kira); echo '</pre>';
		# setkan pembolehubah dulu
		$namajadual = isset($_POST['namajadual']) ? $_POST['namajadual'] : null;
		$susun = isset($_POST['susun']) ? $_POST['susun'] : 1;
		$carian = isset($_POST['cari']) ? $_POST['cari'] : null;
		$pilih = isset($_POST['pilih'][1]) ? $_POST['pilih'][1] : null;
		$semak = isset($_POST['cari'][1]) ? $_POST['cari'][1] : null;
		$semak2 = isset($_POST['cari'][2]) ? $_POST['cari'][2] : null;
		$atau = isset($_POST['atau']) ? $_POST['atau'] : null;
		$this->papar->cariNama = null;
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		//echo '$bil=' . $bil. '<br>$muka=' . $muka. '<br>';
		//echo '$pilih=' . $pilih. '<br>$semak=' . $semak. '<br>';
		
		if (!isset($_POST['atau']) && isset($_POST['pilih'][2]))
		{
			$mesej = 'tak isi atau-dan pada carian';
			$lokasi = ($namajadual=='johor') ? 'lokaliti/' : 'semua/';
		}
		elseif ( (empty($semak) 
			|| ( empty($semak2) && $namajadual=='johor') ) 
			) 
		{
			$mesej = 'tak isi pada carian';
			$lokasi = ($namajadual=='johor') ? 'lokaliti/' : 'semua/';
		}
		elseif (!empty($namajadual) && $namajadual=='msic') 
		{
			$jadual = dpt_senarai('msicbaru');
			# mula cari $cariID dalam $jadual
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				# senarai nama medan
				$medan = ($myTable=='msic2008') ? 
					'seksyen S,bahagian B,kumpulan Kpl,kelas Kls,' .
					'msic2000,msic,keterangan,notakaki' 
					: '*'; 
				$this->papar->cariNama[$myTable] = $this->tanya
				->cariBanyakMedan($myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			$this->papar->carian=$carian;
			$mesej = null; $lokasi = null;
		}
		elseif (!empty($namajadual) && $namajadual=='produk') 
		{
			$jadual = dpt_senarai('produk');
			# mula cari $cariID dalam $jadual
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				# senarai nama medan
				$medan = ($myTable=='kodproduk_aup') ? 
					'bil,substring(kod_produk_lama,1,5) as msic,kod_produk_lama,' .
					'kod_produk,unit_kuantiti unit,keterangan,keterangan_bi,aup,min,max' 
					: '*'; 
				$this->papar->cariNama[$myTable] = $this->tanya
				->cariBanyakMedan($myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			# papar jadual kod unit
			$unit = 'kodproduk_unitkuantiti';
				$this->papar->cariNama[$unit] = $this->tanya
					->paparSemuaJadual($unit, '*');
			
			$this->papar->carian=$carian;
			$mesej = null; $lokasi = null;
		}
		elseif (!empty($namajadual) && $namajadual=='syarikat') 
		{
			$jadual = dpt_senarai('syarikat');
			# mula cari $cariID dalam $jadual
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				# senarai nama medan
				$medan = '*'; 
				$this->papar->cariNama[$myTable] = $this->tanya
				->cariBanyakMedan($myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			$this->papar->carian=$carian;
			$mesej = null; $lokasi = null;
		}
		elseif (!empty($namajadual) && $namajadual=='johor') 
		{
			/*`KOD NEGERI`, `NEGERI`,*/ 
				# senarai nama medan
				$medanAsal = '`KOD NGDBBP 2010`,`PEJABAT OPERASI`,' .
				"\r" . ' concat(`KOD DAERAH BANCI`,"-",`DAERAH BANCI`," | ",`NEGERI`) as DB,' .
				"\r" . ' concat(`KOD STRATA`,"-",`STRATA`) as STRATA,' .
				"\r" . ' concat(`KOD MUKIM`,"-",`MUKIM`) as MUKIM,' .
				"\r" . ' concat(`KOD BP`,"-",`DAERAH PENTADBIRAN`) as DAERAH,' .
				"\r" . ' concat(`KOD PBT`,"-",`PIHAK BERKUASA TEMPATAN`) as PBT,' .
				"\r" . ' concat(`KOD BDR`,"-",`NAMA BANDAR`) as BANDAR,' .
				"\r" . '`DESKRIPSI (LOKALITI STATISTIC KAWKECIL)`, `LOKALITI UNTUK INDEKS`'; 
				# senarai nama medan
				$medanBaru = '`KOD NGDBBP 2010`,' .
				//"\r" . ' concat("01",`no_db`, `no_bp_baru`) as `KodNGDBBP`,' .
				"\r" . ' `kod_strata` as STRATA, NEGERI,' .
				"\r" . ' concat(`KodMukim`,"-",`Mukim`) as MUKIM,' .
				"\r" . ' concat(`KodDP`,"-",`Daerah Pentadbiran`) as DAERAH,' .
				"\r" . ' concat(`KodPBT`,"-",`PBT`) as PBT,' .
				"\r" . ' `catatan`, `kawasan`,' .
				"\r" . ' `LOKALITI UNTUK INDEKS`'; 
				
			# mula cari $cariID dalam $jadual
			$jadual = dpt_senarai('johor');
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				$medan = ($myTable=='pom_lokaliti.johor') ? 
					$medanAsal : $medanBaru;
				$myJadual = ($myTable=='pom_lokaliti.johor') ? 
					'JOHOR':'LK-JOHOR';
				$this->papar->cariNama[$myJadual] = $this->tanya
					->cariBanyakMedan($myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			$this->papar->carian=$carian;
			$mesej = null; $lokasi = null;
		}
		elseif (!empty($namajadual) && $namajadual=='malaysia') 
		{
			/*`KOD NEGERI`, `NEGERI`,*/ 
			$jadual = dpt_senarai('malaysia');
			// mula cari $cariID dalam $jadual
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				# senarai nama medan
				$medan = '*'; 
				$this->papar->cariNama[$myTable] = $this->tanya
				//->cariSql('pom_lokaliti.'.$myTable, $medan, $kira, $had);
				->cariBanyakMedan('pom_lokaliti.'.$myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			$this->papar->carian=$carian;
			$mesej = null; $lokasi = null;
		}
		elseif (!empty($namajadual) && $namajadual=='data_mm_prosesan') 
		{
			$jadual = dpt_senarai('prosesan');
			# mula cari $cariID dalam $jadual
			foreach ($jadual as $key => $myTable)
			{# mula ulang table
				# senarai nama medan
				$medan = '*'; 
				#echo '$myTable:' . $myTable . '<br>';
				$this->papar->cariNama[$myTable] = $this->tanya
				->cariBanyakMedan($myTable, $medan, $kira, $had);
			}# tamat ulang table
			
			$this->papar->carian = $carian;
			$mesej = null; $lokasi = null;
		}
		
		# semak output
		/*echo '<pre>';
		echo '$this->papar->cariNama:'; print_r($this->papar->cariNama);
		//echo '$this->papar->carian : ' . $this->papar->carian . '<br>';
		//echo '$this->papar->apa : ' . $this->papar->apa . '<br>';
		echo '</pre>';
		//*/
		
		# paparkan ke fail cari/$namajadual.php
		if ($mesej != null ) 
		{
			$_SESSION['mesej'] = $mesej;
			
			//echo 'Patah balik ke ' . $lokasi . $mesej . '<hr>' . $data;
			header('location:' . URL . 'cari/' . $lokasi . $namajadual . '/2');
		}
		else 
		{
			//echo 'Tak patah balik';
			$this->papar->baca('cari/' . $namajadual, 0);	
		}
		//*/
	}

}