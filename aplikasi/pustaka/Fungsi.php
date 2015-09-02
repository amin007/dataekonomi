<?php

function dpt_url()
{
	$url = isset($_GET['url']) ? $_GET['url'] : null;
	$url = rtrim($url, '/');
	$url = filter_var($url, FILTER_SANITIZE_URL);
	$url = explode('/', $url);

	return $url;
}

function pecah_url($ulang)
{
	$pecah  = explode("/", $_SERVER['REQUEST_URI']);
	$tambah = ($ulang+1);
	$buang  = ($ulang-1==0) ? 1 : ($ulang-1);
	$papar  = '<a href="' . URL . $pecah[2] 
			. '/' . $pecah[3] 
			. '/' . $pecah[4]
		    . '/' . $tambah . '">Tambah</a>|'
			. '<a href="' . URL . $pecah[2] 
			. '/' . $pecah[3] 
			. '/' . $pecah[4]
		    . '/' . $buang . '">Kurang</a>';

	/*$papar .= '<pre>' . print_r($pecah, 1) . '</pre>';
		$pecah = > Array
		(
			[0] => 
			[1] => ekonomi
			[2] => cari
			[3] => lokaliti
			[4] => johor
			[5] => 3
		)
	//*/
	
	return $papar;
}

function dpt_ip()
{
	$IP = array('192.168.1.', '10.69.112.', 
		'127.0.0.1'/*, '10.72.112.'*/);

	return $IP;
}

function dpt_senarai($namajadual)
{
	$e = null; //'pom_dataekonomi.';
	if ($namajadual=='msiclama')
		$jadual = array($e.'msic08',$e.'msic2008',
		$e.'msic_v1',$e.'msic_bandingan',
		$e.'msic',$e.'msic_nota_kaki');
	elseif ($namajadual=='msicbaru')
		$jadual = array($e.'msic2008',$e.'msic2008_asas',
		$e.'msic_v1',$e.'msic_bandingan',
		$e.'msic2000',$e.'msic2000_notakaki');
	elseif ($namajadual=='produk')
		$jadual = array($e.'kodproduk_aup',
		$e.'kodproduk_mei2011',
		$e.'kod2010_input',
		$e.'kod2010_output',
		$e.'mcpa2008_tr2010',
		$e.'mcpa2009_tr2013',
		$e.'mcpa2009_input',
		/*'kodproduk_unitkuantiti'*/);
	elseif ($namajadual=='syarikat')
	{
		$t = 12;
		$jadual = array('kawal_icdt'.$t,
		'5p_icdt'.$t,'rangka_icdt'.$t,
		'alamat_icdt'.$t);
	}
	elseif ($namajadual=='kawalan_tahunan')
	{
		$jadual = array('kawal_ppmas09',
			'kawal_rpe09',
			'kawal_tani09',
			'sse08_rangka',
			'sse09_buat',
			'sse09_ppt',
			'sse10_kawal',
			'alamat_newss_2013');
	}
	elseif ($namajadual=='prosesan')
	{
        $jadual = array($e.'tblprofpert',
        $e.'tblprofpert_2009',
        $e.'tblprofpert_2010');
	}
	elseif ($namajadual=='data_prosesan')
        $jadual = array($e.'tblemp',
		$e.'tblframe',
		$e.'tblmisc',
		$e.'tblorder',
		$e.'tblprodsale',
		$e.'tblprofpert',
		$e.'tblstock');
	elseif ($namajadual=='johor')
		$jadual = array('johor');
	
	return $jadual;
}

function harga_unit_purata()
{
?>
<!-- Example row of columns -->
<hr>
<div class="row">
	<div class="span4">
	<!-- ======================================================================= -->	
		<table border="1" class="excel">
		<tr><td colspan="2">PANDUAN PENYUNTINGAN DAN PENGEKODAN.</td>
			<td colspan="2">KP 205 2013</td></tr>
		<tr><td colspan="4">HARGA UNIT PURATA (AUP)<br>				
		(AIR, PELINCIR, BAHAN PEMBAKAR DAN TENAGA ELEKTRIK)	
		</td></tr>
		<tr><th>Butiran</th><th>Unit Kuantiti</th><th>Min</th><th>Max</th></tr>
		<tr><td>Air</td><td>Meter Padu</td><td>0.90</td><td>2.20</td></tr>
		<tr><td>Minyak Diesel</td><td>Liter</td><td>1.40</td><td>3.00</td></tr>
		<tr><td>Petrol</td><td>Liter</td><td>1.90</td><td>4.00</td></tr>
		<tr><td>Minyak Relau / Pembakar</td><td>Liter</td><td>0.50</td><td>2.00</td></tr>
		<tr><td>Gas Petroleum Cecair (L.P.G)</td><td>Tonne</td><td>1,200</td><td>1,800</td></tr> 		
		<tr><td>Gas asli untuk kenderaan (NGV)</td><td>Tonne</td><td>1,000</td><td>1,400</td></tr>
		<tr><td>Kuasa Elektrik Yang Dibeli</td><td>k.w.j</td><td>0.20</td><td>0.60</td></tr>
		</table>
	<!-- ======================================================================= -->
	</div>
	<div class="span5">
	<!-- ======================================================================= -->
		<table border="1" class="excel">
		<tr><td colspan="3">Jika pertubuhan mengeluarkan kuasa elektrik sendiri tetapi tidak menyimpan <br>
		rekod bagi nilai kuasa elektrik yang digunakan/dijual, keterangan berikut adalah <br>
		dikehendaki untuk mendapatkan jumlah kuasa elektrik yang dijanakeluarkan :-						
		</td></tr>
		<tr><td>(i)</td><td>Kuasa kuda generator</td><td>(h.p. = n1)</td></tr>
		<tr><td>(ii)</td><td>Bil.Jam sehari generator bergerak</td><td>(jam = M)</td></tr>
		<tr><td>(iii)</td><td>Bil. Hari pertubuhan beroperasi</td><td>(hari = Y)</td></tr>
		<tr><td>&nbsp;</td><td colspan="2">
			1 h.p. = 0.746 k.w.j.<br>k.w.j. = n1 x 0.746 x M x Y<br>
			Jika n2 KVA (kilo-volt amphere) diberi,	menggantikan kuasa kuda iaitu<br>
			(n1 h.p.), k.w.j. = n2 x 0.8 x Y x M
		</td></tr>
		</table>				
	<!-- ======================================================================= -->
	</div>
</div>
<?php
}

