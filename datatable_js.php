<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('#datatables').dataTable({
		stateSave: true,
		sPaginationType:"full_numbers",
		aaSorting:[[0, "asc"]],
		bJQueryUI:true,
		"aLengthMenu": [
        [10, 25, 50, 100, 200, -1],
        [10, 25, 50, 100, 200, "All"]
    	]
	});
})
</script>
