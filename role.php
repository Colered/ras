<?php include('header.php'); 
$userId="";
$objU=new Users();
$result = $objU->getUserType();
?>
<div id="content">
    <div id="main">
        <div class="full_w">
            <div class="h_title">Add User</div>
            <form name="roleForm" id="roleForm" action="postdata.php" method="post">
			    <div class="">
					<div class="custtd_left">
                        <h2>User Type<span class="redstar">*</span></h2>
                    </div>
                    <div class="txtfield">
					  <select id="slctUserType" name="slctUserType" class="select1">
						    <option value="" selected="selected">--Select Type--</option>
							<?php while($userDataType = $result->fetch_assoc()){
								$selected = $userDataType['id']==$role_id ?"selected":'';
							?>		
							<option value="<?php echo $userDataType['id'];?>" <?php echo $selected;?>><?php echo $userDataType['name'];?></option>
							<?php } ?>
                        </select>
                    </div>
                    <div class="clear"></div>
					<div style="width:700px;float:left;" >
						 <table width="200" border="1">
						  <thead>
								<tr>
									<th width="100">Pages</th>
									<th width="50"><input type="checkbox" id="addall" name="addall" onclick="serPermission();"/><br/>Add</th>
									<th width="50"><input type="checkbox" id="editall" name="editall" onclick="serPermission();"/><br/>Edit</th>
									<th width="50"><input type="checkbox" id="deleteall" name="deleteall" onclick="serPermission();"/><br/>Delete </th>
									<th width="50"><input type="checkbox" id="viewall" name="viewall" onclick="serPermission();"/><br/>View</th>
									<th width="50"><input type="checkbox" id="cloneall" name="cloneall" onclick="serPermission();"/><br/>Clone</th>
									<th width="50"><input type="checkbox" id="allall" name="allall"onclick="serPermission();"/><br/>All</th>
								</tr>
						 </thead>
						 <tbody>
							  <tr>
							  	<td align="center">Timetable Dashboard</td>
								<td align="center"><input type="checkbox" id="add1" name="add1" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit1" name="edit1" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete1" name="delete1" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view1" name="view1" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone1" name="clone1" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all1" name="all1" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Generate Timetable</td>
								<td align="center"><input type="checkbox" id="add2" name="add2" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit2" name="edit2" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete2" name="delete2" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view2" name="view2" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone2" name="clone2" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all2" name="all2" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Timetable View</td>
								<td align="center"><input type="checkbox" id="add3" name="add3" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit3" name="edit3" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete3" name="delete3" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view3" name="view3" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone3" name="clone3" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all3" name="all3" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Month</td>
								<td align="center"><input type="checkbox" id="add4" name="add4" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit4" name="edit4" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete4" name="delete4" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view4" name="view4" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone4" name="clone4" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all4" name="all4" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Week</td>
								<td align="center"><input type="checkbox" id="add5" name="add5" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit5" name="edit5" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete5" name="delete5" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view5" name="view5" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone5" name="clone5" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all5" name="all5" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							    <td align="center">Day</td>
								<td align="center"><input type="checkbox" id="add6" name="add6" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit6" name="edit6" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete6" name="delete6" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view6" name="view6" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone6" name="clone6" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all6" name="all6" onclick="serPermission();"/></td>
							  </tr>
							   <tr>
							  	<td align="center">Year</td>
								<td align="center"><input type="checkbox" id="add7" name="add7" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit7" name="edit7" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete7" name="delete7" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view7" name="view7" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone7" name="clone7" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all7" name="all7" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Locations view</td>
								<td align="center"><input type="checkbox" id="add8" name="add8" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit8" name="edit8" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete8" name="delete8" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view8" name="view8" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone8" name="clone8" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all8" name="all8" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Locations</td>
								<td align="center"><input type="checkbox" id="add9" name="add9" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit9" name="edit9" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete9" name="delete9" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view9" name="view9" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone9" name="clone9" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all9" name="all9" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Buildings</td>
								<td align="center"><input type="checkbox" id="add10" name="add10" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit10" name="edit10" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete10" name="delete10" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view10" name="view10" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone10" name="clone10" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all10" name="all10" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Buildings</td>
								<td align="center"><input type="checkbox" id="add11" name="add11" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit11" name="edit11" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete11" name="delete11" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view11" name="view11" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone11" name="clone11" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all11" name="all11" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Rooms</td>
								<td align="center"><input type="checkbox" id="add12" name="add12" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit12" name="edit12" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete12" name="delete12" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view12" name="view12" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone12" name="clone12" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all12" name="all12" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Rooms</td>
								<td align="center"><input type="checkbox" id="add13" name="add13" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit13" name="edit13" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete13" name="delete13" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view13" name="view13" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone13" name="clone13" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all13" name="all13" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Classroom Availability</td>
								<td align="center"><input type="checkbox" id="add14" name="add14" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit14" name="edit14" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete14" name="delete14" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view14" name="view14" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone14" name="clone14" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all14" name="all14" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Classroom Availability</td>
								<td align="center"><input type="checkbox" id="add15" name="add15" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit15" name="edit15" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete15" name="delete15" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view15" name="view15" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone15" name="clone15" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all15" name="all15" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Programs</td>
								<td align="center"><input type="checkbox" id="add16" name="add16" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit16" name="edit16" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete16" name="delete16" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view16" name="view16" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone16" name="clone16" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all16" name="all16" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Programs</td>
								<td align="center"><input type="checkbox" id="add17" name="add17" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit17" name="edit17" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete17" name="delete17" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view17" name="view17" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone17" name="clone17" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all17" name="all17" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Program Cycles</td>
								<td align="center"><input type="checkbox" id="add18" name="add18" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit18" name="edit18" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete18" name="delete18" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view18" name="view18" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone18" name="clone18" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all18" name="all18" onclick="serPermission();"/></td>
							  </tr>
							   <tr>
							  	<td align="center">Add Program Cycles</td>
								<td align="center"><input type="checkbox" id="add19" name="add19" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit19" name="edit19" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete19" name="delete19" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view19" name="view19" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone19" name="clone19" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all19" name="all19" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Areas</td>
								<td align="center"><input type="checkbox" id="add20" name="add20" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit20" name="edit20" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete20" name="delete20" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view20" name="view20" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone20" name="clone20" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all20" name="all20" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Areas</td>
								<td align="center"><input type="checkbox" id="add21" name="add21" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit21" name="edit21" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete21" name="delete21" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view21" name="view21" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone21" name="clone21" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all21" name="all21" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">List Subjects</td>
								<td align="center"><input type="checkbox" id="add22" name="add22" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit22" name="edit22" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete22" name="delete22" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view22" name="view22" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone22" name="clone22" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all22" name="all22" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Subjects</td>
								<td align="center"><input type="checkbox" id="add23" name="add23" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit23" name="edit23" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete23" name="delete23" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view23" name="view23" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone23" name="clone23" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all23" name="all23" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">View Timeslots</td>
								<td align="center"><input type="checkbox" id="add24" name="add24" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit24" name="edit24" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete24" name="delete24" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view24" name="view24" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone24" name="clone24" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all24" name="all24" onclick="serPermission();"/></td>
							  </tr>
							   <tr>
							  	<td align="center">View Teachers</td>
								<td align="center"><input type="checkbox" id="add25" name="add25" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit25" name="edit25" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete25" name="delete25" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view25" name="view25" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone25" name="clone25" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all25" name="all25" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Teachers</td>
								<td align="center"><input type="checkbox" id="add26" name="add26" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit26" name="edit26" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete26" name="delete26" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view26" name="view26" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone26" name="clone26" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all26" name="all26" onclick="serPermission();"/></td>
							  </tr>
							   <tr>
							  	<td align="center">View Teacher Availability</td>
								<td align="center"><input type="checkbox" id="add27" name="add27" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit27" name="edit27" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete27" name="delete27" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view27" name="view27" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone27" name="clone27" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all27" name="all27" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Teacher Availability</td>
								<td align="center"><input type="checkbox" id="add28" name="add28" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit28" name="edit28" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete28" name="delete28" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view28" name="view28" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone28" name="clone28" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all28" name="all28" onclick="serPermission();"/></td>
							  </tr>
							   <tr>
							  	<td align="center">View Holidays</td>
								<td align="center"><input type="checkbox" id="add29" name="add29" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit29" name="edit29" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete29" name="delete29" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view29" name="view29" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone29" name="clone29" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all29" name="all29" onclick="serPermission();"/></td>
							  </tr>
							  <tr>
							  	<td align="center">Add Holidays</td>
								<td align="center"><input type="checkbox" id="add30" name="add30" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="edit30" name="edit30" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="delete30" name="delet30" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="view30" name="view30" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="clone30" name="clone30" onclick="serPermission();"/></td>
								<td align="center"><input type="checkbox" id="all30" name="all30" onclick="serPermission();"/></td>
							  </tr>
							 </tbody> 
						</table>
					 </div>
					<div class="clear"></div>
                  </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>
