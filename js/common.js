$(document).ready(function() {
$(function() {
    $(".activityDateCal").datepicker({
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#dob").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		maxDate: new Date(),
		changeMonth: true, 
		changeYear: true,
	});
	$("#doj").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#exceptnClsAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#exceptnTeachAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#exceptnClsrmAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#exceptnClsrmAval").datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#holiday_date").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#exceptnSpecialActAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		//$("#toSpcialAval").datepicker("option", "minDate", selectedDate);
		//$("#toSpcialAval").datepicker("option", "minDate", selectedDate);
	});
	$("#oneTimeDate").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$("#ad_hoc_fix_date").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	
});			   

$(function() {
	$("#fromGenrtTmtbl").datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toGenrtTmtbl").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#toGenrtTmtbl").datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromGenrtTmtbl").datepicker("option", "maxDate", selectedDate);
		}
	});
});
$(function() {
	$("#fromPrgm").datepicker({
			dateFormat: 'dd-mm-yy',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			changeMonth: true, 
			changeYear: true,
	        onSelect: function (date) {
	            var ptype = $('#slctPrgmType').val(); 
	            var date2 = $('#fromPrgm').datepicker('getDate');
	            date2.setDate(date2.getDate() + ptype*365);
	            dateString = $.datepicker.formatDate('dd-mm-yy', new Date(date2));
	            $('#toPrgm').val(dateString);
	        }
	});

	
});
$(function() {
	$("#fromTeachAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toTeachAval").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#toTeachAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromTeachAval").datepicker("option", "maxDate", selectedDate);
		}
	});
});
$(function() {
 $("#fromTmDuratn").datepicker({
      dateFormat: 'yy-mm-dd',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function(selectedDate) {
	   $("#toTmDuratn").datepicker("option", "minDate", selectedDate);
	  }
	 });
 $("#toTmDuratn").datepicker({
	  dateFormat: 'yy-mm-dd',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function(selectedDate) {
	   $("#fromTmDuratn").datepicker("option", "maxDate", selectedDate);
	  }
	 });
 $("#fromclsRmAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toclsRmAval").datepicker("option", "minDate", selectedDate);
		}
	});
 $("#toclsRmAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromclsRmAval").datepicker("option", "maxDate", selectedDate);
		}
	});
  });

$(function() {
	$("#fromGenrtWR").datepicker({
	    dateFormat: 'yy/mm/dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate) {
			 $("#toGenrtWR").datepicker("option", "minDate", selectedDate);
             var maxDate = new Date(Date.parse(selectedDate));
			 maxDate.setDate(maxDate.getDate() + 6 ); 
			 $( "#toGenrtWR" ).datepicker( "option", "maxDate", maxDate);
        }
	});
	$("#toGenrtWR").datepicker({
	    dateFormat: 'yy/mm/dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromGenrtWR").datepicker("option", "maxDate", selectedDate);
			var minDate = new Date(Date.parse(selectedDate));
            minDate.setDate(minDate.getDate() - 6 );   
			$("#fromGenrtWR").datepicker("option", "minDate", minDate);
		}
	});
 });
$(function() {
	$("#fromGenrtWPR").datepicker({
	    dateFormat: 'yy/mm/dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate) {
			 $("#toGenrtWPR").datepicker("option", "minDate", selectedDate);
             //var maxDate = new Date(Date.parse(selectedDate));
			 //maxDate.setDate(maxDate.getDate() + 6 ); 
			 $( "#toGenrtWPR" ).datepicker( "option", "minDate", selectedDate);
        }
	});
	$("#toGenrtWPR").datepicker({
	    dateFormat: 'yy/mm/dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromGenrtWR").datepicker("option", "maxDate", selectedDate);
			//var minDate = new Date(Date.parse(selectedDate));
            //minDate.setDate(minDate.getDate() - 6 );   
			$("#fromGenrtWR").datepicker("option", "maxDate", selectedDate);
		}
	});
 });
