<?php include('header.php');
$name = isset($_GET['name']) ? $_GET['name'] : '';
$fromGenrtTmtbl = isset($_GET['fromGenrtTmtbl']) ? $_GET['fromGenrtTmtbl'] : '';
$toGenrtTmtbl = isset($_GET['toGenrtTmtbl']) ? $_GET['toGenrtTmtbl'] : '';
?>
<div id="content">
    <div id="main">
        <div class="full_w" style="min-height:300px">
            	 <div class="h_title">Help desk</div>
                 <div class="custtable_left">
				    <p>Please download the file for the help.It may give the idea about your query :<a href="docs/RAS - User Manual.docx" >Download</a></p>
				 </div>
				 <div class="clear"></div>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>
