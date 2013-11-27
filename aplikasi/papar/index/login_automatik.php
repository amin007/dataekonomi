<div id="content" style="position:relative;height:100%;overflow:hidden" align="center">
<table border="0" align="center" width="100%" height="100%">
<tr><td align="center" style="background: url('<?php echo GAMBAR ?>') 
no-repeat center center fixed;background-size: cover;"><?php 
$ip  = $_SERVER['REMOTE_ADDR'];
$ip2 = substr($ip,0,10);
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$server = $_SERVER['SERVER_NAME'];

echo '<label style="background:#ffffff">' .
"<br>Alamat IP : <font color='red'>" . $ip . "</font> |" .
//"<br>Alamat IP2 : <font color='red'>" . substr($ip,0,10) . "</font> |" .
"\r<br>Nama PC : <font color='red'>" . $hostname . "</font> |" .
//"\r<br>Server : <font color='red'>" . $server . "</font>" .
"<br></label>\r";

//$senaraiIP=array('192.168.1.', '10.69.112.', '127.0.0.1', '10.72.112.');
if ( in_array($ip2,$this->IP) )
{?>
	<form method="post" action="<?php echo URL ?>login/semakid">
	<label style="background:#ffffff">anda ada kebenaran masuk sistem</label><br>
	<input name="username" type="hidden" value="<?php echo $this->nama ?>">
	<input name="password" type="hidden" value="<?php echo $this->nama ?>">
	<input type="submit" name="masuk" value="Masuk">
	</form>
<?php
}
else
{
	echo '<label style="background:#ffffff">' 
		. 'ip anda ' . $ip . ', anda tiada kebenaran masuk sistem'
		. "<br></label>\r";
}
?></td></tr>
</table>
</div>