function pecah_post()
{
	$papar['pilih'] = isset($_POST['pilih']) ? $_POST['pilih'] : null;
	$papar['cari'] = isset($_POST['cari']) ? $_POST['cari'] : null;
	$papar['fix'] = isset($_POST['fix']) ? $_POST['fix'] : null;
	$papar['atau'] = isset($_POST['atau']) ? $_POST['atau'] : null;
	
	$kira['pilih'] = count($papar['pilih']);
	$kira['cari'] = count($papar['cari']);
	$kira['fix'] = count($papar['fix']);
	$kira['atau'] = count($papar['atau']);
	
	return $kira;
	//echo '<pre>'; print_r($kira) . '</pre>';
}
// fungsi untuk PAPAR
function semakJenis($sv, $kunci, $var)
{    
	$senaraiMedan = array('F0003','F0004','F0005');
	if (in_array($kunci, $senaraiMedan) 
		&& in_array($sv, array(205,206) )  ) 
	{
		$data = preg_replace('/(\d{1,2})(\d{2})(\d{4})$/', 
			'$3-$2-$1', $var).PHP_EOL;
		$data = date('d M Y',strtotime($data));
	}
	elseif (is_numeric($var)) 
		$data = number_format($var,0);
	else $data = $var;
		
	return $data;
}

function keterangan($key, $data, $myTable, $dataKeterangan)
{
	//echo '<hr><pre>$dataKeterangan='; print_r($dataKeterangan[$myTable]) . '</pre>';
	$thn = ($key=='thn') ? $data : 2010; 
	$keterangan = !isset($dataKeterangan[$myTable][$key][$thn]) ?
		'' : $dataKeterangan[$myTable][$key][$thn];
/*		
		switch ($key) 
		{// mula - pilih key
		
		case 'THN': case 'thn':
			$papar = 'Tahun Kes Terpilih';
			break;
		case 'Batch': case 'batch':
			$papar = 'Batch Prosesan Kes Terpilih';
			break;
		case 'Estab': case 'estab':
			$papar = 'Kod Sidap/Newss Kes Terpilih';
			break;
		case 'Newss': case 'newss':
			$papar = 'Kod Newss';
			break;
		case 'Nama': case 'nama':
			$papar = 'Nama Syarikat';
			break;
		default: 
			$papar = $keterangan;
			break;
		}// tamat - pilih key
*/
		$papar = $keterangan;
		return $papar;
}

function paparDataBrgAm($sv, $myTable, $row, $dataKeterangan, $senaraiMedan)
{?>	<table><tr><?php // mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{?>
		<td valign="top">
		<table border="1" class="excel" id="example"><?php 
		foreach ( $row[$kira] as $key=>$data ) : ?>
		<tr><td><?php //echo keterangan($key, $data, $myTable, $dataKeterangan) // <abbr title="">?>
		<?php echo "\n" . $key; // </abbr>?></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($sv, $key, $data) ?></td>
		</tr><?php endforeach ?>
		</table>
		</td><?php
	}#-----------------------------------------------------------------?>
	</tr></table><?php
}

function paparData($sv, $myTable, $row, $dataKeterangan, $senaraiMedan)
{?>	<table><tr><?php // mula bina jadual
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{?>
		<td valign="top">
		<table border="1" class="excel" id="example"><?php 
		foreach ( $row[$kira] as $key=>$data ) : ?>
		<tr><td><?php echo '<abbr title="' . keterangan($key, $data, $myTable, $dataKeterangan) . '">'; // <abbr title=""> ?>
		<?php echo "\n" . $key . '</abbr>'; ?></td>
		<td align="right"><?php echo (in_array($key, $senaraiMedan)) ? 
			$data : semakJenis($sv, $key, $data) ?></td>
		</tr><?php endforeach ?>
		</table>
		</td><?php
	}#-----------------------------------------------------------------?>
	</tr></table><?php
}

