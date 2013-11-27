<?php

class Cimej extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();		
	}
	
	public function index() 
	{	
		$this->papar->baca('cimej/index');
	}
	
	function cari() 
	{	//echo '<br>Anda berada di class Cimej extends Kawal:cari()<br>';
		//echo '<pre>'; print_r($_POST) . '</pre>';
		//$_POST[id] => Array	( [ssm] => 188561 atau [nama] => sharp manu)
		
		$myJadual = dpt_senarai('kawalan_tahunan');
		$this->papar->cariNama = array();

		// cari id berasaskan newss/ssm/sidap/nama
		$id['ssm'] = isset($_POST['id']['ssm']) ? $_POST['id']['ssm'] : null;
		$id['nama'] = isset($_POST['id']['nama']) ? $_POST['id']['nama'] : null;

		if (!empty($id['ssm'])) 
		{
			//echo "POST[id][ssm]:" . $_POST['id']['ssm'];
			$cariMedan = 'sidap'; // cari dalam medan apa
			$cariID = $id['ssm']; // benda yang dicari
			$this->papar->carian='ssm:' . $cariID;
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				// senarai nama medan
				$medan = ($myTable=='sse10_kawal') ? 
					'sidap,newss,nama' : 'sidap,nama'; 
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariMedan($myTable, $medan, $cariMedan, $cariID);
			}// tamat ulang table
		}
		elseif (!empty($id['nama']))
		{
			//echo "POST[id][nama]:" . $_POST['id']['nama'];
			$cariMedan = 'nama';   // cari dalam medan apa
			$cariID = $id['nama']; // benda yang dicari
			$this->papar->carian='nama:' . $cariID;
			
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				// senarai nama medan
				$medan = ($myTable=='sse10_kawal') ? 
					'sidap,newss,nama' : 'sidap,nama'; 
				$this->papar->cariNama[$myTable] = 
				$this->tanya->cariMedan($myTable, $medan, $cariMedan, $cariID);
			}// tamat ulang table

		}
		else
		{
			$this->papar->carian = null;
		}
		
		// semak data
		//echo '<pre>$this->papar->cariNama:'; print_r($this->papar->cariNama) . '</pre>';
		
		// paparkan ke fail cimej/cari.php
		$this->papar->baca('cimej/cari', 0);
		
	}
	
	function imej($cari = 'ssm', $cariID = null) 
	{
		//echo '<br>Anda berada di class CImej extends Kawal:imej($cari)<br>';
		//echo '<pre>$cari->' . print_r($cari, 1) . '</pre>';
		//echo '<pre>$id->' . print_r($cariID, 1) . '</pre>';
		
		$myJadual = dpt_senarai('kawalan_tahunan'); // dapatkan senarai jadual

		if (!empty($cariID)) 
		{
			// mula cari $cariID dalam $myJadual
			foreach ($myJadual as $key => $myTable)
			{// mula ulang table
				$cariMedan = in_array($myTable, 
					array('sse10_kawal','alamat_newss_2013')) ? 
					'newss' : 'sidap'; 
				$medan = in_array($myTable, 
					array('sse10_kawal','alamat_newss_2013')) ? 
					'sidap,newss,nama' : 'sidap,nama'; 
				$this->papar->kesID[$myTable] = 
				$this->tanya->cariSemuaMedan($myTable, $medan, $cariMedan, $cariID);
			}// tamat ulang table
			
			$this->papar->carian = $cariMedan;
		}
		else
		{
			$this->papar->carian='[tiada id diisi]';
		}

		// semak data
		//echo '<pre>$this->papar->kesID:'; print_r($this->papar->kesID) . '</pre>';
		
		// paparkan ke fail cimej/imej.php
		$this->papar->baca('cimej/imej', 0);
		
	}

}