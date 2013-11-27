<?php

class Kawal 
{

	function __construct() 
	{
		//echo '<br>class Kawal';
		$this->papar = new Papar();
	}
	
	public function muatTanya($nama) 
	{
		
		$path = TANYA . $nama . '_tanya.php';
		//echo '<br>$path->' . $path . '<br>';
		//$tanyaNAMA = ucfirst($nama) . '_Tanya';
		//echo '<br>$tanyaNAMA->' . $tanyaNAMA . '<br>';
		
		if (file_exists($path)) 
		{
			$tanyaNama = ucfirst($nama) . '_Tanya';
			//echo '<br>$tanyaNama->' . $tanyaNama . '<br>';
			
			require_once $path;
			$this->tanya = new $tanyaNama();
			/*
			if (class_exists($tanyaNama)) echo '<br>class ' . $tanyaNama . ' wujud<br>';
			else echo '<br>class ' . $tanyaNama . ' tak wujud<br>';
			*/
		}
					
	}

}