function paparKodProduk($sv, $myTable, $row)
{?>	<table  border="1" class="excel" id="example"><?php 
	$printed_headers = false;
	#-----------------------------------------------------------------
	for ($kira=0; $kira < count($row); $kira++)
	{	//print the headers once: 	
		if ( !$printed_headers ) :?>
	<thead><tr>
	<th>#</th><?php	foreach ( array_keys($row[$kira]) as $tajuk ) : ?>
	<th><?php echo $tajuk ?></th><?php endforeach ?>
	</tr></thead><?php $printed_headers = true; 
		endif;
	#-----------------------------------------------------------------		 
	//print the data row ?>
	<tbody><tr>
	<td><?php echo $kira+1 ?></td>	
	<?php foreach ( $row[$kira] as $key=>$data ) :?>
	<td align="right"><?php echo (in_array($key, 
		array('thn','Estab','F3001','nama_produk','Commodity'))) ? 
		$data : semakJenis($sv, $key, $data) ?></td>
	<?php endforeach ?>
	</tr></tbody>
	<?php 
	} // endfor $kira ?></table><?php
}

function keterangan_medan($key)
{
	//if ($key == 'THN') $papar = 'tahun kes terpilih';
	switch ($key) 
	{// mula - pilih key
	case 'THN': case 'thn':
		$papar = 'tahun kes terpilih';
		break;
	case 'Batch': case 'batch':
		$papar = 'batch prosesan kes terpilih';
		break;
	case 'Estab': case 'estab':
		$papar = 'estab - nombor sidap/newss kes terpilih';
		break;
	case 'Nama': case 'nama':
		$papar = 'nama syarikat';
		break;
	case 'F0003': 
		$papar = 'tahun bermula aktiviti syarikat';
		break;
	case 'F0004':
		$papar = 'tempoh operasi syarikat bermula';
		break;
	case 'F0005': 
		$papar = 'tempoh operasi syarikat berakhir';
		break;
	default: 
		$papar=$key; 
		break;
	}// tamat - pilih key
	
	return 'Ini tentang ' . $papar;
}

function pilihTajuk($tajuk, $jadual)
{
		$tukarTajuk['harta'] = array(
			'F0171'=>'Awal - 01', // 'Nilai buku pada awal tahun'
			'F0271'=>'Baru - 02', //'Pembelian baru termasuk import',
			'F0371'=>'Terpakai - 03', //'Pembelian aset terpakai',
			'F0471'=>'DIY - 04', //'Membuat/membina sendiri',
			'F0571'=>'Jual/tamat - 05', // 'Aset dijual/ditamat'
			'F0671'=>'+/- jual - 06', // 'Untung/Rugi drpd jualan harta'
			'F0771'=>'Susut nilai - 07',
			'F0871'=>'Akhir - 08', // 'Nilai buku pada akhir tahun'
			'F0971'=>'Sewa - 09','F8571'=>'Kerja dlm pelaksanaan - 85');
		// kod output	
		$tukarTajuk['kodOutput'] = array(
			'F2201'=>'M22','F2301'=>'M23','F2401'=>'M24',
			'F2501'=>'Jualan(RM)','F2601'=>'M26(RM)','F2701'=>'M27(RM)',
			'F2501(RM)'=>'Jualan(RM)','F2601(RM)'=>'M26(RM)','F2701(RM)'=>'M27(RM)',
			'F2801'=>'M28','F2901'=>'M29');
		// kod input
		$tukarTajuk['kodInput'] = array(
			'F2201'=>'M22','F2301'=>'F23(RM)','F2401'=>'M24');
	return isset($tukarTajuk[$jadual][$tajuk]) ? $tukarTajuk[$jadual][$tajuk] : $tajuk;
}

function cariMedanInput($ubah,$f,$row,$nama) 
{/* mula -
	$ubah = nama jadual
	$f = nombor medan
	$row = data medan
	$nama = nama medan
	
	senarai nama medan
	0-nota,1-respon,2-fe,3-tel,4-fax,		
	5-responden,6-email,7-msic,8-msic08,
	9-`id U M`,10-nama,11-sidap,12-status 
 */// papar medan yang terlibat
 
	$cariMedan = array(0,1,2,3,4,5,6,8);
	$cariText = array(0); // papar jika nota ada
	$cariMsic = array(8); // papar input text msic sahaja 
	$namaM = $ubah .'[' . $nama . ']';
		
	// tentukan medan yang ada input
	$input=in_array($f,$cariMedan)? 
	(@in_array($f,$cariMsic)? // tentukan medan yang ada msic
		'<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=6>'
		:(@in_array($f,$cariText)? // tentukan medan yang ada input textarea
			'<textarea name="' . $namaM . '" rows=2 cols=23>' . $row[$f] . '</textarea>'
			: // tentukan medan yang bukan input textarea
			'<input type="text" name="' . $namaM . '" value="' . $row[$f] . '" size=30>'
		)
	):'<label class="papan">' . $row[$f] . '</label>';
	
	return $input;

}

function inputTextMedan($jadual, $key)
{    // istihar pembolehubah 
	$name = 'name="medan[' . $jadual . '][' . $key . ']"'
		  . ' id="' . $key . '"';
	
	$input = $key . '</td><td>'
		   . '<input type="text" ' . $name . ' value="' 
		   . $key . '" class="input-medium">';

	return $input . "\r";
}

