<?php
/**
 * Kawalan keselamatan untuk masuk dan keluar sistem
		Kebenaran::kawalMasuk();
		Kebenaran::kawalKeluar();
 */
 
class Kebenaran
{
 
	public static function handleLogin()
	{
		@session_start();
		$logged = $_SESSION['loggedIn'];
		if ($logged == false)
		{
			session_destroy();
			header('location: ../login');
			exit;
		}
	}
	 
	/* Kebenaran::kawalMasuk() khas untuk
	 * class login dan index
	 * supaya kalau user berada dalam class tersebut
	 * sistem automatik masuk class ruangtamu
	 */
	public static function kawalMasuk()
	{
		@session_start();
	
		$kunci = Sesi::get('loggedIn');
		$level = Sesi::get('levelPegawai');
	
		//echo '<pre>$_SESSION->', print_r($_SESSION, 1);
		//echo '<br>$kunci = ' . $kunci . ' | $level = ' . $level . ' |</pre>';

		// semak level
		$senaraiLevel=array('kawal', 'fe', 'kup', 'pegawai');
		 
		if ($kunci == true && in_array($level,$senaraiLevel))
		{
			header('location:' . URL . 'ruangtamu');
			exit;
		}
		 
	}
	 
	public static function kawalKeluar()
	{
		@session_start();
			
		$kunci = Sesi::get('loggedIn');
		$level = Sesi::get('levelPegawai');
			
		//echo '<pre>$_SESSION->', print_r($_SESSION, 1);
		//echo '<br>$kunci = ' . $kunci . ' | $level = ' . $level . ' |</pre>';

		// semak level
		$senaraiLevel=array('kawal', 'fe', 'kup', 'pegawai');
	
		if ($kunci == false || !in_array($level,$senaraiLevel))
		{
			Sesi::destroy();
			header('location:' . URL);
			exit;
		}
	
	}

	public static function papar($_folder)
	{
		// pergi papar kandungan fungsi papar() dalam KAWAL
		$senaraiPengguna = array('fe','kup','pegawai');
		$senaraiPentadbir = array('kawal');
		if (in_array(Sesi::get('levelPegawai'), $senaraiPentadbir)) 
		{
			$paras = 'Paras Pentadbir:' . Sesi::get('levelPegawai');
			return $_folder . 'index';
			//echo $paras . '<br>$this->lihat->baca(' . $_folder . 'index)';

		}
		elseif (in_array(Sesi::get('levelPegawai'), $senaraiPengguna)) 
		{
			$paras = 'Paras Pengguna:' . Sesi::get('levelPegawai');
			return $_folder . 'papar';
			//echo $paras . '<br>$this->lihat->baca(' . $_folder . 'papar)';
		}
		else
		{
			$paras = null;
			return 'ruangtamu/index';
		}
		// pergi papar kandungan fungsi papar() dalam KAWAL
	}

	public static function tambahSimpan($_folder)
	{
		// pergi papar kandungan tambahSimpan() dalam KAWAL
		$senaraiPengguna = array('fe','kup','pegawai');
		$senaraiPentadbir = array('kawal');
		if (in_array(Sesi::get('levelPegawai'), $senaraiPentadbir)) 
		{
			$paras = 'Paras Pentadbir:' . Sesi::get('levelPegawai');
			header('location: ' . URL . $_folder . '');
			//echo $paras . '<br>location: ' . URL . $_folder . '';

		}
		elseif (in_array(Sesi::get('levelPegawai'), $senaraiPengguna)) 
		{
			$paras = 'Paras Pengguna:' . Sesi::get('levelPegawai');
			header('location: ' . URL . $_folder . 'papar');
			//echo $paras . '<br>location: ' . URL . $_folder . 'papar';
		}
		else
		{
			$paras = null;
			header('location: ' . URL);
		}
		// pergi papar kandungan tambahSimpan() dalam KAWAL
	}

	public static function ubahSimpan($_folder, $ID)
	{
		// pergi papar kandungan ubahSimpan($medanID, $cariID) dalam KAWAL
		$senaraiPengguna = array('fe','kup','pegawai');
		$senaraiPentadbir = array('kawal');
		if (in_array(Sesi::get('levelPegawai'), $senaraiPentadbir)) 
		{
			$paras = 'Paras Pentadbir:' . Sesi::get('levelPegawai');
			header('location: ' . URL . $_folder . $ID);
			//echo $paras . '<br>location: ' . URL . $_folder . $ID;

		}
		elseif (in_array(Sesi::get('levelPegawai'), $senaraiPengguna)) 
		{
			$paras = 'Paras Pengguna:' . Sesi::get('levelPegawai');
			header('location: ' . URL . $_folder . 'papar');
			//echo $paras . '<br>location: ' . URL . $_folder . 'papar';
		}
		else
		{
			$paras = null;
			header('location: ' . URL);
		}
		// pergi papar kandungan ubahSimpan($medanID, $cariID) dalam KAWAL
	}

}
