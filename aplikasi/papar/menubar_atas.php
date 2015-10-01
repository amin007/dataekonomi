<?php 
$nav = 'data-toggle="dropdown" class="dropdown-toggle active"';
?>
	<ul class="nav">
	<!-- mula  ul class="nav" -->
	<?php if (Sesi::get('loggedIn') == true):?>
	<li class="dropdown"><a href="<?php echo URL ?>ckawalan">Jejak</a></li>
		<?php if (Sesi::get('namaPegawai')  == 'amin007' 
			|| Sesi::get('namaPegawai')  == 'azizah' ):?>
		<li><a href="<?php echo URL ?>cprosesan">Prosesan</a></li>
		<li><a href="<?php echo URL ?>cimej">Imej</a></li>
		<?php endif ?>
	<li class="dropdown">
		<a <?php echo $nav ?> href="#">
		Kod<b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li class="nav-header">Kamus Kod</li>
		<li><a href="<?php echo URL ?>cari/semua/msic">MSIC</a></li>
		<li><a href="<?php echo URL ?>cari/semua/produk">Produk</a></li>
		<li><a href="<?php echo URL ?>cari/lokaliti/johor">Lokaliti</a></li>
		<li class="nav-header">Data Prosesan</li>
		<li><a href="<?php echo URL ?>cari/prosesan/data_mm_prosesan">MM</a></li>
		<li><a href="<?php echo URL ?>cari/prosesan/data_mm_prosesan">QSS</a></li>
		<li><a href="<?php echo URL ?>cari/prosesan/data_mm_prosesan">BTS</a></li>
		</ul>
	</li>
	<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] ?>/private_html">E-Survey POM</a></li>
	<?php else: ?>
	<li class="dropdown"><a href="<?php echo URL ?>index">Index</a></li>
	<?php endif; ?>
	<!-- tamat ul class="nav" -->
	</ul>