function inputText($jadual, $key, $data)
{    // istihar pembolehubah 
	$name = 'name="' . $jadual . '[' . $key . ']"'
		  . ' id="' . $key . '"';

	$medanApa = $jadual . '[' . $key . ']';
	//elseif(in_array($key,array('fe','tel','fax','responden','email')))
	// $input =  '<textarea ' . $name . ' rows="1" cols="20">' . $data . '</textarea>';
	$input = '<div class="input-prepend">'
		   //. '<span class="add-on">' . $medanApa . '</span>' 
		   . '<input type="text" ' . $name . ' value="' 
		   . $data . '" class="input-medium"></div>';

	return '<td>' . $input . '</td>';
}

function inputText2($kira, $jum, $io, $jadual, $key, $data)
{    // istihar pembolehubah 
	$lajur = $kira+1; //kira3($kira+1, 1);
	// kira baris akhir dan kedua akhir
	$akhir = $jum - $lajur;
	$buangOutput = array('F22','F23','F24','F28','F29');
	$buangInput = array('F22','F24','F25');
	$pilihStaf = array('q05a_2010','q05b_2010','lelaki','wanita'
		//'s' . $this->sv . '_q05a_2010',	's' . $this->sv . '_q05b_2010'
		);
	//$masukOutput = array('F25','F26','F27');
	//$masukInput = array('F23');
	if (in_array($key,$io))
		$input = $data;
	elseif ($jadual == 'harta')
	{
		$jumKey = array('F0871','F0872','F0873','F0874','F0875',
			'F0876','F0877','F0878','F0879','F0880','F0881',
			'F0882','F0870','F0874','F0884','F0886','F0899');
		//$pilihKey = array('F7285','F7385','F7485','F8185','F8685','F9985');
		$pilihKey = array('F7185','F7585','F7685','F7785','F7885','F7985',
			'F8085','F8285','F7085','F8485');
					
		$kiraHarta[$key] = $data;
			//$lajur = kira3($kira+1, 2);
			//$baris = ($akhir==1) ? 'F3041' : 'F30' . $lajur;
			$baris = $key;
			$name = 'name="' . $jadual . '[' . $baris . ']"'
				  . ' id="' . $baris . '"';
			$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
			$paparKanan = (in_array($key,$jumKey)) ? 
				'<span class="add-on">' . $data . '</span>' : null;

		if (in_array($key, $pilihKey)) 
		{
			$input = $data;
		}
		else
			$input = '<div class="input-prepend">'
				   //. '<span class="add-on">' . $baris . '</span>' 
				   . '<input type="text" ' . $name . ' value="' 
				   . $data . '" class="input-mini">'
				   . $paparKanan . '</div>';		
	}
	elseif (in_array($jadual, $pilihStaf)) 
	{
		$kiraHarta[$key] = $data;
		$baris = $key;
		$name = 'name="proses[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$paparKanan = null; /*(in_array($key,$jumKey)) ? 
			'<span class="add-on">' . $data . '</span>' : null;*/
	
			$input = '<div class="input-prepend">'
				   //. '<span class="add-on">' . $baris . '</span>' 
				   . '<input type="text" ' . $name . ' value="' 
				   . $data . '" class="input-mini">'
				   . $paparKanan . '</div>';			
	}
	elseif ($key=='nama_produk')
	{
		if ($jadual == 'kodOutput')
		{
			$lajur = kira3($kira+1, 2);
			$baris = ($akhir==1) ? 'F3041' : 'F30' . $lajur;
		}
		elseif ($jadual == 'kodInput')
		{
			$lajur = kira3($kira+51, 2);
			$baris = ($akhir==1) ? 'F2581' : 'F25' . $lajur;
		}
		
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$input = '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-medium"></div>';		
	}
	// jika $key adalah jumlah besar dan nilai lain2
	elseif ( ($akhir==1 || $akhir==0) 
		&& $jadual == 'kodOutput')
	{	// 42 - jumlah, 41 = lain2
		$baris = $key; //($akhir==1) ? 3041 : 3042;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$input = (in_array($key,$buangOutput)) ? 
				$data : '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';			
	}
	elseif ( ($akhir==1 || $akhir==0) 
		&& $jadual == 'kodInput')
	{// 82 - jumlah, 81 = lain2
		$baris = $key; //($akhir==1) ? 81 : 2582;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$input = (in_array($key,$buangOutput)) ? 
				$data : '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';
	}
	elseif ( $jadual == 'output' || $jadual == 'input')
	{
		$baris = $key;
		$name = 'name="' . $jadual . '[' . $kira . '][' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$input = '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';
	}
	else
	{
		$baris = $key;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$data = ($data=='-' || $data=='_' || $data=='0' ) ? null : $data;
		$input = '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';
	}
	
	//return $input . "|$akhir\r";
	//return $input . "|$key\r";
	return $input;
}

