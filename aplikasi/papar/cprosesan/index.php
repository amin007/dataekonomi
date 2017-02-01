<div class="container">

<h1>Senarai Kes Untuk Prosesan</h1>

<select id="sejarah" name="sejarah">
<option>Sila Pilih</option>
<option>Sebelum 2010</option>
<option>Selepas 2010</option>
</select>

<hr>
<form class="form-horizontal" role="form" method="post" action="ckawalan/proses">
<h2>Selepas 2010</h2>
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
		<label class="col-lg-2 control-label">Tahun Mula - Tamat</label>
		<div class="col-lg-4">
			<input type="text" class="form-control" placeholder="Mula" name="thnmula">
		</div><div class="col-lg-4">
			<input type="text" class="form-control" placeholder="Tamat" name="thntamat">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-10">
		<input type="submit" class="btn btn-default" value="Cari">
		</div>
	</div>
</form>

<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
	<?php 
$bil_soalan = 10;	
for ($bil=1; $bil < $bil_soalan; $bil++)
{
	if ($bil==1):?><li class="active"><a href="#l" data-toggle="tab">Soalan 1</a></li><?php 
	else:?><li><a href="#<?php echo $bil; ?>" data-toggle="tab">Soalan <?php echo $bil; ?></a></li><?php
	endif;
}
?>	</ul>
<div class="tab-content">
	<?php 
for ($bil=1; $bil < $bil_soalan; $bil++)
{
	if ($bil==1):?>
	<div class="tab-pane active" id="l">
	<p>Anda berada di Soalan 1.</p>
	</div>
<?php else:?>	
	<div class="tab-pane" id="<?php echo $bil; ?>">
	<p>Anda berada di Soalan <?php echo $bil; ?>.</p>
	</div>
<?php
	endif;
}
?>
</div>
</div> <!-- /tabbable -->

</div><!--container-->