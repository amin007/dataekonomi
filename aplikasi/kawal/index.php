<?php

class Index extends Kawal 
{
#****************************************************************************************
	function __construct() 
	{
		//echo '<br>class Index extends Kawal';
		parent::__construct();
		Kebenaran::kawalMasuk();
	}

	function index() 
	{
		# Set pemboleubah utama
		$this->papar->Tajuk_Muka_Surat='Enjin Carian Ekonomi';
		# pergi papar kandungan
		$this->papar->baca('index/index');
	}

	function muar() 
	{
		# Set pemboleubah utama
		$this->papar->Tajuk_Muka_Surat='Enjin Carian Ekonomi';
		$this->papar->senaraiIP = dpt_ip(); # dapatkan senarai IP yang dibenarkan
		$this->papar->ip = $ip = $_SERVER['REMOTE_ADDR'];
		$this->papar->ip2 = substr($ip,0,10);
		$this->papar->hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$this->papar->server = $_SERVER['SERVER_NAME'];
		$this->papar->tajuk = 'Login Untuk POM';

		# pergi papar kandungan
		//$this->papar->baca('index/muar');
		$this->papar->baca('mobile/muar');
	}

	function kluang() 
	{
		# Set pemboleubah utama
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/daftar');
	}

	function jb()
	{
		# Set pemboleubah utama
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/daftar');
	}

	function putrajaya()
	{
		# Set pemboleubah utama
		//$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/daftar');
	}

	function login($user)
	{
		# Set pemboleubah utama
		$this->papar->nama=$user; # dapatkan nama pengguna
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/login');
	}

	function login_automatik($user)
	{
		# Set pemboleubah utama
		$this->papar->nama=$user; # dapatkan nama pengguna
		$this->papar->IP=dpt_ip(); # dapatkan senarai IP yang dibenarkan
		# pergi papar kandungan
		$this->papar->baca('index/login_automatik');
	}
#****************************************************************************************
}