function inputTextInputOutput($kira, $jum, $io, $jadual, $key, $data)
{    // istihar pembolehubah 
	$lajur = $kira+1; //kira3($kira+1, 1);
	// kira baris akhir dan kedua akhir
	$akhir = $jum - $lajur;
	$buangOutput = array('F22','F23','F24','F28','F29');
	$buangInput = array('F22','F24','F25');
	//$masukOutput = array('F25','F26','F27');
	//$masukInput = array('F23');
	if (in_array($key,$io))
		$input = $data;
	// jika $key adalah jumlah besar dan nilai lain2
	elseif ( ($akhir==1 || $akhir==0) 
		&& $jadual == 'kodOutput')
	{
		$lajur = ($akhir==0) ? 'jum':'lain2';
		$baris = $key . '-' . $lajur;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$input = (in_array($key,$buangOutput)) ? 
				$data : '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';			
	}
	elseif ( ($akhir==1 || $akhir==0) 
		&& $jadual == 'kodInput')
	{
		$lajur = ($akhir==0) ? 'jum':'lain2';
		$baris = $key . '-' . $lajur;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';
		$input = (in_array($key,$buangOutput)) ? 
				$data : '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';
	}
	elseif ($key=='nama_produk')
	{
		$lajur = kira3($kira+1, 2);
		$name = ($jadual == 'kodInput') ?
			'name="' . $jadual . '[F25' . $lajur . ']" id="' . $baris . '"'
			: 'name="' . $jadual . '[F30' . $lajur . ']" id="' . $baris . '"';
		$input = '<div class="input-prepend">'
			   //. '<span class="add-on">produk-' . $lajur . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-medium"></div>';
	}
	else
	{
		$baris = $key;
		$name = 'name="' . $jadual . '[' . $baris . ']"'
			  . ' id="' . $baris . '"';		
		$input = '<div class="input-prepend">'
			   //. '<span class="add-on">' . $baris . '</span>' 
			   . '<input type="text" ' . $name . ' value="' 
			   . $data . '" class="input-mini"></div>';
	}
	
	//return $input . "|$akhir\r";
	return $input . "\r";
}


function semakMedanDaftar($myTable, $nama, $jenis, $data) 
{
	return $myTable.'->'.$nama.'->'.$jenis.'='.$data;
}

function paparMedanDaftar($myTable, $nama, $jenis, $data) 
{
	$namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
			   . 'id="' . $nama . '"';
	$papar = null;
	
	if ($nama == 'password')
	{
		$papar = '<input type="password" ' . $namaMedan . ' class="span3">';
	}
	elseif ($nama == 'level')
	{
		$papar = '<select ' . $namaMedan . '>';
		$senaraiLevel= array('baru');
		
		foreach ($senaraiLevel as $key => $value)
		{
			$papar .= '<option value="' . $value . '">'
				   . ucfirst(strtolower($value)) 
				   . '</option>';
		}
		$papar .= '</select>';

	}
	elseif ($nama == 'jantina')
	{
		$papar = '<select ' . $namaMedan . '>';
		$senaraiJantina = array('lelaki','perempuan');
		
		foreach ($senaraiJantina as $key => $value)
		{
			$papar .= '<option value="' . $value . '">'
				   . ucfirst(strtolower($value)) 
				   . '</option>';
		}
		$papar .= '</select>';
	}
	else
	{
		$papar = inputDaftar($jenis, $namaMedan, $data);
	}

	return $papar;
}

function inputDaftar($jenis, $namaMedan, $data)
{
		switch ($jenis) 
		{// mula - pilih type
		case 'varchar(15)':
			$papar = '<input type="text" ' . $namaMedan . ' class="span2">';
			break;
		case 'varchar(20)':
			$papar = '<input type="text" ' . $namaMedan . ' class="span3">';
			break;
		case 'varchar(35)':
			$papar = '<input type="text" ' . $namaMedan . ' class="span4">';
			break;
		case 'varchar(50)':
			$papar = '<input type="text" ' . $namaMedan . ' class="span5">';
			break;		
		case 'date':
			$papar = '<input type="text" ' . $namaMedan . ' class="input-small tarikh" readonly">';
			break;
		case 'text':
			$jenisText = $namaMedan . ' rows="3" cols="30" ';
			$papar = '<textarea ' . $jenisText . '></textarea>';
			break;
		default: 
			$papar="$namaMedan-$jenis-$data"; 
			break;
		}// tamat - pilih type

		return $papar;
}

function paparMedanDaftarSesi($myTable, $nama, $jenis, $data, $sesi) 
{
	$namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
			   . 'id="' . $nama . '"';
	$papar = null;
		
	if ($nama == 'nama_penuh')
	{
		$papar = '<input type="text" ' . $namaMedan 
			   . ' value="' . $sesi['namaPenuh'] . '" class="span4">';
	}
	elseif ($nama == 'namapengguna')
	{
		$papar = '<input type="text" ' . $namaMedan 
		       . ' value="' . $sesi['pengguna'] . '" class="span4">';

	}
	elseif ($nama == 'level')
	{
		$papar = '<select ' . $namaMedan . '>';
		$senaraiPengguna= array('baru');
		
		foreach ($senaraiPengguna as $key => $value)
		{
			$papar .= '<option value="' . $value . '"';
			$papar .= ($value == $sesi['level']) ? ' selected >' : '>';
			$papar .= ucfirst(strtolower($value));
			$papar .= '</option>';
		}
		$papar .= '</select>';

	}
	elseif ($nama == 'jantina')
	{
		$papar = '<select ' . $namaMedan . '>';
		$senaraiJantina = array('lelaki','perempuan');
		
		foreach ($senaraiJantina as $key => $value)
		{
			$papar .= '<option value="' . $value . '">'
				   . ucfirst(strtolower($value)) 
				   . '</option>';
		}
		$papar .= '</select>';
	}
	elseif ($nama == 'password')
	{
		$papar = '<input type="password" ' . $namaMedan . ' class="span3">';
	}
	elseif ($nama == 'level')
	{
		$papar = '';
	}
	else
	{
		$papar = inputDaftar($jenis, $namaMedan, $data);
	}

	return $papar;
}

