<?php
function analisis($perangkaan, $ppt, $jadual, $key, $data)
{
	$asetPenuh = $ppt['AsetPenuh'];
	$asetBrgAm = $ppt['BrgAm'];
	$sv = $perangkaan['sv'];
	$hasil = $perangkaan['hasil'];
	$belanja = $perangkaan['belanja'];
	$aset = $perangkaan['aset'];
	$sewa = $perangkaan['asetsewa'];
	$noKey = substr($key, 0, 3);
	//echo "<hr>$key : $sewaHarta ";
	//echo "<hr>sv $sv | jadual $jadual ";
	
	if (in_array($key, array('thn','batch','Estab') ) )
	{
		$value = $data;
	}
	elseif ($sv=='101') 
	{//untuk survey 101 sahaja
		if ($jadual == 's'.$sv.'_q04_2010' && $noKey == 'F08') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == 's'.$sv.'_q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == 's'.$sv.'_q07_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 's'.$sv.'_q08_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		else $nilai = 'x';
		
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	elseif ($sv=='205') 
	{//untuk survey 205 sahaja
		if ($jadual == 'q04_2010' && $noKey == 'F09') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == 'q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == 'q08_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 'q09_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		else $nilai = 'x';
		
		$name = 'name="' . $sv . '_' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	elseif ($sv=='206') 
	{//untuk survey 205 sahaja
		if ($jadual == $sv.'_q04_2010' && $noKey == 'F09') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == $sv.'_q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == $sv.'_q08_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == $sv.'_q09_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		else $nilai = 'x';
		
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	elseif (in_array($sv,$asetPenuh)) 
	{
		$abaikan = array('s'.$sv.'_q02_2010','s'.$sv.'_q03_2010');
		if ($jadual == 's'.$sv.'_q04_2010' && $noKey == 'F09') 
			$nilai = ($sewa==0) ? 0 : (($data / $sewa) * 100);
		elseif ($jadual == 's'.$sv.'_q04_2010' && $noKey != 'F09') 
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100);
		elseif ($jadual == 's'.$sv.'_q08_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 's'.$sv.'_q09_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		elseif(in_array($jadual,$abaikan))
			$nilai = 'x';
			
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	elseif (in_array($sv,$asetBrgAm)) 
	{
		if ($jadual == 's'.$sv.'_q02_2010')
			$nilai = ($hasil==0) ? 0 : (($data / $hasil) * 100 );
		elseif ($jadual == 's'.$sv.'_q03_2010')
			$nilai = ($belanja==0) ? 0 : (($data / $belanja) * 100 );
		elseif ($jadual == 's'.$sv.'_q04_2010')
			$nilai = ($aset==0) ? 0 : (($data / $aset) * 100 );
		else $nilai = 'x';
			
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
	}
	# istihar pembolehubah 
	//$value = number_format($nilai,4,'.',',') . '%';
	$value = ($nilai == 'x' or $nilai == '0') ? '' : number_format($nilai,4,'.',',') . '%';
	$input = '<input type="text" ' . $name . ' value="' 
		   . $data . '" class="input-large">' . $value;
	return '<td>' . $input . '</td>' . "\r";
}
