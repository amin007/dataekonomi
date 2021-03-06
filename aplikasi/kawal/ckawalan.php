<?php

class Ckawalan extends Kawal 
{
#****************************************************************************************
	public function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();

		$this->papar->js = array('bootstrap-datepicker.js',
			'bootstrap-datepicker.ms.js',
			'bootstrap-tooltip.js',
			'bootstrap-popover.js');
		$this->papar->css = array('bootstrap-datepicker.css',
			'bootstrap-editable.css');
		# pilih template
		// $this->_t = '_'; # template lama
		$this->_t = 'tahun_'; # template baru
		$this->papar->levelPegawai = Sesi::get('levelPegawai');
	}

	public function index() 
	{
		$this->papar->baca('ckawalan/' . $this->_t . 'index');
	}

	public function proses() 
	{
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		/*$_POST->Array
		(
			[sv] => 328
			[newss] => 000002666345
			[thnmula] => 2010
			[thntamat] => 2012
		)*/

		# bersihkan data $_POST
		$dataID = 'cprosesan/ubah/' . bersih($_POST['sv']) 
				. '/' . bersih($_POST['newss']);

		# paparkan ke fail 
		$lokasi = 'location: ' . URL . $dataID . '/2010/2012';
		//echo $lokasi;
		header($lokasi);

	}

	public function kp101()
	{	
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		/*$_POST->Array
		(
			[sv] => 328
			[newss] => 000002666345
			[thnmula] => 2010
			[thntamat] => 2012
		)
		*/
		# bersihkan data $_POST
		$dataID = 'cprosesan101/ubah/' . bersih($_POST['sv']) 
				. '/' . bersih($_POST['newss']);

		# paparkan ke fail 
		$lokasi = 'location: ' . URL . $dataID . '/2010/2012';
		//echo $lokasi;
		header($lokasi);

	}

	public function msic() # untuk cdt
	{
		//echo '<br>Anda berada di class Ckawalan::msic() extends Kawal <br>';
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		/* $_POST:Array [msic2000] => 50201 | [msic2008] => 45201  */

		$myTable  = 'data_cdt2009_b';
		$myTable2 = 'data_icdt2012_msic';
		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		# cari id berasaskan newss/ssm/sidap/nama/operator
		//$fe = isset($_POST['fe']) ? $_POST['fe'] : null;
		$id['msic2000'] = isset($_POST['msic2000']) ? $_POST['msic2000'] : null;
		$id['msic2008'] = isset($_POST['msic2008']) ? $_POST['msic2008'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($id['msic2000'])) 
		{
			# set pembolehubah mysql asas
			$jum = pencamSqlLimit($bilSemua = 500, $item = 500, $ms = 1);
			$kumpul = array('kumpul'=>'', 'susun'=>'');
			$susun[] = array_merge($jum, $kumpul );

			# cari data sql
			$msic2000 = $id['msic2000'];
			$cari[] = array('fix'=>'z1','atau'=>'WHERE','medan'=>'c.sidap','apa'=>'b.sidap','akhir'=>NULL);
			//$cari[] = array('fix'=>'z1','atau'=>'AND','medan'=>'b.newss','apa'=>'a.sidap','akhir'=>NULL);
			//$cari[] = array('fix'=>'z2','atau'=>'AND','medan'=>'a.batchawal','apa'=>"'$fe'",'akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'AND (','medan'=>'F5002','apa'=>"'$msic2000%'",'akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'OR',   'medan'=>'F6002','apa'=>"'$msic2000%'",'akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'OR',   'medan'=>'F7002','apa'=>"'$msic2000%'",'akhir'=>')');

			# dapatkan data mysql
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariSemuaData("$myTable c, alamat_newss_2013 b",
					'c.batch,c.sidap sidap,F5002,F6002,F7002,'
					. 'concat_ws(" ",b.nama,b.operator) as nama,'
					. 'concat_ws(" ",b.alamat1a,b.alamat2a,b.poskod,b.alamat3a) alamat'
					,$cari, $susun);

			# cari data sql
			$msic2008 = $id['msic2008'];
			$cari2[] = array('fix'=>'z1','atau'=>'WHERE','medan'=>'c.estab','apa'=>'b.newss','akhir'=>NULL);
			//$cari2[] = array('fix'=>'z1','atau'=>'AND','medan'=>'b.newss','apa'=>'a.newss','akhir'=>NULL);
			//$cari2[] = array('fix'=>'z2','atau'=>'AND','medan'=>'a.batchawal','apa'=>"'$fe'",'akhir'=>NULL);
			$cari2[] = array('fix'=>'z2','atau'=>'AND','medan'=>'c.msic2008','apa'=>"'$msic2008%'",'akhir'=>NULL);

			# dapatkan data mysql
				$this->papar->cariNama[$myTable2] = 
				$this->tanya->cariSemuaData("$myTable2  c, alamat_newss_2013 b",
					'c.estab newss,c.subsektor,c.msic2008,'
					. 'concat_ws(" ",b.nama,b.operator) as nama,'
					. 'concat_ws(" ",b.alamat1a,b.alamat2a,b.poskod,b.alamat3a) alamat'
					,$cari2, $susun);

			# papar carian
			$this->papar->carian='msic2008:' . $msic2008;
			$this->papar->apa = 'msic2000:' . $msic2000;
		}
		else
		{
			$this->papar->carian='[id:0]';
			$this->papar->apa = null; 
		}
		
		# papar array dalam cariNama
		#echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		#echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		//echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';
		
		# paparkan ke fail 
		$this->papar->baca('ckawalan/' . $this->_t . 'cari');
/*
SELECT c.estab,c.subsektor,c.msic2008,concat_ws(" ",nama,operator) as nama,
concat_ws(" ",alamat1a,alamat2a,poskod,alamat3a) alamat
FROM data_icdt2012_msic c, alamat_newss_2013 b
WHERE c.estab = b.newss
AND c.msic2008 like '45201%'

SELECT c.batch,c.sidap,F5002,F6002,F7002,concat_ws(" ",nama,operator) as nama,
concat_ws(" ",alamat1a,alamat2a,poskod,alamat3a) alamat FROM data_cdt2009_b c, alamat_newss_2013 b 
WHERE c.sidap like b.sidap 
AND ( F5002 like '50201%' OR F6002 like '50201%' OR F7002 like '50201%' )
//*/
	}

	public function msicbe2010() 
	{
		//echo '<br>Anda berada di class Ckawalan::msic() extends Kawal <br>';
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		/* $_POST:Array [msic2000] => 50201 | [msic2008] => 45201  */

		$myTable2  = array(
			/*'100',*/'101',/*'103','104','105','201','202','203',*/'205','206',
			'301',/*'302',*/'303',/*'304',*/'305','306','307','308','309',/*'310',*/
			'311','312',/*'313',*/'314',/*'315',*/'316',/*'317',*/'318',/*'319','320',
			322,323,324*/'325','328','331',/*332,333*/'334','335',
			/*391,392,*/'393','800',/*810,840,850*/'850','890'/*999*/);

		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		# cari id berasaskan newss/ssm/sidap/nama/operator
		$bandar = isset($_POST['bandar']) ? $_POST['bandar'] : null;
		$msic2008 = isset($_POST['msic2008']) ? $_POST['msic2008'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($msic2008))
		{
			# set pembolehubah mysql asas
			$jum = pencamSqlLimit($bilSemua = 500, $item = 500, $ms = 1);
			$kumpul = array('kumpul'=>'', 'susun'=>'');
			$susun[] = array_merge($jum, $kumpul );

			foreach  ($myTable2 as $key=>$jadual): 
				if (in_array($jadual, array('205'))):
					$paparJadual = 'q01_2010';
					$msicMedan = 'c.f0014,c.f0015';
					$msicCari = 'c.f0014';
				elseif (in_array($jadual, array('206'))):
					$paparJadual = 's206_q01_2010';
					$msicMedan = 'c.f0014,c.f0015';
					$msicCari = 'c.f0014';
				else:
					$paparJadual = 's' . $jadual . '_tbldatareview_2010';
					$msicMedan = 'c.KodIndustri `msic`';
					$msicCari = 'c.KodIndustri';
				endif;
				# cari data sql
				$cariSama = "\r ON c.estab = b.newss ";
				$cari2[0] = array('fix'=>'zlike','atau'=>'WHERE','medan'=>$msicCari,'apa'=>"'$msic2008%'",'akhir'=>NULL);
				if($bandar!=null)	
					$cari2[1] = array('fix'=>'zlike','atau'=>'AND','medan'=>'b.alamat3a','apa'=>"'$bandar%'",'akhir'=>NULL);

				$this->papar->cariNama[$jadual] = $this->tanya->
				//cariSql("$paparJadual c INNER JOIN alamat_newss_2013 b $cariSama",
				cariSemuaData("$paparJadual c INNER JOIN alamat_newss_2013 b $cariSama",
					'c.estab newss,sidap,'.$msicMedan.',concat_ws(" ",b.nama,b.operator) as nama,'
					. 'concat_ws(" ",b.alamat1a,b.alamat2a,b.poskod,b.alamat3a) alamat' . "\r"
					,$cari2, $susun);//*/
			endforeach;

			# papar cariam
			$this->papar->carian='msic2008:' . $msic2008; 
			$this->papar->apa = 'bandar:' . $bandar; 
		}
		else
		{
			$this->papar->carian='[id:0]'; 
			$this->papar->apa = null; 
		}

		# papar array dalam cariNama
		#echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		#echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		//echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';

		# paparkan ke fail 
		$this->papar->baca('ckawalan/' . $this->_t . 'cari');
	}

	function cari() 
	{
		#echo '<br>Anda berada di class Imej extends Kawal:cari()<br>';
		#echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		/* $_POST: [jenisID] => Newss, [id] => 2534814 */

		$myJadual = dpt_senarai('kawalan_tahunan');
		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		# cari id berasaskan newss/ssm/sidap/nama/operator
		$jenisID = isset($_POST['jenisID']) ? $_POST['jenisID'] : null;
		$id['nama'] = ($jenisID == 'Nama') ? $_POST['id'] : null;
		$id['ssm'] = ($jenisID == 'Sidap') ? $_POST['id'] : null;
		$id['newss'] = ($jenisID == 'Newss') ? $_POST['id'] : null;
		$id['operator'] = ($jenisID == 'Operator') ? $_POST['id'] : null;
		$id['datalama'] = ($jenisID == 'Datalama') ? $_POST['id'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($id['ssm'])) 
		{
			//echo 'Anda berada di ssm:' . $id['ssm'] . '<br>';
			$cari['medan'] = 'sidap'; # cari dalam medan apa
			$cari['id'] = $id['ssm']; # benda yang dicari
			$this->papar->carian = 'ssm'; 
			$this->papar->apa = $id['ssm']; 

			# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}# tamat ulang table

		}
		elseif (!empty($id['newss']))
		{
			//echo 'Anda berada di newss:' . $id['newss'] . '<br>';
			$cari['medan'] = 'newss'; # cari dalam medan apa
			$cari['id'] = $id['newss'];# benda yang dicari
			$this->papar->carian = 'newss'; 
			$this->papar->apa = $id['newss']; 

			# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				if ( in_array($key, array(6,7)) ):
					$this->papar->cariNama[$myTable] = 
					$this->tanya->cariKes($myTable, $cari);
				endif;
			}# tamat ulang table

		}
		elseif (!empty($id['nama']))
		{
			//echo 'Anda berada di nama:' . $id['nama'] . '<br>';
			$cari['medan'] = 'nama'; # cari dalam medan apa
			$cari['id'] = $id['nama'];# benda yang dicari
			$this->papar->carian = 'nama';
			$this->papar->apa = $id['nama']; 

			# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}# tamat ulang table

		}
		elseif (!empty($id['operator']))
		{
			//echo 'Anda berada di operator:' . $id['operator'] . '<br>';
			$cari['medan'] = 'operator'; # cari dalam medan apa
			$cari['id'] = $id['operator'];# benda yang dicari
			$this->papar->carian = 'operator'; 
			$this->papar->apa = $id['operator'];

			# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}# tamat ulang table

		}
		elseif (!empty($id['datalama']))
		{
			//echo 'Anda berada di :' . $id[''] . '<br>';
			$myJadual = dpt_senarai('datalama');
			$carian = $id['datalama'];
			$medan = '*, nodaftar as sidap';//'nodaftar as sidap, nama';
			$cari[] = array('fix'=>'zlike','atau'=>'WHERE','medan'=>'concat_ws("",nodaftar,nama)','apa'=>"'%$carian%'",'akhir'=>NULL);
			$this->papar->carian = 'datalama'; 
			$this->papar->apa = $id['datalama'];

			# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				$bilSemua = $this->tanya->//cariSql($myTable, $medan, $cari)
					cariRow($myTable, $medan, $cari);
				$jum = pencamSqlLimit($bilSemua, $item = 500, $ms = 1);
				$susun[] = array_merge($jum, array('kumpul'=>'', 'susun'=>''));
				$this->papar->cariNama[$myTable] = $this->tanya->
					cariSemuaData($myTable, $medan, $cari, $susun);
					//cariSql($myTable, $medan, $cari, $susun);
			}# tamat ulang table
			//*/
		}
		else
		{
			$this->papar->carian='[id:0]';
			$this->papar->apa = null;
		}

		# papar array dalam cariNama
		#echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		#echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		#echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';

		# paparkan ke fail
		$this->papar->baca('ckawalan/' . $this->_t . 'cari');

	}

	public function data2011()
	{
		$myTable2  = array(
			/*'100',*/'101',/*'103','104','105','201','202','203',*/'205','206',
			'301',/*'302',*/'303',/*'304',*/'305','306','307','308','309',/*'310',*/
			'311','312',/*'313',*/'314',/*'315',*/'316',/*'317',*/'318',/*'319','320',
			322,323,324*/'325','328','331',/*332,333*/'334','335',
			/*391,392,*/'393','800',/*810,840,850*/'850','890'/*999*/);

		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		# cari id berasaskan newss/ssm/sidap/nama/operator
		$hasil = isset($_POST['hasil']) ? $_POST['hasil'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($hasil)) 
		{
			# set pembolehubah mysql asas
			$jum = pencamSqlLimit($bilSemua = 500, $item = 500, $ms = 1);
			$kumpul = array('kumpul'=>'', 'susun'=>'');
			$susun[] = array_merge($jum, $kumpul);
			$query = null;

			foreach  ($myTable2 as $key=>$jadual): // s393_tbldatareview_2010
				# tentukan nilai $paparJadual & $paparMedan
				if (in_array($jadual, array('205'))): 
					$paparJadual = 'q08_2010';
					$paparMedan = 'F2099';
				elseif (in_array($jadual, array('206'))):
					$paparJadual = 's206_q08_2010';
					$paparMedan = 'F2099';
				else:
					$paparJadual = 's' . $jadual . '_tbldatareview_2010';
					$paparMedan = 'Revenue';
				endif;
				# tatasusunan carian
				$cari[0] = array('fix'=>'x<=','atau'=>'WHERE','medan'=>$paparMedan,'apa'=>$hasil,'akhir'=>NULL);
				$cantumSql[] = $this->tanya->cariCantumSql($paparJadual,' "'.$jadual.'" as kp, count(*) jum '
					,$cari, $susun); # cantum Sql
			endforeach;

			# cantum sql
			$this->papar->cariNama['hasil_bawah_' . $hasil] = 
				$this->tanya->cariSemuaSql(implode("UNION\r",$cantumSql));
			# papar carian
			$this->papar->carian = 'hasil bawah ' . $hasil; 
			$this->papar->apa = null; 
		}
		else
		{
			$this->papar->carian='[id:0]'; 
			$this->papar->apa = null; 
		}

		# papar array dalam cariNama
		//echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		//echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		//echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';

		# paparkan ke fail 
		$this->papar->baca('ckawalan/' . $this->_t . 'cari2');
	}

	function ubah($id) 
	{	//echo '<br>Anda berada di class Imej extends Kawal:ubah($id)<br>';

		$myJadual = dpt_senarai('kawalan_tahunan');
		$this->papar->kesID = array();

		# cari id berasaskan sidap
		$medan = '*'; # senarai nama medan
		$cari['id'] = isset($id) ? $id : null; # benda yang dicari

		if (!empty($cari['id'])) 
		{	# mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{# mula ulang table
				# cari dalam medan apa
				$cari['medan'] = in_array($myTable, 
					array('sse10_kawal','alamat_newss_2013')) ? 
					'newss':'sidap'; 

				//echo '$cari[medan]:' . $cari['medan']. '|'
				//   . '$cari[id]:' . $cari['id']. '<br>';

				$this->papar->kesID[$myTable] = 
					$this->tanya->cariSidap($myTable, $medan, $cari);

			}# tamat ulang table

			$this->papar->carian = $cari['medan'];
		}
		else
		{
			$this->papar->carian='[tiada id diisi]';
		}

		//echo '<hr><pre>$this->papar->kesID='; 
		//print_r($this->papar->kesID) . '</pre>';

		# paparkan ke fail 
		$this->papar->baca('ckawalan/ubah', 0);

	}
#****************************************************************************************
}