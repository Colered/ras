<?php include('header.php'); ?>
<div id="content">
    <div id="main">
        <div class="full_w" >
            <div class="h_title">Manage Timetable</div>
            <form action="" method="post">
                <div>
                    <div class="custtd_left1">
                        <a href="generate_timetable.php"><input type="button" name="btnProgram" class="buttonsub" value="New"></a>
                    </div>
                    <div class="custtd_right">
                        <!--<a href="#"><input type="button" name="btnArea" class="buttonsub" value="Edit"></a>-->
						<a target="_blank" href="month.php"><input type="button" name="btnSubject" class="buttonsub" value="Open"></a>
                    </div>
                    <div class="custtd_right">
                        <a target="_blank" href="timetable_view.php"><input type="button" name="btnSubject" class="buttonsub" value="View"></a>
                    </div>
                    <div class="custtd_left1">
                        <!--<a href="#"> <input type="button" name="btnTeacher" class="buttonsub" value="Save"></a>-->
                    </div>
                    <div class="custtd_right">
                        <!--<a href="#"><input type="button" name="btnClsrm" class="buttonsub" value="Publish"></a>-->
                    </div>
                    <div class="custtd_right">
                        <!--<a href="#"><input type="button" name="btnBuilding" class="buttonsub" value="Delete"></a>-->
                    </div>
                    <div class="clear"></div>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th >Checkbox</th>
                                    <th >Timetable</th>
                                    <th >Created On</th>
                                    <th >Last Edit</th>
                                    <th >Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-center"><input  type="radio" id="radio" name="radio"  /></td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <td class="align-center"><input type="radio" id="radio" name="radio"  /></td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                                <tr>
                                    <td class="align-center"><input type="radio" id="radio" name="radio"  /></td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>	
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php include('footer.php'); ?>

