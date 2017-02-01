<!--  mula test untuk tab kiri dan kanan -->
<div class="row">
	<div  class="col-sm-6">
	<h3>Borang Ekonomi 2016 - KP 205</h3>
	<div class="col-xs-3"> <!-- required for floating -->
		<ul class="nav nav-tabs"><?php 
	$bil_soalan = 17;
	for ($bil=1; $bil < $bil_soalan; $bil++)
	{
		if ($bil==1): echo "\n\t\t"; ?><li class="active"><a href="#l" data-toggle="tab">Soalan 1</a></li><?php 
		else: echo "\n\t\t"; ?><li><a href="#<?php echo $bil; ?>" data-toggle="tab">Soalan <?php echo $bil; ?></a></li><?php
		endif;
	}	echo "\n\t\t"; 
	?></ul>
	</div>

	<div class="col-xs-9"><!-- Tab panes -->
		<div class="tab-content"><?php 
for ($bil=1; $bil < $bil_soalan; $bil++)
{
	if ($bil==1):echo "\n\t\t";
		?><div class="tab-pane active" id="l">
		<p>Anda berada di Soalan 1.</p>
		<p><?php include 'masuk-s01.php'; ?></p>
		</div><?php
	elseif (in_array($bil,array(2,3,4,5,6))):
		echo "\n\t\t"; 
		?><div class="tab-pane" id="<?php echo $bil; ?>">
		<p>Anda berada di Soalan <?php echo $bil; ?>.</p>
		<p><?php include 'masuk-s0'.$bil.'.php'; ?></p>
		</div>
<?php else: echo "\n\t\t"; 
		?><div class="tab-pane" id="<?php echo $bil; ?>">
		<p>Anda berada di Soalan <?php echo $bil; ?>.</p>
		</div><?php
	endif;
}	echo "\n\t\t";?></div><!-- / class="tab-content" -->
	</div><!-- / class="col-xs-9" -->

	<div class="clearfix"></div>

	</div>
</div>
<!-- tamat test untuk tab kiri dan kanan -->
<?php
/*
		<!-- Nav tabs -->
		<ul class="nav nav-tabs tabs-left">
		<li class="active"><a href="#home-v" data-toggle="tab">Home</a></li>
		<li><a href="#profile-v" data-toggle="tab">Profile</a></li>
		<li><a href="#messages-v" data-toggle="tab">Messages</a></li>
		<li><a href="#settings-v" data-toggle="tab">Settings</a></li>
		</ul>
*/
?>
