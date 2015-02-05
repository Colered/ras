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
$room_filter_id = (isset($_REQUEST['room_avail_id']))?$_REQUEST['room_avail_id']:'';
$teacher_filter_id = (isset($_REQUEST['teacher_avail_id']))?$_REQUEST['teacher_avail_id']:'';
$program_filter_id = (isset($_REQUEST['program_avail_id']))?$_REQUEST['program_avail_id']:'';

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
$exception_dates=array();
if ( empty ( $TIME_SLOTS ) )
  $TIME_SLOTS = 24;

$boldDays = ( $BOLD_DAYS_IN_YEAR == 'Y' );

$startdate = mktime ( 0, 0, 0, $thismonth, 0, $thisyear );
$enddate = mktime ( 23, 59, 59, $thismonth + 1, 0, $thisyear );

$printerStr = $unapprovedStr = '';
$new_event_Arr=array();
/* Pre-Load the repeated events for quckier access */
$repeated_events = read_repeated_events ( empty ( $user )
  ? $login : $user, $startdate, $enddate, $cat_id );

	if($program_id!='' || $teacher_id!='' || $subject_id!='' || $room_id!='' || $area_id!='' || $teacher_type_id!='' || $cycle_id!=''){
		$events = read_events_filters ( ( ! empty ( $user ) && strlen ( $user ) )? $user : $login, $startdate, $enddate, '',$program_id,$teacher_id,$subject_id,$room_id,$area_id,$teacher_type_id,$cycle_id);
	}elseif($room_filter_id!='' || $teacher_filter_id!="" || $program_filter_id!=""){
	$events_detail = read_events_clsrm_teacher_availability ( ( ! empty ( $user ) && strlen ( $user ) ) ? $user : $login, $startdate, $enddate, $cat_id ,$room_filter_id,$teacher_filter_id,$program_filter_id	);
	$events=$events_detail[0];
	$rows_detail=isset($events_detail[2])?$events_detail[2]:'';
	$date_var='';
	foreach ($rows_detail as $key => $val){
		foreach ($val as $key_new=>$val_new){
				if($key_new=='3'){
					$date_var=$val_new;
				}
		}
		$new_event_Arr[$date_var]=$val;
	}
	$exception_dates=(isset($events_detail[1]) && $events_detail[1]!='')? $events_detail[1] : '';
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
$dayStr = print_day_at_a_glance ( $nowYmd, ( empty ( $user ) ? $login : $user ), $can_add, $room_filter_id, $teacher_filter_id, $program_filter_id,$exception_dates,$new_event_Arr);
$navStr = display_navigation ( 'day' );
$smallMonthStr = display_small_month ( $thismonth, $thisyear, true ,false,'','','',$room_filter_id,$teacher_filter_id,$program_filter_id,$exception_dates,$new_event_Arr);
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
				{$navStr}
		</td>
       </tr>
    </table>
EOT;

echo <<<EOT
    <table id="filters-table" border="0" width="70%" cellpadding="1" style="padding-top:10px;padding-left:92px;padding-bottom:30px;">
      <tr>
        <td id="filters-td" valign="top" width="70%" rowspan="2">
		  		<p>
					<div>
					   <div class="legend-only" ><strong >Legend:</strong></div>
					   <div class="legend-color-avail" > </div><label class="legend-label">Available</label>
					   <div class="legend-color-use" > </div><label class="legend-label">In Use</label>
					   <div class="legend-color-holiday" > </div><label class="legend-label">Holiday</label>
					   <div class="legend-color-excp" > </div><label  class="legend-label">Exception</label>
				   </div>
				</p>
		</td>	
       </tr>
    </table>
EOT;

echo <<<EOT

    <table width="100%" cellpadding="1" style="padding-top:50px; padding-left:92px;padding-right:92px;padding-bottom:21px;">
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
include_once 'footer.php';
?>
