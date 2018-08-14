<script>
function onSuccess(data, status)
{
	data = $.trim(data);
	$("#nota").text(data);
}

function onError(data, status)
{
	// handle an error
}  
     
$(document).ready(function() 
{
	$("#submit").click(function(){
	var formData = $("#cariNewssNama").serialize();

	$.ajax({
		type: "POST",
		url: "<?php echo URL ?>mobile/carian",
		cache: false,
		data: formData,
		success: onSuccess,
		error: onError
		});
	  
	return false;
	});
});
/////////////////////////////////////////////////////////////////////
</script>
<!-- mula page content -->
	<div data-role="content" class="ui-content" role="main">
		<h2>Malaysia Standard Industrial Classification</h2>
		<form id="cariNewssNama">
			<input type="search" name="cariNama" data-mini="true" data-theme="c" class="search-header" />
			<button data-theme="b" id="submit" type="submit" class="ui-btn-hidden" aria-disabled="false">Submit</button>
			<h3 id="nota"></h3>
		</form>	
	</div>