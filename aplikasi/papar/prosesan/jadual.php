<table  border="1" class="excel" id="example">
<?php
// mula bina jadual
$printed_headers = false; 
#-----------------------------------------------------------------
for ($kira=0; $kira < count($row); $kira++)
{
	//print the headers once: 	
	if ( !$printed_headers ) 
	{
		?><thead><tr>
<th>#</th>
<?php
		foreach ( array_keys($row[$kira]) as $tajuk ) 
		{ 
			// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
			if ( !is_int($tajuk) ) 
			{ 
				?><th><?php echo $tajuk ?></th>
<?php		} 
		}

?></tr></thead>
<?php
		$printed_headers = true; 
	} 
#-----------------------------------------------------------------		 
	//print the data row 
	?><tbody><tr>
<td><?php echo $kira+1 ?></td>	
<?php
	
	foreach ( $row[$kira] as $key=>$data ) 
	{		
	?><td><?php echo $data ?></td>
<?php
	}
?> 
</tr></tbody>
<?php
}
#-----------------------------------------------------------------
?>
</table>

<?php
}// tamat ulang $row
?>

