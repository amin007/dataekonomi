<?php Sesi::init(); 

//glyphicon glyphicon-home
//glyphicon glyphicon-send
//glyphicon glyphicon-user
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
			<i class="fa fa-home"></i> Anjung</a>
		<a href="<?php echo URL ?>ruangtamu/logout" class="navbar-brand">
			<i class="fa fa-paper-plane-o"></i> Keluar</a>
	<?php require 'menubar_kiri.php'; ?>

	<!-- menu kanan mula -->
	<ul class="nav navbar-nav navbar-right">
		<li><a><i class="fa fa-user-secret"></i><?php 
		echo huruf('Besar_Depan' , Sesi::get('namaPenuh')) 
		?></a></li>
	</ul> 
	<!-- menu kanan tamat -->
</div>
<!-- tamat menu bawah -->
<?php
}
?>
