<?php

class Sesat extends Kawal 
{
#*************************************************************************************
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
#*************************************************************************************
}