<style type="text/css">
table.librecalc {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:11px;
}
table.librecalc thead th, table.librecalc tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align: top;
}
table.librecalc tbody th { text-align:center; vertical-align: top; }
table.librecalc tbody td { vertical-align:bottom; }
table.librecalc tbody td 
{ 
	padding: 0 3px; border: 1px solid #aaaaaa;
	background:#ffffff;
}
</style>
<pre><?php
//echo '$this->cariNama:'; print_r($this->cariNama);
//echo '$fungsi=>' . $this->fungsi;
//echo '<br>$url=>' . print_r($this->url);
echo (empty($this->url[2])) ? null : 'url[' . URL . $_GET['url'] . ']';
echo ' | Bil kes = ' . count($this->cariNama[$this->jadual]); 
?></pre>

<?php
foreach ($this->cariNama as $myTable => $row)
{// mula ulang $row
?>
<table border="1" class="librecalc" id="example">
<?php
$printed_headers = false; # mula bina jadual
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{   # print the headers once:   
    if ( !$printed_headers ) : ?><thead><tr>
<th>#</th>
<?php    foreach ( array_keys($row[$kira]) AS $tajuk ) : 
        # anda mempunyai kunci integer serta kunci rentetan
        # kerana cara PHP mengendalikan tatasusunan.
            //if ( !is_int($tajuk) ) :
                ?><th><?php echo $tajuk ?></th>
<?php       //endif;
        endforeach; ?>
</tr></thead><?php
        $printed_headers = true; 
    endif;
#-----------------------------------------------------------------       
    # print the data row ?>
<tbody><tr>
<td><?php echo $kira+1 ?></td><?php
    foreach ( $row[$kira] AS $key=>$data ) : 
		if ($key=='tarikh')
		{
			$cdt = 'http://sidapmuar/ekonomi/cprosesan/ubah/cdt/' . $data . '/2004/2013';
			$class = 'btn btn-primary btn-mini';
			$urlCdt = '<a target="_blank" href="' . $cdt . '" class="' . $class . '">' . $data . '</a>';
			echo (empty($data)) ? '<td>&nbsp;</td>' : "<td>$urlCdt</td>";
		}
		elseif ($key=='nossm')
		{
			$icdt = 'http://sidapmuar/ekonomi/cprosesan/ubah/icdt/' . $data . '/2004/2013';
			$icdt2 = 'http://sidapmuar/private_html/tahun/cdt2014/kawalan/ubah/' . $data;
			$mdt = 'http://sidapmuar/private_html/bulan/mdt2013/kawalan/cetak/' . $data;
			$papardata = '<input type="checkbox">' . $data . '|';
			$class = 'btn btn-primary btn-mini';
			?><td><?php echo $papardata;
			?><a target="_blank" href="<?php echo $icdt ?>" class="<?php //echo $class ?>">T</a>|<?php
			?><a target="_blank" href="<?php echo $icdt2 ?>" class="<?php //echo $class ?>">K</a>|<?php
			?><a target="_blank" href="<?php echo $mdt ?>" class="<?php //echo $class ?>">M</a><?php
			?></td><?php
		}
		else
		{
			?><td><?php echo $data ?></td><?php
		}

    endforeach; ?>
</tr></tbody>
<?php
}
#-----------------------------------------------------------------
?>
</table>
 
<?php
}// tamat ulang $row
?>
