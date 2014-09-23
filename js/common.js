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
	$( "#dob" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		maxDate: new Date(),
		changeMonth: true, 
		changeYear: true,
	});
	$( "#doj" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnClsAval" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnTeachAval" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnClsrmAval" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnClsrmAval" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#holiday_date" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
 });			   

$(function() {
	$( "#fromGenrtTmtbl" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#toGenrtTmtbl" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#toGenrtTmtbl" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#fromGenrtTmtbl" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
$(function() {
	$( "#startweek1" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#endweek1" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#endweek1" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#startweek1" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
$(function() {
	$( "#startweek2" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#endweek2" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#endweek2" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#startweek2" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
$(function() {
	$( "#startweek3" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#endweek3" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#endweek3" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#startweek3" ).datepicker( "option", "maxDate", selectedDate );
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
	$( "#fromTeachAval" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#toTeachAval" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#toTeachAval" ).datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#fromTeachAval" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
$(function() {
 $( "#fromTmDuratn" ).datepicker({
      dateFormat: 'yy-mm-dd',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function( selectedDate ) {
	   $( "#toTmDuratn" ).datepicker( "option", "minDate", selectedDate );
	  }
	 });
 $("#toTmDuratn").datepicker({
	  dateFormat: 'yy-mm-dd',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function( selectedDate ) {
	   $( "#fromTmDuratn" ).datepicker( "option", "maxDate", selectedDate );
	  }
	 });
 $("#fromclsRmAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#toclsRmAval" ).datepicker( "option", "minDate", selectedDate );
		}
	});
 $("#toclsRmAval").datepicker({
	    dateFormat: 'yy-mm-dd',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
		onClose: function( selectedDate ) {
			$( "#fromclsRmAval" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
});
//validate form for area
$(document).ready(function(){
		$("#areaForm").validate();
		$("#subjectForm").validate();
		$("#roomsForm").validate();
		$("#buildings").validate();
		$("#frmProgram").validate();
		$("#frmProff").validate();
		$("#frmSgroup").validate();
		$("#frmTactivity").validate();
		$("#teacherAvailabilityForm").validate();
		$("#classroomAvailabilityForm").validate();
		$("#timetable").validate();
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
                        $('#'+$id).closest( 'tr').remove();
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
	}else if(confirm("Are you sure you want to delete the Building?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_buld',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
	}else if(confirm("Are you sure you want to delete?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_program',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
	}else if(confirm("Are you sure you want to delete the Subject?")) {
	    $.ajax({
                type: "POST",
                url: "ajax_common.php",
                data: {
					'id': $id,
					'codeBlock': 'del_subject',
				},
                success: function($succ){
					if($succ==1){
                        $('#'+$id).closest( 'tr').remove();
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
    var max_fields      = 10; 
    var wrapper         = $(".divSession"); 
    var add_button      = $(".btnSession"); 
    var x = 1,y=0; 
    $(add_button).click(function(e){ 
  var sessionName='',sessionOrder='',sessionDesc='';       
  sessionName=stripslashes(strip_tags($('#txtSessionName').val()));
  sessionDesc=stripslashes(strip_tags($('#txtareaSessionDesp').val()));
  sessionOrder=$('#txtOrderNum').val();
  if(sessionName==""){
	 alert('Please select session name.');
  }else if(sessionOrder==""){
	 alert('Please select order number');
  }else if(!$.isNumeric(sessionOrder)){
	 alert('order number should be numeric');
  }
  if($.isNumeric(sessionOrder)){
  e.preventDefault();
  var subjectID=$('#subjectId').val();
  var maxSerialNum=parseInt($('#maxSessionListVal').val(),10);
  if(subjectID!=""){
   var maxSerialNumVal=maxSerialNum + 1;
   $('#maxSessionListVal').val(maxSerialNumVal);
   if(maxSerialNum==0){
    $(wrapper).append('<div class="sessionList"><table id="datatables" class="display"><thead><tr><th>Sr. No.</th><th >Session Name</th><th >Order Number</th><th >Description</th><th>Remove</th></tr></thead><tbody>'); 
   }
   if(sessionName!=''){
    $('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+sessionName+'</td><td>'+sessionOrder+'</td><td>'+sessionDesc+'</td><td style="display:none"><input type="hidden" name="sessionName[]" id="sessionName'+maxSerialNumVal+'"  value="'+sessionName+'"/><input type="hidden" name="sessionDesc[]" id="sessionDesc'+maxSerialNumVal+'"  value="'+sessionDesc+'"/><input type="hidden" name="sessionOrder[]" id="sessionOrder'+maxSerialNumVal+'"  value="'+sessionOrder+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeSession(0,'+maxSerialNumVal+' )">Remove</a></td></tr></tbody></table></div>');
    //$(wrapper).append('');
    $('#txtSessionName').val('');
    $('#txtOrderNum').val('');
    $('#txtareaSessionDesp').val('');
   }
     }else{
   if(x < max_fields){ 
   x++;
   y++;
   if(sessionName!=''){
    if(y==1){
    $(wrapper).append('<div class="sessionList"><table id="datatables" class="display"><thead><tr><th>Sr. No.</th><th >Session Name</th><th >Order Number</th><th >Description</th><th>Remove</th></tr></thead><tbody>'); 
    }
             $('#datatables').append('<tr><td>'+y+'</td><td>'+sessionName+'</td><td>'+sessionOrder+'</td><td>'+sessionDesc+'</td><td style="display:none"><input type="hidden" name="sessionName[]" id="sessionName'+y+'"  value="'+sessionName+'"/><input type="hidden" name="sessionDesc[]" id="sessionDesc'+y+'"  value="'+sessionDesc+'"/><input type="hidden" name="sessionOrder[]" id="sessionOrder'+y+'"  value="'+sessionOrder+'"/></td><td id='+y+'><a class="remove_field" onclick="removeSession(0,'+y+')">Remove</a></td></tr></tbody></table></div>');
    $('#txtSessionName').val('');
    $('#txtOrderNum').val('');
    $('#txtareaSessionDesp').val('');
   }
   }
    }
   }else{
      alert('Order number should be numeric');
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
function removeSession($sessionId, $serialId){
	if(confirm("Are you sure you want to delete the Subject?")) {
	    	if($sessionId == 0){
				$('#'+$serialId).closest( 'tr').remove();
				$('.green, .red').hide();
			}else{
				$.ajax({
						type: "POST",
						url: "ajax_common.php",
						data: {
							'id': $sessionId,
							'codeBlock': 'del_session',
						},
						success: function($succ){
							if($succ==1){
								$('#'+$sessionId).closest( 'tr').remove();
								$('.green, .red').hide();
							}else{
								alert("Cannot delete the selected session.");
								$('.green, .red').hide();
							}
						}
				});
    		}
	}
    return false;
}
//function to show subjects by program
function showSubjects(selval){
    $("#ajaxload_subject").show();
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
					$('#'+$id).closest( 'tr').remove();
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
		 var slctSubject = $('#slctSubject').val();
		 var slctSession = $('#slctSession').val();
		 var slctTeacher = $('#slctTeacher').val();
		 $("#ajaxload_actDiv").show();
		 $.ajax({
		   url: "./ajax_common.php",
		   type: "POST",
		   data: {
			   'program_year_id': slctProgram,
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
    if (!regx.test($('#txtSchd').val())) {
        alert('Please select a valid schedule name with alphanumeric options.');
		return false;
    }
    else if($('#fromTeachAval').val()==""){
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
				$('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exception_date+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exception_date+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeSession(0,'+maxSerialNumVal+' )">Remove</a></td></tr></tbody></table></div>');
				$('#exceptnTeachAval').val('');
			}
	    }
 });
});
//Ajax delete the TeachAvail function 
function deleteExcepTeachAvail($sessionId, $serialId){
	if(confirm("Are you sure you want to delete the Exception?")) {
	    	if($sessionId == 0){
				$('#'+$serialId).closest( 'tr').remove();
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
								$('#'+$sessionId).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
				$('#datatables').append('<tr><td>'+maxSerialNumVal+'</td><td>'+exceptnDate+'</td><td style="display:none"><input type="hidden" name="exceptionDate[]" id="exceptnDate'+maxSerialNumVal+'"  value="'+exceptnDate+'"/></td><td id='+maxSerialNumVal+'><a class="remove_field" onclick="removeClassException(0,'+maxSerialNumVal+' )">Remove</a></td></tr></tbody></table></div>');
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
				$('#'+$serialId).closest( 'tr').remove();
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
								$('#'+$exceptionId).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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
                        $('#'+$id).closest( 'tr').remove();
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