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
	# define('ALAMAT_IP', serialize (array()) );
	$IP = unserialize(ALAMAT_IP);

	return $IP;
}

function senarai_kakitangan()
{
	# define('PEGAWAI', serialize (array()) );
	$pegawai = unserialize(PEGAWAI);

    return $pegawai;
}

function dpt_senarai($namajadual)
{
	$e = null; //'pom_dataekonomi.';
	$e2 = 'pom_projek.';
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
		$e.'mcpa2009_tr2014',
		$e.'mcpa2009_input',
		/*'kodproduk_unitkuantiti'*/);
	elseif ($namajadual=='syarikat')
	{
		$t = 12;
		$jadual = array('kawal_icdt'.$t,
		'5p_icdt'.$t,'rangka_icdt'.$t,
		'alamat_icdt'.$t);
	}
	elseif ($namajadual=='datalama')
	{
		$jadual = array(
			$e2.'pp',$e2.'inlis3',$e2.'pp1malaysia',
			$e2.'dba_rob',/*$e2.'profilrob',*/$e2.'dba_roc',
			$e2.'sidap',$e2.'sisfor',
			$e2.'am2010',$e2.'`kawalan_ekonomi2005-2009`'
			);
	}
	elseif ($namajadual=='kawalan_tahunan')
	{
		$jadual = array(
			'kawal_ppmas09',
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
		$jadual = array('pom_lokaliti.johor',
			'pom_lokaliti.lk_johor');
	elseif ($namajadual=='malaysia')
		$jadual = array('kedah','kelantan','melaka','negeri9',
			'pahang','penang','perak','perlis','selangor','terengganu',
			'sabah','sarawak','kl','labuan','putrajaya');
	
	return $jadual;
}

function harga_unit_purata()
{?>
	<table><tr><td>
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
	</td><td valign="top">
	<!-- ======================================================================= -->
		<table border="1" class="excel">
		<tr><td colspan="3">Jika pertubuhan mengeluarkan kuasa elektrik sendiri tetapi tidak menyimpan <br>
		rekod bagi nilai kuasa elektrik yang digunakan/dijual, keterangan berikut adalah <br>
		dikehendaki untuk mendapatkan jumlah kuasa elektrik yang dijanakeluarkan :-
		</td></tr>
		<tr><td>(i)</td><td>Kuasa kuda generator</td><td>(h.p. = n1)</td></tr>
		<tr><td>(ii)</td><td>Bil.Jam sehari generator bergerak</td><td>(jam = M)</td></tr>
		<tr><td>(iii)</td><td>Bil. Hari pertubuhan beroperasi</td><td>(hari = Y)</td></tr>
		<tr><td colspan="3">
			1 h.p. = 0.746 k.w.j.<br>k.w.j. = n1 x 0.746 x M x Y<br>
			Jika n2 KVA (kilo-volt amphere) diberi,	menggantikan kuasa kuda iaitu<br>
			(n1 h.p.), k.w.j. = n2 x 0.8 x Y x M
		</td></tr>
		</table>
	<!-- ======================================================================= -->
	</td></tr></table>
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

# semak data
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
# mula untuk kod php+html 
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
		{	#print the headers once: 	
			if ( !$printed_headers ) : ?>
		<thead><tr>
		<th>#</th><?php foreach ( array_keys($row[$kira]) as $tajuk ) :
		?><th><?php echo $tajuk ?></th>
		<?php endforeach; ?>  
		</tr></thead>
		<?php	$printed_headers = true; 
			endif;
		#-----------------------------------------------------------------
		#print the data row ?>
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
		# mula bina jadual
		$printed_headers = false; 
		#-----------------------------------------------------------------
		for ($kira=0; $kira < count($row); $kira++)
		{	#print the headers once: 	
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
		#print the data row ?>
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
		{# ulang untuk $kira++ ?>
		<table border="1" class="excel" id="example">
		<tbody><?php foreach ( $row[$kira] as $key=>$data ):?>
		<tr>
		<td><?php echo $key ?></td>
		<td><?php echo $data ?></td>
		</tr>
		<?php endforeach; ?></tbody>
		</table>
		<?php
		}# ulang untuk $kira++ ?>
		<!-- Jadual <?php echo $myTable ?> --><?php
///////////////////////////////////////////////////////////////////////////////////////////////////
	} # tamat if (jadual ==3
	elseif ($jadual == 4)
	{ # mula if (jadual==4
		$bil_tajuk = $row['bil_tajuk'];# => 8
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

		# mula bina jadual
		$printed_headers = false; 
		#-----------------------------------------------------------------
		for ($kira=0; $kira < $bil_baris; $kira++)
		{
			#print the headers once: 	
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
			#print the data row 
			$output .= "\r\t<tbody><tr>\r\t<td>" . ($kira+1) . '</td>';
			foreach ( $row[$kira] as $key=>$data ) :
				$output .= "\r\t" . '<td>' . $data . '</td>';
			endforeach; 
			$output .= "\r\t" . '</tr></tbody>';
		}
		#-----------------------------------------------------------------
		$output .= "\r\t" . '</table>';

		return $output;

	} # tamat if ($jadual == 4
}
# tamat untuk kod php+html 
# sql limit
function pencamSqlLimit($bilSemua, $item, $ms)
{
    # Tentukan bilangan jumlah dalam DB:
    $jum['bil_semua'] = $bilSemua;
    # ambil halaman semasa, jika tiada, cipta satu! 
    $jum['page'] = ( !isset($ms) ) ? 1 : $ms; # mukasurat
    # berapa item dalam satu halaman
    $jum['max'] = ( !isset($item) ) ? 30 : $item; # item
    # Tentukan had query berasaskan nombor halaman semasa.
    $dari = (($jum['page'] * $jum['max']) - $jum['max']); 
    $jum['dari'] = ( !isset($dari) ) ? 0 : $dari; # dari
    # Tentukan bilangan halaman. 
    $jum['muka_surat'] = ceil($jum['bil_semua'] / $jum['max']);
    # nak tentukan berapa bil jumlah dlm satu muka surat
    $jum['bil'] = $jum['dari']+1; 

    return $jum;
}
# format perpuluhan
function kiraPerpuluhan($kiraan, $perpuluhan = 1)
{
	# pecahan kepada ratus
	return number_format($kiraan,$perpuluhan,'.',',');
}

function kira($kiraan)
{
	# pecahan kepada ratus
	return number_format($kiraan,0,'.',',');
}

function kira2($dulu,$kini)
{
	# buat bandingan dan pecahan kepada ratus
	return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
	//@$kiraan=(($kini-$dulu)/$dulu)*100;
}

function kira3($kira,$no) 
{
	return str_pad($kira,$no,"0",STR_PAD_LEFT);
}

function kira4($kira,$no,$jenis='&nbsp') 
{
	return str_pad($kira,$no,$jenis,STR_PAD_LEFT);
}

function pilihKeyData($key,$keyData,$data)
{
	//echo '$key:' . $key; # single key
	//echo '|$keyData:[' . $keyData[$key] . ']';
	//echo '|$data:[' . $data[$keyData[$key]]  . ']<br>';
	return $keyData[$key];
}

function pilihValueData($key,$keyData,$data)
{
	//echo '$key:' . $key; # single key
	//echo '$keyData:[' . $keyData[$key] . ']';
	//echo '$data:[' . $data[$keyData[$key]]  . ']';
	return $data[$keyData[$key]];
}

function huruf($jenis , $papar) 
{
	/*
	$_POST=strtoupper($_POST['']['']);
	$_POST=strtolower($_POST['']['']);
	$_POST=mb_convert_case($_POST[''][''], MB_CASE_TITLE);
	ucfirst
	*/
	
	switch ($jenis) 
	{# mula - pilih $jenis
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
	}# tamat - pilih $jenis

	return $papar;
}

function highlightTeks($data)
{
	# set pembolehubah
	$label = pilihLabel('badge');
	$button = pilihButton('Success');
	# Now we can highlight the terms
	$teks_panjang = ''
		. '<span class="' . $label . '">' . $data . '</span>'
		//. '<a href="#" class="' . $button . '">' . $cari . '</a>'
		. '';
	# lastly, return text string with highlighted term in it
	return $teks_panjang;
}

function highlightTerms($teks_panjang, $cari)
{
	## use preg_quote 
	$cari = preg_quote($cari);
	$label = pilihLabel('badge');
	$button = pilihButton('Success');
	## Now we can highlight the terms
	$teks_panjang = preg_replace("/\b($cari)\b/i",
		'<span class="' . $label . '">' . $cari . '</span>',
		//'<a href="#" class="' . $button . '">' . $cari . '</a>',
		$teks_panjang);
	## lastly, return text string with highlighted term in it
	return $teks_panjang;
}

function pilihLabel($p)
{
	if($p=='highlight') $c = 'highlight';
	if($p=='badge') $c = 'badge';
	if($p=='Default') $c = 'label label-default';
	if($p=='Primary') $c = 'label label-primary';
	if($p=='Success') $c = 'label label-success';
	if($p=='Warning') $c = 'label label-warning';
	if($p=='Danger') $c = 'label label-danger';
	if($p=='Info') $c = 'label label-info';

	return $c;
}

function pilihButton($p)
{
	if($p=='highlight') $c = 'highlight';
	if($p=='Default') $c = 'btn btn-default';
	if($p=='Primary') $c = 'btn btn-primary';
	if($p=='Success') $c = 'btn btn-success';
	if($p=='Warning') $c = 'btn btn-warning';
	if($p=='Danger') $c = 'btn btn-danger';
	if($p=='Info') $c = 'btn btn-info';
	if($p=='Link') $c = 'btn btn-link';

	return $c;
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
    $tmpt1 = '../private_html/bg/bg'; # utk localhost
	//$tmpt1 = '../../../private_html/bg/bg'; # utk localhost
    //$tmpt2 = '../../../../bssu/bg/bg'; # utk website amin007
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
	#require_once ('public/skrip/listfiles2/dir_functions.php');

	if ( isset($ssm) && empty($ssm) )
	{
		$cariImej = null;
	}
	else
	{
		# You can modify this in case you need a different extension
		$strExt = "tif";

		# This is the full match pattern based upon your selections above
		$pattern = "*" . $ssm . "*." . $strExt;
		#echo '<br> Fungsi.php -> $strDir=' . $strDir;
		$cariImej = GetMatchingFiles(GetContents($strDir),$pattern);
	}

	//print_r($cariImej);
	return $cariImej;
}
# lisfile2 - mula
function GetMatchingFiles($files, $search) 
{
	# Split to name and filetype
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

	# Escape all regexp Characters 
	$baseexp=preg_quote($baseexp); 
	$typeexp=preg_quote($typeexp); 

	# Allow ? and *
	$baseexp=str_replace(array("\*","\?"), array(".*","."), $baseexp);
	$typeexp=str_replace(array("\*","\?"), array(".*","."), $typeexp);

	# Search for Matches
	$i=0;
	$matches=null; # $matches adalah array()
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

# Returns all Files contained in given dir, including subdirs
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
# listfile2 - tamat