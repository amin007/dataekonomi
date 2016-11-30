<?php

class Login extends Kawal 
{
#****************************************************************************************
	function __construct() 
	{
		parent::__construct();
		Kebenaran::kawalMasuk();
	}
	
	function index() 
	{	
		$this->papar->gambar=gambar_latarbelakang(null);
		# Set pemboleubah utama
		#$this->papar->Tajuk_Muka_Surat='Enjin Carian Ekonomi - Sesat';
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/daftar');
	}

	function semakid()
	{
		$this->tanya->semakid();
	}

	function salah()
	{
		$this->papar->mesej 
			= 'Ada masalah pada user dan password';
		$this->papar->baca('index/salah');
	}
#****************************************************************************************
}