function ubahMedanSesi($myTable, $nama, $jenis, $data) 
{
	$namaMedan = 'name="' . $myTable . '[' . $nama . ']" '
			   . 'id="' . $nama . '"';

	//$papar = null;
		
	if ($nama == 'level')
	{
		/*
		$papar = '<select ' . $namaMedan . '>';
		$senaraiPengguna= array('baru');
		
		foreach ($senaraiPengguna as $key => $value)
		{
			$papar .= '<option value="' . $value . '"';
			$papar .= ($value == $data) ? ' selected >' : '>';
			$papar .= ucfirst(strtolower($value));
			$papar .= '</option>';
		}
		$papar .= '</select>';
		*/
		$papar = null;

	}
	elseif ($nama == 'jantina')
	{
		$papar = '<select ' . $namaMedan . '>';
		$senaraiJantina = array('lelaki','perempuan');
		
		foreach ($senaraiJantina as $key => $value)
		{
			$papar .= '<option value="' . $value . '"';
			$papar .= ($value == $data) ? ' selected >' : '>';
			$papar .= ucfirst(strtolower($value));
			$papar .= '</option>';
		}
		$papar .= '</select>';
	}
	elseif ($nama == 'password')
	{
		$papar = '<input type="password" ' . $namaMedan . ' value="' . $data . '" class="span3">';
	}
	else
	{
		$papar = ubahInputDaftar($jenis, $namaMedan, $data);
	}

	return $papar;
}

function ubahInputDaftar($jenis, $namaMedan, $data)
{
		switch ($jenis) 
		{// mula - pilih type
		case 'varchar(15)':
			$papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span2">';
			break;
		case 'varchar(20)':
			$papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span3">';
			break;
		case 'varchar(35)':
			$papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span4">';
			break;
		case 'varchar(50)':
			$papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="span5">';
			break;
		case 'date':
			$papar = '<input type="text" ' . $namaMedan . ' value="' . $data . '" class="input-small tarikh" readonly">';
			break;
		case 'text':
			$jenisText = $namaMedan . ' rows="3" cols="30" ';
			$papar = '<textarea ' . $jenisText . '>' . $data . '</textarea>';
			break;
		default: 
			$papar="$namaMedan-$data"; 
			break;
		}// tamat - pilih type

		return $papar;
}

