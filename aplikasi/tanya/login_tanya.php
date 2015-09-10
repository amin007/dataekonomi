<?php

class Login_Tanya extends Tanya
{
	public function __construct()
	{
		parent::__construct();
	}

	function semakid()
	{
		//echo '<pre>$_POST->'; print_r($_POST);
		//echo 'Kod:' . Hash::rahsia('md5', $_POST['password']) . ': </pre><pre>';

		# set pembolehubah		
		$cariUser = bersih($_POST['username']);
		$cariPass = Hash::rahsia('md5', 
					bersih($_POST['password']) );
		$cariMedan = 'namaPegawai,Nama_Penuh,kataLaluan,level';
		try 
		{		
			$sql = 'SELECT ' . $cariMedan . ' FROM nama_pegawai'
				 . ' WHERE namaPegawai = "' . $cariUser . '" '
				 . ' AND kataLaluan = "' . $cariPass . '" ';
			//echo $sql . '<br>';
			$data = $this->db->selectAll($sql); 
			# $data adalah array untuk jadual $myTable
			//echo '<hr><pre>$data:'; print_r($data) . '</pre><hr>'; 
			# kira jumlah data
			$bil = $this->db->rowcount($sql); //echo ' | $bil=' . $bil;
		}
		catch (PDOException $e) 
		{
			echo $e->getMessage();
			echo '<br><a href="' . URL . 'ruangtamu/logout">Keluar</a>';
			exit;
		}
		
		if ($bil == 1) 
		{	//echo 'login berjaya';
			Sesi::init();
			// namaPegawai,Nama_Penuh,kataLaluan,level 
			Sesi::set('namaPegawai', $data[0]['namaPegawai']);
			Sesi::set('namaPenuh', $data[0]['Nama_Penuh']);
			Sesi::set('levelPegawai', $data[0]['level']);
			Sesi::set('loggedIn', true);
			header('location:' . URL . 'ruangtamu');
		} 
		else 
		{	//echo 'login gagal';
			Sesi::set('loggedIn', false);	
			header('location:' . URL . 'login/salah');
		}//*/			
	}

	public function semakid_lama()
	{
		//echo '<pre>$_POST->'; print_r($_POST) . '</pre>| ';
		//echo 'Kod:' . Hash::rahsia('md5', $_POST['password']);
		
		$sth = $this->db->prepare("
			SELECT namaPegawai,Nama_Penuh,kataLaluan,level 
			FROM nama_pegawai WHERE 
			namaPegawai = :username AND kataLaluan = :password");
		
		$sth->execute(array(
			':username' => $_POST['username'],
			':password' => Hash::rahsia('md5', $_POST['password'])
			//':password' => Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY)
		));
		
		//$sth->debugDumpParams();
		//echo ' | $sth=<pre>' . print_r($sth) . '</pre>';
		
		$data = $sth->fetch();
		$count =  $sth->rowCount();
		//echo ' | $count=' . $count;
		
		if ($count == 1) 
		{	//echo 'login berjaya';
			Sesi::init();
			// namaPegawai,kataLaluan,level 
			Sesi::set('nama', $data['namaPegawai']);
			Sesi::set('namaPenuh', $data['Nama_Penuh']);
			Sesi::set('levelPegawai', $data['level']);
			Sesi::set('loggedIn', true);
			header('location:' . URL . 'ruangtamu');
		} 
		else 
		{	//echo 'login gagal';
			Sesi::set('loggedIn', false);	
			header('location:' . URL . 'login/salah');
		}	
	}
}