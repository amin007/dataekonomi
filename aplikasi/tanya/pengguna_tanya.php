<?php

class Pengguna_Tanya extends Tanya
{
	public function __construct()
	{
		parent::__construct();
		$this->_myTable = 'nama_pegawai';
	}

	public function senaraiPengguna()
	{
		/*	nama medan dalam $this->_myTable = nama_pegawai
			[no] => 1
            [namaPegawai] => admin
            [kataLaluan] => ****
            [level] => admin
            [No_Staf] => 
            [Nama_Penuh] => Admin
            [email] => 
            [nohp] => 
            [Jawatan] => 
            [Kod] => 
            [Unit] => 
            [Tetap] => 0
            [CatatNota] => 
			$medan = array('namaPegawai','kataLaluan','level',
			'No_Staf','Nama_Penuh','email','nohp',
			'Jawatan','Kod','Unit','Tetap','CatatNota');
		*/
		return $this->db->selectAll('SELECT no,namaPegawai,Nama_Penuh,level FROM ' . $this->_myTable);
	}
	
	public function userSingleList($id)
	{
		return $this->db->select('SELECT no, login, role FROM users WHERE id = :id', array(':id' => $id));
	}
	
	public function create($data)
	{
		$myTable = 'users';
		$postNewData = array(
			'login' => $data['login'],
			'password' => Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY),
			'role' => $data['role']
		);
		$this->db->insert($myTable, $postNewData);
	}
	
	public function editSave($data)
	{
		$myTable = 'users';
		$postData = array(
			'login' => $data['login'],
			'password' => Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY),
			'role' => $data['role']
		);
		$where = "`id` = {$data['id']}";
		
		$this->db->update($myTable, $postData, $where);
	}
	
	public function delete($id)
	{
		$myTable = 'users';
		$result = $this->db->select('SELECT role FROM ' . $myTable . 
		' WHERE id = :id', array(':id' => $id));

		if ($result[0]['role'] == 'owner')
			return false;
		
		$this->db->delete($myTable, "id = '$id'");
	}
}