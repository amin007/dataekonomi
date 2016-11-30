<?php

class Ruangtamu extends Kawal 
{
#***************************************************************
	function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();
	}

	function index() 
	{
		$this->papar->baca('ruangtamu/index');
	}

	function logout()
	{
		Sesi::destroy();
		header('location: ' . URL);
		exit;
	}
#***************************************************************
}