<?php

class Ckawalan extends Kawal 
{
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
		// pilih template
		//private $pilih = 'lama'; 
		// $this->_t = '_'; # template lama
		$this->_t = 'tahun_'; # template baru
	}
	
	public function index() 
	{	
		$this->papar->baca('ckawalan/' . $this->_t . 'index');
	}

	public function proses() 
	{	
		//echo '<pre>$_POST->', print_r($_POST, 1) . '</pre>';
		/*
		$_POST->Array
		(
			[sv] => 328
			[newss] => 000002666345
			[thnmula] => 2010
			[thntamat] => 2012
		)
		*/		
		// bersihkan data $_POST
		$dataID = 'cprosesan/ubah/' . bersih($_POST['sv']) 
				. '/' . bersih($_POST['newss']);
		
		// paparkan ke fail 
		$lokasi = 'location: ' . URL . $dataID . '/2010/2012';
		//echo $lokasi;
		header($lokasi);
		
	}

	public function msic() 
	{
		//echo '<br>Anda berada di class Ckawalan::msic() extends Kawal <br>';
		//echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		/* $_POST:Array [] => 50201 | [msic2008] => 45201  */
		
		$myTable  = 'data_cdt2009_b';
		$myTable2 = 'data_icdt2012_msic';
		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		// cari id berasaskan newss/ssm/sidap/nama/operator
		$id['msic2000'] = isset($_POST['msic2000']) ? $_POST['msic2000'] : null;
		$id['msic2008'] = isset($_POST['msic2008']) ? $_POST['msic2008'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($id['msic2000'])) 
		{
			# set pembolehubah mysql asas
			$jum = pencamSqlLimit($bilSemua = 500, $item = 100, $ms = 1);
			$kumpul = array('kumpul'=>'', 'susun'=>'');
			$susun[] = array_merge($jum, $kumpul );
		
			# cari data sql
			$msic2000 = $id['msic2000'];			
			$cari[] = array('fix'=>'z2','atau'=>'WHERE','medan'=>'c.sidap','apa'=>'b.sidap','akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'AND (','medan'=>'F5002','apa'=>"'$msic2000%'",'akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'OR',   'medan'=>'F6002','apa'=>"'$msic2000%'",'akhir'=>NULL);
			$cari[] = array('fix'=>'z2','atau'=>'OR',   'medan'=>'F7002','apa'=>"'$msic2000%'",'akhir'=>')');

			# dapatkan data mysql
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariSemuaData("$myTable c, alamat_newss_2013 b ",
					'c.batch,c.sidap,F5002,F6002,F7002,'
					. 'concat_ws(" ",nama,operator) as nama,'
					. 'concat_ws(" ",alamat1a,alamat2a,poskod,alamat3a) alamat'
					,$cari, $susun);

			# cari data sql
			$msic2008 = $id['msic2008'];			
			$cari2[] = array('fix'=>'z2','atau'=>'WHERE','medan'=>'c.estab','apa'=>'b.newss','akhir'=>NULL);
			$cari2[] = array('fix'=>'z2','atau'=>'AND','medan'=>'c.msic2008','apa'=>"'$msic2008%'",'akhir'=>NULL);

			# dapatkan data mysql
				$this->papar->cariNama[$myTable2] = 
				$this->tanya->cariSemuaData("$myTable2  c, alamat_newss_2013 b ",
					'c.estab,c.subsektor,c.msic2008,'
					. 'concat_ws(" ",nama,operator) as nama,'
					. 'concat_ws(" ",alamat1a,alamat2a,poskod,alamat3a) alamat'
					,$cari2, $susun);

		}
		else
		{
			$this->papar->carian='[id:0]';// set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = null; // set pembolehubah untuk LIHAT => $this->apa
		}
		
		// papar array dalam cariNama
		#echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		#echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		//echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';
		
		// paparkan ke fail 
		$this->papar->baca('ckawalan/' . $this->_t . 'cari', 0);
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

	function cari() 
	{
		#echo '<br>Anda berada di class Imej extends Kawal:cari()<br>';
		#echo '<pre>$_POST:'; print_r($_POST) . '</pre>';
		/* $_POST: [jenisID] => Newss, [id] => 2534814 */
		
		$myJadual = dpt_senarai('kawalan_tahunan');
		//echo '<pre>$myJadual:' . print_r($myJadual) . '</pre>';
		$this->papar->cariNama = array();

		// cari id berasaskan newss/ssm/sidap/nama/operator
		$jenisID = isset($_POST['jenisID']) ? $_POST['jenisID'] : null;
		$id['nama'] = ($jenisID == 'Nama') ? $_POST['id'] : null;
		$id['ssm'] = ($jenisID == 'Sidap') ? $_POST['id'] : null;
		$id['newss'] = ($jenisID == 'Newss') ? $_POST['id'] : null;
		$id['operator'] = ($jenisID == 'Operator') ? $_POST['id'] : null;
		//echo '<pre>$id:' . print_r($id) . '</pre>';

		if (!empty($id['ssm'])) 
		{
			//echo 'Anda berada di ssm:' . $id['ssm'] . '<br>';
			$cari['medan'] = 'sidap'; // cari dalam medan apa
			$cari['id'] = $id['ssm']; // benda yang dicari
			$this->papar->carian = 'ssm'; // set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = $id['ssm']; // set pembolehubah untuk LIHAT => $this->apa
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}// tamat ulang table

		}
		elseif (!empty($id['newss']))
		{
			//echo 'Anda berada di newss:' . $id['newss'] . '<br>';
			$cari['medan'] = 'newss'; // cari dalam medan apa
			$cari['id'] = $id['newss'];// benda yang dicari
			$this->papar->carian = 'newss'; // set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = $id['newss']; // set pembolehubah untuk LIHAT => $this->apa
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				if ( in_array($key, array(6,7)) ):
					$this->papar->cariNama[$myTable] = 
					$this->tanya->cariKes($myTable, $cari);
				endif;
			}// tamat ulang table

		}
		elseif (!empty($id['nama']))
		{
			//echo 'Anda berada di nama:' . $id['nama'] . '<br>';
			$cari['medan'] = 'nama'; // cari dalam medan apa
			$cari['id'] = $id['nama'];// benda yang dicari
			$this->papar->carian = 'nama'; // set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = $id['nama']; // set pembolehubah untuk LIHAT => $this->apa
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}// tamat ulang table

		}
		elseif (!empty($id['operator']))
		{
			//echo 'Anda berada di operator:' . $id['operator'] . '<br>';
			$cari['medan'] = 'operator'; // cari dalam medan apa
			$cari['id'] = $id['operator'];// benda yang dicari
			$this->papar->carian = 'operator'; // set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = $id['operator']; // set pembolehubah untuk LIHAT => $this->apa
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariKes($myTable, $cari);
			}// tamat ulang table

		}
		else
		{
			$this->papar->carian='[id:0]';// set pembolehubah untuk LIHAT => $this->carian
			$this->papar->apa = null; // set pembolehubah untuk LIHAT => $this->apa
		}
		
		// papar array dalam cariNama
		#echo '<pre>$this->papar->carian:' . $this->papar->carian . '<br>';
		#echo '<pre>$this->papar->apa:' . $this->papar->apa . '<br>';
		#echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';
		
		// paparkan ke fail 
		$this->papar->baca('ckawalan/' . $this->_t . 'cari');
		
	}
	
	function ubah($id) 
	{	//echo '<br>Anda berada di class Imej extends Kawal:ubah($id)<br>';
		
		$myJadual = dpt_senarai('kawalan_tahunan');
		$this->papar->kesID = array();

		// cari id berasaskan sidap
		$medan = '*'; // senarai nama medan
		$cari['id'] = isset($id) ? $id : null; // benda yang dicari
		
		if (!empty($cari['id'])) 
		{	// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				// cari dalam medan apa
				$cari['medan'] = in_array($myTable, 
					array('sse10_kawal','alamat_newss_2013')) ? 
					'newss':'sidap'; 

				//echo '$cari[medan]:' . $cari['medan']. '|'
				//   . '$cari[id]:' . $cari['id']. '<br>';
				
				$this->papar->kesID[$myTable] = 
					$this->tanya->cariSidap($myTable, $medan, $cari);
				
			}// tamat ulang table
			
			$this->papar->carian = $cari['medan'];
		}
		else
		{
			$this->papar->carian='[tiada id diisi]';
		}
		
		//echo '<hr><pre>$this->papar->kesID='; 
		//print_r($this->papar->kesID) . '</pre>';
		
		// paparkan ke fail 
		$this->papar->baca('ckawalan/ubah', 0);
		
	}

}