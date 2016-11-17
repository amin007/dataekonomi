<?php

class Borang206
{
######################################################################################################################
##--------------------------------------------------------------------------------------------------------------------
	public static function tatasusunanPekerjaLama()
	{
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 30=>'Purata Staf', 18=>'Gaji');
		$lelaki = array(1=>'Pemilik(ROB)-1',2=>'Pekerja keluarga(ROB)-2',
			3=>'Pengurusan-3.1',4=>'Juruteknik-3.2',
			5=>'Kerani-3.3',6=>'Pekerja Asas-3.4',
			7=>'Mahir-3.5.1',8=>'XMahir-3.5.1',9=>'Buruh Mahir-3.6.1',10=>'Buruh Mahir-3.6.1',
			11=>'Pekerja sambilan-4',19=>'Jumlah pekerja-5');
		$keyLelaki = array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,8=>9,9=>10,10=>11,11=>19);
		$wanita = array(21=>'Pemilik(ROB)-1',22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',26=>'Pekerja Asas-3.4',
			27=>'Mahir-3.5.1',28=>'XMahir-3.5.1',29=>'Buruh Mahir-3.6.1',30=>'Buruh Mahir-3.6.1',
			31=>'Pekerja sambilan-4',39=>'Jumlah pekerja-5');
		$keyWanita = array(0=>21,1=>22,2=>23,3=>24,4=>25,5=>26,6=>27,7=>28,	8=>29,9=>30,10=>31,11=>39);
		$jenisKerja = array(0=>'Pemilik(ROB)-1',1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',3=>'Juruteknik-3.2',4=>'Kerani-3.3',5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',11=>'Jumlah pekerja-5');

	/*
	$lelaki:Array						|$wanita:Array
	(
		[1] => Pemilik(ROB)-1			[21] => Pemilik(ROB)-1
		[2] => Pekerja keluarga(ROB)-2	[22] => Pekerja keluarga(ROB)-2
		[3] => Pengurusan-3.1			[23] => Pengurusan-3.1
		[4] => Juruteknik-3.2			[24] => Juruteknik-3.2
		[5] => Kerani-3.3				[25] => Kerani-3.3
		[6] => Pekerja Asas-3.4			[26] => Pekerja Asas-3.4
		[7] => -3.5						[27] => -3.5
		[8] => -3.6						[28] => -3.6
		[11] => Pekerja sambilan-4		[31] => Pekerja sambilan-4
		[19] => Jumlah pekerja-5		[39] => Jumlah pekerja-5
	)

	*/		
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function dataPekerja($cariL, $cariW, $kp)
	{
		//echo '<pre>cariL ->'; print_r($cariL); echo '</pre>';
		//echo '<pre>cariW ->'; print_r($cariW); echo '</pre>';
		//echo '<pre>jenisKerja ->'; print_r($jenisKerja); echo '</pre>';
		# setkan tatasusunan 
		list($bangsaStaf, $jenisKerja, $lelaki,$keyLelaki, 
		$wanita, $keyWanita) = Borang206::tatasusunanPekerja();
		$pilihBangsa = array (/*'Melayu','Cina',*/'Gaji');
		$kira=0;
		
		# bina tatasusunan
		foreach ($jenisKerja as $kerja => $kategori):
			$pekerja[$kira]['nama'] = $kategori;
			$data = null; $data2 = null;
			foreach ($bangsaStaf as $keyL => $bangsa):
			# set pembolehubah asas lelaki
				list($kunci,$lajur,$data) = 
					Borang206::cariLajurData($kerja,$keyL,$keyLelaki,$lelaki,$cariL,'_');
			# mula masuk data				
				$pekerja[$kira]['L'] = $kunci;
				$pekerja[$kira][(in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa|L$lajur": "L$lajur"] =
					 !empty($data) ? $data : '-';
			endforeach;
			foreach ($bangsaStaf as $keyW => $bangsa):
			# set pembolehubah asas wanita	
				list($kunci2,$lajur2,$data2) = 
					Borang206::cariLajurData($kerja,$keyW,$keyWanita,$wanita,$cariW,'_');
			# mula masuk data
				$pekerja[$kira]['W'] = $kunci2;
				$pekerja[$kira][(in_array($bangsa,$pilihBangsa) ) ?
					"$bangsa|W$lajur2": "W$lajur2"] =
					 !empty($data2) ? $data2 : '-';
			endforeach;
			//echo '<hr>';
			$kira++;
		endforeach;

		//echo '<pre>pekerja ->'; print_r($pekerja); echo '</pre>';
		return $pekerja; # pulangkan nilai
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function cariLajurData($kerja,$keyJ,$keyJantina,$jantina,$cari,$ruang='_')
	{
		# set pembolehubah asas lelaki
		$kunci = pilihKeyData($kerja,$keyJantina,$jantina);
		$lajur = kira3($keyJ, 2); 
		$baris = kira3($kunci, 2); 
		$medan  = 'F' . $lajur . $baris;
		$data = isset($cari[$medan]) ?	$cari[$medan] : $ruang;

		# debug
		/* contoh panggil fungsi untuk tatasusunan
				list($kunci,$lajur,$data) = 
					Borang206::cariLajurData($kerja,$keyL,$keyLelaki,$lelaki,$cariL);
				list($kunci2,$lajur2,$data2) = 
					Borang206::cariLajurData($kerja,$keyW,$keyWanita,$wanita,$cariW);
		*/

		return array($kunci,$lajur,$data); # pulangkan nilai
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function kiraDataStaf($lajur,$data,$Warga,$Pati,$jumStaf,$Gaji)
	{
			if(in_array($lajur, array('01','02','03','04','05','06','07','08','09') )):
				$Warga += $data; 
			elseif(in_array($lajur, array('10','11','12','13') )):
				$Pati += $data; 
			elseif(in_array($lajur, array('14') )):
				$jumStaf = !empty($data) ? $data : '-';
			elseif(in_array($lajur,array('18'))):
				$Gaji = !empty($data) ? $data : '-';
			endif;

		// $pekerja[$kira]['Bumi'] => array('01','02','03','04','05','06')
		// $pekerja[$kira]['XBumi'] => array('07','08','09') 

		# debug
		/* contoh panggil fungsi untuk tatasusunan
				list($WargaL,$PatiL,$jumStafL,$GajiL) = 
					Borang206::kiraDataStaf($lajur,$data,$WargaL,$PatiL,$jumStafL,$GajiL)
				list($WargaW,$PatiW,$jumStafW,$GajiW) = 
					Borang206::kiraDataStaf($lajur2,$data2,$WargaW,$PatiW,$jumStafW,$GajiW);
		*/

		return array($Warga,$Pati,$jumStaf,$Gaji); # pulangkan nilai
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function tatasusunanPekerja()
	{
		$bangsaStaf = array(1=>'Melayu', 2=>'Iban',
			3=>'Bidayuh', 4=>'Bajau',
			5=>'Kadazan', 6=>'Bumiputra Lain',
			7=>'Cina', 8=>'India', 9=>'WM Lain2',
			10=>'Indonesia', 11=>'Filipina',
			12=>'Bangladesh', 13=>'BWM Lain2',
			14=>'Jumlah', 30=>'Purata Staf', 18=>'Gaji');
		$lelaki = array(1=>'Pemilik(ROB)-1',2=>'Pekerja keluarga(ROB)-2',
			3=>'Pengurusan-3.1',4=>'Juruteknik-3.2',
			5=>'Kerani-3.3',6=>'Pekerja Asas-3.4',
			7=>'Mahir-3.5.1',8=>'XMahir-3.5.1',9=>'Buruh Mahir-3.6.1',10=>'Buruh Mahir-3.6.1',
			11=>'Pekerja sambilan-4',19=>'Jumlah pekerja-5');
		$keyLelaki = array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,8=>9,9=>10,10=>11,11=>19);
		$wanita = array(21=>'Pemilik(ROB)-1',22=>'Pekerja keluarga(ROB)-2',
			23=>'Pengurusan-3.1',24=>'Juruteknik-3.2',
			25=>'Kerani-3.3',26=>'Pekerja Asas-3.4',
			27=>'Mahir-3.5.1',28=>'XMahir-3.5.1',29=>'Buruh Mahir-3.6.1',30=>'Buruh Mahir-3.6.1',
			31=>'Pekerja sambilan-4',39=>'Jumlah pekerja-5');
		$keyWanita = array(0=>21,1=>22,2=>23,3=>24,4=>25,5=>26,6=>27,7=>28,	8=>29,9=>30,10=>31,11=>39);
		$jenisKerja = array(0=>'Pemilik(ROB)-1',1=>'Pekerja keluarga(ROB)-2',
			2=>'Pengurusan-3.1',3=>'Juruteknik-3.2',4=>'Kerani-3.3',5=>'Pekerja Asas-3.4',
			6=>'Pekerja Mahir-3.5.1',7=>'Pekerja XMahir-3.5.2',
			8=>'Upah Mahir-3.5.1',9=>'Upah XMahir-3.5.2',
			10=>'Pekerja sambilan-4',11=>'Jumlah pekerja-5');

	/*	$lelaki:Array					|$wanita:Array
	(
		[1]  => Pemilik(ROB)-1			[21] => Pemilik(ROB)-1
		[2]  => Pekerja keluarga(ROB)-2	[22] => Pekerja keluarga(ROB)-2
		[12] => Pengurusan-3.1			[32] => Pengurusan-3.1
		[3]  => Profesional-3.2.1		[23] => Profesional-3.2.1
		[13] => Penyelidik-3.2.2		[33] => Penyelidik-3.2.2
		[4]  => Juruteknik				[24] => Juruteknik
		[5]  => Kerani-3.4				[25] => Kerani-3.4
		[15] => Servis & Jualan-3.5		[35] => Servis & Jualan-3.5
		[07] => Kemahiran-3.6			[27] => Kemahiran-3.6
		[18] => XKemahiran-3.6			[38] => XKemahiran-3.6
		[16] => Mesin & Operator-3.7	[36] => Mesin & Operator-3.7
		[6]  => Pekerja Asas-3.8		[26] => Pekerja Asas-3.8
		[7]  => -3.5					[27] => -3.5
		[8]  => -3.6					[28] => -3.6
		[17] => Jum Staf Bergaji-3.9	[37] => Jum Staf Bergaji-3.9
		[11] => Pekerja sambilan-4		[31] => Pekerja sambilan-4
		[19] => Jumlah pekerja-5		[39] => Jumlah pekerja-5
	)
		01-09 - Msia (in_array($lajur, array('01','02','03','04','05','06','07','08','09') ))
		10-13 - Pati (in_array($lajur, array('10','11','12','13') ))
		14 - Jumlah
		30 - Purata

		list($bangsaStaf, $jenisKerja, 
		$lelaki,$keyLelaki, 
		$wanita, $keyWanita) = Borang206::tatasusunanPekerja();
	*/

		# pulangkan nilai
		return array($bangsaStaf, $jenisKerja,
		$lelaki,$keyLelaki, $wanita, $keyWanita);
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function dataPekerja2016($cariL, $cariW, $kp)
	{
		# setkan tatasusunan 
		list($bangsaStaf, $jenisKerja, $lelaki,$keyLelaki, 
		$wanita, $keyWanita) = Borang206::tatasusunanPekerja();

		$kira = 0; //echo '<pre>$jenisKerja ->'; print_r($jenisKerja); echo '</pre>';
		
		# bina tatasusunan
		foreach ($jenisKerja as $kerja => $kategori):
			$data = null; $data2 = null;
			# set pembolehubah asas lelaki
			$wargaL = $patiL = $jumStafL = $gajiL = 0;
			foreach ($bangsaStaf as $keyL => $bangsa):
				list($kunci,$lajur,$data) = 
					Borang206::cariLajurData($kerja,$keyL,$keyLelaki,$lelaki,$cariL,'&nbsp;');
				list($wargaL,$patiL,$jumStafL,$gajiL) = # tambah jika data wujud 
					Borang206::kiraDataStaf($lajur,$data,$wargaL,$patiL,$jumStafL,$gajiL);
			endforeach;
			# set pembolehubah asas wanita
			$wargaW = $patiW = $jumStafW = $gajiW = 0;
			foreach ($bangsaStaf as $keyW => $bangsa):
				list($kunci2,$lajur2,$data2) = 
					Borang206::cariLajurData($kerja,$keyW,$keyWanita,$wanita,$cariW,'&nbsp;');
				list($wargaW,$patiW,$jumStafW,$gajiW) = # tambah jika data wujud 
					Borang206::kiraDataStaf($lajur2,$data2,$wargaW,$patiW,$jumStafW,$gajiW);			
			endforeach;
			# ubahsuai data Lelaki
				$pekerja[$kira]['nama'] = $kategori;
				$pekerja[$kira]['L'] = $kunci;
				$pekerja[$kira]['WargaL'] = ($wargaL==0) ? '' : $wargaL;
				$pekerja[$kira]['PatiL'] = ($patiL==0) ? '' : $patiL;
				$pekerja[$kira]['Jum|L14'] = $jumStafL;
				$pekerja[$kira]['Gaji|L18']  = $gajiL;
			# ubahsuai data Perempuan
				$pekerja[$kira]['W'] = $kunci2;
				$pekerja[$kira]['WargaW'] = ($wargaW==0) ? '' : $wargaW;
				$pekerja[$kira]['PatiW'] = ($patiW==0) ? '' : $patiW;
				$pekerja[$kira]['Jum|P14'] = $jumStafW;
				$pekerja[$kira]['Gaji|P18'] = $gajiW;
			$kira++; # tambah 
		endforeach; //*/

		//echo '<pre>$jadualStaf ->'; print_r($jadualStaf); echo '</pre>';
		//echo '<pre>pekerja dalam fungsi dataPekerja2015 ->'; print_r($pekerja); echo '</pre>';
		return $pekerja; # pulangkan nilai
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function soalan11($asal, $kp)
	{
		# jenis harta
		$jenisHarta = array(
			41=>'Air yang dibeli', # -Meter padu
			51=>'Air yang diabstrak',
			42=>'Pelincir',
			## 'X1'=>'Bahan Pembakar',
			43=>'Minyak diesel', # -Liter
			44=>'Petrol', # -Liter
			45=>'Minyak relau / Minyak pembakar', # Liter',
			46=>'Gas petroleum cecair (LPG)', # Tan',
			47=>'Gas asli / gas asli untuk kenderaan (NGV)', # Tan',
			48=>'Bahan pembakar lain (cth. Bio-mass, Solar, Bateri hybrid dll)', # Tan',
			49=>'Tenaga elektrik yang dibeli', # Kilowatt-jam',
			50=>'Tenaga elektrik yang dijana', # Kilowatt-jam',
			52=>'% Tenaga elektrik yang dijana', # Kilowatt-jam',
			59=>'Jumlah RM', # Kilowatt-jam',
		);

		$nilaiBuku = array(
			14=>'Unit',
			15=>'Kuantiti',
			16=>'Nilai',
		);

		$cari2 = array(
			'F1441'=>'Meter padu',
			'F1451'=>'-',
			'F1442'=>'-',
			'F1443'=>'Liter',
			'F1444'=>'Liter',
			'F1445'=>'Liter',
			'F1446'=>'Tan',
			'F1447'=>'Tan',
			'F1448'=>'Tan',
			'F1449'=>'Kilowatt-jam',
			'F1450'=>'Kilowatt-jam',
			'F1452'=>'-',
			'F1459'=>'-',
			'F14X1'=>'-',
			'F15X1'=>'-',
			'F16X1'=>'-',
		);

		$cari = array_merge($asal,$cari2);
		$calc = $kira = 0; # mula cari 
		$binaan = array();

		# bina tatasusunan
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;

				$data = isset($cari[$baris]) ? $cari[$baris] : '0';

				$t0["$tajuk - $key2"] =  !empty($data) ? $data : '-';
				$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			# buang data kosong
			if (array_sum($jumlah[$calc]['F']) != 0)
				$binaan[$kira++] = array_merge(
					array('nama' => $jenis, 'kod' => $key), 
					$t0);
			else $calc++;
		endforeach; //*/ # foreach ($jenisHarta as $key => $jenis):

		//echo '<pre>soalan11($cariAsal,'.$kp.')='; print_r($cariAsa1); echo '</pre><hr>';
		//echo '<pre>soalan11($cari2,'.$kp.')='; print_r($cari2); echo '</pre><hr>';
		//echo '<pre>soalan11($cari,'.$kp.')='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>$jum='; print_r($jum); echo '</pre><hr>';
		//echo '<pre>Borang206::soalan11($binaan)='; print_r($binaan); echo '</pre><hr>';

		# pulangkan nilai
		return (!isset($cari)) ? array() : $binaan;
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function soalan13($asal, $kp)
	{
		# jenis harta
		$jenisHarta = array(
			21=>'1.1-',  22=>'1.2-',  23=>'1.3-',  24=>'1.4 JOHOR',
			25=>'2.1-',  26=>'2.2-',  27=>'2.3-',  28=>'2.4 KEDAH',
			29=>'3.1-',  30=>'3.2-',  31=>'3.3-',  32=>'3.4 KELANTAN',
			33=>'4.1-',  34=>'4.2-',  35=>'4.3-',  36=>'4.4 MELAKA',
			37=>'5.1-',  38=>'5.2-',  39=>'5.3-',  40=>'5.4 NEGERI SEMBILAN',
			41=>'6.1-',  42=>'6.2-',  43=>'6.3-',  44=>'6.4 PAHANG',
			# Muka 2
			45=>'7.1-',  46=>'7.2-',  47=>'7.3-',  48=>'7.4 PULAU PINANG',
			49=>'8.1-',  50=>'8.2-',  51=>'8.3-',  52=>'8.4 PERAK',
			53=>'9.1 PERLIS',
			54=>'10.1-', 55=>'10.2-', 56=>'10.3-', 57=>'10.4 SELANGOR',
			58=>'11.1-', 59=>'11.2-', 60=>'11.3-', 61=>'11.4 TERENGGANU ',
			62=>'12.1 WILAYAH PERSEKUTUAN KUALA LUMPUR',
			63=>'12.2 WILAYAH PERSEKUTUAN LABUAN',
			80=>'12.3 WILAYAH PERSEKUTUAN PUTRAJAYA',
			# Muka 3
			64=>'13.1-', 65=>'13.2-', 66=>'13.3-', 67=>'13.4-', 68=>'13.5-', 69=>'13.6 SABAH',
			70=>'14.1-', 71=>'14.2-', 72=>'14.3-', 73=>'14.4-', 74=>'14.5-', 75=>'14.6-',
			76=>'14.7-', 77=>'14.8-', 78=>'14.9-', 79=>'14.10 SARAWAK',
			89=>'Jumlah Besar',
		);
		
		$nilaiBuku = array(
			24=>'Nilai',
			25=>'Kod Daerah',
		);

		$cari2 = array();
		$cari = array_merge($asal);
		$calc = $kira = 0; # mula cari 
		$binaan = array();
		
		# bina tatasusunan
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;

				$data = isset($cari[$baris]) ? $cari[$baris] : '0';

				$t0["$tajuk - $key2"] =  !empty($data) ? $data : '-';
				$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			# buang data kosong
			if (array_sum($jumlah[$calc]['F']) != 0)
				$binaan[$kira++] = array_merge(
					array('nama' => $jenis, 'kod' => $key), 
					$t0);
			else $calc++;
		endforeach; //*/ # foreach ($jenisHarta as $key => $jenis):

		//echo '<pre>soalan11($asal,'.$kp.')='; print_r($asal); echo '</pre><hr>';
		//echo '<pre>soalan11($cari2,'.$kp.')='; print_r($cari2); echo '</pre><hr>';
		//echo '<pre>soalan11($cari,'.$kp.')='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>$jum='; print_r($jum); echo '</pre><hr>';
		//echo '<pre>Borang206::soalan13($binaan)='; print_r($binaan); echo '</pre><hr>';

		# pulangkan nilai
		return (!isset($cari)) ? array() : $binaan;
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function soalan15($asal, $kp)
	{
		# jenis harta
		$jenisHarta = array(
			1=>'Bangunan kediaman', # Residential buildings
			2=>'Bangunan perindustrian', # Industrial buildings
			3=>'Pejabat dan bangunan perniagaan', # Office and commercial buildings
			4=>'Sekolah dan bangunan pelajaran lain', # Schools and other educational buildings
			5=>'Hospital dan bangunan lain untuk perkhidmatan kesihatan', # Hospitals and other buildings for health services
			6=>'Bangunan lain', # Other buildings
			7=>'Pembinaan jalan, jambatan, terowong, jejambat, lebuh raya, lebuh raya bertingkat, landasan keretapi, lapangan terbang, dsb',
			# Construction of roads, bridges, tunnels, viaducts, highways, elevated highways, railways, airfields, etc.
			8=>'Pembinaan empangan, sistem perairan, sistem saliran dan kumbahan, saluran paip, pelabuhan dan projek air lain dsb.',
			# Construction of dam, irrigation system, drainage and sewage system, pipelines, harbours and other water projects, etc.
			9=>'Komunikasi dan talian kuasa', # Communication and power lines
			10=>'Kemudahan sukan termasuk stadium, padang golf dsb', # Sports facilities including stadiums, golf courses, etc.
			15=>'Kejuruteraan awam lain', # Other civil engineering
			16=>'Pertukangan khas', # Special trades
			19=>'JUMLAH BESAR', # GRAND TOTAL
		);

		$nilaiBuku = array(
			22=>'binabaru/ membaikpulih (Kerajaan)',
			# New construction and major renovation (Government)
			23=>'membaiki/ menyelenggara (Kerajaan)',
			# Repairs and maintenance (Government)
			24=>'binabaru/ membaikpulih (Sendiri)',
			# New construction and major renovation (Persendirian)(Private)
			25=>'membaiki/ menyelenggara (Sendiri)',
			# Repairs and maintenance (Private)
			26=>'Jumlah binabaru/ membaikpulih (Kerajaan + Sendiri)',
			# New construction and major renovation
			27=>'Jumlah membaiki/ menyelenggara (Kerajaan + Sendiri)',
			# Repairs and maintenance
			28=>'Jumlah (binabaru/membaikpulih + membaiki/menyelenggara)',
		);

		$cari2 = array();
		$cari = array_merge($asal);
		$calc = $kira = 0; # mula cari
		$binaan = array();

		# bina tatasusunan
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;

				$data = isset($cari[$baris]) ? $cari[$baris] : '0';

				$t0["$tajuk - $key2"] =  !empty($data) ? $data : '-';
				$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			# buang data kosong
			if (array_sum($jumlah[$calc]['F']) != 0)
				$binaan[$kira++] = array_merge(
					array('nama' => $jenis, 'kod' => $key), 
					$t0);
			else $calc++;
		endforeach; //*/ # foreach ($jenisHarta as $key => $jenis):

		//echo '<pre>soalan15($asal,'.$kp.')='; print_r($asal); echo '</pre><hr>';
		//echo '<pre>soalan11($cari2,'.$kp.')='; print_r($cari2); echo '</pre><hr>';
		//echo '<pre>soalan11($cari,'.$kp.')='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>$jum='; print_r($jum); echo '</pre><hr>';
		//echo '<pre>Borang206::soalan15($binaan)='; print_r($binaan); echo '</pre><hr>';

		# pulangkan nilai
		return (!isset($cari)) ? array() : $binaan;
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function soalan16($asal, $kp)
	{
		$cari2 = array();
		$cari = array_merge($asal); # cantum tatasusunan
		$calc = $kira = 0; # mula cari 
		$binaan = array();	
		list($jenisHarta, $nilaiBuku) = Borang206::soalan16tatasusunan();

		# bina tatasusunan
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$lajur = kira3($key2, 2);
				$baris = 'F' . $lajur . $key;

				$data = isset($cari[$baris]) ? $cari[$baris] : '0';

				if($lajur == '28'):
					$F2899 = isset($cari['F2899']) ? $cari['F2899'] : '0';
					$fx = ($data / $F2899) * 100;
					$p1 = kiraPerpuluhan($fx,0);
					$p2 = kira4($p1,4,'.');
					$data2 = kiraPerpuluhan($data,0) . ' |&nbsp;' . $p2 . '%';
					$t0["$tajuk - $key2"] = !empty($data) ? $data : '-';
				else:
					$t0["$tajuk - $key2"] = !empty($data) ? $data : '-';
				endif;

				//$t0["$tajuk - $key2"] = !empty($data) ? $data : '';
				$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			# buang data kosong
			if (array_sum($jumlah[$calc]['F']) != 0)
				$binaan[$kira++] = array_merge(
					array('nama-bahan-binaan-yang-panjang-daa' => $jenis, 'kod' => $key),
					$t0);
			else $calc++;
		endforeach; //*/ # foreach ($jenisHarta as $key => $jenis):

		//echo '<pre>soalan16($asal,'.$kp.')='; print_r($asal); echo '</pre><hr>';
		//echo '<pre>soalan16($cari2,'.$kp.')='; print_r($cari2); echo '</pre><hr>';
		//echo '<pre>soalan16($cari,'.$kp.')='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>Borang206::soalan16($binaan)='; print_r($binaan); echo '</pre><hr>';

		# pulangkan nilai
		return (!isset($cari)) ? array() : $binaan;
	}
##--------------------------------------------------------------------------------------------------------------------
	function soalan16tatasusunan()
	{
		# jenis harta
		$jenisHarta = array(
			21=>'1.1-Besi / keluli tetulang', # Reinforcement iron / steel
			22=>'1.2-Kepingan besi bersadur', # Galvanised iron sheets
			23=>'1.3-Paip dan tiub daripada besi tuang', # Cast iron pipes and tubes
			24=>'1.4-Pintu, bingkai tingkap, pintu pagar, kisi-kisi, dsb. diperbuat dpd logam dsb', # Metal doors, window frames, gates, grilles, etc.
			25=>'1.5-Bahan pagar dan jaring daripada kawat, besi dan keluli', # Fensing and netting materials of wire, iron and steel
			26=>'1.6-Paku, bot nat dan barangan besi lain', # Nails, bolts, nuts and other hardware
			27=>'1.7-Bahan-bahan besi dan keluli lain', # Other iron and steel materials
			# Simen dan bahan konkrit : Cement and concrete materials:
			28=>'2.1-Simen (OPC)', # Cement (OPC)
			29=>'2.2-Pasir', # Sand
			30=>'2.3-Agregat (batu baur)', # Aggregate
			31=>'2.4-Konkrit siap bancuh', # Ready mix concrete
			32=>'2.5-Bahan-bahan simen dan konkrit lain', # Other cement and concrete materials
			# Bahan-bahan batu bata :	Brickwork materials:
			33=>'3.1-Batu bata tanah liat', # Common clay bricks
			34=>'3.2-Batu bata pasir', # Common sand bricks
			35=>'3.3-Blok konkrit berlubang pra tuang', # Precast concrete vent blocks
			36=>'3.4-Blok berlubang bertetulang', # Autoclaved aerated blocks
			37=>'3.5-Blok berongga', # Hollow blocks
			38=>'3.6-Bahan-bahan batu bata yang lain', # Other brickwork materials
			# Kayu dan keluaran kayu: Timber and timber products:
			39=>'4.1-Kayu gergaji', # Sawn timber
			40=>'4.2-Papan lapis', # Plywood
			41=>'4.3-Papan plaster gypsum', # Gypsum plaster boards
			42=>'4.4-Rangka pintu kayu & bingkai tingkap', # Timber doors and window frames
			43=>'4.5-Bahan kayu yang lain', # Other timber materials
			# Muka 2
			# Bahan-bahan bumbung | Roofing materials :
			44=>'5.1-Jubin bumbung tanah liat', # Clay roof tiles
			45=>'5.2-Jubin bumbung konkrit', # Concrete roof tiles
			46=>'5.3-Jubin bumbung logam ', # Metal roof tiles
			47=>'5.4-Kepingan bumbung logam ', # Metal profiled roof sheets
			48=>'5.5-Bahan bumbung lain ', # Other roofing materials
			# Jubin | Tiles :
			49=>'6.1.0-Jubin lantai', # Floor tiles
			50=>'6.2.0-Jubin dinding', # Wall tiles
			# 6.3-Batu penyudah | Stone finishes :
			52=>'6.3.1-Granit hitam', # Black granite
			53=>'6.3.2-Marmar hitam', # Black marble
			54=>'6.3.3-Marmar putih', # White marble
			55=>'6.4.0-Bahan-bahan jubin lain', # Other floor tiles
			# Pemasangan mekanikal dan elektrik | Mechanical and electrical materials :
			56=>'7.1-Loji penyamanan udara', # Air conditioning plants
			57=>'7.2-Loji pendinginan', # Refrigerating plants
			58=>'7.3-Alat pemanas', # Heating equipment
			59=>'7.4-Lif, eskalator dan travelator', # Lifts, escalators travelators
			60=>'7.5-Jentera lain', # Other machinery
			61=>'7.6-Alat kelengkapan & aksesori elektrik', # Electrical fitting and accessories
			62=>'7.7-Bahan-bahan jentera & elektrik lain', # Other machinery and electrical materials
			# Bahan-bahan IBS | IBS building materials :
			76=>'8.1-Sistem kerangka, panel dan kekotak konkrit pratuang (tiang, rasuk,'
				. 'lantai pratuang, komponen 3D, contohnya balkoni, tangga, tandas, lif)', 
				# Pre-cast concrete framing, panel and box system (pre-cast columns,
				# beams, slabs, 3D components e.g. balconies, staircases, toilets, lifts)
			77=>'8.2-Sistem kerangka keluli (Tiang dan rasuk keluli kerangka portal,kerangka bumbung)', 
				# Steel framing system (Steel columns and beams, portal frames, roof trusses)
			78=>'8.3-Sistem acuan keluli [bentuk terowong, acuan rasuk dan tiang, acuan keluli tetap (pelantar logam)]',
				# Steel formworks {tunnel forms, beams and columns, moulding forms, permanent steel formworks (metal deck)}
			79=>'8.4-Sistem kerangka kayu pra-siap (Tiang dan rasuk kayu pra-siap dan kerangka bumbung)',
				# Prefabricated timber frames (Prefebricated timber, beams and columns)
			80=>'8.5-Sistem blok (interlocking concrete masonry units (MMU), blok konkrit ringan]',
				# Block work systems (interlocking concrete masonry units (MMU),lightweight concrete blocks]
			81=>'8.6-Sistem inovatif House Modular lain, dry wall-gypsum board, panel konkrit, panel sandwich,'
				. 'panel dinding bio-komposit, unit bilik mandi, panel duralite, cemboard dry wall',
				# Other innovative system modular house, dry wall-gypsum board, concrete panel, 
				# sandwich panel, bio-composite wall panel, bathroom unit, duralite panel and cemboard dry wall.
			# Muka 3
			63=>'9.1-Pintu, pintu pagar, dsb. daripada aluminium', # Aluminium doors, gates etc.
			64=>'9.2-Kajang, bidai, dsb. daripada aluminium', # Aluminium awnings, venetian blinds etc.
			65=>'9.3-Bahan lain daripada aluminium, loyang tembaga, dsb.', # Other materials of aluminium, brass, copper etc.
			66=>'9.4-Bahan kaca', # Glass materials
			67=>'9.5-Papan dinding, papan lembut, papan serpih dsb.', # Wallboards, soft boards, particle boards etc.
			68=>'9.6-Paip PVC dan alat kelengkapan kebersihan', # PVC pipes and sanitary fittings
			69=>'9.7-Bahan penebat', # Insulating materials
			70=>'9.8-Alat pemadam kebakaran', # Fire fighting equipment
			71=>'9.9-Kabel', # Cables
			72=>'9.10-Bahan-bahan mengecat', # Painting materials
			73=>'9.11-Bahan-bahan cerucuk termasuk besi, konkrit dan kayu', # Pilling materials including steel concrete and timber
			74=>'9.12-Bitumen, tar dan asfalt (premix)', # Bitumen, tar and asphalt (premix)
			75=>'9.13-Bahan lain, sila nyatakan:', # Other materials, please specify:
			99=>'JUMLAH BAHAN BINAAN DIGUNAKAN', # TOTAL MATERIALS USED
		);

		$nilaiBuku = array(
			28=>'Nilai (RM)', # Value (RM)
			29=>'% Bahan Tempatan', # % Local materials
		);

		$pulangkan = array($jenisHarta, $nilaiBuku);
		//echo '<pre>tatsusunan($pulangkan)='; print_r($pulangkan); echo '</pre><hr>';

		return $pulangkan;		
	}
##--------------------------------------------------------------------------------------------------------------------
	public static function soal16salin($asal, $kp)
	{
		$cari2 = array();
		$cari = array_merge($asal); # cantum tatasusunan
		$calc = $kira = 0; # mula cari 
		$binaan2 = array();	
		list($jenisHarta, $nilaiBuku) = Borang206::soalan16tatasusunan();

		# bina tatasusunan
		foreach ($jenisHarta as $key => $jenis):
			foreach ($nilaiBuku as $key2 => $tajuk):
				$baris = 'F' . kira3($key2, 2) . $key;
				$data = isset($cari[$baris]) ? $cari[$baris] : '0';
				$t0["$tajuk - $key2"] = !empty($data) ? $data : '';
				//$jumlah[$calc]['F'][$lajur] = !empty($data) ? $data : '0';
			endforeach;
			# buang data kosong
			//if (array_sum($jumlah[$calc]['F']) != 0)
				$binaan2[$kira++] = array_merge(
					array('namaBahan' => '', 'kod' => $key), 
					$t0);
			//else $calc++;
		endforeach; //*/ # foreach ($jenisHarta as $key => $jenis):

		//echo '<pre>soalan16($asal,'.$kp.')='; print_r($asal); echo '</pre><hr>';
		//echo '<pre>soalan16($cari2,'.$kp.')='; print_r($cari2); echo '</pre><hr>';
		//echo '<pre>soalan16($cari,'.$kp.')='; print_r($cari); echo '</pre><hr>';
		//echo '<pre>$jum='; print_r($jum); echo '</pre><hr>';
		//echo '<pre>Borang206::soal16salin($binaan)='; print_r($binaan2); echo '</pre><hr>';

		# pulangkan nilai
		return (!isset($cari)) ? array() : $binaan2;
	}
##--------------------------------------------------------------------------------------------------------------------
######################################################################################################################
}