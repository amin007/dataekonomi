<?php
if ($paparMenuAtas == 0)
{
	echo '';
}	
else
{
?>
<hr>
	<footer>
	<span class="label label-info">&copy; Hak Cipta Terperihara 2012 |
	<a target="_blank" href="http://getbootstrap.com">
	Theme <?php echo $pilih ?></a>|
	<a target="_blank" href="http://bootswatch.com/united/">Ubuntu United</a>
	</span>
	</footer>
<!-- // kemudian masukkan  jquery dan js lain2
---------------------------------------------------------------------------------- -->
<script type="text/javascript" src="<?php echo JQUERY ?>"></script>
<script type="text/javascript" src="<?php echo $js_url ?>bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{
	$('.tarikh').datepicker(
		{ "format": "yyyy-mm-dd", 
		"language": "ms", 
		"weekStart": 1,
		"autoclose": true
		});
	
	$("[rel=tooltip]").tooltip();
	$('#kirahasil').calx();
	$('#kirabelanja').calx();
	
});
</script>
<?php
}
if (isset($this->js)) 
{
	foreach ($this->js as $js)
	{
		echo "\n";
		?><script type="text/javascript" src="<?php echo $js_url . $js ?>"></script><?php
	}
}
echo "\n";
?>
</body>
</html>