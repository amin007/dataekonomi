<div class="container">

<h1>Senarai Kes Untuk Kawalan</h1>
<?php
//echo '<pre>$this->senaraiKes:'; print_r($this->senaraiKes) . '</pre>';
?>
<form method="post" action="ckawalan/cari">
<table><tr>
<td><input type="text" name="id[nama]" /></td>
<td><input type="submit" value="cari nama"/></td>
</tr></table>
</form>
<form method="post" action="ckawalan/cari">
<table><tr>
<td><input type="text" name="id[ssm]" /></td>
<td><input type="submit" value="cari ssm"/></td>
</tr></table>
</form>

</div><!--container-->