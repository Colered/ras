$(document).ready(function() {
 $(function() {
	$( "#dob" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		maxDate: new Date(),
		changeMonth: true, 
		changeYear: true,
	});
	$( "#doj" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnClsAval" ).datepicker({
	    dateFormat: 'dd-mm-yy',
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 1,
		changeMonth: true, 
		changeYear: true,
	});
	$( "#exceptnTeachAval" ).datepicker({
	    dateFormat: 'dd-mm-yy',
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
	    dateFormat: 'dd-mm-yy',
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
	    dateFormat: 'dd-mm-yy',
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
	$( "#fromclsRmAval" ).datepicker({
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
	$( "#toclsRmAval" ).datepicker({
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
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'program_id': selval,
			'codeBlock': 'getSubjects',
            },
        success: function(data) {
			 $("#slctSubject").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
//function to show sessions for a subject
function showSessions(selval){
    $.ajax({
        url: "./ajax_common.php",
        type: "POST",
        data: {
            'subject_id': selval,
			'codeBlock': 'getSessions',
            },
        success: function(data) {
			 $("#slctSession").html(data);
        },
        error: function(errorThrown) {
            console.log(errorThrown);
        }
    });
}
