<div id="footer">
    <div class="center" style="text-align:center; font-weight:normal">
	<p>&copy; 2014 COLERED. All rights reserved &nbsp;
	<?php $user = getPermissions('about_us');
		  if($user['view'] != '0'){?>
			| &nbsp;<a style="font-weight:normal" href="about_us.php" target="_self"> About Us</a>&nbsp; 
	<?php } ?>
	<?php $user = getPermissions('help');
		  if($user['view'] != '0'){?>
			| &nbsp;<a style="font-weight:normal" href="help.php" target="_self">Help</a>
	<?php } ?>
	</p>
    </div>
</div>
</div>
</body>
</html>
