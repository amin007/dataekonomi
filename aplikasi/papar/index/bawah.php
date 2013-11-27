<hr>
	<footer>
	<span class="label label-info">&copy; Hak Cipta Terperihara 2012 |
	<a target="_blank" href="http://getbootstrap.com">
	Theme <?php echo $pilih ?></a> </span>
	</footer>
<!-- // kemudian masukkan  jquery dan js lain2
---------------------------------------------------------------------------------- -->
<script type="text/javascript" src="<?php echo JQUERY ?>"></script>
<script type="text/javascript" src="<?php echo $js_url ?>bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $js_url ?>bootstrap-modal.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{
	$('.submenu').hover(function () {
        jQuery(this).children('ul').removeClass('submenu-hide').addClass('submenu-show');
    }, function () {
        jQuery(this).children('ul').removeClass('.submenu-show').addClass('submenu-hide');
    <?php // }).find("a:first").append(" &raquo; "); ?>
	}).find("a:first").append(" <i class=<?php echo $simbol ?>></i> ");
	
	$('.tarikh').datepicker(
		{ "format": "yyyy-mm-dd", 
		"language": "ms", 
		"weekStart": 1,
		"autoclose": true
		});
	
	$("[rel=tooltip]").tooltip();
	 
	$('#fid').hide(); $('#fnama').hide();
	$("#sejarah").change(function () 
	{
		if($(this).val() === "Selepas 2010")
		{
			$('#fid').show(); $('#fnama').hide();
		}
		else
		{
			$('#fid').hide(); $('#fnama').show();
		}
	});
});
</script>
<?php
/*
<script type="text/javascript">
$(window).load(function(){
    jQuery('.submenu').hover(function () {
        jQuery(this).children('ul').removeClass('submenu-hide').addClass('submenu-show');
    }, function () {
        jQuery(this).children('ul').removeClass('.submenu-show').addClass('submenu-hide');
    <?php // }).find("a:first").append(" &raquo; "); ?>
	}).find("a:first").append(" <i class=<?php echo $simbol ?>></i> ");
}); 
</script>
*/
if (isset($this->js)) 
{
	foreach ($this->js as $js)
	{
		echo "\n";
?>		<script type="text/javascript" src="<?php echo $js_url . $js ?>"></script><?php
	}
}
echo "\n";
?>

</body>
</html>