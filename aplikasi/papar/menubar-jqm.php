<?php if (!isset($this->tajuk)) :?>
		<div data-role="navbar">
			<ul>
				<li><a href="<?php //echo URL ?>#mobile" data-icon="home">Anjung</a></li>
				<li><a href="<?php echo URL ?>mobile/icon" data-icon="bullets">Icon</a></li>
			</ul>
		</div>
<?php elseif($this->tajuk=='Login Untuk POM'):?>
		<div data-role="navbar">
			<ul>
				<li><a href="<?php echo URL ?>index/muar" data-icon="home">Anjung</a></li>
				<li><a href="<?php echo URL ?>mobile/icon" data-icon="bullets">Icon</a></li>
			</ul>
		</div>
<?php else:?>
		<div data-role="navbar">
			<ul>
				<li><a href="<?php echo URL ?>ruangtamu" data-icon="home">Anjung</a></li>
				<li><a href="<?php echo URL ?>ruangtamu/logout" data-icon="lock" data-ajax="false">Keluar</a></li>
			</ul>
		</div>
<?php endif;?>
<?php
	echo "\n";
/*
				<li><a href="<?php echo URL ?>mobile/icon" data-icon="bullets">Kawal</a></li>
				<li><a href="<?php echo URL ?>mobile/cari" data-icon="search">Cari</a></li>
				<li><a href="#anylink" data-icon="grid">Laporan</a></li>

*/
?>