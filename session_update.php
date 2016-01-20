<?php include('header.php');
$user = getPermissions('session_upload');
if($user['view'] != '1')
{
	echo '<script type="text/javascript">window.location = "page_not_found.php"</script>';
}
$locName=""; $locId="";
$obj = new locations();
if(isset($_GET['edit']) && $_GET['edit']!=""){
	$locId = base64_decode($_GET['edit']);
	$result = $obj->getDataByLocID($locId);
	$row = $result->fetch_assoc();
}
$locName = isset($_GET['edit']) ? $row['name'] : (isset($_POST['txtLname'])? $obj->cleanText($_POST['txtLname']):'');
?>
<div id="content">
    <div id="main">
		<?php 
		if(isset($_SESSION['succ_msg'])){ echo '<div class="full_w green center">'.$_SESSION['succ_msg'].'</div>'; unset($_SESSION['succ_msg']);} ?>
        <div class="full_w">
            <div class="h_title">Session Update (Case No, Technical Notes, Description)</div>
            <form name="session_update" id="session_update" action="postdata_import.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="form_action" value="upldateSession" />
				<!--<input type="hidden" name="locId" value="<?php echo $locId; ?>" />-->
                <div class="custtable_left">
					<div class="custtd_left">
                        <h2>File Path<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
						 <input type="file" name="uploadSess" class="buttonsub" value="Upload"><input style="margin-left:20px;" type="submit" name="Upload" value="Upload" class="buttonsub" />
                    </div>
					<div class="clear"></div>
					<!--<div style="float:left; margin-left:292px;">	
					Click <a href="sample/upload.xlsx" target="_blank">here</a> to download a sample file.
					</div>-->
                    <div class="clear"></div>	
                    <div class="custtd_left">
                         <h3><span class="redstar">*</span>All Fields are mandatory.</h3>
                    </div>
                </div>
            </form>
			<div class="clear"></div>
			<div style="float:left">
			<div class="rule">
               <h2><strong>How to download a sample file with correct format to upload with all the session's data from system:</strong></h2>
            </div>
			<ul class="rule-list">
			<li style="list-style:disc">
			From top menu go to <strong>Reports->Export All Session Activity</strong> and download the report.
			</li>
			<li style="list-style:disc">
			Do not modify anything in the first row(Headers/Titles) of the sheet.
			</li>
			<li style="list-style:disc">
			Do not delete any columns from the file. You can delete any rows if needed.
			</li>
			<li style="list-style:disc">
			Use the same file to upload by modify as required the three field Case No, Technical Notes, Description and let the other fields as it is.
			</li>
			
			<li style="list-style:disc">
			System will automatically ignore special activities from the sheet.
			</li>
			</ul>
			</div>
			<div class="clear"></div>
			<div class="red" style="text-align:left; margin-left:305px;">
					<?php
					if((isset($_SESSION['error_msgArr'])) && (count($_SESSION['error_msgArr'])>0)){
						foreach($_SESSION['error_msgArr'] as $errorData){
							echo $errorData.'</br>';
						}
						unset($_SESSION['error_msgArr']);
					}
					?>
			</div><br /><br />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

