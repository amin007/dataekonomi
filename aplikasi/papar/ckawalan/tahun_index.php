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
		<label class="col-lg-1 control-label">SV</label>
		<div class="col-lg-10">
		<input type="sv" class="form-control" placeholder="SV" name="sv">
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-1 control-label">Newss</label>
		<div class="col-lg-10">
		<input type="text" class="form-control" placeholder="NEWSS" name="newss">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-10">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
	</div>
</form>
<br>
<form class="form-horizontal" role="form" method="post" action="ckawalan/msic">
<h2>Cari MSIC Utk CDT & ICDT sahaja</h2>
	<div class="form-group">
		<label class="col-lg-1 control-label">MSIC</label>
		<div class="col-lg-10">
		<input type="sv" class="form-control" placeholder="MSIC" name="msic">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-10">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
	</div>
</form>

</div><!--container-->
<?php
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