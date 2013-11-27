<div class="container">

<h1>Senarai Kes Untuk Prosesan</h1>

<select id="sejarah" name="sejarah">
<option>Sila Pilih</option>
<option>Sebelum 2010</option>
<option>Selepas 2010</option>
</select>

<form class="form-search" method="post" action="ckawalan/cari" id="fnama">
	<h2>Sebelum 2010</h2>
	<div class="input-append">
	<select name="jenisID">
	<option>Sidap</option><option>Nama</option>
	</select>

	<input class="span3 search-query" type="text" name="id" />
	<input class="btn" type="submit" value="cari" />
	</div>
</form>
<form class="form-search" method="post" action="ckawalan/cari" id="fid">
	<h2>Selepas 2010</h2>
	<select name="jenisID">
	<option>Sidap</option><option>Newss</option><option>Nama</option>
	</select>
	<div class="input-append">
	<input class="span3 search-query" type="text" name="id" />
	<input class="btn" type="submit" value="cari" />
	</div>
</form>

<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
	<?php 
$bil_soalan = 10;	
for ($bil=1; $bil < $bil_soalan; $bil++)
{
	if ($bil==1):?>	
	<li class="active"><a href="#l" data-toggle="tab">Soalan 1</a></li>
<?php else:?>	
	<li><a href="#<?php echo $bil; ?>" data-toggle="tab">Soalan <?php echo $bil; ?></a></li>
<?php
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