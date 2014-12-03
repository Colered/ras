<?php
/* $Id: day.php,v 1.78.2.4 2008/03/31 21:03:41 umcesrjones Exp $ */
include_once 'includes/init.php';
include_once 'config.php';
include_once 'includes/header.php';
//check UAC

$program_id=(isset($_REQUEST['program_id'])) ? ($_REQUEST['program_id']) : '';
$teacher_id=(isset($_REQUEST['teacher_id'])) ? ($_REQUEST['teacher_id']) : '';
$subject_id=(isset($_REQUEST['subject_id'])) ? ($_REQUEST['subject_id']) : '';
$room_id=(isset($_REQUEST['room_id'])) ? ($_REQUEST['room_id']) : '';
$area_id=(isset($_REQUEST['area_id'])) ? ($_REQUEST['area_id']) : '';
$teacher_type_id=(isset($_REQUEST['teacher_type_id'])) ? ($_REQUEST['teacher_type_id']) : '';
$cycle_id=(isset($_REQUEST['cycle_id'])) ? ($_REQUEST['cycle_id']) : '';

if ( ! access_can_access_function ( ACCESS_DAY ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();
  
load_user_layers ( $user != $login && $is_nonuser_admin ? $user : '' );

load_user_categories ();

$wday = strftime ( '%w', mktime ( 0, 0, 0, $thismonth, $thisday, $thisyear ) );
$now = mktime ( 23, 59, 59, $thismonth, $thisday, $thisyear );
$nowYmd = date ( 'Ymd', $now );

$next = mktime ( 0, 0, 0, $thismonth, $thisday + 1, $thisyear );
$nextday = date ( 'd', $next );
$nextmonth = date ( 'm', $next );
$nextyear = date ( 'Y', $next );
$nextYmd = date ( 'Ymd', $next );

$prev = mktime ( 0, 0, 0, $thismonth, $thisday - 1, $thisyear );
$prevday = date ( 'd', $prev );
$prevmonth = date ( 'm', $prev );
$prevyear = date ( 'Y', $prev );
$prevYmd = date ( 'Ymd', $prev );

if ( empty ( $TIME_SLOTS ) )
  $TIME_SLOTS = 24;

$boldDays = ( $BOLD_DAYS_IN_YEAR == 'Y' );

$startdate = mktime ( 0, 0, 0, $thismonth, 0, $thisyear );
$enddate = mktime ( 23, 59, 59, $thismonth + 1, 0, $thisyear );

$printerStr = $unapprovedStr = '';

/* Pre-Load the repeated events for quckier access */
$repeated_events = read_repeated_events ( empty ( $user )
  ? $login : $user, $startdate, $enddate, $cat_id );

	/* Pre-load the non-repeating events for quicker access */
	   /*$events = read_events ( empty ( $user )
  		? $login : $user, $startdate, $enddate, $cat_id );
  	*/	
	/*if($teacher_id!=""){
	$events = read_events_teacher (  empty ( $user )
	  ? $user : $login, $startdate, $enddate,'',$teacher_id);
	}else if($program_id!=""){
	$events = read_events_program ( empty ( $user )
	  ? $user : $login, $startdate, $enddate, '' ,$program_id);
	}else if($subject_id!=""){
	$events = read_events_subject (  empty ( $user )
	  ? $user : $login, $startdate, $enddate, $cat_id ,$subject_id);
	}else if($room_id!=""){
	$events = read_events_room (  empty ( $user )
	  ? $user : $login, $startdate, $enddate, $cat_id ,$room_id);
	}else if($area_id!=""){
	$events = read_events_area ( ( ! empty ( $user ) && strlen ( $user ) )
  	? $user : $login, $startdate, $enddate, $cat_id ,$area_id);	
	}else if($teacher_type_id){
	$events = read_events_teacher_type ( ( ! empty ( $user ) && strlen ( $user ) )
  	? $user : $login, $startdate, $enddate, $cat_id ,$teacher_type_id);
	}else if($cycle_id!=""){
	$events = read_events_cycle ( ( ! empty ( $user ) && strlen ( $user ) )
  	? $user : $login, $startdate, $enddate, $cat_id ,$cycle_id);
	}else{
	 $events = read_events (empty ( $user ) 
	  ? $user : $login,$startdate, $enddate, $cat_id );
	} */
	if($program_id!='' || $teacher_id!='' || $subject_id!='' || $room_id!='' || $area_id!='' || $teacher_type_id!='' || $cycle_id!=''){
		$events = read_events_filters ( ( ! empty ( $user ) && strlen ( $user ) )? $user : $login, $startdate, $enddate, '',$program_id,$teacher_id,$subject_id,$room_id,$area_id,$teacher_type_id,$cycle_id);
	}else{
 		$events = read_events (empty ( $user ) ? $user : $login,$startdate, $enddate, $cat_id);
	}
	
if ( empty ( $DISPLAY_TASKS_IN_GRID ) || $DISPLAY_TASKS_IN_GRID == 'Y' )
  /* Pre-load tasks for quicker access */
  $tasks = read_tasks ( ! empty ( $user ) && strlen ( $user ) && $is_assistant
    ? $user : $login, $now, $cat_id );

$smallTasks = ( $DISPLAY_TASKS == 'Y' ? '<div id="minitask">
           ' . display_small_tasks ( $cat_id ) . '
          </div>' : '' );
$dayStr = print_day_at_a_glance ( $nowYmd, ( empty ( $user )
    ? $login : $user ), $can_add );
$navStr = display_navigation ( 'day' );
$smallMonthStr = display_small_month ( $thismonth, $thisyear, true );
if ( empty ( $friendly ) ) {
  $unapprovedStr = display_unapproved_events (
    $is_assistant || $is_nonuser_admin ? $user : $login );
  $printerStr = generate_printer_friendly ( 'day.php' );
}
$eventinfo = ( empty ( $eventinfo ) ? '' : $eventinfo );
$trailerStr = print_trailer ();
print_header ( array ( 'js/popups.php/true' ), generate_refresh_meta (), '',
  false, false, false, false );

echo <<<EOT
    <table id="filters-table" border="0" width="70%" cellpadding="1" style="padding-left:92px;">
      <tr>
        <td id="filters-td" valign="top" width="70%" rowspan="2" style="padding-top:0px;">
			<fieldset>
  				<legend>Filters:</legend>
 				{$navStr}
			</fieldset>
		 </td>
       </tr>
    </table>
EOT;

echo <<<EOT

    <table width="100%" cellpadding="1" style="padding-top:50px; padding-left:92px;padding-right:92px;">
      <tr>
        <td width="80%">
         
        </td>
        <td class="aligntop" rowspan="2">
          <!-- START MINICAL -->
          <div class="minicalcontainer">
            {$smallMonthStr}
          </div>
          {$smallTasks}
        </td>
      </tr>
      <tr>
        <td>
          {$dayStr}
        </td>
      </tr>
    </table>
    {$eventinfo}
    {$unapprovedStr}
    {$printerStr}
    {$trailerStr}
EOT;

?>