// semak data
function semakDataPOST($semua)
{
			foreach ($_POST as $myTable => $value)
			{	
				if ( in_array($myTable,$semua) ):
					//echo "myTable : $myTable <br>";
					foreach ($value as $kekunci => $papar):
						$ubahMedan = $_POST['medan'][$myTable][$kekunci];
						if ($kekunci != $ubahMedan)
						{	/*echo "$myTable - $kekunci = $ubahMedan | berubah :"
							. '$posmen['.$myTable.']['.$ubahMedan.'] '
							. '<= $posmen['.$myTable.']['.$kekunci.']='
							. bersih($papar) . '<br>';*/
							
							$posmen[$myTable][$ubahMedan] = bersih($papar);
							unset($posmen[$myTable][$kekunci]);
						}
						elseif ($papar == null || $papar == '0')
							unset($posmen[$myTable][$kekunci]);
						else 
							$posmen[$myTable][$kekunci] = bersih($papar);
						
					endforeach;
				endif;
			}
	
	return $posmen;
}
// mula untuk kod php+html 
function papar_jadual($row, $myTable, $pilih)
{
	if ($pilih == 1) 
	{
///////////////////////////////////////////////////////////////////////////////////////////////////
		?><!-- Jadual <?php echo $myTable ?> -->	
		<table  border="1" class="excel" id="example"><?php
		// mula bina jadual
		$printed_headers = false; 
		#-----------------------------------------------------------------
		for ($kira=0; $kira < count($row); $kira++)
		{	//print the headers once: 	
			if ( !$printed_headers ) : ?>
		<thead><tr>
		<th>#</th><?php foreach ( array_keys($row[$kira]) as $tajuk ) :
		?><th><?php echo $tajuk ?></th>
		<?php endforeach; ?>  
		</tr></thead>
		<?php	$printed_headers = true; 
			endif;
		#-----------------------------------------------------------------		 
		//print the data row ?>
		<tbody><tr>
		<td><?php echo $kira+1 ?></td>	
		<?php foreach ( $row[$kira] as $key=>$data ) : 
		?><td><?php echo $data ?></td>
		<?php endforeach; ?>  
		</tr></tbody>
		<?php
		}
		#-----------------------------------------------------------------
		?></table><!-- Jadual <?php echo $myTable ?> --><?php
///////////////////////////////////////////////////////////////////////////////////////////////////
	}
	elseif ($pilih == 2) 
	{
///////////////////////////////////////////////////////////////////////////////////////////////////
		?><!-- Jadual <?php echo $myTable ?> -->	
		<table  border="1" class="excel" id="example"><?php
		// mula bina jadual
		$printed_headers = false; 
		#-----------------------------------------------------------------
		for ($kira=0; $kira < count($row); $kira++)
		{	//print the headers once: 	
			if ( !$printed_headers ) : ?>
		<thead><tr>
		<th>#</th><?php
				foreach ( array_keys($row[$kira]) AS $tajuk ) 
				{ 	if ( !is_int($tajuk) ) :
						$paparTajuk = ($tajuk=='nama') ?
						$tajuk . '(jadual:' . $myTable . ')'
						: $tajuk; ?>
		<th><?php echo $paparTajuk ?></th>
		<?php		endif;
				}
		?></tr></thead><?php
				$printed_headers = true; 
			endif; 
		#-----------------------------------------------------------------		 
		//print the data row ?>
		<tbody><tr>
		<td><?php echo $kira+1 ?></td>	
		<?php
			foreach ( $row[$kira] AS $key=>$data ) 
			{
				if ($key=='sidap') :
					$sidap= $data;
					$ssm = substr($data,0,12); 
				elseif ($key=='nama') :
					$syarikat = $data;
				endif;
				?><td><?php echo $data ?></td>
		<?php
			} 
			?></tr></tbody>
		<?php
		}
		#-----------------------------------------------------------------
		?></table><!-- Jadual <?php echo $myTable ?> --><?php
///////////////////////////////////////////////////////////////////////////////////////////////////
	}
	elseif ($pilih == 3) 
	{
///////////////////////////////////////////////////////////////////////////////////////////////////
		?><!-- Jadual <?php echo $myTable ?>  --><?php
		for ($kira=0; $kira < count($row); $kira++)
		{// ulang untuk $kira++ ?>
		<table border="1" class="excel" id="example">
		<tbody><?php foreach ( $row[$kira] as $key=>$data ):?>
		<tr>
		<td><?php echo $key ?></td>
		<td><?php echo $data ?></td>
		</tr>
		<?php endforeach; ?></tbody>
		</table>
		<?php
		}// ulang untuk $kira++ ?>
		<!-- Jadual <?php echo $myTable ?> --><?php
///////////////////////////////////////////////////////////////////////////////////////////////////
	} // tamat if (jadual ==3
	elseif ($jadual == 4)
	{ // mula if (jadual==4
		$bil_tajuk = $row['bil_tajuk'];// => 8
		$bil_baris = $row['bil_baris']; 

		$output  = null; 
		//$output .= '<br>$bil_tajuk=' . $bil_tajuk;
		//$output .= '<br>$bil_baris=' . $bil_baris;
		$output .= '<table border="1" class="excel" id="example">
		<thead><tr>
		<th colspan="' . $bil_tajuk . '">
		<strong>Jadual ' . $myTable . ' : ' . $bil_tajuk . '
		</strong></th>
		</tr></thead>';

		// mula bina jadual
		$printed_headers = false; 
		#-----------------------------------------------------------------
		for ($kira=0; $kira < $bil_baris; $kira++)
		{
			//print the headers once: 	
			if ( !$printed_headers ) 
			{##============================================================
			$output .= "\r\t<thead><tr>\r\t<th>#</th>";
			foreach ( array_keys($row[$kira]) as $tajuk ) :
				$output .= "\r\t" . '<th>' . $tajuk . '</th>';
			endforeach;
			$output .= "\r\t" . '</tr></thead>';
			##=============================================================
				$printed_headers = true; 
			} 
		#-----------------------------------------------------------------		 
			//print the data row 
			$output .= "\r\t<tbody><tr>\r\t<td>" . ($kira+1) . '</td>';
			foreach ( $row[$kira] as $key=>$data ) :
				$output .= "\r\t" . '<td>' . $data . '</td>';
			endforeach; 
			$output .= "\r\t" . '</tr></tbody>';
		}
		#-----------------------------------------------------------------
		$output .= "\r\t" . '</table>';

		return $output;

	} // tamat if ($jadual == 4
}
// tamat untuk kod php+html 
// sql limit
function pencamSqlLimit($bilSemua, $item, $ms)
{
    // Tentukan bilangan jumlah dalam DB:
    $jum['bil_semua'] = $bilSemua;
    // ambil halaman semasa, jika tiada, cipta satu! 
    $jum['page'] = ( !isset($ms) ) ? 1 : $ms; // mukasurat
    // berapa item dalam satu halaman
    $jum['max'] = ( !isset($item) ) ? 30 : $item; // item
    // Tentukan had query berasaskan nombor halaman semasa.
    $dari = (($jum['page'] * $jum['max']) - $jum['max']); 
    $jum['dari'] = ( !isset($dari) ) ? 0 : $dari; // dari
    // Tentukan bilangan halaman. 
    $jum['muka_surat'] = ceil($jum['bil_semua'] / $jum['max']);
    // nak tentukan berapa bil jumlah dlm satu muka surat
    $jum['bil'] = $jum['dari']+1; 
    
    return $jum;
}
// format perpuluhan
function kiraPerpuluhan($kiraan, $perpuluhan = 1)
{
	// pecahan kepada ratus
	return number_format($kiraan,$perpuluhan,'.',',');
} 

function kira($kiraan)
{
	// pecahan kepada ratus
	return number_format($kiraan,0,'.',',');
} 

