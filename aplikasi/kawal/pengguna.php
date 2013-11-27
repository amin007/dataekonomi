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
	
	public function create() 
	{
		$data = array();
		$data['login'] = $_POST['login'];
		$data['password'] = $_POST['password'];
		$data['role'] = $_POST['role'];
		
		// @TODO: Do your error checking!
		
		$this->tanya->create($data);
		header('location: ' . URL . 'pengguna');
	}
	
	public function edit($id) 
	{
		$this->papar->user = $this->tanya->userSingleList($id);
		$this->papar->baca('pengguna/edit');
	}
	
	public function editSave($id)
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