<?php

class Sesat extends Kawal 
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
	public function papar($cariTarikh = null, $cariID = null) 
    {    
		# setkan pembolehubah untuk $this->tanya
			//echo "\$cariTarikh = $cariTarikh . \$cariID = $cariID <br>";
			$item = 1000; $ms = 1;
            $medanRangka = $this->medanRangka;
			$medanData = $this->medanData;
			$medan = $medanRangka;
			$senaraiJadual = array('data_pelanggan');
		# cari $cariTarikh wujud tak
		if (!isset($cariTarikh) || empty($cariTarikh) ):
			$paparError = 'Tiada batch<br>';
		else:
			if((!isset($cariID) || empty($cariID) ))
				$paparError = 'Tiada id<br>';
			else
			{
				$paparMedan = 'nossm,nama,operator,'
					. 'concat_ws(" ",alamat1,alamat2,poskod,bandar,negeri) as alamat,'
					. 'concat_ws("|",tel,responden,nota) as nota';
				$cariNama[] = array('fix'=>'x=','atau'=>'WHERE','medan'=>'nossm','apa'=>$cariID);
				$dataKes = $this->tanya->cariSatuSahaja($senaraiJadual[0], $paparMedan, $cariNama);
				//echo '<pre>', print_r($dataKes, 1) . '</pre><br>';
				$paparError = 'Ada id:' . $dataKes['nossm'] 
							. '| ssm:' . $dataKes['nossm']
							. '<br> nama:' . $dataKes['nama'] 
							. '| operator:' . $dataKes['operator']
							. '<br> alamat:' . $dataKes['alamat']
							. '<br> nota:' . $dataKes['nota']; 
			}
		endif;
		
			# mula papar semua dalam $myTable
			$carian[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'nossm','apa'=>$cariID,'akhir'=>null);
			$carian[] = array('fix'=>'x=','atau'=>'AND','medan'=>'semak','apa'=>$cariTarikh,'akhir'=>null);
			foreach ($senaraiJadual as $key => $myTable)
			{# mula ulang table
				# dapatkan bilangan jumlah rekod
				//echo "\$myTable:$myTable | \$medan:$medan | \$cariTarikh:$cariTarikh<br>";
				$bilSemua = $this->tanya->kiraKes($myTable, $medan, $carian);
				# tentukan bilangan mukasurat. bilangan jumlah rekod
				//echo '$bilSemua:' . $bilSemua . ', $item:' . $item . ', $ms:' . $ms . '<br>';
				$jum = pencamSqlLimit($bilSemua, $item, $ms);
				$cantumSusun[] = array_merge($jum, array('kumpul'=>null,'susun'=>'nota') );
				$this->papar->bilSemua[$myTable] = $bilSemua;
				# sql guna limit //$this->papar->cariApa = array();
				$this->papar->cariApa[$myTable] = $this->tanya->
					cariSemuaData($myTable, $medan, $carian, $cantumSusun);
				# halaman
				$this->papar->halaman[$myTable] = halaman($jum);
			}# tamat ulang table
			
			# buat group ikut bandar
			$jadualGroup = $senaraiJadual[0];
			$carian3[] = array('fix'=>'like','atau'=>'WHERE','medan'=>'negeri','apa'=>'JOHOR');
			$susun3[] = array_merge($jum2, array('kumpul'=>'bandar','susun'=>'bandar') );
			# sql semula
			$this->papar->cariApa['kiraBandar'] = $this->tanya->
				cariSemuaData($jadualGroup, $medan = 'bandar,count(*) as kira', $carian3, $susun3);

        # semak pembolehubah $this->papar->cariApa
        //echo '<pre>', print_r($this->papar->cariApa, 1) . '</pre><br>';

        # Set pemboleubah utama
		## untuk menubar
		$this->papar->pegawai = senarai_kakitangan();

		## untuk dalam class Papar
		$this->papar->error = $paparError; //echo ' Error : ' . $paparError . '<br>';
		$this->papar->cariTarikh = $cariTarikh;
		$this->papar->cariID = $cariID;
		$this->papar->carian = 'semua';

        # pergi papar kandungan
        $this->papar->baca('sesat/jadual', 0);
    }

################################################################################################

}