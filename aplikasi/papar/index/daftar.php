<?php require 'atas.php'; ?>
<body style="background: url('<?php echo GAMBAR ?>') no-repeat center center fixed;background-size: cover;">
<div class="container">
	<form class="form-signin" method="post" action="<?php echo URL ?>login/semakid">
	<h2 class="form-signin-heading">Sila daftar masuk</h2>
	
	<div class="input-prepend"><i class="icon-user"></i>
	<input name="username" type="text" placeholder="Nama Pengguna"
	class="input-block-level search-query">
	</div>

	<div class="input-prepend"><i class="icon-qrcode"></i>
	<input name="password" type="password" placeholder="Kata Laluan"
	class="input-block-level search-query">
	</div>
	
	<i class="icon-hand-right"></i>
	<input type="submit" name="masuk" value="Masuk" class="btn btn-large btn-primary">
	<a class="btn btn-large btn-danger" href="<?php echo URL ?>">
	<i class="icon-home icon-white"></i>Keluar</a>
	</form>
</div> <!-- /container -->
<?php require 'bawah.php'; ?>

<?php
/*
<!-- sample modal content -->
<div id="#modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="daftarLogin" aria-hidden="true">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 id="daftarLogin">Waktu berbuka</h3>
	</div>
	<div class="modal-body">
		
		<form class="form-signin" method="post" action="<?php echo URL ?>login/semakid">
		<h2 class="form-signin-heading">Sila daftar masuk</h2>
		
		<div class="input-prepend"><i class="icon-user"></i>
		<input name="username" type="text" placeholder="Nama Pengguna"
		class="input-block-level search-query">
		</div>

		<div class="input-prepend"><i class="icon-qrcode"></i>
		<input name="password" type="password" placeholder="Kata Laluan"
		class="input-block-level search-query">
		</div>
		
		<i class="icon-hand-right"></i>
		<input type="submit" name="masuk" value="Masuk" class="btn btn-large btn-primary">
		<a class="btn btn-large btn-danger" href="<?php echo URL ?>">
		<i class="icon-home icon-white"></i>Keluar</a>
		</form>
	
	</div>
</div>
*/?>