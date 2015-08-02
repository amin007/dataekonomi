<div class="container">

<h1><span style="background-color:black;color:white;">
Senarai Kes Untuk Kawalan
</span></h1>

<!--
<select class="form-control" id="sejarah" name="sejarah">
<option>Sila Pilih</option>
<option>Sebelum 2010</option>
<option>Selepas 2010</option>
</select>
-->
<table class="table"><tr><td>
<form class="form-inline" role="form" method="post" action="ckawalan/cari" id="fnama">
	<h2>Sebelum 2010</h2>
	<div class="form-group">
		<select class="form-control" name="jenisID">
		<option>Sidap</option><option>Nama</option><option>Operator</option>
		</select>
	</div><div class="form-group">
		<div class="input-group">
		<input class="form-control" type="text" name="id">
		</div>
	</div><div class="form-group">
	<input class="btn" type="submit" value="cari">
	</div>
</form>
</td><td>
<form class="form-inline" role="form" method="post" action="ckawalan/cari" id="fid">
<h2>Selepas 2010</h2>
<div class="form-group">
		<select class="form-control" name="jenisID">
		<option>Sidap</option><option>Newss</option><option>Nama</option><option>Operator</option>
		</select>
</div><div class="form-group">		
		<input class="form-control col-sm-4" type="text" name="id">
</div><div class="form-group">		
		<input class="btn" type="submit" value="cari">
</div>
</form>
</td>
</tr>
</table>
<br>
<form class="form-horizontal" role="form" method="post" action="ckawalan/proses">
<h2>Untuk BE 2011 TAHUN RUJUKAN 2010</h2>
	<div class="form-group">
<!-- ////////////////////////////////////////////////////////////////////////////////////// -->
		<label class="col-lg-1 control-label">SV</label>
		<div class="col-lg-1">
		<input type="text" class="form-control" placeholder="SV/KP" name="sv">
		</div>
		<label class="col-lg-1 control-label">NEWSS</label>
		<div class="col-lg-4">
		<input type="text" class="form-control" placeholder="NEWSS" name="newss">
		</div>
		<div class="col-lg-1">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
<!-- ////////////////////////////////////////////////////////////////////////////////////// -->
	</div>
</form>
<!-- >
<form class="form-horizontal" role="form" method="post" action="ckawalan/msic">
<h2>Cari MSIC Utk CDT & ICDT sahaja</h2>
	<div class="form-group">
		<label class="col-lg-1 control-label">MSIC</label>
		<div class="col-lg-1">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
		<div class="col-lg-3">
		<input type="text" class="form-control" placeholder="MSIC 2000" name="msic2000">
		</div>
		<div class="col-lg-3">
		<input type="text" class="form-control" placeholder="MSIC 2008" name="msic2008">
		</div>
	</div>
</form>
< -->
<form class="form-horizontal" role="form" method="post" action="ckawalan/msicbe2010">
<h2>Cari MSIC Utk BE2010 sahaja</h2>
	<div class="form-group">
		<label class="col-lg-1 control-label">MSIC</label>
		<div class="col-lg-1">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
		<div class="col-lg-3">
		<?php pautan() ?>
		</div>
		<div class="col-lg-3">
		<input type="text" class="form-control" placeholder="MSIC 2008" name="msic2008">
		</div>
		<div class="col-lg-3">
		<input type="text" class="form-control" placeholder="Bandar" name="bandar">
		</div>
	</div>
</form>

</div><!--container-->
<?php
function pautan($paparID = null, $jadual = null)
{
	$proses = array (
		//'surveyAm <-2009' => '../cprosesan/ubah/' . $ssm . '/2004/2009',
		//'surveyAm 2010->' => '../cprosesan/ubah/' . $id . '/2010/2012',
		//'CDT 2009->' => 'cdt',
		//'ICDT 2012->' => 'icdt',
		'101 2010-2012' => '101',
		'205 2010-2012' => '205',
		'206 2010-2012' => '206',
		'305 2010-2012' => '305',
		'306 2010-2012' => '306',
		'308 2010-2012' => '308',
		'309 2010-2012' => '309',
		'311 2010-2012' => '311',
		'312 2010-2012' => '312',
		'316 2010-2012' => '316',
		'328 2010-2012' => '328',
		'331 2010-2012' => '331',
		'334 2010-2012' => '334',
		'335 2010-2012' => '335',
		'800 2010-2012' => '800',
		'850 2010-2012' => '850',
		);
	
	echo "\t\t";
	?><select class="form-control" name="kp"><?php 	
		foreach ( $proses AS $key2=>$data2 ):?>
		<option value="<?php echo $data2 ?>">survey <?php echo $key2 ?></option><?php
		endforeach; echo "\t\t";
	?></select><?php
}
?><?php
/* 
<select id="jenis_data" name="jenis_data">
<option>Kawalan</option><option>Prosesan</option>
</select>


<div class="input-group">
	<span class="input-group-addon">and yet another length</span>
	<input type="text" class="form-control" id="current_pwd" name="current_pwd" />
</div>
<div class="input-group margin_top_10">
	<span class="input-group-addon ">another length</span>
	<input type="text" class="form-control" id="new_pwd" name="new_pwd" />
</div>
<div class="input-group margin_top_10">
	<span class="input-group-addon">length_1</span>
	<input type="text" class="form-control" id="confirm_pwd" name="confirm_pwd" />
</div>


<hr>
<div class="form-group">
<label for="start-date" class="col-sm-2 control-label">Start</label>

<div class="col-sm-2">
<input type="text" name="startDate" id="start-date" class="form-control">
</div>

<div class="col-sm-4">
<input type="text" name="startTime" id="start-time" class="form-control">
</div>
</div>
*/
?>