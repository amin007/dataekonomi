<?php
$css_url = JS . 'bootstrap3/css/';
$js_url  = JS . 'bootstrap3/js/';
$ico_url = JS . 'bootstrap3/img/';
$font_url = JS . 'bootstrap3/font/';

//$theme[]='cerulean_blue';
//$theme[]=''; basic
$theme[]='-united_jingga';
$theme[]='-united_jingga2';
//$theme[]='journal_white';
//$theme[]='spruce_hijau';

$hariini = 1; //rand(0, count($theme)-1); 
$pilih = $theme[$hariini];

?><!-- Le styles -->
	<link href="<?php echo $css_url ?>theme/bootstrap<?php echo $pilih ?>.css" rel="stylesheet"><?php
if (isset($this->css)) 
{
	foreach ($this->css as $css)
	{
		echo "\n\t"; // '<link rel="stylesheet" type="text/css" href="' . . $css . '">';
?><link rel="stylesheet" href="<?php echo $css_url . $css ?>"><?php
	}
}
echo "\n"; ?>
<style type="text/css">
/*.navbar-xs { min-height:28px; height: 28px; }
.navbar-xs .navbar-brand{ padding: 0px 12px;font-size: 16px;line-height: 28px; }
.navbar-xs .navbar-nav > li > a {  padding-top: 0px; padding-bottom: 0px; line-height: 28px; }*/
</style>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->