$(function() {
	$("#fromSpecialAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toSpcialAval").datepicker("option", "minDate", selectedDate);
			$("#exceptnSpecialActAval").datepicker("option", "minDate", selectedDate);
		}
		
	});
	$("#toSpcialAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromSpecialAval").datepicker("option", "maxDate", selectedDate);
			$("#exceptnSpecialActAval").datepicker("option", "maxDate", selectedDate);
		}
	});
});
$(function() {
	$("#fromPeriodicAct").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toPeriodicAct").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#toPeriodicAct").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromPeriodicAct").datepicker("option", "maxDate", selectedDate);
		}
	});
});
$(function() {
	$("#fromADHocDate").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#toADHocDate").datepicker("option", "minDate", selectedDate);
		}
	});
	$("#toADHocDate").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function(selectedDate) {
			$("#fromADHocDate").datepicker("option", "maxDate", selectedDate);
		}
	});
});
});
//validate form 
$(document).ready(function(){
		$('.periodicAct').hide();
		$('.otAct').hide();
		$("#dialog-confirm").hide();
		$("#dialog-confirm-area").hide();
		$("#areaForm").validate();
		$("#roomsForm").validate();
		$("#buildings").validate();
		$("#locations").validate();
		$("#frmProgram").validate();
		$("#frmProff").validate();
		$("#frmSgroup").validate();
		$("#frmTactivity").validate();
		$("#teacherAvailabilityForm").validate();
		$("#classroomAvailabilityForm").validate();
		$("#teacher_report").validate();
		$("#teacher_rate_report").validate();
		$("#timetable").validate();
		$("#weekly_report").validate();
		$("#roleAdd").validate();
		//$("#userMgmtForm").validate();
		//$("#changePwdForm").validate();
		$( "#forgotPwdForm" ).validate({
			rules: {
			email: {
				required: true,
				email: true
			}
			}
		});
		$( "#userMgmtForm" ).validate({
			rules: {
			txtUserName: {
				required: true,
				},
			txtUserPwd: {
				required: true,
				}	,
			txtUserEmail: {
				required: true,
				email: true
				},
			slctUserType: {
				required: true,
				}
			}
		});
		$( "#changePwdForm" ).validate({
			rules: {
			newPassword: {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			confirmPassword: {
				required: true,
				minlength: 6,
				maxlength: 20
			}
			}
		});
		
		
});
//Function to validate the email ID
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
//Ajax delete the areas function 
function deleteArea($id){
	if($id==""){
		alert("Please select a area to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Area?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_area',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else if($succ==2){
						alert("Cannot delete this area as this is being used by some other subjects.");
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Area.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//ajax delete the building
function deleteBuld($id){
	if($id==""){
		alert("Please select a building to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Building? It will also delete all the rooms and other associated data.")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_buld',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Building.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}

//Ajax delete the teacher function 
function deleteTeacher($id){
	if($id==""){
		alert("Please select a teacher to delete");
		return false;
	}else if(confirm("Are you sure you want to delete?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_teacher',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//Ajax delete the program function 
function deleteProgram($id){
	if($id==""){
		alert("Please select a program to delete");
		return false;
	}else if(confirm("Are you sure you want to delete? This will delete all the related subjects, sessions and activities")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_program',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}

//function to show hide program cycles
function show_hide_cycle(selval){
	if(selval==1){
	  $('#firstCycle').show();
	}else if(selval==2){
	  $('#firstCycle').show();
	  $('#secondCycle').show();
	}else if(selval==3){
	  $('#firstCycle').show();
	  $('#secondCycle').show();
	  $('#thirdCycle').show();
	}
}
//Ajax delete the room function 
function deleteRoom($id){
	if($id==""){
		alert("Please select a room to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Room?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_room',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Room.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//ajax delete the group
function deleteGroup($id){
	if($id==""){
		alert("Please select a group to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Group?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_group',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Group.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//function to show groups at the time of association with programs
function showGroups(selval){
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'program_id': selval,
			'codeBlock': 'getGroups',
            },
        success: function(data) {
			 $("#slctSgroups").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
//Ajax delete the associated groups with a program 
function del_associated_prog_group($id){
	if($id==""){
		alert("Please select an association to delete");
		return false;
	}else if(confirm("Are you sure you want to delete?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_associated_prog_group',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}

//ajax delete timeslot
function deleteTimeslot($id){
	if($id==""){
		alert("Please select a timeslot to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Timeslot?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_timeslot',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Group.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}

//Ajax delete the Subject function 
function deleteSubject($id){
	if($id==""){
		alert("Please select a subject to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Subject? This will delete all the related sessions and activities.")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_subject',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected subject.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}

//function for addind session number with subject
$(document).ready(function() {
 	$('.subjectSession').hide();
}); 
//$(document).ready(function() {
	//function for check availability
	/*$("#btnCheckAvail").on( "click", function() {
		checkAvailability();									  
	});*/
	
	//add a new session function										  
	/*$("#btnAddNewSess").on( "click", function() {
		addSubjectSession();										  
	});*/
//});

function checkAvailability($usrAccessforPopup) {
	$usrAccessFlag = $usrAccessforPopup;
	//alert($usrAccessFlag);
	    /*if($forcing == undefined){
			$forcing="";
		}*/
		var txtSessionName="", txtCaseNo="", slctTeacher="",tslot_id="", subSessDate="", txtareatechnicalNotes="", txtareaSessionDesp="", programId="", cycleId="", areaId="", subjectId="";
		var subIdEncrypt = $('#subIdEncrypt').val();
  		//custom validation for all the fieelds on form
		var formValid = 0;
		if($('#txtSessionName').val()==""){
			$('#txtSessionName').css('border', '1px solid red');
			var formValid = 1;
		}else{
			$('#txtSessionName').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#allocation_style').val()=="Allocation by Rule")
		{
			if($('#slctTeacherRule').val()=="" || $('#slctTeacherRule').val()==null){
				$('#slctTeacherRule').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#slctTeacherRule').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
			if($('#slctTeacherRule option:selected').length > 1 && $('#reasonRule').val()==""){
				$('#reasonRule').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#reasonRule').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
		}else{
			if($('#slctTeacherInd').val()=="" || $('#slctTeacherInd').val()==null){
				$('#slctTeacherInd').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#slctTeacherInd').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
			if($('#slctTeacherInd option:selected').length > 1 && $('#reasonInd').val()==""){
				$('#reasonInd').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#reasonInd').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
		}		
		if($('#room_id').val()==""){
			$('#room_id').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#room_id').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#tslot_id').val()==""){
			$('#tslot_id').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#tslot_id').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#duration').val()==""){
			$('#duration').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#duration').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#subSessDate').datepicker().val()==""){
			$('#subSessDate').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#subSessDate').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if(($('#txtSessionName').val()=="") || ($('#duration').val()=="") || ($('#allocation_style').val()=="Allocation by Individual") && ($('#slctTeacherInd').val()=="") || ($('#allocation_style').val()=="Allocation by Rule") && ($('#slctTeacherRule').val()=="") || ($('#subSessDate').datepicker().val()=="") || ($('#slctTeacherInd option:selected').length > 1 && $('#reasonInd').val()=="") || ($('#slctTeacherRule option:selected').length > 1 && $('#reasonRule').val()=="")){
			var formValid = 1; 
			return false;
			}
		if($('#allocation_style').val()=="Allocation by Rule")
		{
			slctTeacher = $('#slctTeacherRule').val();
			reason = $('#reasonRule').val();
		}
		else{
			slctTeacher = $('#slctTeacherInd').val();
			reason = $('#reasonInd').val();
		}
		//sending an ajax request to check the availability of an activity
		if(formValid==0){
			$.ajax({
					type: "POST",
					url: "ajax_common.php",
					data: {
						'subjectId': $('#subjectId').val(),
						'cycleId': $('#slctCycle').val(),
						'txtSessionName': $('#txtSessionName').val(),
						//'txtOrderNum': $('#txtOrderNum').val(),
						'txtareaSessionDesp': $('#txtareaSessionDesp').val(),
						'txtCaseNo': $('#txtCaseNo').val(),
						'txtareatechnicalNotes': $('#txtareatechnicalNotes').val(),
						'room_id': $('#room_id').val(),
						'programId': $('#slctProgram').val(),
						'areaId': $('#slctArea').val(),
						'slctTeacher': slctTeacher,
						'reason':reason,
						'tslot_id': $('#tslot_id').val(),
						'duration': $('#duration').val(),
						'subSessDate': $('#subSessDate').val(),
						'sess_hidden_id': $('#sess_hidden_id').val(),
						'act_hidden_id': $('#act_hidden_id').val(),
						//'check_avail_force_entry':$forcing,
						'force_flag':0,
						'codeBlock': 'checkAvailabilitySession',
					},
					success: function($succ){
						if($succ==1){
							$('#showstatusNoAvail').hide();
							$('#showstatusAvail').show();
						}else if($succ==2){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('session name already exist.');
						}else if($succ==5){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher is not available on the selected time and day.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==6){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('This session cannot happen in selected room, as other sessions of this subject are scheduled in different room.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==3){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher is already engaged in other activity.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==4){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Classroom is already engaged in other activity.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==7){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Classroom is not free on the given date and time.');
						}else if($succ==8){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Session Name, Teacher, Room, Timeslot and Date are mendatory fields to create a reserved activity.');
						}else if($succ==9){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Program is not available on the selected day and time.');
						}else if($succ==10){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher already have 4 sessions allocated to him on selected day.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==11){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Selected teacher already have other classs at some different location on the selected day.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==12){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher is already allocated to two saturdays of this cycle.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==13){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('The sessions scheduled on Saturdays should be from the same academic area.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==14){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Maximum number of sessions for the selected area and date has been exceeded.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==15){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Please choose a single teacher while creating a reserved activity with alternate teacher option.');
						}else if($succ==16){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Program already have some reserved activity on the selected date and time.');
						}else if($succ==17){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Maximum number of sessions of the Program for the selected date has been exceeded.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else{
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert("Cannot create the session.");
						}
					}
				});
		}else{
			return false;
		}
}
function addSubjectSession($forcing,$force_flag,$usrAccessFlag){
		if($forcing == undefined){
		   $forcing="";
		}
		if($force_flag == undefined){
		   $force_flag="0";
		}	
	    if($usrAccessFlag == undefined){
			$usrAccessFlag = 0;
		}
	    var txtSessionName="", txtCaseNo="", tslot_id="", subSessDate="", txtareatechnicalNotes="", txtareaSessionDesp="", programId="", cycleId="", areaId="", subjectId="";	
		var subIdEncrypt = $('#subIdEncrypt').val();
 		//validating the forms
 		var formValid = 0;
		
		if($('#txtSessionName').val()==""){
			$('#txtSessionName').css('border', '1px solid red');
			var formValid = 1;
		}else{
			$('#txtSessionName').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#duration').val()==""){
			$('#duration').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#duration').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#allocation_style').val()=="Allocation by Rule")
		{
			if($('#slctTeacherRule').val()=="" || $('#slctTeacherRule').val()==null){
				$('#slctTeacherRule').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#slctTeacherRule').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
			if($('#slctTeacherRule option:selected').length > 1 && $('#reasonRule').val()==""){
				$('#reasonRule').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#reasonRule').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
		}else{
			if($('#slctTeacherInd').val()=="" || $('#slctTeacherInd').val()==null){
				$('#slctTeacherInd').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#slctTeacherInd').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
			if($('#slctTeacherInd option:selected').length > 1 && $('#reasonInd').val()==""){
				$('#reasonInd').css('border', 'solid 1px red');
				var formValid = 1; 
			}else{
				$('#reasonInd').css('border', '1px solid #C0C0C0');
				var formValid = 0;
			}
		}		
		if($('#subjectId').val()==""){
			var formValid = 1;
			alert('Please save subject info before add to session.');
			return false;
		}
		if(($('#txtSessionName').val()=="") || ($('#duration').val()=="") || ($('#allocation_style').val()=="Allocation by Individual") && ($('#slctTeacherInd').val()=="") || ($('#allocation_style').val()=="Allocation by Rule") && ($('#slctTeacherRule').val()=="") || ($('#slctTeacherInd option:selected').length > 1 && $('#reasonInd').val()=="") || ($('#slctTeacherRule option:selected').length > 1 && $('#reasonRule').val()=="")) {
			var formValid = 1; 
			return false;
			}
		if($('#allocation_style').val()=="Allocation by Rule")
		{
			slctTeacher = $('#slctTeacherRule').val();
			reason = $('#reasonRule').val();
		}
		else{
			slctTeacher = $('#slctTeacherInd').val();
			reason = $('#reasonInd').val();
		}
		//sending an ajax request to save the session and creating a teacher activity
		if(formValid==0){
			$.ajax({
					type: "POST",
					url: "ajax_common.php",
					data: {
						'subjectId': $('#subjectId').val(),
						'cycleId': $('#slctCycle').val(),
						'txtSessionName': $('#txtSessionName').val(),
						//'txtOrderNum': $('#txtOrderNum').val(),
						'txtareaSessionDesp': $('#txtareaSessionDesp').val(),
						'txtCaseNo': $('#txtCaseNo').val(),
						'txtareatechnicalNotes': $('#txtareatechnicalNotes').val(),
						'room_id': $('#room_id').val(),
						'programId': $('#slctProgram').val(),
						'areaId': $('#slctArea').val(),
						'slctTeacher': slctTeacher,
						'tslot_id': $('#tslot_id').val(),
						'duration': $('#duration').val(),
						'subSessDate': $('#subSessDate').val(),
						'sess_hidden_id': $('#sess_hidden_id').val(),
						'act_hidden_id': $('#act_hidden_id').val(),
						'force_var':$forcing,
						'force_flag':$force_flag,
						'reason':reason,
						'codeBlock': 'add_sub_session',
					},
					success: function($succ){
						if($succ==1){
							window.location.href = 'subjects.php?edit='+subIdEncrypt;
							//alert("New session is added successfully");
						}else if($succ==2){
							alert('session name already exist.');
						}else if($succ==5){
							alert('Teacher is not available on the selected time and day.');
						}else if($succ==6){
							alert('This session cannot happen in selected room, as other sessions of this subject are scheduled in different room.');
						}else if($succ==3){
							alert('Teacher is already engaged in other activity.');
						}else if($succ==4){
							alert('Classroom is already engaged in other activity.');
						}else if($succ==7){
							alert('Classroom is not free on the given date and time.');
						}else if($succ==8){
							alert('Session Name, Duration, Teacher, Room, Timeslot and Date are mendatory fields to create a reserved activity.');
						}else if($succ==9){
							alert('Program is not available on the selected day and time.');
						}else if($succ==10){
							alert('Teacher already have 4 sessions allocated to him on selected day.');
						}else if($succ==11){
							alert('Teacher is already allocated to some different location the same day.');
						}else if($succ==12){
							alert('Teacher is already allocated to two saturdays of this cycle.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==13){	
							alert('The sessions scheduled on Saturdays should be from the same academic area.');
							if($usrAccessFlag==1)
								opendialogToComfirmArea();
						}else if($succ==14){
							alert('Maximum number of sessions for the selected area and date has been exceeded.');
						}else if($succ==15){
							alert('Please choose a single teacher while creating a reserved activity with alternate teacher option.');
						}else if($succ==16){							
							alert('Program already have some reserved activity on the selected date and time.');
						}else if($succ==17){
							alert('Maximum number of sessions of the Program for the selected date has been exceeded.');
						}else{
							alert("Cannot create the session.");
						}
					}
				});
		}else{
				return false;
		}
	
}
function getSessionName(subjectId)
{
	var divSessionName = '#divSessionName'+subjectId;
    var imageId='#sessionNameImg'+subjectId;
		if($(divSessionName).css('display') == 'none') {
		//close all the open links
		$(".subjectSession").slideUp("slow");
		$(".sessionNameImg").attr({src: 'images/plus_icon.png'});
		//open the clicked link
		$(divSessionName).slideDown("slow");
        $(imageId).attr({src: 'images/minus_icon.png'});
    }
    else {
        $(divSessionName).slideUp("slow");
        $(imageId).attr({src: 'images/plus_icon.png'});
	}
}


//Ajax delete the Subject function 
function delAllSessForASub($subjectId, $encSubjectId){
	if(confirm("Are you sure you want to delete all sessions of selected subject?")) {
		$.ajax({
				type: "POST",
				url: "ajax_common.php",
				data: {
					'subjectId': $subjectId,
					'codeBlock': 'del_AllSessForASub',
				},
				success: function($succ){
					if($succ==1){
						window.location.href = 'subjects.php?edit='+$encSubjectId+'';
					}else{
						alert("Cannot delete all sessions for the selected subject.");
						$('.green, .red').hide();
					}
				}
		});
	}
    return false;
}
//Ajax delete the Subject function 
function removeSession($activityId, $sessionID, $subjectId, $srno ){
	if(confirm("Are you sure you want to delete the session?")) {
		$.ajax({
				type: "POST",
				url: "ajax_common.php",
				data: {
					'activityId': $activityId,
					'sessionID': $sessionID,
					'codeBlock': 'del_activity',
				},
				success: function($succ){
					if($succ==2){
						//if the activity is last then delete the session also
						if(confirm("if you will delete this activity, the session will also be deleted.?")) {
							$.ajax({
										type: "POST",
										url: "ajax_common.php",
										data: {
											'activityId': $activityId,
											'sessionID': $sessionID,
											'codeBlock': 'del_sub_activity_session',
										},
										success: function($succ){
											if($succ==1){
												//reload the page
												window.location.href = 'subjects.php?edit='+$subjectId+'';										
											}else{
												alert("Cannot delete the selected session.");
												$('.green, .red').hide();
											}
										}
								});
							}
						return false;
					}else if($succ==1){
						window.location.href = 'subjects.php?edit='+$subjectId+'';
					}else{
						alert("Cannot delete the selected subject session.");
						$('.green, .red').hide();
					}
				}
		});
	}
    return false;
}
//function to show subjects by program
function showSubjects(selval){
    $("#ajaxload_subject").show();
    $("#ajaxload_progCycle").show();
    showPYCycles(selval);
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'year_id': selval,
			'codeBlock': 'getSubjects',
        },
        success: function(data) {
             $("#ajaxload_subject").hide();
			 $("#slctSubject").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
//function to show subjects by program
function showPYCycles(pyid){
    $("#ajaxload_progCycle").show();
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'py_id': pyid,
			'codeBlock': 'getCyclesByPyId',
        },
        success: function(data) {
             $("#ajaxload_progCycle").hide();
			 $("#slctProgramCycle").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
//function to show sessions for a subject
function showSessions(selval){
    $("#ajaxload_session").show();
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'subject_id': selval,
			'codeBlock': 'getSessions',
        },
        success: function(data) {
             $("#ajaxload_session").hide();
			 $("#slctSession").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
//Ajax delete the teacher activity function 
function deleteTeacherActivity($id){
	if($id==""){
		alert("Please select an activity to delete");
		return false;
	}else if(confirm("Are you sure you want to delete?")) {
	    $.ajax({
			type: "POST",
			url: "ajax_common.php",
			data: {
				'id': $id,
				'codeBlock': 'del_teacher_activity',
			},
			success: function($succ){
				if($succ==1){
					$('#'+$id).closest('tr').remove();
					$('.green, .red').hide();
				}else{
					alert("Cannot delete the selected Activity.");
					$('.green, .red').hide();
				}
			}
        });
    }
    return false;
}
//function to add activity
$(document).ready(function() {
    $("#btnTeacherAct").on('click',addTeacherActivity);
});
//Ajax function to add activities
function addTeacherActivity()
{ 
	 if($('#frmTactivity').valid()){
		 var slctProgram = $('#slctProgram').val();
		 var slctProgramCycle = $('#slctProgramCycle').val();
		 var slctSubject = $('#slctSubject').val();
		 var slctSession = $('#slctSession').val();
		 var slctTeacher = $('#slctTeacher').val();
		 $("#ajaxload_actDiv").show();
		 $.ajax({
		   url: "./ajax_common.php",
		   type: "POST",
		   data: {
			   'program_year_id': slctProgram,
			   'cycle_id':slctProgramCycle,
			   'subject_id': slctSubject,
			   'session_id': slctSession,
			   'teachersArr': slctTeacher,
			   'codeBlock': 'addTeacherAct',
		   },
		   success: function(data) {
			 $("#ajaxload_actDiv").hide();
			 $("#activityAddMore").html(data).find(".activityDateCal").datepicker({
                inline: true,
				dateFormat: 'dd-mm-yy',
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 1,
				changeMonth: true, 
				changeYear: true
             });
			 $("#activityReset").show();
		   },
		   error: function(errorThrown) {
			   console.log(errorThrown);
		   }
	  });
   }	   	  
}
// end ajax add activity
$(document).ready(function() {
 $('#slctClsType').on('change', function(){
    var selected=$("#slctClsType option:selected").map(function(){ return this.value }).get().join(",");
	var slctRoom="slctRoom";
	ajaxCommonClassroomAvail(selected,slctRoom);
 });
});

$(document).ready(function() {
 $('#slctClsType').on('change', function(){
    var selected=$("#slctClsType option:selected").map(function(){ return this.value }).get().join(",");
	var slctRoom="slctRoom";
	ajaxCommonClassroomAvail(selected,slctRoom);
 });
});
//getting room for classroom avalability 
$(document).ready(function() {
  $('#slctRmType').on('change', function(){
	var selected=$("#slctRmType option:selected").map(function(){ return this.value }).get().join(",");
	var slctRmName="slctRmName";
	ajaxCommonClassroomAvail(selected,slctRmName);
  });
});
//common ajax function of classromm availability
function ajaxCommonClassroomAvail(selectedVal,slctID){
	var slctID = '#'+slctID;
$.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'roomTypeValue': selectedVal,
			'codeBlock': 'getRooms'
            },
        success: function(data) {
			 $(slctID).html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });	
}
//getting rooms in dropdown for classroom availability
function getRoomByType(roomId){
	var selected=$("#slctRmType option:selected").map(function(){ return this.value }).get().join(",");
	 $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'roomTypeValue': selected,
			'codeBlock': 'getRooms',
			'roomId': roomId,
		},
        success: function(data) {
			 $("#slctRmName").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
      });
}
$(document).ready(function(){
	$("#ts-avail-day-0,#ts-avail-day-1,#ts-avail-day-2,#ts-avail-day-3,#ts-avail-day-4,#ts-avail-day-5").hide();
	   $('input[class=days]').click(function(){
            if($(this).attr("value")=="0"){
				$("#ts-avail-day-0").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-0").val('');
   				}
			}
            if($(this).attr("value")=="1"){
				$("#ts-avail-day-1").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-1").val('');
   				}
            }
            if($(this).attr("value")=="2"){
				$("#ts-avail-day-2").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-2").val('');
   				}
            }
			if($(this).attr("value")=="3"){
				$("#ts-avail-day-3").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-3").val('');
   				}
            }
			if($(this).attr("value")=="4"){
				$("#ts-avail-day-4").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-4").val('');
   				}
            }
			if($(this).attr("value")=="5"){
				$("#ts-avail-day-5").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-day-5").val('');
   				}
            }
	   });
});
$(document).ready(function() {
 var count=1;
 $('.btnCreateRule').click(function(e){
  	var timeslotMon = ""; var timeslotTue=""; var timeslotWed=""; var timeslotThu=""; var timeslotFri=""; var timeslotSat="";
	if($('#txtSchd').val()==""){
			alert('Please select a valid Schedule Name.');
	}else if($('#fromTmDuratn').val()==""){
			alert('Please select a valid From Time.');
	}else if($('#toTmDuratn').val()==""){ 
			alert('Please select a valid To Time.');
	}else if($('.tmSlot input:checked').length <= 0){
			alert('Please select atleast one day and timeslot.');
	}else{
		//get the selected values on each days
		if($('#Mon:checked').length > 0){
				if($('#ts-avail-day-0').val()==null){
					alert('please select the timeslot of monday');
					return false;
				}else{
					var timeslotMon = '{' +$('select#ts-avail-day-0').val()+ '}';
				}
		}
		if($('#Tue:checked').length > 0) {
				if($('#ts-avail-day-1').val()==null){
					alert('please select the timeslot of tuesday');
					return false;
				}else{
					var timeslotTue = '{' +$('select#ts-avail-day-1').val()+ '}';
				}
			
		}
		if($('#Wed:checked').length > 0) {
				if($('#ts-avail-day-2').val()==null){
					alert('please select the timeslot of wednesday');
					return false;
				}else{
					var timeslotWed = '{' +$('select#ts-avail-day-2').val()+ '}';
				}
		}
		if($('#Thu:checked').length > 0){
				if($('#ts-avail-day-3').val()==null){
					alert('please select the timeslot of thursday');
					return false;
				}else{
					var timeslotThu = '{' +$('select#ts-avail-day-3').val()+ '}';
				}
		}
		if($('#Fri:checked').length > 0){
				if($('#ts-avail-day-4').val()==null){
					alert('please select the timeslot of friday');
					return false;
				}else{
					var timeslotFri = '{' +$('select#ts-avail-day-4').val()+ '}';
				}
		}
		if($('#Sat:checked').length > 0){
				if($('#ts-avail-day-5').val()==null){
					alert('please select the timeslot of saturday');
					return false;
				}else{
					var timeslotSat = '{' +$('select#ts-avail-day-5').val()+ '}';
				}
		}							
		//send ajax request to insert values into DB		
 if(timeslotMon!="" || timeslotTue!="" || timeslotWed!="" || timeslotThu!="" || timeslotFri!="" || timeslotSat!=""){				
	var schdName=$('#txtSchd').val();
	var dateFrom=$('#fromTmDuratn').val();
	var dateTo=$('#toTmDuratn').val();
	var dateRange = 'From '+dateFrom+' to '+dateTo;
	var days = new Array();
	$.each($("input[name='day[]']:checked"), function() {
			days.push($(this).val());
		});
	var tsValArr = new Array();
	for($i=0;$i<days.length;$i++){
		var clsTmSlot = '#ts-avail-day-'+days[$i];
		var str='option:selected';
		var tmSlotVal=$(clsTmSlot+ ' ' +str).map(function(){ return this.value }).get().join(",");
		tsValArr.push(tmSlotVal); 
	}
	
	$.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
			'SchdName': schdName,
			'countRule': count,
			'dateFrom': dateFrom,
			'dateTo': dateTo,
			'dateRange': dateRange,
            'days': days,
			'timeSoltArr': tsValArr,
			'codeBlock': 'createClassAvailabilityRules',
            },
        success: function(data) {			
			if(data==1){
			 count++;
			 $('#fromTmDuratn, #toTmDuratn,.slctTs').val('');
			 $("#ts-avail-day-0,#ts-avail-day-1,#ts-avail-day-2,#ts-avail-day-3,#ts-avail-day-4,#ts-avail-day-5").hide();
			 $('.days').prop('checked', false);
			 $('#txtSchd').val('');
			  $id = "";
			  if($('#slctRmName').val()!=""){
				 $id = '?rid='+$('#slctRmName').val();
			    }
				window.location.href = 'classroom_availability.php'+$id+'';
			 }else{
				alert("Rule name already exists.");
			 }
		},
        error: function(errorThrown) {
            console.log(errorThrown);
        }
      });
	}else{
		alert('Please select atleast one timeslot.');
	 }
	}
  });
});
//function to reset reserved flag
function reset_reserved_flag(){
    if($("input:radio[name=reserved_flag]").is(":checked")){
		var row_id = $('input:radio[name=reserved_flag]:checked', '#frmTactivity').val();
		$("#room_validate_"+row_id).hide();
		$("#tslot_validate_"+row_id).hide();
		$("#activityDate_validate_"+row_id).hide();
		$("#btnTeacherCheckAbail_"+row_id).hide();
		$("#room_id_"+row_id).prop("disabled", true);
		$("#tslot_id_"+row_id).prop("disabled", true);
		$("#activityDateCal_"+row_id).prop("disabled", true);
	}
	$(".activity_row_chk").val("");
	$(".activityDateCal").val("");
	$('input:radio[name=reserved_flag]').attr('checked',false);
}
function roomTslotValidate(tid)
{
	$(".rfv_error").hide();
	$(".activity_row_chk").prop("disabled", true);
	$(".activityDateCal").prop("disabled", true);
	$(".btnTeacherCheckAbail").hide();
	$("#btnTeacherCheckAbail_"+tid).show();

	$(".activity_row_chk").val("");
	$(".activityDateCal").val("");

	$("#room_id_"+tid).prop("disabled", false);
	$("#room_validate_"+tid).show();

	$("#tslot_id_"+tid).prop("disabled", false);
	$("#tslot_validate_"+tid).show();

	$("#activityDateCal_"+tid).prop("disabled", false);
	$("#activityDate_validate_"+tid).show();
   	  
}
function roomTslotValidateEdit(tid)
{
	$(".rfv_error").hide();
	$(".activity_row_chk").prop("disabled", true);
	$(".activityDateCal").prop("disabled", true);
	$(".btnTeacherCheckAbail").hide();
	$("#btnTeacherCheckAbail_"+tid).show();

	$("#room_id_"+tid).prop("disabled", false);
	$("#tslot_id_"+tid).prop("disabled", false);
	$("#activityDateCal_"+tid).prop("disabled", false);
   	  
}
//Ajax to check activity availability
function checkActAvailability(program_year_id,subject_id,sessionid,teacher_id,row_id)
{
    var room_id = $("#room_id_"+row_id).val();
    if(room_id!=''){
      $("#room_validate_"+row_id).hide();
    }
    var tslot_id = $("#tslot_id_"+row_id).val();
    if(tslot_id!=''){
	  $("#tslot_validate_"+row_id).hide();
    }
	var act_date_val = $("#activityDateCal_"+row_id).val();
	if(act_date_val!=''){
	  $("#activityDate_validate_"+row_id).hide();
	}
	$("#room_tslot_availability_avail_"+row_id).hide();
	$("#room_tslot_availability_not_avail_"+row_id).hide();
	
    if(room_id!='' && tslot_id!='' && act_date_val!=''){
		$.ajax({
			 url: "./ajax_common.php",
			 type: "POST",
			 data: {
				'program_year_id': program_year_id,
				'subject_id': subject_id,
				'sessionid': sessionid,
				'teacher_id': teacher_id,
				'room_id': room_id,
				'tslot_id': tslot_id,
				'act_date_val': act_date_val,
				'codeBlock': 'checkActAvailability',
			 },
			 success: function(data) {
			     if(data==1){
			        $("#room_tslot_availability_not_avail_"+row_id).show();
				 	$('input[type="submit"]').attr('disabled' , true);
				 }else{
				   $("#room_tslot_availability_avail_"+row_id).show();
				   $('input[type="submit"]').attr('disabled' , false);
				 }	
			 },
			 error: function(errorThrown) {
				 console.log(errorThrown);
			 }
		});
   }	
}
$(document).ready(function(){
	$("#ts-avail-mon,#ts-avail-tue,#ts-avail-wed,#ts-avail-thu,#ts-avail-fri,#ts-avail-sat").hide();
	$('.actNameCls').hide();
	   $('input[class=days]').click(function(){
            if($(this).attr("value")=="Mon"){
				$("#ts-avail-mon").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-mon").val('');
   				}
			}
            if($(this).attr("value")=="Tue"){
				$("#ts-avail-tue").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-tue").val('');
   				}
            }
            if($(this).attr("value")=="Wed"){
				$("#ts-avail-wed").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-wed").val('');
   				}
            }
			if($(this).attr("value")=="Thu"){
				$("#ts-avail-thu").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-thu").val('');
   				}
            }
			if($(this).attr("value")=="Fri"){
				$("#ts-avail-fri").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-fri").val('');
   				}
            }
			if($(this).attr("value")=="Sat"){
				$("#ts-avail-sat").toggle();
				if($(this).is(":not(:checked)")){
   					$("#ts-avail-sat").val('');
   				}
            }
	   });
});
$(document).ready(function(){
	$(".sp-act-ts-mon,.sp-act-ts-tue,.sp-act-ts-wed,.sp-act-ts-thu,.sp-act-ts-fri,.sp-act-ts-sat").hide();
	   $('input[class=days]').click(function(){
			if($(this).attr("value")=="Mon"){
				$(".sp-act-ts-mon").toggle();
			}
            if($(this).attr("value")=="Tue"){
				$(".sp-act-ts-tue").toggle();
			 }
            if($(this).attr("value")=="Wed"){
				$(".sp-act-ts-wed").toggle();
			}
			if($(this).attr("value")=="Thu"){
				$(".sp-act-ts-thu").toggle();
			}
			if($(this).attr("value")=="Fri"){
				$(".sp-act-ts-fri").toggle();
			}
			if($(this).attr("value")=="Sat"){
				$(".sp-act-ts-sat").toggle();
			}
	   });
});
//function to show subjects by program
function createTeachAvailRule(){
	var timeslotMon = ""; var timeslotTue=""; var timeslotWed=""; var timeslotThu=""; var timeslotFri=""; var timeslotSat="";
	var regx = /^[A-Za-z0-9 .]+$/;
    /*if (!regx.test($('#txtSchd').val())) {
        alert('Please select a valid schedule name with alphanumeric options.');
		return false;
    }*/
    if($('#txtSchd').val()==""){
		alert('Please select a valid Schedule Name.');
		return false;
	}else if($('#fromTeachAval').val()==""){
			alert('Please select a valid From Time.');
	}else if($('#toTeachAval').val()==""){ 
			alert('Please select a valid To Time.');
	}else if($('.tmSlot input:checked').length <= 0){
			alert('Please select atleast one day and timeslot.');
	}else{
		//get the selected values on each days
		if($('#Mon:checked').length > 0){
				if($('#ts-avail-mon').val() == null){
					alert('please select the timeslot of monday');
					return false;
				}else{
					var timeslotMon = '{' +$('select#ts-avail-mon').val()+ '}';
				}
		}
		if($('#Tue:checked').length > 0){
				if($('#ts-avail-tue').val() == null){
					alert('please select the timeslot of tuesday');
					return false;
				}else{
					var timeslotTue = '{' +$('select#ts-avail-tue').val()+ '}';
				}
		}
		if($('#Wed:checked').length > 0){
				if($('#ts-avail-wed').val() == null){
					alert('please select the timeslot of wednesday');
					return false;
				}else{
					var timeslotWed = '{' +$('select#ts-avail-wed').val()+ '}';
				}
		}
		if($('#Thu:checked').length > 0){
				if($('#ts-avail-thu').val() == null){
					alert('please select the timeslot of thursday');
					return false;
				}else{
					var timeslotThu = '{' +$('select#ts-avail-thu').val()+ '}';
				}
		}
		if($('#Fri:checked').length > 0){
				if($('#ts-avail-fri').val() == null){
					alert('please select the timeslot of friday');
					return false;
				}else{
					var timeslotFri = '{' +$('select#ts-avail-fri').val()+ '}';
				}
			
		}
		if($('#Sat:checked').length > 0){
				if($('#ts-avail-sat').val() == null){
					alert('please select the timeslot of saturday');
					return false;
				}else{
					var timeslotSat = '{' +$('select#ts-avail-sat').val()+ '}';
				}
		}
		//send ajax request to insert values into DB		
		if(timeslotMon!="" || timeslotTue!="" || timeslotWed!="" || timeslotThu!="" || timeslotFri!="" || timeslotSat!=""){
			$.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'rule_name': $('#txtSchd').val(),
					'start_date': $('#fromTeachAval').val(),
					'end_date': $('#toTeachAval').val(),
					'codeBlock': 'createTeachAvaRule',
					'timeslotMon': timeslotMon,
					'timeslotTue': timeslotTue,
					'timeslotWed': timeslotWed,
					'timeslotThu': timeslotThu,
					'timeslotFri': timeslotFri,
					'timeslotSat': timeslotSat,
					},
				success: function($succ){
						
					if($succ==1){
						$id = "";
						if($('#slctTeacher').val()!=""){
							$id = '?tid='+$('#slctTeacher').val();
						}
						window.location.href = 'teacher_availability.php'+$id+'';
					}else{
						alert("Rule name already exists.");
					}
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
		}else{
			alert('Please select atleast one timeslot.');
			}
	}
}
function changeTeacherData($id){
		$id="";
		if($('#slctTeacher').val()!=""){
			$id = '?tid='+$('#slctTeacher').val();
		}
		window.location.href = 'teacher_availability.php'+$id+'';
}
$(document).ready(function() {
	var max_fields = 10000; 
    var wrapper2 = $(".divException"); 
    var add_button_class_exception = $(".btnTeachAvailExcep"); 
    var x = 1,y=0; 
    $(add_button_class_exception).click(function(e){ 
		var exception_date = $('#exceptnTeachAval').val();
		e.preventDefault();
		var decodeTeachId=$('#decodeTeachId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal').val(),100);
		if(decodeTeachId!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(wrapper2).append('<div class="sessionList"><table id="datatables" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th >Session Name</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exception_date!=''){
				$('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exception_date+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exception_date+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeSession(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnTeachAval').val('');
			}
	    }
 });
});
//Ajax delete the TeachAvail function 
function deleteExcepTeachAvail($sessionId, $serialId){
	if(confirm("Are you sure you want to delete the Exception?")) {
	    	if($sessionId == 0){
				$('#'+$serialId).closest('tr').remove();
				$('.green, .red').hide();
			}else{
				$.ajax({
						type: "POST",
						url: "ajax_common.php",
						data: {
							'id': $sessionId,
							'codeBlock': 'deleteExcepTeachAvail',
						},
						success: function($succ){
							if($succ==1){
								$('#'+$sessionId).closest('tr').remove();
								$('.green, .red').hide();
							}else{
								alert("Cannot delete the selected Exception.");
								$('.green, .red').hide();
							}
						}
				});
    		}
	}
    return false;
}
//Ajax delete the Subject function 
function deleteTeachAvail($id){
 if($id==""){
  alert("Please select a teacher to delete");
  return false;
 }else if(confirm("Are you sure you want to delete the teacher availability mapping?")) {
     $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
     'id': $id,
     'codeBlock': 'del_teachAvailMap',
    },
                success: function($succ){
     if($succ==1){
                        $('#'+$id).closest('tr').remove();
      $('.green, .red').hide();
     }else{
      alert("Cannot delete the teacher availability mapping subject.");
      $('.green, .red').hide();
     }
                }
        });
    }
    return false;
}
$(document).ready(function() {
	var max_fields = 10000; 
    var wrapper = $(".divException"); 
    var add_button_class_exception = $(".btnclsrmException"); 
    var x = 1,y=0; 
    $(add_button_class_exception).click(function(e){ 
		var exceptnDate = $('#exceptnClsrmAval').val();
		e.preventDefault();
		var roomIdException=$('#roomId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal').val(),100);
		if(roomIdException!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(wrapper).append('<div class="sessionList"><table id="datatables" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th >Session Name</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exceptnDate!=''){
				$('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exceptnDate+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exceptnDate+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeClassException(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				//$(wrapper).append('');
				$('#exceptnClsrmAval').val('');
			}
	    }else{
			if(x < max_fields){ 
			x++;
			y++;
			if(exceptnDate!=''){
				if(y==1){
				$(wrapper).append('<div class="exceptionList"><table id="datatables" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th>Exception Date</th><th>Remove</th></tr></thead><tbody>');	
						}
				$('#datatables').append('<tr><td>'+y+'</td><td>'+exceptnDate+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceoptionDate'+y+'"  value="'+exceptnDate+'"/></td><td id='+y+'><a class="remove_field" onclick="removeClassException(0,'+y+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnClsrmAval').val('');
			}
	  }
    }
 });
});
function changeRoomData($id){
		$id="";
		if($('#slctRmName').val()!=""){
			$id = '?rid='+$('#slctRmName').val();
		}
		window.location.href = 'classroom_availability.php'+$id+'';
}
function removeClassException($exceptionId, $serialId){
	if(confirm("Are you sure you want to delete the classroom exception?")) {
	    	if($exceptionId == 0){
				$('#'+$serialId).closest('tr').remove();
				$('.green, .red').hide();
			}else{
				$.ajax({
						type: "POST",
						url: "ajax_common.php",
						data: {
							'id': $exceptionId,
							'codeBlock': 'del_cls_exception',
						},
						success: function($succ){
							if($succ==1){
								$('#'+$exceptionId).closest('tr').remove();
								$('.green, .red').hide();
							}else{
								alert("Cannot delete the selected exception.");
								$('.green, .red').hide();
							}
						}
				});
    		}
	}
    return false;
}
function deleteClassroomAvailability($id){
	if($id==""){
		alert("Please select a classroom availability to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the classroom availability?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_classroom_availabilty',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected subject.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//ajax delete the holiday
function deleteHoliday($id){
	if($id==""){
		alert("Please select a holiday to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Holiday?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_holiday',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Holiday.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}
function stripslashes(str) {
 return str.replace(/\\'/g,'\'').replace(/\"/g,'"').replace(/\\\\/g,'\\').replace(/\\0/g,'\0');
}
function changeExceptionData(pid){
	window.location.href = 'program_cycles.php?edit='+window.btoa(pid);
}
//function do add exception date in program cycles
$(function() {
	var start_date1 = $('#program_start_date').val();
	var end_date1 = $('#program_end_date').val();
	var cycle1_endweekdate = $('#endweek1').val();
	var cycle2_endweekdate = $('#endweek2').val();
	
    //for cycle 1
	$("#startweek1").datepicker({
		//minDate: start_date1,
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
		    var date2 = $('#startweek1').datepicker('getDate');
			date2.setDate(date2.getDate() + 1);
		    $("#endweek1").datepicker("option", "minDate", date2);
			//$("#endweek1").datepicker("option", "maxDate", end_date1);
			$("#exceptnProgAval1").datepicker("option", "minDate", selectedDate);
			$("#additionalDayCal1").datepicker("option", "minDate", selectedDate);			
			$('#exceptnProgAval1').val('');
		}
	});
	$("#endweek1").datepicker({
		//maxDate: end_date1,
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
			var date2 = $('#endweek1').datepicker('getDate');
			date2.setDate(date2.getDate() + 1);
			$("#startweek2").datepicker("option", "minDate", date2);
			$("#exceptnProgAval1").datepicker("option", "maxDate", selectedDate);
			$("#additionalDayCal1").datepicker("option", "maxDate", selectedDate);
			$('#exceptnProgAval1').val('');
		}
	});
	$("#exceptnProgAval1, #additionalDayCal1").datepicker({
		maxDate: $('#endweek1').datepicker('getDate'),
		minDate: $('#startweek1').datepicker('getDate'),
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	 /* $("#exceptnProgAval1, #additionalDayCal1, #additionalDayCal2, #additionalDayCal3").datepicker({
	  dateFormat: 'dd-mm-yy',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	 });*/
	//for cycle 2
	$("#startweek2").datepicker({
	   	minDate: $('#endweek1').datepicker('getDate'),
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
			var date2 = $('#startweek2').datepicker('getDate');
			date2.setDate(date2.getDate() + 1);
			$("#endweek2").datepicker("option", "minDate", date2);
			//$("#endweek2").datepicker("option", "maxDate", end_date1);
			$("#exceptnProgAval2").datepicker("option", "minDate", selectedDate);
			$("#additionalDayCal2").datepicker("option", "minDate", selectedDate);
			$('#exceptnProgAval2').val('');
		}
	});
	$("#endweek2").datepicker({
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
			var date2 = $('#endweek2').datepicker('getDate');
			date2.setDate(date2.getDate() + 1);
			$("#startweek3").datepicker("option", "minDate", date2);
			$("#exceptnProgAval2").datepicker("option", "maxDate", selectedDate);
			$("#additionalDayCal2").datepicker("option", "maxDate", selectedDate);
			$('#exceptnProgAval2').val('');
		}
	});
	$("#exceptnProgAval2, #additionalDayCal2").datepicker({
		maxDate: $('#endweek2').datepicker('getDate'),
		minDate: $('#startweek2').datepicker('getDate'),
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	//for cycle 3
	$("#startweek3").datepicker({
	    minDate: $('#endweek2').datepicker('getDate'),
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
			var date2 = $('#startweek3').datepicker('getDate');
			date2.setDate(date2.getDate() + 1);
			$("#endweek3").datepicker("option", "minDate", date2);
			$("#exceptnProgAval3").datepicker("option", "minDate", selectedDate);
			$("#additionalDayCal3").datepicker("option", "minDate", selectedDate);
			//$("#endweek3").datepicker("option", "maxDate", end_date1);
			$('#exceptnProgAval3').val('');
		}
	});
	$("#endweek3").datepicker({
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onSelect: function(selectedDate) {
			$("#exceptnProgAval3").datepicker("option", "maxDate", selectedDate);
			$("#additionalDayCal3").datepicker("option", "maxDate", selectedDate);
			$('#exceptnProgAval3').val('');
		}
	});
	$("#exceptnProgAval3, #additionalDayCal3").datepicker({
		maxDate: $('#endweek3').datepicker('getDate'),
		minDate: $('#startweek3').datepicker('getDate'),
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
});
//end exception date program cycle
//function to add cycle exception
$(document).ready(function() {
   $(".btnProgCycleAvailExcep1").click(function(e){ 
		var max_fields = 10000; 
		var x = 1,y=0; 
		var exception_date = $('#exceptnProgAval1').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal1').val(),100);
		if(programId!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal1').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(".divException1").append('<div class="exceptionList1"><table id="datatables1" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th>Exception Date</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exception_date!=''){
				$('#datatables1').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exception_date+'</td><td style="display:none"><input type="hidden" name="exceptionDate1[]" id="exceptnDate'+maxSerialNumVal+'" value="'+exception_date+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteExcepProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnProgAval1').val('');
			}
		}
	});

   $(".btnProgCycleAvailExcep2").click(function(e){ 
        
   		var max_fields = 10000; 
   		var x = 1,y=0; 
		var exception_date = $('#exceptnProgAval2').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal2').val(),100);
		if(programId!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal2').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(".divException2").append('<div class="exceptionList2"><table id="datatables2" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th>Exception Date</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exception_date!=''){
				$('#datatables2').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exception_date+'</td><td style="display:none"><input type="hidden" name="exceptionDate2[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exception_date+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteExcepProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnProgAval2').val('');
			}
		}
	});

	$(".btnProgCycleAvailExcep3").click(function(e){ 
		var max_fields = 10000; 
		var x = 1,y=0; 
 		var exception_date = $('#exceptnProgAval3').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal3').val(),100);
		if(programId!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal3').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(".divException3").append('<div class="exceptionList3"><table id="datatables3" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th>Exception Date</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exception_date!=''){
				$('#datatables3').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exception_date+'</td><td style="display:none"><input type="hidden" name="exceptionDate3[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exception_date+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteExcepProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnProgAval3').val('');
			}
		}
	});
});
//Ajax delete the program cycle exception function 
function deleteExcepProgCycle($sessionId, $serialId){
	if(confirm("Are you sure you want to delete the Exception?")) {
		if($sessionId == 0){
			$('#'+$serialId).closest('tr').remove();
			$('.green, .red').hide();
		}else{
			$.ajax({
					type: "POST",
					url: "ajax_common.php",
					data: {
						'id': $sessionId,
						'codeBlock': 'deleteExcepProgCycle',
					},
					success: function($succ){
						if($succ==1){
							$('#'+$sessionId).closest('tr').remove();
							$('.green, .red').hide();
						}else{
							alert("Cannot delete the selected Exception.");
							$('.green, .red').hide();
						}
					}
			});
		}
	}
    return false;
}
//function to show/hide the cycle info
function showHideCycleInfo(subjectId)
{
	var divSessionName = '#divSessionName'+subjectId;
    var imageId='#sessionNameImg'+subjectId;
	if($(divSessionName).css('display') == 'none') {
		//close all the open links
		$(".subjectSession").slideUp("slow");
		$(".sessionNameImg").attr({src: 'images/plus_icon.png'});
		//open the clicked link
		$(divSessionName).slideDown("slow");
        $(imageId).attr({src: 'images/minus_icon.png'});
    }
    else {
        $(divSessionName).slideUp("slow");
        $(imageId).attr({src: 'images/plus_icon.png'});
	}
}
//function to show hide time slot at program cycle page
$(document).ready(function(){
	$("#ts-avail-c1-w1-0,#ts-avail-c1-w1-1,#ts-avail-c1-w1-2,#ts-avail-c1-w1-3,#ts-avail-c1-w1-4,#ts-avail-c1-w1-5").hide();
	$("#ts-avail-c1-w2-0,#ts-avail-c1-w2-1,#ts-avail-c1-w2-2,#ts-avail-c1-w2-3,#ts-avail-c1-w2-4,#ts-avail-c1-w2-5").hide();
	$("#ts-avail-c2-w1-0,#ts-avail-c2-w1-1,#ts-avail-c2-w1-2,#ts-avail-c2-w1-3,#ts-avail-c2-w1-4,#ts-avail-c2-w1-5").hide();
	$("#ts-avail-c2-w2-0,#ts-avail-c2-w2-1,#ts-avail-c2-w2-2,#ts-avail-c2-w2-3,#ts-avail-c2-w2-4,#ts-avail-c2-w2-5").hide();
	$("#ts-avail-c3-w1-0,#ts-avail-c3-w1-1,#ts-avail-c3-w1-2,#ts-avail-c3-w1-3,#ts-avail-c3-w1-4,#ts-avail-c3-w1-5").hide();
	$("#ts-avail-c3-w2-0,#ts-avail-c3-w2-1,#ts-avail-c3-w2-2,#ts-avail-c3-w2-3,#ts-avail-c3-w2-4,#ts-avail-c3-w2-5").hide();
	
	   $('input[class=days]').click(function(){
            if($(this).attr("value")=="Mon1C1W1"){
				$("#ts-avail-c1-w1-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-0").toggle();
			}else if($(this).attr("value")=="Mon2C1W2"){
				$("#ts-avail-c1-w2-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-0").toggle();
			}else if($(this).attr("value")=="MonC2W1"){
				$("#ts-avail-c2-w1-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-0").toggle();
			}else if($(this).attr("value")=="MonC2W2"){
				$("#ts-avail-c2-w2-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-0").toggle();
			}else if($(this).attr("value")=="MonC3W1"){
				$("#ts-avail-c3-w1-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-0").toggle();
			}else if($(this).attr("value")=="MonC3W2"){
				$("#ts-avail-c3-w2-0").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-0").toggle();
			}
            if($(this).attr("value")=="Tue1C1W1"){
				$("#ts-avail-c1-w1-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-1").toggle();
            }else if($(this).attr("value")=="Tue2C1W2"){
				$("#ts-avail-c1-w2-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-1").toggle();
            }else if($(this).attr("value")=="TueC2W1"){
				$("#ts-avail-c2-w1-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-1").toggle();
            }else if($(this).attr("value")=="TueC2W2"){
				$("#ts-avail-c2-w2-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-1").toggle();
            }else if($(this).attr("value")=="TueC3W1"){
				$("#ts-avail-c3-w1-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-1").toggle();
            }else if($(this).attr("value")=="TueC3W2"){
				$("#ts-avail-c3-w2-1").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-1").toggle();
            }
            if($(this).attr("value")=="Wed1C1W1"){
				$("#ts-avail-c1-w1-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-2").toggle();
            }else if($(this).attr("value")=="Wed2C1W2"){
				$("#ts-avail-c1-w2-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-2").toggle();
            }else if($(this).attr("value")=="WedC2W1"){
				$("#ts-avail-c2-w1-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-2").toggle();
            }else if($(this).attr("value")=="WedC2W2"){
				$("#ts-avail-c2-w2-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-2").toggle();
            }else if($(this).attr("value")=="WedC3W1"){
				$("#ts-avail-c3-w1-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-2").toggle();
            }else if($(this).attr("value")=="WedC3W2"){
				$("#ts-avail-c3-w2-2").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-2").toggle();
            }
			if($(this).attr("value")=="Thu1C1W1"){
				$("#ts-avail-c1-w1-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-3").toggle();
            }else if($(this).attr("value")=="Thu2C1W2"){
				$("#ts-avail-c1-w2-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-3").toggle();
            }else if($(this).attr("value")=="ThuC2W1"){
				$("#ts-avail-c2-w1-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-3").toggle();
            }else if($(this).attr("value")=="ThuC2W2"){
				$("#ts-avail-c2-w2-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-3").toggle();
            }else if($(this).attr("value")=="ThuC3W1"){
				$("#ts-avail-c3-w1-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-3").toggle();
            }else if($(this).attr("value")=="ThuC3W2"){
				$("#ts-avail-c3-w2-3").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-3").toggle();
            }
			if($(this).attr("value")=="Fri1C1W1"){
				$("#ts-avail-c1-w1-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-4").toggle();
            }else if($(this).attr("value")=="Fri2C1W2"){
				$("#ts-avail-c1-w2-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-4").toggle();
            }else if($(this).attr("value")=="FriC2W1"){
				$("#ts-avail-c2-w1-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-4").toggle();
            }else if($(this).attr("value")=="FriC2W2"){
				$("#ts-avail-c2-w2-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-4").toggle();
            }else if($(this).attr("value")=="FriC3W1"){
				$("#ts-avail-c3-w1-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-4").toggle();
            }else if($(this).attr("value")=="FriC3W2"){
				$("#ts-avail-c3-w2-4").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-4").toggle();
            }
			if($(this).attr("value")=="Sat1C1W1"){
				$("#ts-avail-c1-w1-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w1-5").toggle();
            }else if($(this).attr("value")=="Sat2C1W2"){
				$("#ts-avail-c1-w2-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c1-w2-5").toggle();
            }else if($(this).attr("value")=="SatC2W1"){
				$("#ts-avail-c2-w1-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w1-5").toggle();
            }else if($(this).attr("value")=="SatC2W2"){
				$("#ts-avail-c2-w2-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c2-w2-5").toggle();
            }else if($(this).attr("value")=="SatC3W1"){
				$("#ts-avail-c3-w1-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w1-5").toggle();
            }else if($(this).attr("value")=="SatC3W2"){
				$("#ts-avail-c3-w2-5").find('option:selected').removeAttr('selected');
				$("#ts-avail-c3-w2-5").toggle();
            }         
	   });
});
function showCycleDetails($week){
	if($week == "1w")
	{
		$("#custtd_leftc1w1").show();
		$("#c1week1").show();
		$("#custtd_leftc1w2").hide();
		$("#c1week2").hide();

	}else{
		$("#custtd_leftc1w1").show();		
		$("#c1week1").show();
		$("#custtd_leftc1w2").show();
		$("#c1week2").show();
	}
}
function showCycleDetailstwo($week){
	if($week == "1w")
	{
		$("#custtd_leftc2w1").show();
		$("#c2week1").show();
		$("#custtd_leftc2w2").hide();
		$("#c2week2").hide();
	}else{
		$("#custtd_leftc2w1").show();		
		$("#c2week1").show();
		$("#custtd_leftc2w2").show();
		$("#c2week2").show();
	}

}
$(document).ready(function() {
    $("#btnAddTeacherActivity").click(function(e){ 
      	if($("input:radio[name=reserved_flag]").is(":checked")){
			var row_id = $('input:radio[name=reserved_flag]:checked', '#frmTactivity').val();
			var room_id = $("#room_id_"+row_id).val();
			var timeslot_id = $("#tslot_id_"+row_id).val();
			var act_date = $("#activityDateCal_"+row_id).val();
			if(room_id===null || room_id==''){
				alert('Please choose room');
				return false;
			}
			if(timeslot_id===null || timeslot_id==''){
				alert('Please choose timeslot');
				return false;
			}
			if(act_date===null || act_date==''){
				alert('Please choose date');
				return false;
			}
      	}
	});
});
function showCycleDetailsthree($week){
	if($week == "1w")
	{
		$("#custtd_leftc3w1").show();
		$("#c3week1").show();
		$("#custtd_leftc3w2").hide();
		$("#c3week2").hide();

	}else{
		$("#custtd_leftc3w1").show();		
		$("#c3week1").show();
		$("#custtd_leftc3w2").show();
		$("#c3week2").show();
	}

}

$(document).ready(function(){
  if($('#programId').val()!=''){
	 for ( var i = 0; i <= 5; i++ ){
	    cyc1_wk1 = '#c1-w1-'+i;
		ts_avail_cyc1_wk1 = '#ts-avail-c1-w1-'+i;
		cyc1_wk2 = '#c1-w2-'+i;
		ts_avail_cyc1_wk2 = '#ts-avail-c1-w2-'+i;
		cyc2_wk1 = '#c2-w1-'+i;
		ts_avail_cyc2_wk1 = '#ts-avail-c2-w1-'+i;
		cyc2_wk2 = '#c2-w2-'+i;
		ts_avail_cyc2_wk2 = '#ts-avail-c2-w2-'+i;
		cyc3_wk1 = '#c3-w1-'+i;
		ts_avail_cyc3_wk1 = '#ts-avail-c3-w1-'+i;
		cyc3_wk2 = '#c3-w2-'+i;
		ts_avail_cyc3_wk2 = '#ts-avail-c3-w2-'+i;
		if($(cyc1_wk1).prop('checked') == true){
			$(ts_avail_cyc1_wk1).show();
		}
		if($(cyc1_wk2).prop('checked') == true){
			$(ts_avail_cyc1_wk2).show();
		}
		if($(cyc2_wk1).prop('checked') == true){
			$(ts_avail_cyc2_wk1).show();
		}
		if($(cyc2_wk2).prop('checked') == true){
			$(ts_avail_cyc2_wk2).show();
		}
		if($(cyc3_wk1).prop('checked') == true){
			$(ts_avail_cyc3_wk1).show();
		}
		if($(cyc3_wk2).prop('checked') == true){
			$(ts_avail_cyc3_wk2).show();
		}
	  }	
  }
});
//Ajax delete the cycle function 
function deleteCycle($id){
	if($id==""){
		alert("Please select a row to delete");
		return false;
	}else if(confirm("Are you sure you want to delete this Program Cycle? This will delete all the related subjects, sessions and activities")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_cycle',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Program Cycle.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//getting cycles by program ID
function getCycleByProgId($this){
	var selectVal = $('#slctProgram :selected').val();
	var progId = selectVal.split("#");
	if(progId[0]!=""){
		 $.ajax({
			url: "./ajax_common.php",
			type: "POST",
			data: {
				'codeBlock': 'getCycles',
				'progId': progId[0],
			},
			success: function(data) {
				 $("#slctCycle").html(data);
			},
			error: function(errorThrown) {
				console.log(errorThrown);
			}
		  });
	}else{
			$("#slctCycle").html("<option value=''>--Select a program first--</option>");
		}
}
//Ajax to check activity availability on subject session page
function checkAvailSubSession(program_year_id,subject_id,sessionid,teacher_id,row_id)
{
    var room_id = $("#room_id_"+row_id).val();
    if(room_id!=''){
      $("#room_validate_"+row_id).hide();
    }
    var tslot_id = $("#tslot_id_"+row_id).val();
    if(tslot_id!=''){
	  $("#tslot_validate_"+row_id).hide();
    }
	var act_date_val = $("#activityDateCal_"+row_id).val();
	if(act_date_val!=''){
	  $("#activityDate_validate_"+row_id).hide();
	}
	$("#room_tslot_availability_avail_"+row_id).hide();
	$("#room_tslot_availability_not_avail_"+row_id).hide();
	
    if(room_id!='' && tslot_id!='' && act_date_val!=''){
		$.ajax({
			 url: "./ajax_common.php",
			 type: "POST",
			 data: {
				'program_year_id': program_year_id,
				'subject_id': subject_id,
				'sessionid': sessionid,
				'teacher_id': teacher_id,
				'room_id': room_id,
				'tslot_id': tslot_id,
				'act_date_val': act_date_val,
				'codeBlock': 'checkActAvailability',
			 },
			 success: function(data) {
			     if(data==1){
			        $("#room_tslot_availability_not_avail_"+row_id).show();
				 	$('input[type="submit"]').attr('disabled' , true);
				 }else{
				   $("#room_tslot_availability_avail_"+row_id).show();
				   $('input[type="submit"]').attr('disabled' , false);
				 }	
			 },
			 error: function(errorThrown) {
				 console.log(errorThrown);
			 }
		});
   }	
}

function sortingSession(){
	$(".datatableSession").tableDnD({
		dragHandle: ".dragHandle"
	});
	$(".datatableSession tr").hover(function () {
        $(".datatableSession tr").addClass('showDragHandle');
    }, function () {
        $(".datatableSession tr").removeClass('showDragHandle');
    });

}

function checkweekTS()
{	
	var cycle = $('#slctNumCycle').val();	
	if(cycle == '1'){
		var occ1 = $('#c1chWeek1').val();
		if(occ1 == '1w' || occ1 == '2w')
		{
			if($('.tmSlotc1w1 input:checked').length <= 0 && $('.tmSlotc1w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-1.');
				return false;
			}
		}
	}else if(cycle == '2'){
		var occ1 = $('#c1chWeek1').val();
		if(occ1 == '1w' || occ1 == '2w')
		{
			if($('.tmSlotc1w1 input:checked').length <= 0 && $('.tmSlotc1w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-1.');
				return false;
			}
		}
		var occ2 = $('#c1chWeek2').val();
		if(occ2 == '1w' || occ2 == '2w')
		{
			if($('.tmSlotc2w1 input:checked').length <= 0 && $('.tmSlotc2w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-2.');
				return false;
			}
		}
	}else if(cycle == '3'){
		var occ1 = $('#c1chWeek1').val();
		if(occ1 == '1w' || occ1 == '2w')
		{
			if($('.tmSlotc1w1 input:checked').length <= 0 && $('.tmSlotc1w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-1.');
				return false;
			}
		}
		var occ2 = $('#c1chWeek2').val();
		if(occ2 == '1w' || occ2 == '2w')
		{
			if($('.tmSlotc2w1 input:checked').length <= 0 && $('.tmSlotc2w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-2.');
				return false;
			}
		}
		var occ3 = $('#c1chWeek3').val();
		if(occ3 == '1w' || occ3 == '2w')
		{
			if($('.tmSlotc3w1 input:checked').length <= 0 && $('.tmSlotc3w2 input:checked').length <= 0){
				alert('Please select atleast one day and timeslot for first week of cycle-3.');
				return false;
			}
		}
	}
}
function deleteRuleTeacher($id, $tid){
	if($id==""){
		alert("Please select a rule to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Rule?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'rule_id': $id,
					'codeBlock': 'del_rule_teacher',
				},
                success: function($succ){
					if($succ==1){
						if($tid==0){
                       		window.location.href = 'teacher_availability.php';
						}else{
							window.location.href = 'teacher_availability.php?tid='+$tid;
						}
					}else{
						alert("Cannot delete the selected Rule, as this rule is associated with some teacher.");
					}
                }
        });
    }
    return false;
}
function deleteRuleClassroom($id, $rid){
	if($id==""){
		alert("Please select a rule to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Rule?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'rule_id': $id,
					'codeBlock': 'del_rule_classroom',
				},
                success: function($succ){
					if($succ==1){
					   if($rid==0){
                       		window.location.href = 'classroom_availability.php';
					   }else{
						   	window.location.href = 'classroom_availability.php?rid='+$rid;
						}
					}else{
					   alert("Cannot delete the selected Rule, as this rule is associated with some classroom.");
					}
                }
        });
    }
    return false;
}

//ajax delete the location
function deleteLoc($id){
	if($id==""){
		alert("Please select a location to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the Location?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_loc',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Location, as this location is associated with some buildings.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
$(document).ready(function() {
   $(".additionalDayButt1").click(function(e){ 
	   if($('#timeSlot1 option:selected').length <= 0 || $('#additionalDayCal1').val() == ''){
			alert('Atleast one timeslot and date needs to be selected for cycle-1.');			
		}else{
			var max_fields = 10000; 
			var x = 1,y=0; 
			var additional_date = $('#additionalDayCal1').val();
			var time_slot1 = $('#timeSlot1').val();
			
			 $.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'time_slot': time_slot1,
					'codeBlock': 'getTimeslots',
				},
				success: function(data) {
					var dataArray =data.split("_");
					 $("#time_slot"+maxSerialNumVal).html(dataArray[0]);
					 $("#timeslot"+maxSerialNumVal).val(dataArray[0]);
					 $("#act_timeslot"+maxSerialNumVal).val(dataArray[1]);
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
			e.preventDefault();
			var programId=$('#programId').val();
			var maxSerialNum=parseInt($('#maxSessListVal1').val(),100);
			if(programId!=""){
				var maxSerialNumVal=maxSerialNum + 1;
				$('#maxSessListVal1').val(maxSerialNumVal);
				if(maxSerialNum==0){
					$(".divAddition1").append('<div class="additionList1"><table id="dataaddtables1" class="additionTbl"><thead><tr><th>Sr. No.</th><th>Additional Date</th><th>Additional Timeslots</th><th>Remove</th></tr></thead><tbody>');	
				}
				if(additional_date!=''){
					$('#dataaddtables1').append('<tr><td>'+maxSerialNumVal+'</td><td>'+additional_date+'</td><td style="display:none"><input type="hidden" name="additionDate1[]" id="additionDate'+maxSerialNumVal+'" value="'+additional_date+'"/></td><td id="time_slot'+maxSerialNumVal+'"></td><td style="display:none"><input type="hidden" name="time_slot1[]" id="timeslot'+maxSerialNumVal+'" value=""/><input type="hidden" name="actual_time_slot1[]" id="act_timeslot'+maxSerialNumVal+'" value=""/></td><td id="add_'+maxSerialNumVal+'"><a class="remove_field" onclick="deleteAddProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
					$('#additionalDayCal1').val('');
					$('#timeSlot1').val('');
				}
			}
		}	
	});
	$(".additionalDayButt2").click(function(e){ 
	   if($('#timeSlot2 option:selected').length <= 0 || $('#additionalDayCal2').val() == ''){
			alert('Atleast one timeslot and date needs to be selected for cycle-2');			
		}else{
			var max_fields = 10000; 
			var x = 1,y=0; 
			var additional_date = $('#additionalDayCal2').val();
			var time_slot2 = $('#timeSlot2').val();
			var maxSerialNum=parseInt($('#maxSessListVal2').val(),100);
			 $.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'time_slot': time_slot2,
					'codeBlock': 'getTimeslots',
				},
				success: function(data) {
					var dataArray =data.split("_");
					 $("#time_slot2"+maxSerialNumVal).html(dataArray[0]);
					 $("#timeslot2"+maxSerialNumVal).val(dataArray[0]);
					 $("#act_timeslot2"+maxSerialNumVal).val(dataArray[1]);
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
			e.preventDefault();
			var programId=$('#programId').val();			
			if(programId!=""){
				var maxSerialNumVal=maxSerialNum + 1;
				$('#maxSessListVal2').val(maxSerialNumVal);
				if(maxSerialNum==0){
					$(".divAddition2").append('<div class="additionList2"><table id="dataaddtables2" class="additionTbl"><thead><tr><th>Sr. No.</th><th>Additional Date</th><th>Additional Timeslots</th><th>Remove</th></tr></thead><tbody>');	
				}
				if(additional_date!=''){
					$('#dataaddtables2').append('<tr><td>'+maxSerialNumVal+'</td><td>'+additional_date+'</td><td style="display:none"><input type="hidden" name="additionDate2[]" id="additionDate'+maxSerialNumVal+'" value="'+additional_date+'"/></td><td id="time_slot2'+maxSerialNumVal+'"></td><td style="display:none"><input type="hidden" name="time_slot2[]" id="timeslot2'+maxSerialNumVal+'" value=""/><input type="hidden" name="actual_time_slot2[]" id="act_timeslot2'+maxSerialNumVal+'" value=""/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteAddProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
					$('#additionalDayCal2').val('');
					$('#timeSlot2').val('');
				}
			}
		}	
	});
	$(".additionalDayButt3").click(function(e){ 
	   if($('#timeSlot3 option:selected').length <= 0 || $('#additionalDayCal3').val() == ''){
			alert('Atleast one timeslot and date needs to be selected for cycle-3');			
		}else{
			var max_fields = 10000; 
			var x = 1,y=0; 
			var additional_date = $('#additionalDayCal3').val();
			var time_slot3 = $('#timeSlot3').val();
			var maxSerialNum=parseInt($('#maxSessListVal3').val(),100);
			 $.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'time_slot': time_slot3,
					'codeBlock': 'getTimeslots',
				},
				success: function(data) {
					var dataArray =data.split("_");
					 $("#time_slot3"+maxSerialNumVal).html(dataArray[0]);
					 $("#timeslot3"+maxSerialNumVal).val(dataArray[0]);
					 $("#act_timeslot3"+maxSerialNumVal).val(dataArray[1]);
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
			e.preventDefault();
			var programId=$('#programId').val();			
			if(programId!=""){
				var maxSerialNumVal=maxSerialNum + 1;
				$('#maxSessListVal3').val(maxSerialNumVal);
				if(maxSerialNum==0){
					$(".divAddition3").append('<div class="additionList3"><table id="dataaddtables3" class="additionTbl"><thead><tr><th>Sr. No.</th><th>Additional Date</th><th>Additional Timeslots</th><th>Remove</th></tr></thead><tbody>');	
				}
				if(additional_date!=''){
					$('#dataaddtables3').append('<tr><td>'+maxSerialNumVal+'</td><td>'+additional_date+'</td><td style="display:none"><input type="hidden" name="additionDate3[]" id="additionDate'+maxSerialNumVal+'" value="'+additional_date+'"/></td><td id="time_slot3'+maxSerialNumVal+'"></td><td style="display:none"><input type="hidden" name="time_slot3[]" id="timeslot3'+maxSerialNumVal+'" value=""/><input type="hidden" name="actual_time_slot3[]" id="act_timeslot3'+maxSerialNumVal+'" value=""/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteAddProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
					$('#additionalDayCal3').val('');
					$('#timeSlot3').val('');
				}
			}
		}	
	});
});
//Ajax delete the program cycle exception function 
function deleteAddProgCycle($sessionId, $serialId){
	if(confirm("Are you sure you want to delete the Additional Date?")) {
		if($sessionId == 0){
			$('#add_'+$serialId).closest('tr').remove();
			$('.green, .red').hide();
		}else{
			$.ajax({
					type: "POST",
					url: "ajax_common.php",
					data: {
						'id': $sessionId,
						'codeBlock': 'deleteAddProgCycle',
					},
					success: function($succ){
						if($succ==1){
							$('#'+$sessionId).closest('tr').remove();
							$('.green, .red').hide();
						}else{
							alert("Cannot delete the selected row.");
							$('.green, .red').hide();
						}
					}
			});
		}
	}
    return false;
}
//function to print reports
function printDiv(divName) {
  $(".dataTables_length,.dataTables_filter,.dataTables_info,.dataTables_paginate").css("display","none");
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  $(".dataTables_length,.dataTables_filter,.dataTables_info,.dataTables_paginate").show();;
}
//Ajax delete the timetable
function deleteTimetable($id){
if($id==""){
		alert("Please select a timetable to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the timetable?")) {
		$.ajax({
		type: "POST",
		url: "ajax_common.php",
		data: {
			'id': $id,
			'codeBlock': 'del_timetable',
			},
		success: function($succ){
			if($succ==1){
					$('#'+$id).closest('tr').remove();
					$('.green, .red').hide();
				}else{
					alert("Cannot delete the selected timetable.");
					$('.green, .red').hide();
				}
			  }
		});
    }
    return false;
}
//Subject's session date range when subject is in edit mode
$(document).ready(function() {
if($('#slctCycle option:selected').val()!=""){
  	$.ajax({
           type: "POST",
           url: "ajax_common.php",
           data: {
					'cycle_id': $('#slctCycle option:selected').val(),
					'codeBlock': 'getCycleDateRange',
				 },
                success: function($succ){
					if($succ){
						 var str = $succ;
						 var DateCycle = str.split('#');
						 $('#subSessDate').datepicker({
							dateFormat: 'yy-mm-dd',
							defaultDate: "+1w",
							changeMonth: true,
							numberOfMonths: 1,
							changeMonth: true, 
							changeYear: true,
							minDate: DateCycle[0],
							maxDate: DateCycle[1],
							inline: true
				   		});
					}
                }
        });
	}
});

function opendialogToComfirm(){
	$("#dialog-confirm").show();
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      height:140,
      modal: true,
      buttons: {
        "Force Entry": function() {
		  var force_entry="Forcing";
		  var force_flag="1";
		  addSubjectSession(force_entry, force_flag);	
          $( this ).dialog( "close" );
        },
        "Edit": function() {
          $( this ).dialog( "close" );
        }
      }
    });
}
function opendialogToComfirmArea(){
	$("#dialog-confirm-area").show();
	$( "#dialog-confirm-area" ).dialog({
      resizable: false,
      height:240,
      modal: true,
      buttons: {
        "Force Entry": function() {
		  var force_entry="Forcing";
		  var force_flag="1";
		  addSubjectSession(force_entry,force_flag);	
          $( this ).dialog( "close" );
        },
        "Edit": function() {
          $( this ).dialog( "close" );
        }
      }
    });
}
//Generate the timetable 
$(document).ready(function() {
	$(".btnGenertTimetbl").click(function () {
		$("#timetable").valid();
		var schdTime=$("#txtAName").val();
		var fromDate=$("#fromGenrtTmtbl").val();
	    var toDate=$("#toGenrtTmtbl").val();
		var programVal = new Array();
		/*$("#programs option:selected").each(function(){
			programVal.push($(this).val());
  		});*/
		$("#programs option").each(function(){
			programVal.push($(this).val());
  		});
		if(schdTime!="" && fromDate!="" && toDate!="" && programVal.length!=0){
		   $("#wait").show();
		  // if($("input.btnGenertTimetbl").attr("disabled", true)){
			  //$('.btnGenertTimetbl').addClass('clsbtnGenrtTimtblDisable'); 
			//}
			  $.ajax({
			   type: "POST",
			   url: "ajax_common.php",
			   data: {
						'txtAName': schdTime,
						'fromGenrtTmtbl': fromDate,
						'toGenrtTmtbl': toDate,
						'programs': programVal,
						'codeBlock': 'generateTimetable',
					 },
					success: function($succ){
						//alert($succ);
						if($succ==1){
							if($("input.btnGenertTimetbl").attr("disabled", false)){
								 $('.btnGenertTimetbl').removeClass("clsbtnGenrtTimtblDisable");
							 }
							$("#wait").hide();
							window.location.href = 'timetable_view.php';
							//header('Location: timetable_view.php');
						}else if($succ=="Session-Error" || $succ=="Name-Exist" || $succ=="Timetable-Error"){
							if($("input.btnGenertTimetbl").attr("disabled", false)){
								 $('.btnGenertTimetbl').removeClass("clsbtnGenrtTimtblDisable");
							 }
							$("#wait").hide();
							window.location.href = 'generate_timetable.php?fromGenrtTmtbl='+fromDate+'&toGenrtTmtbl='+toDate;
						}else if($succ=="Enter-Rquired-Feild"){
							if($("input.btnGenertTimetbl").attr("disabled", false)){
								 $('.btnGenertTimetbl').removeClass("clsbtnGenrtTimtblDisable");
							 }
							$("#wait").hide();
							window.location.href = 'generate_timetable.php';
						}
					}
			});
		}
		
	});
});

function acceptAllocationFun(){
	var values = new Array();
	$.each($("input[name='activity_allocation[]']:checked"), function() {
  		values.push($(this).val());
    });
	if(values.length === 0){
		alert('Please select at least one activity');
	}else if(confirm("Are you sure ,you want accept allocation for selected activity ?")){
		$.ajax({
			   type: "POST",
			   url: "ajax_common.php",
			   data: {
						'check_activity_value': values,
						'codeBlock': 'acceptAllocation',
					 },
					success: function($succ){
						if($succ==1){
							$(location).attr('href', 'teacher_activity_view.php');
						}else{
							 alert('Please select at least one activity');	
						}
					}
			});
	}
}
//To the accept allocation
$(document).ready(function() {
	//To select/deselect for selectAll checkbox when all checkbox are selected or not
	$(document).on('click', ".activityCkb", function() {
			var desabledCkbCnt = $(".ckbDisabled").length;
			var allCkbOncurrntPageCnt =$(".allCKbCls").length;
			var activeCkbOnpageCnt=allCkbOncurrntPageCnt-desabledCkbCnt;
			var ckbCheckedCnt=$(".activityCkb:checked").length;
			if(activeCkbOnpageCnt == ckbCheckedCnt) {
				$("#ckbCheckAllActivity").prop("checked", "checked");
			} else {
				$("#ckbCheckAllActivity").removeAttr("checked");
			}
	});
    //To select/deselect the all checbox when click on select all checkbox
	$('#ckbCheckAllActivity').click(function(event) { 
			if(this.checked) { 
				$('.activityCkb').each(function() { 
					this.checked = true;             
				});
			}else{
				$('.activityCkb').each(function() { 
					this.checked = false;                       
				});         
			}
		});
});
$(document).ready(function() {
	$("#weekly_report").on("submit", function(){
		 $('.removeWKRErr').html("");	
	});
});
//function to show subjects by program
function createSpecialAvailRule(){
	var timeslotMon1 = ""; var timeslotTue1=""; var timeslotWed1=""; var timeslotThu1=""; var timeslotFri1=""; var timeslotSat1="";
	var timeslotMon2 = ""; var timeslotTue2=""; var timeslotWed2=""; var timeslotThu2=""; var timeslotFri2=""; var timeslotSat2="";
	var regx = /^[A-Za-z0-9 .]+$/;
    var exceptionDateArr = [];
	$("input[name='exceptionDate[]']").each(function () {
		exceptionDateArr.push( this.value );
	});

	if($('#txtSchd').val()==""){
		alert('Please select a valid Schedule Name.');
		return false;
	}else if($('#fromSpecialAval').val()==""){
			alert('Please select a valid From Time.');
			return false;
	}else if($('#toSpcialAval').val()==""){ 
			alert('Please select a valid To Time.');
			return false;
	}else if($('#c1chWeek1').val()==""){ 
			alert('Please select the occurrence.');
			return false;
	}
	var occ1 = $('#c1chWeek1').val();
	if(occ1 == '1w' || occ1 == '2w')
	{
		if($('.tmSlotc1w1 input:checked').length <= 0 && $('.tmSlotc1w2 input:checked').length <= 0){
			alert('Please select atleast one day and timeslot.');
			return false;
		}
	}
	if($('#Mon1C1W1:checked').length > 0){
		   if($('#duration-sp-mon-w1').val() == '' || $('#ts-sp-mon-w1').val() == '' ){
			   alert('Please select duration and start time of monday');
			   return false;
		   }else{
				var durationMon1 = $('select#duration-sp-mon-w1').val();
				var timeslotMon1 = $('select#ts-sp-mon-w1').val();
		   }
	}
	if($('#Tue1C1W1:checked').length > 0){
		   if($('#duration-sp-tue-w1').val() == '' || $('#ts-sp-tue-w1').val() == '' ){
			    alert('Please select duration and start time of tuesday');
			    return false;
		   }else{
				var durationTue1 = $('select#duration-sp-tue-w1').val();
				var timeslotTue1 = $('select#ts-sp-tue-w1').val();
		   }
	}
	if($('#Wed1C1W1:checked').length > 0){
			if($('#duration-sp-wed-w1').val() == '' || $('#ts-sp-wed-w1').val() == '' ){
			    alert('Please select duration and start time of wednesday');
			    return false;
		   }else{
				var durationWed1= $('select#duration-sp-wed-w1').val();
				var timeslotWed1 = $('select#ts-sp-wed-w1').val();
		   }
	}
	if($('#Thu1C1W1:checked').length > 0){
			if($('#duration-sp-thu-w1').val() == '' || $('#ts-sp-thu-w1').val() != '' == '' ){
			    alert('Please select duration and start time of thursday');
			    return false;
		   }else{
				var durationThu1 = $('select#duration-sp-thu-w1').val();
				var timeslotThu1 = $('select#ts-sp-thu-w1').val();
		   }
	}
	if($('#Fri1C1W1:checked').length > 0){
		   if($('#duration-sp-fri-w1').val()== '' || $('#ts-sp-fri-w1').val() == '' ){
			   alert('Please select duration and start time of friday');
			   return false;
		   }else{
				var durationFri1 = $('select#duration-sp-fri-w1').val();
				var timeslotFri1 = $('select#ts-sp-fri-w1').val();
		   }
			
	}
	if($('#Sat1C1W1:checked').length > 0){
		   if($('#duration-sp-sat-w1').val() == '' || $('#ts-sp-sat-w1').val() == '' ){
			   alert('Please select duration and start time of saturday');
			   return false;
		   }else{
				var durationSat1 = $('select#duration-sp-sat-w1').val();
				var timeslotSat1 = $('select#ts-sp-sat-w1').val();
		   }
			
	}
	if($('#Mon2C1W2:checked').length > 0){
		   if($('#duration-sp-mon-w2').val() == '' || $('#ts-sp-mon-w2').val() == '' ){
			   alert('Please select duration and start time of monday');
			   return false;
		   }else{
				var durationMon2 = $('select#duration-sp-mon-w2').val();
				var timeslotMon2 = $('select#ts-sp-mon-w2').val();
		   }
	}
	if($('#Tue2C1W2:checked').length > 0){
		   if($('#duration-sp-tue-w2').val() == '' || $('#ts-sp-tue-w2').val() == '' ){
			   alert('Please select duration and start time of tuesday');
			   return false;
		   }else{
				var durationTue2 = $('select#duration-sp-tue-w2').val();
				var timeslotTue2 = $('select#ts-sp-tue-w2').val();
		   }
	}
	if($('#Wed2C1W2:checked').length > 0){
		   if($('#duration-sp-wed-w2').val() == '' || $('#ts-sp-wed-w2').val() == '' ){
			   alert('Please select duration and start time of wednesday');
			   return false;
		   }else{
				var durationWed2= $('select#duration-sp-wed-w2').val();
				var timeslotWed2 = $('select#ts-sp-wed-w2').val();
		   }
	}
	if($('#Thu2C1W2:checked').length > 0){
		   if($('#duration-sp-thu-w2').val() == '' || $('#ts-sp-thu-w2').val() == '' ){
			   alert('Please select duration and start time of thursday');
			   return false;
		   }else{
				var durationThu2 = $('select#duration-sp-thu-w2').val();
				var timeslotThu2 = $('select#ts-sp-thu-w2').val();
		   }
	}
	if($('#Fri2C1W2:checked').length > 0) {
		 if($('#duration-sp-fri-w2').val() == '' || $('#ts-sp-fri-w2').val() == '' ){
			   alert('Please select duration and start time of friday');
			   return false;
		   }else{
				var durationFri2 = $('select#duration-sp-fri-w2').val();
				var timeslotFri2 = $('select#ts-sp-fri-w2').val();
		   }
			
	}
	if($('#Sat2C1W2:checked').length > 0){
		   if($('#duration-sp-sat-w2').val() == '' || $('#ts-sp-sat-w2').val() == '' ){
			   alert('Please select duration and start time of saturday');
			   return false;
		   }else{
				var durationSat2 = $('select#duration-sp-sat-w2').val();
				var timeslotSat2 = $('select#ts-sp-sat-w2').val();
		   }
	}
	//send ajax request to insert values into DB		
			$.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'rule_name': $('#txtSchd').val(),
					'start_date': $('#fromSpecialAval').val(),
					'end_date': $('#toSpcialAval').val(),
					'codeBlock': 'createSpecialAvaRule',
					'exceptionSpecialActDates': exceptionDateArr,
					'occurrence':occ1,
					'durationMon1': durationMon1,
					'timeslotMon1': timeslotMon1,
					'durationTue1': durationTue1,
					'timeslotTue1': timeslotTue1,
					'durationWed1': durationWed1,
					'timeslotWed1': timeslotWed1,
					'durationThu1': durationThu1,
					'timeslotThu1': timeslotThu1,
					'durationFri1': durationFri1,
					'timeslotFri1': timeslotFri1,
					'durationSat1': durationSat1,
					'timeslotSat1': timeslotSat1,
					'durationMon2': durationMon2,
					'timeslotMon2': timeslotMon2,
					'durationTue2': durationTue2,
					'timeslotTue2': timeslotTue2,
					'durationWed2': durationWed2,
					'timeslotWed2': timeslotWed2,
					'durationThu2': durationThu2,
					'timeslotThu2': timeslotThu2,
					'durationFri2': durationFri2,
					'timeslotFri2': timeslotFri2,
					'durationSat2': durationSat2,
					'timeslotSat2': timeslotSat2
					},
				success: function($succ){
					if($succ==1){
						window.location.href = 'special_activity.php';
					}else{
						alert("Rule name already exists.");
					}
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
		
	}
$(document).ready(function() {
	var max_fields = 10000; 
    var wrapper = $(".divException"); 
	var add_button_class_exception = $(".btnSpecialActAvailExcep"); 
    var x = 1,y=0; 
    $(add_button_class_exception).click(function(e){ 
	if($("#fromSpecialAval").val()!="" && $("#fromSpecialAval").val()!=""){										 
		var exceptnDate = $('#exceptnSpecialActAval').val();
		e.preventDefault();
		var roomIdException=$('#roomId').val();
		roomIdException="";
		var maxSerialNum=parseInt($('#maxSessionListVal').val(),100);
		if(roomIdException!=""){
			var maxSerialNumVal=maxSerialNum + 1;
			$('#maxSessionListVal').val(maxSerialNumVal);
			if(maxSerialNum==0){
				$(wrapper).append('<div class="sessionList"><table id="datatables" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th >Session Name</th><th>Remove</th></tr></thead><tbody>');	
			}
			if(exceptnDate!=''){
				$('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exceptnDate+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exceptnDate+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeSpecialActException(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
				//$(wrapper).append('');
				$('#exceptnSpecialActAval').val('');
			}
	    }else{
			if(x < max_fields){ 
			x++;
			y++;
			if(exceptnDate!=''){
				if(y==1){
				$(wrapper).append('<div class="exceptionList"><table id="datatables" class="exceptionTbl"><thead><tr><th>Sr. No.</th><th>Exception Date</th><th>Remove</th></tr></thead><tbody>');	
						}
				$('#datatables').append('<tr><td>'+y+'</td><td>'+exceptnDate+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceoptionDate'+y+'"  value="'+exceptnDate+'"/></td><td id='+y+'><a class="remove_field" onclick="removeSpecialActException(0,'+y+')">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnSpecialActAval').val('');
			}
	  }
    }
  }else{
		alert('please select the rule date range before adding a exception');  
	}
  });
});
function removeSpecialActException($exceptionId, $serialId){
	if(confirm("Are you sure you want to delete the Special activity exception?")) {
	    	if($exceptionId == 0){
				$('#'+$serialId).closest('tr').remove();
				$('.green, .red').hide();
			}else{
				$.ajax({
						type: "POST",
						url: "ajax_common.php",
						data: {
							'id': $exceptionId,
							'codeBlock': 'del_spc_act_exception',
						},
						success: function($succ){
							if($succ==1){
								$('#'+$exceptionId).closest('tr').remove();
								$('.green, .red').hide();
							}else{
								alert("Cannot delete the selected exception.");
								$('.green, .red').hide();
							}
						}
				});
    		}
	}
    return false;
}
//showing optional,required field and rule blocks
function specialActivity(){
		 var activity = $( "#special_activity option:selected" ).val();
		 var activity_type = $( "#special_activity_type" ).val();
		 if(activity==3 && activity_type==1){
		   $('#duration,#oneTimeDate,#ot_tslot_id,#ad_hoc_date_slct,#fromADHocDate,#toADHocDate').val(''); 
		   $('.otAct').show();
		   $('.div-ad-hoc-label,.div-ad-hoc-date-slct,.div-ad-hoc-fixed,.div-ad-hoc-range').hide();	
		   $('.scheduleBlockSpAct').hide();	
		   $('.spanPrgm, .spanCycle').text("*");
		   $('.spanPrgm, .spanCycle').closest('.custtd_left').find('h2').css({'font-weight': 'bold'});
		   $('.spanArea, .spanRoom, .spanSubject, .spanSubCode, .spanSubCode').text("");
		   $("#slctArea option").filter(function() {
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $("#slctRoom option").filter(function() {
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $("#slctSubjectName option").filter(function(){
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $('#txtSubjCode').val('N/A');
		   $("#slctTeacher option").filter(function(){
		    return this.text == 'N/A'; 
		}).attr('selected', true);
	   }else if(activity==3 && activity_type==2){
		   $('.otAct').hide();
		   $('#duration,#oneTimeDate,#ot_tslot_id,#ad_hoc_date_slct,#fromADHocDate,#toADHocDate').val(''); 
		   $('.div-ad-hoc-date-slct,.div-ad-hoc-fixed,.div-ad-hoc-range,.divDateSingle ').hide();	
		   $('.scheduleBlockSpAct').show();	
		   $('.spanPrgm, .spanCycle').text("*");	
		   $('.spanPrgm, .spanCycle').closest('.custtd_left').find('h2').css({'font-weight': 'bold'});
		   $('.spanArea, .spanRoom, .spanSubject, .spanSubCode').text("");
		   $("#slctArea option").filter(function() {
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $("#slctRoom option").filter(function() {
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $("#slctSubjectName option").filter(function(){
		    return this.text == 'N/A'; 
			}).attr('selected', true);
		   $('#txtSubjCode').val('N/A');
		   $("#slctTeacher option").filter(function(){
		    return this.text == 'N/A'; 
		}).attr('selected', true);
	   }
	  if((activity==4 || activity==5) && activity_type==1){
		   $('#duration,#oneTimeDate,#ot_tslot_id,#ad_hoc_date_slct,#fromADHocDate,#toADHocDate').val(''); 
		   $('.otAct').show();
		   	if(activity==5){
			 	  $('.div-ad-hoc-fixed,.div-ad-hoc-range,.divDateSingle ').hide();	
			}
			if(activity==4){
				$('.div-ad-hoc-label,.div-ad-hoc-date-slct,.div-ad-hoc-fixed,.div-ad-hoc-range').hide();	
		   	}
		   $('.scheduleBlockSpAct').hide();	
		   $('.spanPrgm, .spanCycle, .spanArea, .spanRoom, .spanSubject, .spanSubCode ').text("");	
		   $('.spanPrgm, .spanCycle').closest('.custtd_left').find('h2').css({'font-weight': 'normal'});
		   $('#slctArea option[value=""]').attr("selected",true);
		   $('#slctRoom option[value=""]').attr("selected",true);
		   $('#slctSubjectName option[value=""]').attr("selected",true);
		   $('#txtSubjCode').val('');
		   $('#slctTeacher option[value=""]').attr("selected",true);
	  	}
		if((activity==4 || activity==5) && activity_type==2){
		   $('#duration,#oneTimeDate,#ot_tslot_id,#ad_hoc_date_slct,#fromADHocDate,#toADHocDate').val(''); 
		   $('.otAct').hide();
		   $('.div-ad-hoc-date-slct,.div-ad-hoc-fixed,.div-ad-hoc-range,.divDateSingle ').hide();	
		   $('.scheduleBlockSpAct').show();	
		   $('.spanPrgm, .spanCycle, .spanArea, .spanRoom, .spanSubject, .spanSubCode').text("");	
		   $('.spanPrgm, .spanCycle').closest('.custtd_left').find('h2').css({'font-weight': 'normal'});
		   $('#slctArea option[value=""]').attr("selected",true);
		   $('#slctRoom option[value=""]').attr("selected",true);
		   $('#slctSubjectName option[value=""]').attr("selected",true);
		   $('#txtSubjCode').val('');
		   $('#slctTeacher option[value=""]').attr("selected",true);
	  	}
}
$(document).ready(function() {
	$('.showotBlock').show();
	if($('#special_act_id').val()!=""){
		$('.scheduleBlockSpAct').hide();
		if($('#ad_hoc_act_date_dd').val()!="" && $('#ad_hoc_act_date_dd').val()=="1"){
			$('.div-ad-hoc-fixed').show();
			$('#oneTimeDate').val('');
			$('.divDateSingle').hide();
			$('.div-ad-hoc-range').hide();
		}else if($('#ad_hoc_act_date_dd').val()!=""){
			$('.divDateSingle').hide();
			$('.div-ad-hoc-fixed').hide();
			$('.div-ad-hoc-range').show();
		}
	}
	if($('#special_sp_act_name').val()!=""){
		if($('#special_activity_type').val()=="2"){
			$('.div-ad-hoc-fixed').hide();
			$('.scheduleBlockSpAct').show();
		}else{
			$('.scheduleBlockSpAct').hide();
			if($('#ad_hoc_act_date_dd').val()!="" && $('#ad_hoc_act_date_dd').val()=="1" ){
				$('.div-ad-hoc-fixed').show();
				$('#oneTimeDate').val('');
				$('.divDateSingle').hide();
				$('.div-ad-hoc-range').hide();
			}else if($('#ad_hoc_act_date_dd').val()!=""){
				$('.divDateSingle').hide();
				$('.div-ad-hoc-fixed').hide();
				$('.div-ad-hoc-range').show();
			}
		}
		
	}
});
//Ajax delete special activity function for the view page
function deleteSpecialActivity($actityName){
	if($actityName==""){
		alert("Please select a special activity to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the special activity associated with activity name?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'actityName': $actityName,
					'codeBlock': 'del_special_activity',
				},
                success: function($succ){
					if($succ==1){
						$('#'+$actityName).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected special activity.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//Ajax to delete the special activity rule
function deleteRuleSpecialActivity($id){
	if($id==""){
		alert("Please select a rule to delete");
		return false;
	}else if(confirm("Are you sure you want to delete rule with associated activities ?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'rule_id': $id,
					'codeBlock': 'del_rule_special_activity',
				},
                success: function($succ){
					if($succ==1){
						window.location.href = 'special_activity.php';
					}else{
						alert("Cannot delete the selected Rule.");
					}
                }
        });
    }
    return false;
}
//validation for the special activity
$(document).ready(function() {
	$("#specialActivityForm").on("submit", function(){
		if($("#txtActName").val()===""){
			alert('please enter the activity name');
			return false;
		}else if($("#special_activity").val()===""){
				alert('please select the activity type');
				return false;
		}else if($("#special_activity_type").val()===""){
				alert('please select the activity frequency');
				return false;
		}											
		if($('#special_activity_type').val()==="1" && $('#special_activity').val()!="5"){
			 if($("#duration").val()===""){
				 	alert('please select the duration');
					return false;
			 }else if($("#oneTimeDate").val()===""){
				 	alert('please select the date');
					return false;
			 }else if($("#ot_tslot_id").val()===""){
					alert('please select the timeslot');
					return false;
			 }
		}else if($('#special_activity_type').val()==="1"){
			 	if($("#duration").val()===""){
				 	alert('please select the duration');
					return false;
			 	}else if($("#ad_hoc_date_slct").val()===""){
					alert('please select the activity date');
					return false;
				} 
				if($("#ad_hoc_date_slct").val()=="1" && $("#ad_hoc_fix_date").val()===""){
				    alert('please select the date');
					return false;
				}
				if($("#ad_hoc_date_slct").val()=="2" && $("#fromADHocDate").val()===""){
					alert('please select the start date range');
					return false;
				}else if($("#ad_hoc_date_slct").val()=="2" && $("#toADHocDate").val()===""){
					alert('please select the end date range');
					return false;
				}
		}
		if($('#special_activity').val()==="3"){
		  	 if($("#slctProgram").val()===""){
				 	alert('please select the program');
					return false;
			 }else if($("#slctCycle").val()===""){
				 	alert('please select the cycle');
					return false;
			 }
		}
		if($('#special_activity_type').val()==="2" && $('[name="ruleval[]"]:checked').length===0){
				alert('please select at least one rule');
					return false;
		}
	});
});
//deleting the special activity which are associate rule
$(document).ready(function() {
   $('.rule__listed_ckb').click(function(){
	 if($('#special_sp_act_name').val()!=""){
		if($(this).is(":checked")){
		}else if($(this).is(":not(:checked)")){
			var activity=$('#special_activity').val();
			var activityType=$('#special_activity_type').val();
			var activityName=$('#txtActName').val();
			var rule_id=$(this).val();
			var ruleIdActid_str = $('#rule_id_grp').val().split(',');
			var ruleCheckedValStr="";
			for (var i = 0; i < ruleIdActid_str.length; i++){
					if(rule_id===ruleIdActid_str[i]){
						ruleCheckedValStr="matched";
						break;
					}
			}
			if(ruleCheckedValStr!=""){
				if(rule_id==""){
					alert("Please select a rule to delete");
					return false;
				}else if(confirm("Are you sure you want to delete all associated activities with this rule?")) {
					$.ajax({
							type: "POST",
							url: "ajax_common.php",
							data: {
								'id': rule_id,
								'activity': activity,
								'activityType': activityType,
								'activityName':activityName,
								'codeBlock': 'delete_rule_associated_activity',
							},
							success: function($succ){
								if($succ==1){
									window.location.href = 'special_activity_view.php';
									$('.green, .red').hide();
								}else{
									alert('Activity can not be deleted');
									$('input[type=checkbox][value='+rule_id+']').prop('checked', false);
									$('.green, .red').hide();
								}
							}
					});
				}
				return false;
		  }
		}
	 }
   });
});
//show and hide the ad-hoc fixed date and range date
function adHocDateShowHide(){
	if($('#ad_hoc_date_slct').val()==1){
			$('.div-ad-hoc-fixed').show();
			$('.div-ad-hoc-range').hide();
			$('#fromADHocDate,#toADHocDate').val('');
	}else if($('#ad_hoc_date_slct').val()==2){
			$('.div-ad-hoc-fixed').hide();
			$('.div-ad-hoc-range').show();
			$('#ad_hoc_fix_date').val('');
	}else{
			$('.div-ad-hoc-fixed').hide();
			$('.div-ad-hoc-range').hide();
			$('#fromADHocDate,#toADHocDate,#ad_hoc_fix_date').val('');
	}
		
}
//getting the subject name on the special activity page with combination of program and cycle 
function getSubjectByProgIDAndCycleID(){
	var prgmId = $('#slctProgram :selected').val();
	var cycleId = $('#slctCycle :selected').val();
	if(prgmId!="" && cycleId!=""){
		 $.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'prgmId': prgmId,
					'cycleId': cycleId,
					'codeBlock': 'getSubjectByPrgmIDAndCycleID',
				},
				success: function(data) {
					 $("#slctSubjectName").html(data);
					 if($('#special_activity').val()==3){
						$("#slctSubjectName option").filter(function() {
							return this.text == 'N/A'; 
						}).attr('selected', true);
					 }
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			  });
	
	}else{
		$("#slctSubjectName").html("<option value=''>--Select a program and cycle first--</option>");	
	}
}
$(document).ready(function() {
	var count = $('#slctTeacherRule option:selected').length;
	if(count == 1)
	{
		$("#reasonRule").prop('disabled', 'disabled');
	}
	var count = $('#slctTeacherInd option:selected').length;
	if(count == 1)
	{
		$("#reasonInd").prop('disabled', 'disabled');
	}
});
function processSelectBoxRule()
{
	var count = $('#slctTeacherRule option:selected').length;
	if(count>1)
	{
		 $("#reasonRule").removeAttr("disabled");
		 $("#reasonRule option:selected").prop("selected", false);
		 $('#reasonRule option[value="Alternate Choices for Session"]').prop("selected", "selected");
	}else{
		$("#reasonRule").attr('disabled', 'disabled');
		$("#reasonRule option:selected").prop("selected", false);
		$("#reasonRule option:first").prop("selected", "selected");		
	}	
}
function processSelectBoxInd()
{
	var count = $('#slctTeacherInd option:selected').length;
	if(count>1)
	{
		 $("#reasonInd").removeAttr("disabled");
		 $("#reasonInd option:selected").prop("selected", false);
		 $('#reasonInd option[value="Alternate Choices for Session"]').prop("selected", "selected");
	}else{
		$("#reasonInd").attr('disabled', 'disabled');
		$("#reasonInd option:selected").prop("selected", false);
		$("#reasonInd option:first").prop("selected", "selected");		
	}
}

function getActName(actNameViewId)
{
	var divActName = '#divActName'+actNameViewId;
    var imageId='#actNameImg'+actNameViewId;
		if($(divActName).css('display') == 'none') {
		//close all the open links
		$(".actNameCls").slideUp("slow");
		$(".actNameImgCls").attr({src: 'images/plus_icon.png'});
		//open the clicked link
		$(divActName).slideDown("slow");
        $(imageId).attr({src: 'images/minus_icon.png'});
    }
    else {
        $(divActName).slideUp("slow");
        $(imageId).attr({src: 'images/plus_icon.png'});
	}
}
//Ajax deleting special activity function from the listing when combination select
function deleteSpecialActivityListing($id){
	if($id==""){
		alert("Please select a special activity to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the special activity?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_special_activity_listing',
				},
                success: function($succ){
					if($succ==1){
						$('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected special activity.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//Ajax function to delete the user 
function deleteUser($id){
	if($id==""){
		alert("Please select a user to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the user?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_user',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected User.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
//active and deactive user
function setUserStatus($id){
	if($id==""){
		alert("Please select a user to delete");
		return false;
	}else {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'set_user_status',
				},
                success: function($succ){
					var imageId='#status-user'+$id;
					if($succ==1){
						//$(imageId).css('background-image','url(./images/bar-circle.gif)');
                       	$(imageId).attr({src: 'images/status-active.png'});
						$(imageId).attr({title: 'Desable'});
					}else{
						$(imageId).attr({src: 'images/status-deactive.png'});
						$(imageId).attr({title: 'Enable'});
					}
                }
        });
    }
 }
 
$(document).ready(function() {
	$('.cls-permission').click(function(){
	 	if($('#slctUserType').val()!=""){
		var ckbVal = $(this).val();
		 var allCkbVal = ckbVal.split("-");
		 var selVal = [];
		 if(allCkbVal[0]=='all'){
			if(this.checked) { 
				if(!$('#add'+allCkbVal[1]).prop('disabled')){ $('#add'+allCkbVal[1]).prop('checked', true); selVal[0] = 'add'+allCkbVal[1]; };
				if(!$('#edit'+allCkbVal[1]).prop('disabled')){ $('#edit'+allCkbVal[1]).prop('checked', true); selVal[1] = 'edit'+allCkbVal[1]; };
				if(!$('#delete'+allCkbVal[1]).prop('disabled')){ $('#delete'+allCkbVal[1]).prop('checked', true); selVal[2] = 'delete'+allCkbVal[1]; };
				if(!$('#view'+allCkbVal[1]).prop('disabled')){ $('#view'+allCkbVal[1]).prop('checked', true); selVal[3] = 'view'+allCkbVal[1]; };
				if(!$('#clone'+allCkbVal[1]).prop('disabled')){ $('#clone'+allCkbVal[1]).prop('checked', true); selVal[4] = 'clone'+allCkbVal[1]; };
			 	
			 }else{
				if(!$('#add'+allCkbVal[1]).prop('disabled')){ $('#add'+allCkbVal[1]).prop('checked', false); selVal[0] = 'add'+allCkbVal[1]; };
				if(!$('#edit'+allCkbVal[1]).prop('disabled')){ $('#edit'+allCkbVal[1]).prop('checked', false); selVal[1] = 'edit'+allCkbVal[1]; };
				if(!$('#delete'+allCkbVal[1]).prop('disabled')){ $('#delete'+allCkbVal[1]).prop('checked', false); selVal[2] = 'delete'+allCkbVal[1]; };
				if(!$('#view'+allCkbVal[1]).prop('disabled')){ $('#view'+allCkbVal[1]).prop('checked', false); selVal[3] = 'view'+allCkbVal[1]; };
				if(!$('#clone'+allCkbVal[1]).prop('disabled')){ $('#clone'+allCkbVal[1]).prop('checked', false); selVal[4] = 'clone'+allCkbVal[1]; };
  
			 }
		  }
		if((allCkbVal[0]=='add' || allCkbVal[0]=='edit') && (allCkbVal[1]==8 || allCkbVal[1]==10|| allCkbVal[1]==15)){
				if(allCkbVal[0]=='add'){
					var edit_current = '#edit'+allCkbVal[1];
					if(this.checked) { 
						 $(edit_current).prop('checked', true);
					 }else{
						$(edit_current).prop('checked', false);
					 }
				}else if(allCkbVal[0]=='edit'){
					var add_current = '#add'+allCkbVal[1];
					if(this.checked) { 
						 $(add_current).prop('checked', true);
					 }else{
						$(add_current).prop('checked', false);
					 }
				}
		}
		var roleType = $('#slctUserType').val();
		if(allCkbVal[1]!=""){
			var page_name = 'page'+allCkbVal[1];
			var page_all='#all'+allCkbVal[1];
			if($('[name="'+page_name+'[]"]:checked').length == $('[name="'+page_name+'[]"]:enabled').length){
				$(page_all).prop('checked', true);
				//send an ajax to update the DB
				$.ajax({
						type: "POST",
						url: "ajax_common.php",
						data: {
							'roleType': roleType,
							'ckbVal': ckbVal,
							'codeBlock': 'updateAllField',
						},
						success: function($succ){
							// do nothing
						}
				});
				
			}else{
				$(page_all).prop('checked', false);
			}
		}
		
		var status='';
		if($(this).is(":checked")){
			status=1;
		}else if($(this).is(":not(:checked)")){
			status=0;
		}
		$.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'roleType': roleType,
					'ckbVal': ckbVal,
					'selVal': selVal,
					'status':status,
					'codeBlock': 'set_user_permission',
				},
                success: function($succ){
					if($succ==1){
						$('#msg').html("Permission has been updated successfully");
						 setTimeout(function() {
        					$("#msg").html('', {}, 500)
    					}, 5000);
				}else{
						$('#msg').html("Permission has not been updated successfully");
						 setTimeout(function() {
        					$("#msg").html('', {}, 500)
    					}, 5000);
					}
                }
        });
	  }else{
		alert('Please select the role type');
		return false;
	  }
   });
});
//redirect the user at role permission page
function setAllPermission(){
		var id='';;
		if($('#slctUserType').val()!=""){
			id = '?rid='+$('#slctUserType').val();
		}
		window.location.href = 'role.php'+id+'';
}
//Ajax delete function the roles like as admin/readonly etc.  
function deleteRole($id){
	if($id==""){
		alert("Please select a role to delete");
		return false;
	}else if(confirm("Are you sure you want to delete the role?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_role',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest('tr').remove();
						$('.green, .red').hide();
					}else{
						alert("Cannot delete the selected Role.");
						$('.green, .red').hide();
					}
                }
        });
    }
    return false;
}
$(document).ready(function() {
	$(".txt-sub").hide();	
});
function PrgmSubSessCloning(){
		var subjectId = new Array();
		$.each($("input[name='prgm_clone[]']"), function() {
  			subjectId.push($(this).val());
    	});
		var subjectName = new Array();
		$.each($("input[name='subject_name[]']"), function() {
  			subjectName.push($(this).val());
    	});
		var subjectCode = new Array();
		$.each($("input[name='subject_code[]']"), function() {
  			subjectCode.push($(this).val());
    	});
		var areaId = new Array();
		$.each($("input[name='area_id[]']"), function() {
  			areaId.push($(this).val());
    	});
		var cycleNum = new Array();
		$.each($("input[name='cycle_num[]']"), function() {
  			cycleNum.push($(this).val());
    	});
		var programYearId = new Array();
		$.each($("input[name='program_yr_new_id[]']"), function() {
  			programYearId.push($(this).val());
    	});
		if(confirm("Are you sure ,you want to clone all subject and session?")){
			$.ajax({
				   type: "POST",
				   url: "ajax_common.php",
				   data: {
							'subjectId': subjectId,
							'subjectName': subjectName,
							'subjectCode': subjectCode,
							'areaId': areaId,
							'cycleNum': cycleNum,
							'programYearId': programYearId,
							'codeBlock': 'cloneSubjectSessionProgram'
						 },
						success: function($succ){
							if($succ==1){
								var sts='Y';
								window.location.href = 'programs_view.php?status='+sts;
							}else if($succ==0){
								 alert('Data is not corrected');	
							}else{
								 alert('Subject code '+$succ+' already exist');
							}
						}
				});
		}
		return false;
}
//function to show hide time slot at program cycle page
$(document).ready(function(){
	$("#sp-act-ts-mon-w1,#sp-act-ts-tue-w1,#sp-act-ts-wed-w1,#sp-act-ts-thu-w1,#sp-act-ts-fri-w1,#sp-act-ts-sat-w1").hide();
	$("#sp-act-ts-mon-w2,#sp-act-ts-tue-w2,#sp-act-ts-wed-w2,#sp-act-ts-thu-w2,#sp-act-ts-fri-w2,#sp-act-ts-sat-w2").hide();
	  $('input[class=special_days]').click(function(){
            if($(this).attr("value")=="Mon1C1W1"){
				$("#sp-act-ts-mon-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-mon-w1").val('');
					$("#ts-sp-mon-w1").val('');
				}
			}else if($(this).attr("value")=="Mon2C1W2"){
				$("#sp-act-ts-mon-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-mon-w2").val('');
					$("#ts-sp-mon-w2").val('');
				}
			}
            if($(this).attr("value")=="Tue1C1W1"){
				$("#sp-act-ts-tue-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-tue-w1").val('');
					$("#ts-sp-tue-w1").val('');
				}
            }else if($(this).attr("value")=="Tue2C1W2"){
				$("#sp-act-ts-tue-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-tue-w2").val('');
					$("#ts-sp-tue-w2").val('');
				}
            }
            if($(this).attr("value")=="Wed1C1W1"){
				$("#sp-act-ts-wed-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-wed-w1").val('');
					$("#ts-sp-wed-w1").val('');
				}
				
            }else if($(this).attr("value")=="Wed2C1W2"){
				$("#sp-act-ts-wed-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-wed-w2").val('');
					$("#ts-sp-wed-w2").val('');
				}
            }
			if($(this).attr("value")=="Thu1C1W1"){
				$("#sp-act-ts-thu-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-thu-w1").val('');
					$("#ts-sp-thu-w1").val('');
				}
            }else if($(this).attr("value")=="Thu2C1W2"){
				$("#sp-act-ts-thu-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-thu-w2").val('');
					$("#ts-sp-thu-w2").val('');
				}
            }
			if($(this).attr("value")=="Fri1C1W1"){
				$("#sp-act-ts-fri-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-fri-w1").val('');
					$("#ts-sp-fri-w1").val('');
				}
            }else if($(this).attr("value")=="Fri2C1W2"){
				$("#sp-act-ts-fri-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-fri-w2").val('');
					$("#ts-sp-fri-w2").val('');
				}
            }
			if($(this).attr("value")=="Sat1C1W1"){
				$("#sp-act-ts-sat-w1").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-sat-w1").val('');
					$("#ts-sp-sat-w1").val('');
				}
            }else if($(this).attr("value")=="Sat2C1W2"){
				$("#sp-act-ts-sat-w2").toggle();
				if($(this).is(":not(:checked)")){
					$("#duration-sp-sat-w2").val('');
					$("#ts-sp-sat-w2").val('');
				}
            }        
	   });
});
function setAllocation($allocation)
{
	if($allocation == 'Allocation by Rule')
	{
		$('#rule_div').show();
		$('#individual_div').hide();
	}
	else
	{
		$('#rule_div').hide();
		$('#individual_div').show();
	}
}
//function to show subjects by program
function createActivityAvailRule(){
	var timeslotMon1 = ""; var timeslotTue1=""; var timeslotWed1=""; var timeslotThu1=""; var timeslotFri1=""; var timeslotSat1="";
	var subIdEncrypt = $('#subIdEncrypt').val();
	var timeslotMon2 = ""; var timeslotTue2=""; var timeslotWed2=""; var timeslotThu2=""; var timeslotFri2=""; var timeslotSat2="";
	
	if($('#txtSchd').val()==""){
		alert('Please select a valid Schedule Name.');
		return false;
	}else if($('#fromSpecialAval').val()==""){
			alert('Please select a valid From Time.');
			return false;
	}else if($('#toSpcialAval').val()==""){ 
			alert('Please select a valid To Time.');
			return false;
	}else if($('#c1chWeek1').val()==""){ 
			alert('Please select the occurrence.');
			return false;
	}
	var occ1 = $('#c1chWeek1').val();
	if(occ1 == '1w' || occ1 == '2w')
	{
		if($('.tmSlotc1w1 input:checked').length <= 0 && $('.tmSlotc1w2 input:checked').length <= 0){
			alert('Please select atleast one day and timeslot.');
			return false;
		}
	}	
	//get the selected values on each days
	if($('#Mon1C1W1:checked').length > 0){
			if($('#duration-sp-mon-w1').val() == '' || $('#ts-sp-mon-w1').val() == '' ){
			   alert('Please select duration and start time of monday');
			   return false;
		   }else{
				var durationMon1 = $('select#duration-sp-mon-w1').val();
				var timeslotMon1 = $('select#ts-sp-mon-w1').val();
		   }
	}
	if($('#Tue1C1W1:checked').length > 0){
		   if($('#duration-sp-tue-w1').val() == '' || $('#ts-sp-tue-w1').val() == '' ){
			   alert('Please select duration and start time of tuesday');
			   return false;
		   }else{
				var durationTue1 = $('select#duration-sp-tue-w1').val();
				var timeslotTue1 = $('select#ts-sp-tue-w1').val();		
		   }
				
	}
	if($('#Wed1C1W1:checked').length > 0){
		   if($('#duration-sp-wed-w1').val() == '' || $('#ts-sp-wed-w1').val() == '' ){
			   alert('Please select duration and start time of wednesday');
			   return false;
		   }else{
				var durationWed1= $('select#duration-sp-wed-w1').val();
				var timeslotWed1 = $('select#ts-sp-wed-w1').val();
		   }
			
	}
	if($('#Thu1C1W1:checked').length > 0){
			if($('#duration-sp-thu-w1').val() == '' || $('#ts-sp-thu-w1').val() == '' ){
			   alert('Please select duration and start time of thursday');
			   return false;
		   }else{
				var durationThu1 = $('select#duration-sp-thu-w1').val();
				var timeslotThu1 = $('select#ts-sp-thu-w1').val();
		   }
			
	}
	if($('#Fri1C1W1:checked').length > 0){
			if($('#duration-sp-fri-w1').val() == '' || $('#ts-sp-fri-w1').val() == '' ){
			   alert('Please select duration and start time of friday');
			   return false;
		   }else{
				var durationFri1 = $('select#duration-sp-fri-w1').val();
				var timeslotFri1 = $('select#ts-sp-fri-w1').val();
		   }
			
	}
	if($('#Sat1C1W1:checked').length > 0){
			if($('#duration-sp-sat-w1').val() == '' || $('#ts-sp-sat-w1').val() == '' ){
			   alert('Please select duration and start time of saturday');
			   return false;
		   }else{
				var durationSat1 = $('select#duration-sp-sat-w1').val();
				var timeslotSat1 = $('select#ts-sp-sat-w1').val();
		   }
			
	}
	if($('#Mon2C1W2:checked').length > 0){
			if($('#duration-sp-mon-w2').val() == '' || $('#ts-sp-mon-w2').val() == '' ){
			   alert('Please select duration and start time of monday');
			   return false;
		   }else{
				var durationMon2 = $('select#duration-sp-mon-w2').val();
				var timeslotMon2 = $('select#ts-sp-mon-w2').val();
		   }
			
	}
	if($('#Tue2C1W2:checked').length > 0){
			if($('#duration-sp-tue-w2').val() == '' || $('#ts-sp-tue-w2').val() == '' ){
			   alert('Please select duration and start time of tuesday');
			   return false;
		   }else{
				var durationTue2 = $('select#duration-sp-tue-w2').val();
				var timeslotTue2 = $('select#ts-sp-tue-w2').val();
		   }
	}
	if($('#Wed2C1W2:checked').length > 0){
			if($('#duration-sp-wed-w2').val() == '' || $('#ts-sp-wed-w2').val() == '' ){
			   alert('Please select duration and start time of wednesday');
			   return false;
		   }else{
				var durationWed2= $('select#duration-sp-wed-w2').val();
				var timeslotWed2 = $('select#ts-sp-wed-w2').val();
		   }
			
	}
	if($('#Thu2C1W2:checked').length > 0){
			if($('#duration-sp-thu-w2').val() == '' || $('#ts-sp-thu-w2').val() == '' ){
			   alert('Please select duration and start time of thursday');
			   return false;
		   }else{
				var durationThu2 = $('select#duration-sp-thu-w2').val();
				var timeslotThu2 = $('select#ts-sp-thu-w2').val();
		   }
			
	}
	if($('#Fri2C1W2:checked').length > 0){
			if($('#duration-sp-fri-w2').val() == '' || $('#ts-sp-fri-w2').val() == '' ){
			   alert('Please select duration and start time of friday');
			   return false;
		   }else{
				var durationFri2 = $('select#duration-sp-fri-w2').val();
				var timeslotFri2 = $('select#ts-sp-fri-w2').val();
		   }
			
	}
	if($('#Sat2C1W2:checked').length > 0){
			if($('#duration-sp-sat-w2').val() == '' || $('#ts-sp-sat-w2').val() == '' ){
			   alert('Please select duration and start time of saturday');
			   return false;
		   }else{
				var durationSat2 = $('select#duration-sp-sat-w2').val();
				var timeslotSat2 = $('select#ts-sp-sat-w2').val();
		   }
			
	}
	if((timeslotMon1!="" || timeslotTue1!="" || timeslotWed1!="" || timeslotThu1!="" || timeslotFri1!="" || timeslotSat1!="" || timeslotMon2!="" || timeslotTue2!="" || timeslotWed2!="" || timeslotThu2!="" || timeslotFri2!="" || timeslotSat2!="") && (durationMon1!="" || durationTue1!="" || durationWed1!="" || durationThu1!="" || durationFri1!="" || durationSat1!="" || durationMon2!="" || durationTue2!="" || durationWed2!="" || durationThu2!="" || durationFri2!="" || durationSat2!="")){
	
		//send ajax request to insert values into DB		
			$.ajax({
				url: "./ajax_common.php",
				type: "POST",
				data: {
					'subject_id': $('#subjectId').val(),
					'rule_name': $('#txtSchd').val(),
					'start_date': $('#fromSpecialAval').val(),
					'end_date': $('#toSpcialAval').val(),
					'codeBlock': 'createActivities',
					'occurrence':occ1,
					'durationMon1': durationMon1,
					'timeslotMon1': timeslotMon1,
					'durationTue1': durationTue1,
					'timeslotTue1': timeslotTue1,
					'durationWed1': durationWed1,
					'timeslotWed1': timeslotWed1,
					'durationThu1': durationThu1,
					'timeslotThu1': timeslotThu1,
					'durationFri1': durationFri1,
					'timeslotFri1': timeslotFri1,
					'durationSat1': durationSat1,
					'timeslotSat1': timeslotSat1,
					'durationMon2': durationMon2,
					'timeslotMon2': timeslotMon2,
					'durationTue2': durationTue2,
					'timeslotTue2': timeslotTue2,
					'durationWed2': durationWed2,
					'timeslotWed2': timeslotWed2,
					'durationThu2': durationThu2,
					'timeslotThu2': timeslotThu2,
					'durationFri2': durationFri2,
					'timeslotFri2': timeslotFri2,
					'durationSat2': durationSat2,
					'timeslotSat2': timeslotSat2
					},
				success: function($succ){
					if($succ==1){
						window.location.href = 'subjects.php?edit='+subIdEncrypt+'&rule=1';
					}else{
						alert("Rule name already exists.");
					}
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
		}else{
			alert('Please select atleast one duration and timeslot.');
		}
}
//Ajax to delete the activity rule
function deleteActivityByRule($id){
		var subIdEncrypt = $('#subIdEncrypt').val();
		if($id==""){
			alert("Please select a rule to delete");
			return false;
		}else if(confirm("Are you sure you want to delete the Rule ?")) {
			$.ajax({
					type: "POST",
					url: "ajax_common.php",
					data: {
						'rule_id': $id,
						'codeBlock': 'del_rule_activity',
					},
					success: function($succ){
						if($succ==1){
							window.location.href = 'subjects.php?edit='+subIdEncrypt+'&rule=1';
						}else{
							alert("Cannot delete the selected Rule, as this rule is associated with sessions and activities.");
						}
					}
			});
		}
		return false;
}
	
//deleting the special activity which are associate rule
$(document).ready(function() {
	   var subIdEncrypt = $('#subIdEncrypt').val();
	   $('.rule_checkbox').click(function(){		 
			if($(this).is(":checked")){
			}else if($(this).is(":not(:checked)")){
				var rule_id=$(this).val();
				var ruleIdActid_str = $('#rule_id_grp').val().split(',');
				var ruleCheckedValStr="";
				for (var i = 0; i < ruleIdActid_str.length; i++){
						if(rule_id===ruleIdActid_str[i]){
							ruleCheckedValStr="matched";
							break;
						}
				}
				if(ruleCheckedValStr!=""){
					if(rule_id==""){
						alert("Please select a rule to delete");
						return false;
					}else if(confirm("Are you sure you want to delete all associated activities with this rule?")) {
						$.ajax({
								type: "POST",
								url: "ajax_common.php",
								data: {
									'id': rule_id,
									'codeBlock': 'delete_rule_associated_teacher_activity',
								},
								success: function($succ){
									if($succ==1){
										window.location.href = 'subjects.php?edit='+subIdEncrypt+'&rule=1';
										$('.green, .red').hide();
									}else{
										alert('Activity can not be deleted');
										$('input[type=checkbox][value='+rule_id+']').prop('checked', false);
										$('.green, .red').hide();
									}
								}
						});
					}
					return false;
			  }
			}
		 
	   });
});
function checkSubjectForm()
	{
		if($('#txtSessName').val()==""){
			alert('Please select a valid Session Name.');
			return false;
		}else if($('#slctTeacherRule option:selected').length == 0){
				alert('Please select a Teacher.');
				return false;
		}else if($('#slctTeacherRule option:selected').length > 1 && $('#reasonRule').val()==""){
				 alert('Please select a reason.');
				return false;
		}else if($('.rule_checkbox:checked').length == 0){ 
				alert('Please select atleast one rule.');
				return false;
		}else{
			$("#subjectForm").submit();
		}
}
function forceSwap2Act(){
	var values = new Array();
	$.each($("input[name='activity_allocation[]']:checked"), function() {
  		values.push($(this).val());
    });
	if(values.length != 2){
		alert('Please select any two pre-allocated activities to swap with each other.');
	}else if(confirm("Are you sure ,you want to swap selected activity ?")){
		$.ajax({
			   type: "POST",
			   url: "ajax_common.php",
			   data: {
						'forceSwapActVal': values,
						'codeBlock': 'forceSwap2Act',
					 },
					success: function($succ){
						if($succ==1){
							$(location).attr('href', 'teacher_activity_view.php');
						}else if($succ==0){
							 alert('Only pre allocated activities can be swapped with each other.');	
						}else if($succ==2){
							 alert('Both selected activities should be from same program.');	
						}else if($succ==3){
							 alert('Both selected activities should have same duration.');	
						}else if($succ==4 || $succ==5){
							 alert('Teacher is not available on the swapped time.');	
						}else{
							 alert('Swaping cannot be done, please contact to site administrator.');	
							}
					}
			});
	}
}

