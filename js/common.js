$(document).ready(function() {
 $(function() {
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
      dateFormat: 'dd-mm-yy',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function( selectedDate ) {
	   $( "#toclsRmAval" ).datepicker( "option", "minDate", selectedDate );
	  }
	 });
 $("#toTmDuratn").datepicker({
	  dateFormat: 'dd-mm-yy',
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  changeMonth: true, 
	  changeYear: true,
	  onClose: function( selectedDate ) {
	   $( "#fromclsRmAval" ).datepicker( "option", "maxDate", selectedDate );
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

$(document).ready(function() {
   $('#slctClsType').on('change', function(){
    var selected=$("#slctClsType option:selected").map(function(){ return this.value }).get().join(",");
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'roomTypeValue': selected,
			'codeBlock': 'getRooms',
            },
        success: function(data) {
			 $("#slctRoom").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
	
    
});
});

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
		alert("Please select a program to delete");
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
  sessionName=$('#txtSessionName').val();
  sessionDesc=$('#txtareaSessionDesp').val();
  sessionOrder=$('#txtOrderNum').val();
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
			 $("#activityAddMore").html(data);
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
   $('#slctRmType').on('change', function(){
    var selected=$("#slctRmType option:selected").map(function(){ return this.value }).get().join(",");
	$.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'roomTypeValue': selected,
			'codeBlock': 'getRooms',
            },
        success: function(data) {
			 $("#slctRmName").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
      });
	});
});
$(document).ready(function(){
	$(".ts-avail-mon,.ts-avail-tue,.ts-avail-wed,.ts-avail-thu,.ts-avail-fri,.ts-avail-sat").hide();
	   $('input[class=days]').click(function(){
            if($(this).attr("value")=="mon"){
				$(".ts-avail-mon").toggle();
			}
            if($(this).attr("value")=="tue"){
				$(".ts-avail-tue").toggle();
            }
            if($(this).attr("value")=="wed"){
				$(".ts-avail-wed").toggle();
            }
			if($(this).attr("value")=="thu"){
				$(".ts-avail-thu").toggle();
            }
			if($(this).attr("value")=="fri"){
				$(".ts-avail-fri").toggle();
            }
			if($(this).attr("value")=="sat"){
				$(".ts-avail-sat").toggle();
            }
	   });
});
$(document).ready(function() {
 var count=1;
 $('#arrow-img').click(function(e){ 
	var dateFrom=$('#fromTmDuratn').val();
	var dateTo=$('#toTmDuratn').val();
	var dateRange = dateFrom+' to '+dateTo;
	var days = new Array();
	$.each($("input[name='day[]']:checked"), function() {
 		days.push($(this).val());
	});
	var tsValArr = new Array();
	for($i=0;$i<days.length;$i++){
		var clsTmSlot = '.ts-avail-'+days[$i];
		var str='option:selected';
		var monTmSlot=$(clsTmSlot+ ' ' +str).map(function(){ return this.value }).get().join(",");
		tsValArr.push(monTmSlot); 
	}
	$.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
			'countRule': count,
			'dateFrom': dateFrom,
			'dateTo': dateTo,
			'dateRange': dateRange,
            'days': days,
			'timeSolteArr': tsValArr,
			'codeBlock': 'createRules',
            },
        success: function(data) {
			 count++;
			 $('#fromTmDuratn, #toTmDuratn, #town1, .tmsloteCls').val('');
			 $(".ts-avail-mon,.ts-avail-tue,.ts-avail-wed,.ts-avail-thu,.ts-avail-fri,.ts-avail-sat").hide();
			 $('.days').prop('checked', false);
			 $("#rules").append(data);
		},
        error: function(errorThrown) {
            console.log(errorThrown);
        }
      });
  });
});
//function to reset reserved flag
function reset_reserved_flag(){
    if($("input:radio[name=reserved_flag]").is(":checked")){
       var row_id = $('input:radio[name=reserved_flag]:checked', '#frmTactivity').val();
       $("#room_validate_"+row_id).hide();
       $("#tslot_validate_"+row_id).hide();
	}
	$('input:radio[name=reserved_flag]').attr('checked',false);
}
function roomTslotValidate(tid)
{
   var room_id = $("#room_id_"+tid).val();
   var tslot_id = $("#tslot_id_"+tid).val();
   $(".rfv_error").hide();
   if(room_id=='')
   	  $("#room_validate_"+tid).show();
   if(tslot_id=='')
   	  $("#tslot_validate_"+tid).show();
}
//Ajax to check activity availability
function checkActAvailability(program_year_id,subject_id,sessionid,teacher_id)
{
    var room_id = $("#room_id_"+teacher_id).val();
    if(room_id!=''){
      $("#room_validate_"+teacher_id).hide();
    }
    var tslot_id = $("#tslot_id_"+teacher_id).val();
    if(tslot_id!=''){
	  $("#tslot_validate_"+teacher_id).hide();
    }
    if(room_id!='' || tslot_id!=''){
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
				'codeBlock': 'checkActAvailability',
			 },
			 success: function(data) {
			     var dataArr = data.split('#');
			     if(dataArr[0]==1){
				 	$("#room_id_"+dataArr[1]).addClass("error");
				 	$("#tslot_id_"+dataArr[1]).addClass("error");
				 	$('input[type="submit"]').attr('disabled' , true);
				 }else if(room_id=='' && tslot_id==''){
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
	if($('#txtSchd').val()==""){
			alert('Please select a valid Schedule Name.');
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