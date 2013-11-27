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
		foreach ( array_keys($row[$kira]) AS $tajuk ) 
		{ 
			// anda mempunyai kunci integer serta kunci rentetan
			// kerana cara PHP mengendalikan tatasusunan.
			if ( !is_int($tajuk) ) 
			{ 
				$paparTajuk = ($tajuk=='nama') ?
				$tajuk . ' (jadual:' . $myTable . ')'
				: $tajuk; 
				?><th><?php echo $paparTajuk ?></th>
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
	
	foreach ( $row[$kira] AS $key=>$data ) 
	{		
		if ($key=='sidap')
		{
			$sidap= $data;
			$ssm = substr($data,0,12); 
		}
		elseif ($key=='nama')
		{
			$syarikat = $data;
		}
		else
			{}
		?><td><?php echo $data ?></td>
<?php
	} 
	?></tr></tbody>
<?php
}
#-----------------------------------------------------------------
?>
</table>
