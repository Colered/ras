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
});
//validate form for area
$(document).ready(function(){
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
		//$("#changePwdForm").validate();
		$( "#forgotPwdForm" ).validate({
			rules: {
			email: {
				required: true,
				email: true
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
$(document).ready(function() {
	//function for check availability
	$("#btnCheckAvail").on( "click", function() {
		var txtSessionName="", txtCaseNo="", tslot_id="", subSessDate="", txtareatechnicalNotes="", txtareaSessionDesp="", programId="", cycleId="", areaId="", subjectId="";	
		var subIdEncrypt = $('#subIdEncrypt').val()
  		//custom validation for all the fieelds on form
		var formValid = 0;
		if($('#txtSessionName').val()==""){
			$('#txtSessionName').css('border', '1px solid red');
			var formValid = 1;
		}else{
			$('#txtSessionName').css('border', '1px solid #C0C0C0');
			var formValid = 0;
		}
		if($('#slctTeacher').val()==""){
			$('#slctTeacher').css('border', 'solid 1px red');
			var formValid = 1; 
		}else{
			$('#slctTeacher').css('border', '1px solid #C0C0C0');
			var formValid = 0;
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
		if(($('#txtSessionName').val()=="") || ($('#slctTeacher').val()=="") || ($('#slctTeacher').val()=="") || ($('#tslot_id').val()=="") || ($('#subSessDate').datepicker().val()=="")){
			var formValid = 1; 
			return false;
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
						'slctTeacher': $('#slctTeacher').val(),
						'tslot_id': $('#tslot_id').val(),
						'duration': $('#duration').val(),
						'subSessDate': $('#subSessDate').val(),
						'sess_hidden_id': $('#sess_hidden_id').val(),
						'act_hidden_id': $('#act_hidden_id').val(),
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
						}else if($succ==6){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('This session cannot happen in selected room, as other sessions of this subject are scheduled in different room.');
						}else if($succ==3){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher is not available on the selected time and day.');
						}else if($succ==4){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Classroom is already engaged in other activity.');
						}else if($succ==7){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Classroom is not free on the given date and time.');
						}else if($succ==8){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Session Name, Teacher, Room, Timeslot and Date are mendatory fields to create an activity.');
						}else if($succ==9){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Program is not available on the selected day and time.');
						}else if($succ==10){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher already have 4 sessions allocated to him on selected day.');
						}else if($succ==11){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Selected teacher already have other classs at some different location on the selected day.');
						}else if($succ==12){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('Teacher is already allocated to two saturdays of this cycle.');
						}else if($succ==13){
							$('#showstatusAvail').hide();
							$('#showstatusNoAvail').show();
							alert('The sessions scheduled on Saturdays should be from the same academic area.');
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
	});

	
	//add a new session function										  
	$("#btnAddNewSess").on( "click", function() {
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
		if($('#subjectId').val()==""){
			var formValid = 1;
			alert('Please save subject info before add to session.');
			return false;
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
						'slctTeacher': $('#slctTeacher').val(),
						'tslot_id': $('#tslot_id').val(),
						'duration': $('#duration').val(),
						'subSessDate': $('#subSessDate').val(),
						'sess_hidden_id': $('#sess_hidden_id').val(),
						'act_hidden_id': $('#act_hidden_id').val(),
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
							alert('Teacher is not available on the selected time and day.');
						}else if($succ==4){
							alert('Classroom is already engaged in other activity.');
						}else if($succ==7){
							alert('Classroom is not free on the given date and time.');
						}else if($succ==8){
							alert('Session Name, Teacher, Room, Timeslot and Date are mendatory fields to create an activity.');
						}else if($succ==9){
							alert('Program is not available on the selected day and time.');
						}else if($succ==10){
							alert('Teacher already have 4 sessions allocated to him on selected day.');
						}else if($succ==11){
							alert('Teacher is already allocated to some different location the same day.');
						}else if($succ==12){							
							alert('Teacher is already allocated to two saturdays of this cycle.');
						}else if($succ==13){							
							alert('The sessions scheduled on Saturdays should be from the same academic area.');
						}else{
							alert("Cannot create the session.");
						}
					}
				});
		}else{
				return false;
		}
	});
});

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
												$('#'+$srno).closest('tr').remove();
												$('.green, .red').hide();
												var Rows = $(".datatableSession tbody tr");
												var cnt=0;
												Rows.each(function(index, element) {
														cnt++;
												var firstCell = $(this).find('td').eq(0).text(cnt);
												});
												
												//window.location.href = 'subjects.php?edit'+$subjectId+'';
											}else{
												alert("Cannot delete the selected session.");
												$('.green, .red').hide();
											}
										}
								});
							}
						return false;
					}else if($succ==1){
						$('#'+$srno).closest('tr').remove();
						$('.green, .red').hide();
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
			}
            if($(this).attr("value")=="1"){
				$("#ts-avail-day-1").toggle();
            }
            if($(this).attr("value")=="2"){
				$("#ts-avail-day-2").toggle();
            }
			if($(this).attr("value")=="3"){
				$("#ts-avail-day-3").toggle();
            }
			if($(this).attr("value")=="4"){
				$("#ts-avail-day-4").toggle();
            }
			if($(this).attr("value")=="5"){
				$("#ts-avail-day-5").toggle();
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
		if(($('#Mon:checked').length > 0) && ($('#ts-avail-day-0').val() != null)){
				var timeslotMon = '{' +$('select#ts-avail-day-0').val()+ '}';
		}
		if(($('#Tue:checked').length > 0) && ($('#ts-avail-day-1').val() != null)){
			var timeslotTue = '{' +$('select#ts-avail-day-1').val()+ '}';
		}
		if(($('#Wed:checked').length > 0) && ($('#ts-avail-day-2').val() != null)){
			var timeslotWed = '{' +$('select#ts-avail-day-2').val()+ '}';
		}
		if(($('#Thu:checked').length > 0) && ($('#ts-avail-day-3').val() != null)){
			var timeslotThu = '{' +$('select#ts-avail-day-3').val()+ '}';
		}
		if(($('#Fri:checked').length > 0) && ($('#ts-avail-day-4').val() != null)){
			var timeslotFri = '{' +$('select#ts-avail-day-4').val()+ '}';
		}
		if(($('#Sat:checked').length > 0) && ($('#ts-avail-day-5').val() != null)){
			var timeslotSat = '{' +$('select#ts-avail-day-5').val()+ '}';
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
	   $('input[class=days]').click(function(){
            if($(this).attr("value")=="Mon"){
				$("#ts-avail-mon").toggle();
			}
            if($(this).attr("value")=="Tue"){
				$("#ts-avail-tue").toggle();
            }
            if($(this).attr("value")=="Wed"){
				$("#ts-avail-wed").toggle();
            }
			if($(this).attr("value")=="Thu"){
				$("#ts-avail-thu").toggle();
            }
			if($(this).attr("value")=="Fri"){
				$("#ts-avail-fri").toggle();
            }
			if($(this).attr("value")=="Sat"){
				$("#ts-avail-sat").toggle();
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
		if(($('#Mon:checked').length > 0) && ($('#ts-avail-mon').val() != null)){
				var timeslotMon = '{' +$('select#ts-avail-mon').val()+ '}';
		}
		if(($('#Tue:checked').length > 0) && ($('#ts-avail-tue').val() != null)){
			var timeslotTue = '{' +$('select#ts-avail-tue').val()+ '}';
		}
		if(($('#Wed:checked').length > 0) && ($('#ts-avail-wed').val() != null)){
			var timeslotWed = '{' +$('select#ts-avail-wed').val()+ '}';
		}
		if(($('#Thu:checked').length > 0) && ($('#ts-avail-thu').val() != null)){
			var timeslotThu = '{' +$('select#ts-avail-thu').val()+ '}';
		}
		if(($('#Fri:checked').length > 0) && ($('#ts-avail-fri').val() != null)){
			var timeslotFri = '{' +$('select#ts-avail-fri').val()+ '}';
		}
		if(($('#Sat:checked').length > 0) && ($('#ts-avail-sat').val() != null)){
			var timeslotSat = '{' +$('select#ts-avail-sat').val()+ '}';
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
	var max_fields = 10; 
    var wrapper2 = $(".divException"); 
    var add_button_class_exception = $(".btnTeachAvailExcep"); 
    var x = 1,y=0; 
    $(add_button_class_exception).click(function(e){ 
		var exception_date = $('#exceptnTeachAval').val();
		e.preventDefault();
		var decodeTeachId=$('#decodeTeachId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal').val(),10);
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
	var max_fields = 10; 
    var wrapper = $(".divException"); 
    var add_button_class_exception = $(".btnclsrmException"); 
    var x = 1,y=0; 
    $(add_button_class_exception).click(function(e){ 
		var exceptnDate = $('#exceptnClsrmAval').val();
		e.preventDefault();
		var roomIdException=$('#roomId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal').val(),10);
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
	$("#exceptnProgAval1").datepicker({
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	  $("#exceptnProgAval1, #additionalDayCal1, #additionalDayCal2, #additionalDayCal3").datepicker({
	  dateFormat: 'dd-mm-yy',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	 });
	//for cycle 2
	$("#startweek2").datepicker({
	    minDate: cycle1_endweekdate,
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
	$("#exceptnProgAval2").datepicker({
		dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	//for cycle 3
	$("#startweek3").datepicker({
	    minDate: cycle2_endweekdate,
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
	$("#exceptnProgAval3").datepicker({
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
		var max_fields = 10; 
		var x = 1,y=0; 
		var exception_date = $('#exceptnProgAval1').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal1').val(),10);
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
        
   		var max_fields = 10; 
   		var x = 1,y=0; 
		var exception_date = $('#exceptnProgAval2').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal2').val(),10);
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
		var max_fields = 10; 
		var x = 1,y=0; 
 		var exception_date = $('#exceptnProgAval3').val();
		e.preventDefault();
		var programId=$('#programId').val();
		var maxSerialNum=parseInt($('#maxSessionListVal3').val(),10);
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
	}else if(confirm("Are you sure you want to delete this Program Cycles?")) {
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
/*$(document).ready(function(){ 
	$("#subSessDate").datepicker({
			dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			changeMonth: true, 
			changeYear: true,
	});
});
*/

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
	$(".datatableSession").tableDnD();
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
			var max_fields = 10; 
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
			var maxSerialNum=parseInt($('#maxSessListVal1').val(),10);
			if(programId!=""){
				var maxSerialNumVal=maxSerialNum + 1;
				$('#maxSessListVal1').val(maxSerialNumVal);
				if(maxSerialNum==0){
					$(".divAddition1").append('<div class="additionList1"><table id="dataaddtables1" class="additionTbl"><thead><tr><th>Sr. No.</th><th>Additional Date</th><th>Additional Timeslots</th><th>Remove</th></tr></thead><tbody>');	
				}
				if(additional_date!=''){
					$('#dataaddtables1').append('<tr><td>'+maxSerialNumVal+'</td><td>'+additional_date+'</td><td style="display:none"><input type="hidden" name="additionDate1[]" id="additionDate'+maxSerialNumVal+'" value="'+additional_date+'"/></td><td id="time_slot'+maxSerialNumVal+'"></td><td style="display:none"><input type="hidden" name="time_slot1[]" id="timeslot'+maxSerialNumVal+'" value=""/><input type="hidden" name="actual_time_slot1[]" id="act_timeslot'+maxSerialNumVal+'" value=""/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="deleteAddProgCycle(0,'+maxSerialNumVal+')">Remove</a></td></tr></tbody></table></div>');
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
			var max_fields = 10; 
			var x = 1,y=0; 
			var additional_date = $('#additionalDayCal2').val();
			var time_slot2 = $('#timeSlot2').val();
			var maxSerialNum=parseInt($('#maxSessListVal2').val(),10);
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
			var max_fields = 10; 
			var x = 1,y=0; 
			var additional_date = $('#additionalDayCal3').val();
			var time_slot3 = $('#timeSlot3').val();
			var maxSerialNum=parseInt($('#maxSessListVal3').val(),10);
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
			$('#'+$serialId).closest('tr').remove();
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
