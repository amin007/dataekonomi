<?php

class BorangPapar
{ # untuk papar data ekonomi
####################################################################################################################################
#----------------------------------------------------------------------------------------------------------------------
	public static function semakJenis($sv, $kunci, $var)
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
#----------------------------------------------------------------------------------------------------------------------
	public static function keterangan($key, $data, $myTable, $dataKeterangan)
	{
		//echo '<hr><pre>$dataKeterangan='; print_r($dataKeterangan[$myTable]) . '</pre>';
		$thn = ($key=='thn') ? $data : 2010; 
		$keterangan = !isset($dataKeterangan[$myTable][$key][$thn]) ?
			'' : $dataKeterangan[$myTable][$key][$thn];

		return $keterangan;
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function paparDataBrgAm($sv, $myTable, $row, $dataKeterangan, $senaraiMedan)
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
				$data : BorangPapar::semakJenis($sv, $key, $data) ?></td>
			</tr><?php endforeach ?>
			</table>
			</td><?php
		}#-----------------------------------------------------------------?>
		</tr></table><?php
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function paparData($sv, $myTable, $row, $dataKeterangan, $senaraiMedan)
	{?>	<table><tr><?php # mula bina jadual
		#-----------------------------------------------------------------
		for ($kira=0; $kira < count($row); $kira++)
		{?><td valign="top">
			<table border="1" class="excel" id="example"><?php 
			foreach ( $row[$kira] as $key=>$data ) : 
			echo "\n\t\t\t"; 
			?><tr><td><?php echo "\n\t\t\t" . '<abbr title="' 
			. BorangPapar::keterangan($key, $data, $myTable, $dataKeterangan) . '">' // <abbr title=""> 
			. $key . '</abbr>'; ?></td><td align="right"><?php 
			echo (in_array($key, $senaraiMedan)) ? 
				$data : BorangPapar::semakJenis($sv, $key, $data) ?></td>
			</tr><?php endforeach ?>
			</table>
			</td><?php
		}#-----------------------------------------------------------------?>
		</tr></table><?php
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function paparDataRingkas($sv, $myTable, $row, $dataKeterangan, $senaraiMedan)
	{?>	<table><tr><?php # mula bina jadual
		#-----------------------------------------------------------------
		for ($kira=0; $kira < count($row); $kira++)
		{?><td valign="top">
			<table border="1" class="excel" id="example"><?php 
			foreach ( $row[$kira] as $key=>$data ) : 
			echo "\n\t\t\t"; 
			?><tr><td><?php echo "\n\t\t\t" . '<abbr title="' 
			. BorangPapar::keterangan($key, $data, $myTable, $dataKeterangan) . '">' // <abbr title=""> 
			. $key . '</abbr> : ' . "\t";
			echo (in_array($key, $senaraiMedan)) ? 
				$data : BorangPapar::semakJenis($sv, $key, $data) ?></td>
			</tr><?php endforeach ?>
			</table>
			</td><?php
		}#-----------------------------------------------------------------?>
		</tr></table><?php
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function paparKodProduk($sv, $myTable, $row)
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
		#- print the data row --------------------------------------------?>
		<tbody><tr>
		<td><?php echo $kira+1 ?></td>	
		<?php foreach ( $row[$kira] as $key=>$data ) :?>
		<td align="right"><?php echo (in_array($key, 
			array('thn','Estab','F3001','nama_produk','Commodity'))) ? 
			$data : BorangPapar::semakJenis($sv, $key, $data) ?></td>
		<?php endforeach ?>
		</tr></tbody>
		<?php 
		} // endfor $kira ?></table><?php
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function keterangan_medan($key)
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
#----------------------------------------------------------------------------------------------------------------------
	public static function pilihTajuk($tajuk, $jadual)
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
			# kod output	
			$tukarTajuk['kodOutput'] = array(
				'F2201'=>'M22','F2301'=>'M23','F2401'=>'M24',
				'F2501'=>'Jualan(RM)','F2601'=>'M26(RM)','F2701'=>'M27(RM)',
				'F2501(RM)'=>'Jualan(RM)','F2601(RM)'=>'M26(RM)','F2701(RM)'=>'M27(RM)',
				'F2801'=>'M28','F2901'=>'M29');
			# kod input
			$tukarTajuk['kodInput'] = array(
				'F2201'=>'M22','F2301'=>'F23(RM)','F2401'=>'M24');
				
		return isset($tukarTajuk[$jadual][$tajuk]) ? $tukarTajuk[$jadual][$tajuk] : $tajuk;
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function cariMedanInput($ubah,$f,$row,$nama) 
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
		$cariText = array(0); # papar jika nota ada
		$cariMsic = array(8); # papar input text msic sahaja 
		$namaM = $ubah .'[' . $nama . ']';
			
		# tentukan medan yang ada input
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
#----------------------------------------------------------------------------------------------------------------------
	public static function inputTextMedan($jadual, $key)
	{    // istihar pembolehubah 
		$name = 'name="medan[' . $jadual . '][' . $key . ']"'
			  . ' id="' . $key . '"';

		$input = $key . '</td><td>'
			   . '<input type="text" ' . $name . ' value="' 
			   . $key . '" class="input-medium">';

		return $input . "\r";
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function inputText($jadual, $key, $data)
	{    // istihar pembolehubah 
		$name = 'name="' . $jadual . '[' . $key . ']"'
			  . ' id="' . $key . '"';
		$medanApa = $jadual . '[' . $key . ']';
		$input = '<div class="input-prepend">' . $jadual
			   //. '<span class="add-on">' . $medanApa . '</span>'
			   . '<input type="text" ' . $name . ' value="'
			   . $data . '" class="input-medium"></div>';

		return '<td>' . $input . '</td>';
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function inputText2($kira, $jum, $io, $jadual, $key, $data)
	{	# istihar pembolehubah 
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
				$input = $data;
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
			$baris = 'namaProduk';
			$name = 'name="' . $jadual . '[' . $kira . '][' . $baris . ']"'
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
		//elseif ( $jadual == 'output' || $jadual == 'input')
		elseif ( in_array($jadual,array('output','input','teamgenius')) )
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
#----------------------------------------------------------------------------------------------------------------------
	public static function inputTextInputOutput($kira, $jum, $io, $jadual, $key, $data)
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
#----------------------------------------------------------------------------------------------------------------------
	public static function semakMedanDaftar($myTable, $nama, $jenis, $data) 
	{
		return $myTable.'->'.$nama.'->'.$jenis.'='.$data;
	}
#----------------------------------------------------------------------------------------------------------------------
	public static function paparMedanDaftar($myTable, $nama, $jenis, $data) 
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
#----------------------------------------------------------------------------------------------------------------------
	public static function inputDaftar($jenis, $namaMedan, $data)
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
#----------------------------------------------------------------------------------------------------------------------
	public static function paparMedanDaftarSesi($myTable, $nama, $jenis, $data, $sesi) 
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
#----------------------------------------------------------------------------------------------------------------------
	public static function ubahMedanSesi($myTable, $nama, $jenis, $data) 
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
#----------------------------------------------------------------------------------------------------------------------
	public static function ubahInputDaftar($jenis, $namaMedan, $data)
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
#----------------------------------------------------------------------------------------------------------------------
####################################################################################################################################
}