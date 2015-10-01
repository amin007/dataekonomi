<?php
/*
	<ul class="nav navbar-nav">
		<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
		<ul class="dropdown-menu" aria-labelledby="themes">
			<li><a tabindex="-1" href="../default/">Default</a></li>
			<li class="divider"></li>
			<li><a tabindex="-1" href="../amelia/">Amelia</a></li>
			<li><a tabindex="-1" href="../cerulean/">Cerulean</a></li>
			<li><a tabindex="-1" href="../cosmo/">Cosmo</a></li>
			<li><a tabindex="-1" href="../cyborg/">Cyborg</a></li>
			<li><a tabindex="-1" href="../flatly/">Flatly</a></li>
			<li><a tabindex="-1" href="../journal/">Journal</a></li>
			<li><a tabindex="-1" href="../readable/">Readable</a></li>
			<li><a tabindex="-1" href="../simplex/">Simplex</a></li>
			<li><a tabindex="-1" href="../slate/">Slate</a></li>
			<li><a tabindex="-1" href="../spacelab/">Spacelab</a></li>
			<li><a tabindex="-1" href="../united/">United</a></li>
		</ul>
		</li>
		<li><a href="../help/">Help</a></li>
		<li><a href="http://news.bootswatch.com">Blog</a></li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Download <span class="caret"></span></a>
			<ul class="dropdown-menu" aria-labelledby="download">
				<li><a tabindex="-1" href="./bootstrap.min.css">bootstrap.min.css</a></li>
				<li><a tabindex="-1" href="./bootstrap.css">bootstrap.css</a></li>
			</ul>
		</li>
	</ul>
glyphicon glyphicon-search
glyphicon glyphicon-stats
glyphicon glyphicon-picture
<span class="glyphicon glyphicon-stats"></span>
*/
$nav = 'class="dropdown-toggle" data-toggle="dropdown"';
$filter = '<i class="fa fa-filter"></i>';//'<span class="glyphicon glyphicon-filter"></span>';
?>
	<ul  class="nav navbar-nav">
	<!-- mula  ul class="nav" -->
	<?php if (Sesi::get('loggedIn') == true):?>
	<li class="dropdown"><a href="<?php echo URL ?>ckawalan">
		<i class="fa fa-search"></i></span>Jejak</a></li>
		<?php 
		$khas = array('amin007','azizah');
		$user = Sesi::get('namaPegawai');
		if ( in_array($user,$khas) ):?>
		<li><a href="<?php echo URL ?>cprosesan">
			<span class="glyphicon glyphicon-stats"></span>Prosesan</a></li>
		<li><a href="<?php echo URL ?>cimej">
			<span class="glyphicon glyphicon-picture"></span>Imej</a></li>
		<?php endif ?>
	<li class="dropdown">
		<a <?php echo $nav ?> href="#">
		<i class="fa fa-photo"></i>Kod<b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li class="nav-header">Kamus Kod</li>
		<li><a href="<?php echo URL ?>cari/semua/msic"><?php echo $filter ?>MSIC</a></li>
		<li><a href="<?php echo URL ?>cari/semua/produk"><?php echo $filter ?>Produk</a></li>
		<li><a href="<?php echo URL ?>cari/lokaliti/johor"><?php echo $filter ?>Lokaliti Johor</a></li>
		<li><a href="<?php echo URL ?>cari/lokaliti/malaysia"><?php echo $filter ?>Lokaliti Malaysia</a></li>
		<li class="nav-header">Data Prosesan</li>
		<li><a href="<?php echo URL ?>cari/prosesan/mm">MM</a></li>
		<li><a href="<?php echo URL ?>cari/prosesan/qss">QSS</a></li>
		<li><a href="<?php echo URL ?>cari/prosesan/bts">BTS</a></li>
		</ul>
	</li>
	<li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] ?>/private_html">
		<i class="fa fa-bar-chart"></i>E-Survey POM</a></li>
	<?php else: ?>
	<li class="dropdown"><a href="<?php echo URL ?>index">Index</a></li>
	<?php endif; ?>
	<!-- tamat ul class="nav" -->
	</ul>
<?php
/*
<li class="dropdown">
	<a <?php echo $nav ?> href="#">Go To <b class="caret"></b></a>
	<ul class="dropdown-menu">
	<li class="dropdown submenu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 1</a>
		<ul class="dropdown-menu submenu-show submenu-hide">
		<li class="dropdown submenu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 1.1</a>
			<ul class="dropdown-menu submenu-show submenu-hide">
			<li><a href="#">Level 1.1.1</a></li>
			<li><a href="#">Level 1.1.2</a></li>
			<li><a href="#">Level 1.1.3</a></li>
			<li><a href="#">Level 1.1.4</a></li>
			</ul>
		</li>
		<li class="dropdown submenu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 1.2</a>
			<ul class="dropdown-menu submenu-show submenu-hide">
			<li class="dropdown submenu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Level 1.2.1</a>
				<ul class="dropdown-menu submenu-show submenu-hide">
				<li><a href="#">Level 1.2.1.1</a></li>
				<li><a href="#">Level 1.2.1.2</a></li>
				</ul>
			</li>
			<li><a href="#">Level 1.2.2</a></li>
			</ul>
		</li>
		<li><a href="#">Level 1.3</a></li>
		<li><a href="#">Level 1.4</a></li>
		<li><a href="#">Level 1.5</a></li>
		</ul>
	</li>
	<li><a href="#">Other</a></li>
	</ul>
</li>
*/
?>	