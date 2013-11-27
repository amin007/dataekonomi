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