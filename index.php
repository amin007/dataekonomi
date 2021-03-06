<?php
/*
 * Ini fail index.php
 * Dalam ini kita isytiharkan
 * 1. laporan tahap kesilapan kod PHP
 * 2. zon masa kita pada Asia/Kuala Lumpur
 * 3. setkan tatarajah sistem
 * 4. masukkan semua fail class dari folder PUSTAKA
 * 5. istihar class Mulakan
 */
 
# 1. laporan tahap kesilapan kod PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', -1);
 
# 2. isytiharkan zon masa => Asia/Kuala Lumpur
date_default_timezone_set('Asia/Kuala_Lumpur');
 
# 3. setkan tatarajah sistem
require 'tatarajah.php';

# 4. masukkan semua fail class dari folder PUSTAKA
#    Also spl_autoload_register (Take a look at it if you like)
function __autoload($class)
{
	//echo '$class=' .$class . '<hr>';
	$cariFail = GetMatchingFiles(GetContents('aplikasi'),$class . '.php');
	//echo '<pre>$cariFail='; print_r($cariFail) . '</pre>';
	//echo '$failPustaka->' . $cariFail[0] . '<br>';
	require $cariFail[0];
}

# 5. istihar class Mulakan
$aplikasi = new Mulakan();
