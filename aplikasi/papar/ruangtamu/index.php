<style type="text/css">
/* Godek hero-unit <?php $font = '#800080'; ?>
-------------------------------------------------- */

.pasaran {
  padding: 60px;
  margin-bottom: 30px;
  /*background-color: #f5f5f5;*/
  color: <?php echo $font ?>;
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
}

/* Bootstrap code examples 
-------------------------------------------------- */

/* Base class */
.bs-docs-example {
  position: relative;
  margin: 15px 0;
  padding: 39px 19px 14px;
  *padding-top: 19px;
  background-color: #fff;
  opacity: 0.5;filter:alpha(opacity=50); 
  color: <?php echo $font ?>;
  /*border: 1px solid #ddd;*/
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

/* Echo out a label for the example */
.bs-docs-example:after {
  content: "Selamat Datang <?php echo huruf('Besar_Depan' , Sesi::get('namaPenuh')) 
  ?>. ";
  position: absolute;
  top: -1px;
  left: -1px;
  padding: 3px 7px;
  /*font-size: 12px;
  font-weight: bold;*/
  background-color: #f5f5f5;
  /*border: 1px solid #ddd;*/
  color: <?php echo $font ?>; /*#9da0a4*/
  -webkit-border-radius: 4px 0 4px 0;
     -moz-border-radius: 4px 0 4px 0;
          border-radius: 4px 0 4px 0;
}
</style>

<div class="container"><div class="pasaran">
<div class="bs-docs-example"><p class="lead" style="text-align:justify;">
Bermula pada Banci EKS 2005, desakan ke arah kualiti data ekonomi sangat diperlukan.  
Ia dilihat mampu memberi kesan signifikan kepada Jabatan Perangkaan Malaysia khususnya JP Johor.
Dengan pelaksanaan Banci Ekonomi 2006 serta beberapa siri banci/penyiasatan berkaitan pertubuhan ekonomi. 
Projek ini berjalan dalam tempoh berkala (bulanan, tahunan, suku tahunan, setiap 5 tahun dll). <i class="fa fa-spinner fa-pulse"></i>
Maka satu pasukan kerja Inovasi JP Johor yang diberi nama MAHARANI ditubuhkan. Mereka merintis jalan 
ke arah mewujudkan pengkalan data khusus pertubuhan ekonomi di negeri ini, dan dikenali sebagai M-ECO.</p>
</div><!-- / class="bs-docs-example" -->

<p><a class="btn btn-primary btn-large">Pergi lebih jauh <i class="fa  fa-fighter-jet fa-5x"></i></a></p>
</div><!--pasaran-->
</div><!--container-->
<?php
/* style="background-color:black;color:white"
<div class="bs-docs-example">
<p class="lead" style="text-align:justify;">
</p><!-- / class="lead" -->
</div><!-- / class="bs-docs-example" -->


//*/
?>
