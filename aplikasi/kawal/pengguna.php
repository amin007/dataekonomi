<?php

class Pengguna extends Kawal 
{

	public function __construct() 
	{
		parent::__construct();
        Kebenaran::kawalKeluar();
	}
	
	public function index() 
	{	
		$this->papar->senaraiPengguna = $this->tanya->senaraiPengguna();
		$this->papar->baca('pengguna/index');
	}
	
	public function tambahSimpan() 
	{
		$data = array();
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];
		$data['role'] = $_POST['role'];
		
		$semua = array('nama_pegawai');
		foreach ($_POST as $myTable => $value)
		{	
			if ( in_array($myTable,$semua) )
			{	//echo "myTable : $myTable <br>";
				foreach ($value as $kekunci => $papar)
					$data[$myTable][$kekunci] = bersih($papar);
			}
		}

		// @TODO: Do your error checking!		
		$this->tanya->tambahSimpan($data);
		header('location: ' . URL . 'pengguna');
	}
	
	public function ubah($id) 
	{
		$this->papar->user = $this->tanya->userSingleList($id);
		$this->papar->baca('pengguna/edit');
	}
	
	public function ubahSimpan($id)
	{
		$data = array();
		$data['id'] = $id;
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];
		$data['role'] = $_POST['role'];
		
		// @TODO: Do your error checking!
		
		$this->tanya->editSave($data);
		header('location: ' . URL . 'pengguna');
	}
	
	public function delete($id)
	{
		$this->tanya->delete($id);
		header('location: ' . URL . 'pengguna');
	}
}