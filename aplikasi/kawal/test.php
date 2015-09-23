<?php

class Test extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
	}
	
	function index() 
	{
		$this->papar->mesej = 'Halaman ini tidak wujud';
		$this->papar->baca('sesat/index');
	}

	function parameter() 
	{
		$this->papar->mesej = 'Class wujud tapi parameter/method/fungsi tidak wujud';
		$this->papar->baca('sesat/index');
	}
	
################################################################################################
## contoh carian papar tarikh dan nossm
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

################################################################################################
}