function kira2($dulu,$kini)
{
	// buat bandingan dan pecahan kepada ratus
	return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
	//@$kiraan=(($kini-$dulu)/$dulu)*100;
}

function kira3($kira,$n) 
{
	return str_pad($kira,$n,"0",STR_PAD_LEFT);
}

function pilihKeyData($key,$keyData,$data)
{
	//echo '$key:' . $key; single key
	//echo '$keyData:[' . $keyData[$key] . ']';
	//echo '$data:[' . $data[$keyData[$key]]  . ']';
	return $keyData[$key];
}

function pilihValueData($key,$keyData,$data)
{
	//echo '$key:' . $key; single key
	//echo '$keyData:[' . $keyData[$key] . ']';
	//echo '$data:[' . $data[$keyData[$key]]  . ']';
	return $data[$keyData[$key]];
}


function huruf($jenis , $papar) 
{
	/*
	$_POST=strtoupper($_POST['mdt_rangka']['respon']);
	$_POST=strtolower($_POST['mdt_rangka']['fe']);
	$_POST=mb_convert_case($_POST, MB_CASE_TITLE);
	ucfirst
	*/
	
	switch ($jenis) 
	{// mula - pilih $jenis
	case "BESAR":
		$papar = strtoupper($papar);
		break;
	case "kecil":
		$papar = strtolower($papar);
		break;
	case "Besar":
		$papar = ucfirst($papar);
		break;
	case "Besar_Depan":
		$papar = mb_convert_case($papar, MB_CASE_TITLE);
		break;
	}// tamat - pilih $jenis
	
	return $papar;

}

function bersih($papar) 
{
	# lepas lari aksara khas dalam SQL
	//$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
	$papar = trim($papar);
	
	return $papar;
}

function gambar_latarbelakang($lokasi)
{
	// '$lokasi=' . $lokasi;
    $tmpt1 = '../private_html/bg/bg'; // utk localhost
	//$tmpt1 = '../../../private_html/bg/bg'; // utk localhost
    //$tmpt2 = '../../../../bssu/bg/bg'; // utk website amin007
	//$tmpt = ($lokasi=='localhost') ? $tmpt1 : $tmpt2;
    $dh = opendir($tmpt1);
    $i=1;
    while (($file = readdir($dh)) !== false) 
    {
        if($file != "."
            && $file != ".."
            && $file != "Thumbs.db"
            && $file != "index.html"
            && $file != "index.php") 
        {
            if ($file=='index.php') {echo "";}
            elseif (is_dir($file)==false) 
            { 
                //echo "\n" . $i++ . ")" . $file . "<br>";
                $gambar = $file;
                if (substr($gambar,-3) == 'jpg') 
                    $papar[]=$gambar;
            }
        }
 
    }
    closedir($dh);
 
    /*
    foreach(scandir($tmpt) as $gambar) 
    {
        if (substr($gambar,-3) == 'jpg') 
            $papar[]=$gambar;
    }
    */
     
    $today = rand(0, count($papar)-1); 
    return $papar[$today];
}

function cari_imej($ssm,$strDir)
{
	//require_once ('public/skrip/listfiles2/dir_functions.php');

	if ( isset($ssm) && empty($ssm) )
	{
		$cariImej = null;
	}
	else
	{
		// You can modify this in case you need a different extension
		$strExt = "tif";

		// This is the full match pattern based upon your selections above
		$pattern = "*" . $ssm . "*." . $strExt;
		//echo '<br> Fungsi.php -> $strDir=' . $strDir;
		$cariImej = GetMatchingFiles(GetContents($strDir),$pattern);
	}
	
	//print_r($cariImej);
	return $cariImej;
}
// lisfile2 - mula
function GetMatchingFiles($files, $search) 
{
	// Split to name and filetype
	if(strpos($search,".")) 
	{
		$baseexp=substr($search,0,strpos($search,"."));
		$typeexp=substr($search,strpos($search,".")+1,strlen($search));
	} 
	else 
	{ 
		$baseexp=$search;
		$typeexp="";
	} 
		
	// Escape all regexp Characters 
	$baseexp=preg_quote($baseexp); 
	$typeexp=preg_quote($typeexp); 
		
	// Allow ? and *
	$baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
	$typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);
		   
	// Search for Matches
	$i=0;
	$matches=null; // $matches adalah array()
	foreach($files as $file) 
	{
		$filename=basename($file);
			  
		if(strpos($filename,".")) 
		{
			$base=substr($filename,0,strpos($filename,"."));
			$type=substr($filename,strpos($filename,".")+1,strlen($filename));
		} 
		else 
		{ 
			$base=$filename;
			$type="";
		}

		if(preg_match("/^".$baseexp."$/i",$base) && preg_match("/^".$typeexp."$/i",$type))  
		{
			$matches[$i]=$file;
			$i++;
		}
	}
	
	return $matches;
}

// Returns all Files contained in given dir, including subdirs
function GetContents($dir,$files=array()) 
{
	if(!($res=opendir($dir))) exit("$dir doesn't exist!");
		while(($file=readdir($res))==TRUE) 
		if($file!="." && $file!="..")
			if(is_dir("$dir/$file")) 
				$files=GetContents("$dir/$file",$files);
			else array_push($files,"$dir/$file");
		 
	closedir($res);
	return $files;
}
// listfile2 - tamat
