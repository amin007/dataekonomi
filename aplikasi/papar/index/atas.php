<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php
echo Tajuk_Muka_Surat;
$dpt_url = dpt_url();
echo (empty($url[2])) ? null 
	: '[' . $dpt_url[2] . ']';
?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<?php
$bt = '3';
$css_url = JS . 'bootstrap/'.$bt.'/css/';
$js_url  = JS . 'bootstrap/'.$bt.'/js/';
$ico_url = JS . 'bootstrap/'.$bt.'/img/';
$font_url = JS . 'bootstrap/'.$bt.'/font/';
$fontAwesome = JS . 'font-awesome/4.4.0/css/';

//$theme[]='cerulean_blue';
//$theme[]=''; basic
$theme[]='-united_jingga';
//$theme[]='journal_white';
//$theme[]='spruce_hijau';
$theme[]='font-awesome';

$hariini = 0; //rand(0, count($theme)-1); 
$pilih = $theme[$hariini];
$pilih3 = $theme[1];
?><!-- Le styles -->
<link href="<?php echo $css_url ?>theme/bootstrap<?php echo $pilih ?>.css" rel="stylesheet">
<link href="<?php echo $fontAwesome . $pilih3 ?>.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ico_url ?>apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $ico_url ?>apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ico_url ?>apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $ico_url ?>apple-touch-icon-57-precomposed.png">

<style type="text/css">
body {
  padding-top: 40px;
  padding-bottom: 40px
}

.form-signin {
  max-width: 280px;
  padding: 10px 29px 29px;
  margin: 0 auto 20px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
    border-radius: 5px;
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
     -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin input[type="text"],
.form-signin input[type="password"] {
  font-size: 16px;
  height: auto;
  margin-bottom: 15px;
  padding: 7px 9px;
}

/* Everything but the jumbotron gets side spacing for mobile-first views */
.masthead,
.body-content,
.footer {
  padding-left: 15px;
  padding-right: 15px;
}

.footer {
  border-top: 1px solid #ddd;
  margin-top: 30px;
  padding-top: 29px;
  padding-bottom: 30px;
}

/* Main marketing message and sign up button */
.jumbotron {
  text-align: center;
  background-color: transparent;
}
.jumbotron .btn {
  font-size: 21px;
  padding: 14px 24px;
}

/* Customize the nav-justified links to be fill the entire space of the .navbar */
.nav-justified {
  max-height: 50px;
  background-color: #eee;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.nav-justified > li > a {
  padding-top: 15px;
  padding-bottom: 15px;
  color: #777;
  font-weight: bold;
  text-align: center;
  border-left: 1px solid rgba(255,255,255,.75);
  border-right: 1px solid rgba(0,0,0,.1);
  background-color: #e5e5e5; /* Old browsers */
  background-repeat: repeat-x; /* Repeat the gradient */
  background-image: -moz-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%); /* FF3.6+ */
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f5f5), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */
  background-image: -webkit-linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* Chrome 10+,Safari 5.1+ */
  background-image: -ms-linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* IE10+ */
  background-image: -o-linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* Opera 11.10+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
  background-image: linear-gradient(top, #f5f5f5 0%,#e5e5e5 100%); /* W3C */
}
.nav-justified > .active > a {
  background-color: #ddd;
  background-image: none;
  box-shadow: inset 0 3px 7px rgba(0,0,0,.15);
}
.nav-justified > li:first-child > a {
  border-left: 0;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}
.nav-justified > li:last-child > a {
  border-right: 0;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}


/* Responsive: Portrait tablets and up */
@media screen and (min-width: 768px) {
  /* Remove the padding we set earlier */
  .masthead,
  .marketing,
  .footer {
    padding-left: 0;
    padding-right: 0;
  }
}

</style>
</head><?php
/*
style="background: url('<?php echo GAMBAR ?>') no-repeat center center fixed;background-size: cover;"
*/
?>