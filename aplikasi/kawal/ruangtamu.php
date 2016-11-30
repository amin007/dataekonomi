<?php

class Ruangtamu extends Kawal 
{

	function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalKeluar();	
		//$this->papar->js = array('ruangtamu/js/default.js');
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
	
	function xhrInsert()
	{
		$this->tanya->xhrInsert();
	}
	
	function xhrGetListings()
	{
		$this->tanya->xhrGetListings();
	}
	
	function xhrDeleteListing()
	{
		$this->tanya->xhrDeleteListing();
	}

}