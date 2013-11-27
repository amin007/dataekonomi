<?php Sesi::init(); 

//$paparMenuAtas = 0;
$paparMenuAtas = 1;


if ($paparMenuAtas == 0)
{
	echo '';
}	
else
{
?>
<!-- mula menu atas -->
<div class="navbar navbar-default">
<!-- div class="navbar navbar-default navbar-fixed-top" -->
		<a href="<?php echo URL ?>ruangtamu" class="navbar-brand">
			<span class="glyphicon glyphicon-home"></span> Anjung</a>
		<a href="<?php echo URL ?>ruangtamu/logout" class="navbar-brand">
			<span class="glyphicon glyphicon-send"></span> Keluar</a>
	<?php require 'menubar_kiri.php'; ?>

	<!-- menu kanan mula -->
	<ul class="nav navbar-nav navbar-right">
		<li><a><span class="glyphicon glyphicon-user"></span><?php 
		echo huruf('Besar_Depan' , Sesi::get('namaPenuh')) 
		?></a></li>
	</ul> 
	<!-- menu kanan tamat -->
</div>
<!-- tamat menu bawah -->
<?php
}
?>
