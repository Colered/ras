<?php
/* $Id: week.php,v 1.133.2.5 2008/09/27 14:50:18 cknudsen Exp $ */
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
$room_avail_id = (isset($_GET['room_avail_id']) && (!empty($_GET['room_avail_id'])))? (explode('-', $_GET['room_avail_id'])):((isset($_POST['room_avail_id']) && ($_POST['room_avail_id']!=""))? $_POST['room_avail_id']:"");
  $teacher_avail_id = (isset($_GET['teacher_avail_id']) && (!empty($_GET['teacher_avail_id'])))? (explode('-',$_GET['teacher_avail_id'])):((isset($_POST['teacher_avail_id']) && ($_POST['teacher_avail_id']!=""))? $_POST['teacher_avail_id']:"");
  $program_avail_id = (isset($_GET['program_avail_id']) && (!empty($_GET['program_avail_id'])))? (explode('-',$_GET['program_avail_id'])):((isset($_POST['program_avail_id']) && ($_POST['program_avail_id']!=""))? $_POST['program_avail_id']:"");
  
//echo $program_avail_id; die;

if ( ! access_can_access_function ( ACCESS_WEEK ) || 
  ( ! empty ( $user ) && ! access_user_calendar ( 'view', $user ) )  )
  send_to_preferred_view ();
  
load_user_layers ( ( $user != $login ) && $is_nonuser_admin ? $user : '' );
load_user_categories ();

$nextYmd =
date ( 'Ymd', mktime ( 0, 0, 0, $thismonth, $thisday + 7, $thisyear ) );
$prevYmd =
date ( 'Ymd', mktime ( 0, 0, 0, $thismonth, $thisday - 7, $thisyear ) );

$boldDays = ( ! empty ( $BOLD_DAYS_IN_YEAR ) && $BOLD_DAYS_IN_YEAR == 'Y' );

$wkstart = get_weekday_before ( $thisyear, $thismonth, $thisday + 1 );
$wkend = $wkstart + ( 86400 * ( $DISPLAY_WEEKENDS == 'N' ? 5 : 7 ) );

$startdate = date ( 'Ymd', $wkstart );
$enddate = date ( 'Ymd', $wkend );

$start_ind = 0;

if ( $DISPLAY_WEEKENDS == 'N' ) {
  $end_ind = 4;
  $WEEK_START = 1; //Set to Monday.
} else
  $end_ind = 6;

if ( empty ( $TIME_SLOTS ) )
  $TIME_SLOTS = 24;

$interval = 1440 / $TIME_SLOTS;

$first_slot = intval ( ( $WORK_DAY_START_HOUR * 60 ) / $interval );
$last_slot = intval ( ( $WORK_DAY_END_HOUR * 60 ) / $interval );

$untimed_found = false;
$get_unapproved = ( $DISPLAY_UNAPPROVED == 'Y' );
// .
// Make sure all days with events are bold if mini cal is displayed.
if ( $DISPLAY_SM_MONTH == 'Y' && $BOLD_DAYS_IN_YEAR == 'Y' ) {
  $evStart = get_weekday_before ( $thisyear, $thismonth );
  $evEnd = mktime ( 23, 59, 59, $thismonth + 2, 0, $thisyear );
} else {
  $evStart = $wkstart;
  $evEnd = $wkend;
}
$exception_dates=$new_event_Arr=array();
/* Pre-Load the repeated events for quickier access. */
$repeated_events = read_repeated_events ( ( strlen ( $user )
    ? $user : $login ), $evStart, $evEnd, $cat_id );


if($program_id!='' || $teacher_id!='' || $subject_id!='' || $room_id!='' || $area_id!='' || $teacher_type_id!='' || $cycle_id!=''){
	$events = read_events_filters ( ( strlen ( $user )? $user : $login ),  $evStart - 604800, $evEnd, '',$program_id,$teacher_id,$subject_id,$room_id,$area_id,$teacher_type_id,$cycle_id);
}elseif(!empty($room_avail_id) || !empty($teacher_avail_id) || !empty($program_avail_id)){
     $events_detail = read_events_clsrm_teacher_availability (( strlen ( $user )? $user : $login ), $evStart - 604800, $evEnd,$cat_id ,$room_avail_id,$teacher_avail_id,$program_avail_id);
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
 	$events = read_events ( ( strlen ( $user )? $user : $login ),  $evStart - 604800, $evEnd, $cat_id );
}

if ( empty ( $DISPLAY_TASKS_IN_GRID ) || $DISPLAY_TASKS_IN_GRID == 'Y' )
  /* Pre-load tasks for quicker access. */
  $tasks = read_tasks ( ! empty ( $user ) && strlen ( $user ) && $is_assistant
    ? $user : $login, $wkend, $cat_id );

$eventsStr = $filler = $headerStr = $minical_tasks = $untimedStr = '';
$navStr = display_navigation ( 'week' );
$week_name_display=display_navigation_current_month( 'week' );
$objTS =new Timeslot();
$allocated_data=$objTS->getAllAllocatedDateForAllIds($teacher_filter_id,$room_filter_id,$program_filter_id);
$allocate_nonAllocated_TS_str=$allocate_nonAllocated_TS = $hasTimeslot = '';$allocated_ts_str_Arr=array();
$holiday_date=array();
   //Holiday Dates
   $objH =new Holidays();
   $holiday_data=$objH->viewHoliday();
	while($row_holiday = $holiday_data->fetch_assoc()){
   		$holiday_date[] = date("Ymd", strtotime($row_holiday['holiday_date']));
    }

for ( $i = $start_ind; $i <= $end_ind; $i++ ) {
  $days[$i] = ( $wkstart + ( 86400 * $i ) ) + 43200;
  $weekdays[$i] = weekday_name ( ( $i + $WEEK_START ) % 7, $DISPLAY_LONG_DAYS );
  $dateYmd = date ( 'Ymd', $days[$i] );
  $header[$i] = $weekdays[$i] . '<br />'
   . date_to_str ( $dateYmd, $DATE_FORMAT_MD, false, true );
  // .
  // Generate header row.
  $class = ( $dateYmd == date ( 'Ymd', $today )? " today" : ( is_weekend ( $days[$i] ) ? " weekend" : "" ) );
  
  $room_avail_id_link = (isset($_GET['room_avail_id']) && ($_GET['room_avail_id']!=""))? $_GET['room_avail_id']:((isset($_POST['room_avail_id']) && ($_POST['room_avail_id']!=""))?(implode('-',$_POST['room_avail_id'])):"");
  $teacher_avail_id_link = (isset($_GET['teacher_avail_id']) && ($_GET['teacher_avail_id']!=""))? $_GET['teacher_avail_id']:((isset($_POST['teacher_avail_id']) && ($_POST['teacher_avail_id']!=""))?(implode('-',$_POST['teacher_avail_id'])):"");
  $program_avail_id_link = (isset($_GET['program_avail_id']) && ($_GET['program_avail_id']!=""))? $_GET['program_avail_id']:((isset($_POST['program_avail_id']) && ($_POST['program_avail_id']!=""))?(implode('-',$_POST['program_avail_id'])):"");
  
  $headerStr .= '
              <th ' . $class . '>'
   . ( $can_add ? html_for_add_icon ( $dateYmd, '', '', $user ) : '' )
   . '<p style="margin:.75em 0 0 0"><a href="day.php?' . $u_url . 'date=' . $dateYmd . $caturl 
	   . ( empty ( $_REQUEST['program_id'] ) ? '' : '&amp;program_id=' .$_REQUEST['program_id'] )
	   . ( empty ( $_REQUEST['teacher_id'] ) ? '' : '&amp;teacher_id=' .$_REQUEST['teacher_id'] )
	   . ( empty ( $_REQUEST['subject_id'] ) ? '' : '&amp;subject_id=' .$_REQUEST['subject_id'] )
	   . ( empty ( $_REQUEST['room_id'] ) ? '' : '&amp;room_id=' .$_REQUEST['room_id'] )
	   . ( empty ( $_REQUEST['area_id'] ) ? '' : '&amp;area_id=' .$_REQUEST['area_id'] )
	   . ( empty ( $_REQUEST['teacher_type_id'] ) ? '' : '&amp;teacher_type_id=' .$_REQUEST['teacher_type_id'] )
	   . ( empty ( $_REQUEST['cycle_id'] ) ? '' : '&amp;cycle_id=' .$_REQUEST['cycle_id'] )
	   . ( empty ( $_REQUEST['room_avail_id'] ) ? '' : '&amp;room_avail_id=' .$room_avail_id_link )
	   . ( empty ( $_REQUEST['teacher_avail_id'] ) ? '' : '&amp;teacher_avail_id=' .$teacher_avail_id_link )
	   . ( empty ( $_REQUEST['program_avail_id'] ) ? '' : '&amp;program_avail_id=' .$program_avail_id_link ). '">'
   . $header[$i] . '</a></p></th>';

  $date = date ( 'Ymd', $days[$i] );
  $hour_arr = $rowspan_arr = $tk = array ();
  
  // .
  // Get, combine and sort, static and repeating events for this date.
  $ev = combine_and_sort_events ( get_entries ( $date, $get_unapproved ),
    get_repeating_entries ( $user, $date ) );
  // .
  // Then sort in any tasks due for this day and before.
  $ev = combine_and_sort_events ( $ev,
    ( $date >= date ( 'Ymd' )
      ? get_tasks ( $date, $get_unapproved ) : $tk ) );
//print_r($hour_arr);
  for ( $j = 0, $cnt = count ( $ev ); $j < $cnt; $j++ ) {
    if ( $get_unapproved || $ev[$j]->getStatus () == 'A' )
      html_for_event_week_at_a_glance ( $ev[$j], $date );
  }
  // .
  // Squish events that use the same cell into the same cell.
  // For example, an event from 8:00-9:15 and another from 9:30-9:45
  // both want to show up in the 8:00-9:59 cell.
   $last_row = -1;
  $rowspan = 0;
  for ( $j = 0; $j < $TIME_SLOTS; $j++ ) {
    if ( $rowspan > 1 ) {
      if ( ! empty ( $hour_arr[$j] ) ) {
        $diff_start_time = $j - $last_row;
        if ( $rowspan_arr[$j] > 1 ) {
          if ( $rowspan_arr[$j] + ( $diff_start_time ) > $rowspan_arr[$last_row] )
            $rowspan_arr[$last_row] = ( $rowspan_arr[$j] + ( $diff_start_time ) );

          $rowspan += ( $rowspan_arr[$j] - 1 );
        } else
          $rowspan_arr[$last_row] += $rowspan_arr[$j];
        // .
        // This will move entries apart that appear in one field,
        // yet start on different hours.
        for ( $u = $diff_start_time; $u > 0; $u-- ) {
          $hour_arr[$last_row] .= '<br />' . "\n";
        }
        $hour_arr[$last_row] .= $hour_arr[$j];
        $hour_arr[$j] = '';
        $rowspan_arr[$j] = 0;
      }
      $rowspan--;
    } else
    if ( ! empty ( $rowspan_arr[$j] ) && $rowspan_arr[$j] > 1 ) {
      $last_row = $j;
      $rowspan = $rowspan_arr[$j];
    }
  }
  // .
  // Now save the output...
  if ( ! empty ( $hour_arr[9999] ) && strlen ( $hour_arr[9999] ) ) {
    $untimed[$i] = $hour_arr[9999];
    $untimed_found = true;
  }

  $untimedStr .= '
              <td'
  // Use the class 'hasevents' for any hour block that has events in it.
  . ( ! empty ( $untimed[$i] ) && strlen ( $untimed[$i] )
   ? ' class="hasevents"' : $class )
   . '>' . ( ! empty ( $untimed[$i] ) && strlen ( $untimed[$i] )
    ? $untimed[$i] : '&nbsp;' ) . '</td>';
//print_r($hour_arr);
  $save_hour_arr[$i] = $hour_arr;
  $save_rowspan_arr[$i] = $rowspan_arr;
  $rowspan_day[$i] = 0;
}
$untimedStr = ( $untimed_found ? '
            <tr>
              <th class="empty">&nbsp;</th>' . $untimedStr . '
            </tr>' : '' );
for ( $i = $first_slot; $i <= $last_slot; $i++ ) {
  $time_h = intval ( ( $i * $interval ) / 60 );
  $time_m = ( $i * $interval ) % 60;
  // Do not apply TZ offset.
  $eventsStr .= '
            <tr>
              <th class="row">'
   . display_time ( ( $time_h * 100 + $time_m ) * 100, 1 ) . '</th>';

  for ( $d = $start_ind; $d <= $end_ind; $d++ ) {
    $dateYmd = date ( 'Ymd', $days[$d] );
	
	//check the timeslot allocated or not for color change
	//echo $program_avail_id;die;
		if((isset($program_filter_id) && !empty($program_filter_id) && (in_array($dateYmd,$allocated_data, true))) || (isset($teacher_filter_id) && $teacher_filter_id!='' && (in_array($dateYmd,$allocated_data, true))) || (isset($room_filter_id) && $room_filter_id!='' && (in_array($dateYmd,$allocated_data, true)))){
		$allocate_nonAllocated_TS='';
		   foreach($new_event_Arr as $key=>$val){
		   		if($dateYmd==$key ){
					//echo $dateYmd.'<br>';
					$allocate_nonAllocated_TS_str = isset($new_event_Arr[$key]['1'])?$new_event_Arr[$key]['1']:'';
					break;
				}
		   }
		   $allocated_ts_str_Arr=explode(',',$allocate_nonAllocated_TS_str);
		   $str_alloacted_text=(isset($allocated_ts_str_Arr['1']) && $allocated_ts_str_Arr['1']!="") ? $allocated_ts_str_Arr['1']:'';
		   if($str_alloacted_text == "<B>Allocated</B>"){
		   		$hasTimeslot = ' hasAllAllocatedTimeslot';
		   }else{
		   		$hasTimeslot = ' hasAllocatedTimeslot';
		   }
		  }
	
	
	$class = ( ! empty ( $save_hour_arr[$d][$i] ) && strlen ( $save_hour_arr[$d][$i] ) ? " hasevents".(((isset($program_filter_id) && $program_filter_id!='' && (in_array($dateYmd,$allocated_data, true))) || (isset($teacher_filter_id) && $teacher_filter_id!='' && (in_array($dateYmd,$allocated_data, true))) || (isset($room_filter_id) && $room_filter_id!='' && (in_array($dateYmd,$allocated_data, true))))? $hasTimeslot : (((isset($program_filter_id) && $program_filter_id!='' && (in_array($dateYmd,$allocated_data, true))) || (isset($teacher_filter_id) && $teacher_filter_id!='' && (in_array($dateYmd,$allocated_data, true))) || (isset($room_filter_id) && $room_filter_id!='' && (in_array($dateYmd,$allocated_data, true))))? $hasTimeslot : (isset($program_filter_id) && $program_filter_id!='') || (isset($teacher_filter_id) && $teacher_filter_id!='') || (isset($room_filter_id) && $room_filter_id!='')?' hasUnAllocatedAvailability':' ')) : ( $dateYmd == date ( 'Ymd', $today ) ? " today" : ( is_weekend ( $days[$d] ) ? "weekend" : "" ) ) )
	
	. (in_array($dateYmd,$holiday_date, true) ? " hasHolidays": "")
    . (in_array($dateYmd,$exception_dates, true) ? " hasExceptionDays": "");
   if ( $rowspan_day[$d] > 1 ) {
      // This might mean there's an overlap,
      // or it could mean one event ends at 11:15 and another starts at 11:30.
      if ( ! empty ( $save_hour_arr[$d][$i] ) )
        $eventsStr .= '
              <td class=' . $class . '>' . $save_hour_arr[$d][$i] . '</td>';

      $rowspan_day[$d]--;
    } else {
      $eventsStr .= '<td '.( $class != '' ? ' class="' . $class . '"' : '' ); if ( empty ( $save_hour_arr[$d][$i] ) ) {
	  $eventsStr .= '>'
         . ( $can_add // If user can add events, then echo the add event icon.
          ? html_for_add_icon ( $dateYmd, $time_h, $time_m, $user ) : '' )
         . '&nbsp;';
      } else {
	  	$rowspan_day[$d] = $save_rowspan_arr[$d][$i];
        $eventsStr .= ( $rowspan_day[$d] > 1
          ? ' rowspan="' . $rowspan_day[$d]  .'"': '' )
         . '>' . ( $can_add
          ? html_for_add_icon ( $dateYmd, $time_h, $time_m, $user ) : '' )
         . $save_hour_arr[$d][$i];
      }
      $eventsStr .= '</td>';
    }
  }
  $eventsStr .= '
            </tr>';
}

$eventinfo = ( empty ( $eventinfo ) ? '' : $eventinfo );
$tableWidth = '100%';
$unapprovedStr = $printerStr = '';

if ( empty ( $friendly ) ) {
  $unapprovedStr = display_unapproved_events ( $is_assistant || $is_nonuser_admin
    ? $user : $login );
  $printerStr = generate_printer_friendly ( 'month.php' );
}

$trailerStr = print_trailer ();
if ( $DISPLAY_TASKS == 'Y' ) {
  $tableWidth = '80%';
  $filler = '<td></td>';
  $minical_tasks .= '
        <td id="minicolumn" rowspan="2" valign="top">
<!-- START MINICAL -->
          <div class="minicontainer">' . ( $DISPLAY_SM_MONTH == 'Y' ? '
            <div class="minicalcontainer">'
     . display_small_month ( $thismonth, $thisyear, true ) . '</div>' : '' ) . '
            <div id="minitask">' . display_small_tasks ( $cat_id ) . '</div>
          </div>
        </td>';
}

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
					   <div class="legend-color-free-ts" > </div><label class="legend-label">Completely Free</label>
					   <div class="legend-color-partial-free-ts" > </div><label class="legend-label">Partially Free</label>
					   <div class="legend-color-use" > </div><label class="legend-label">In Use</label>
					   <div class="legend-color-holiday" > </div><label class="legend-label">Holiday</label>
					   <div class="legend-color-excp" > </div><label >Exception</label>
				   </div>
				</p>
		</td>	
       </tr>
    </table>
EOT;


echo <<<EOT
    <table width="100%" cellpadding="1" style="padding-left:92px;padding-right:92px;padding-bottom:21px;">
      <tr>
        <td id="printarea" style="vertical-align:top; width:{$tableWidth}; padding-top:44px; " >
        {$week_name_display}
        </td>
        {$filler}
      </tr>
      <tr>
        <td>
          <table class="main">
            <tr>
              <th class="empty">&nbsp;</th>{$headerStr}
            </tr>{$untimedStr}{$eventsStr}
          </table>
        </td>{$minical_tasks}
      </tr>
    </table>
    {$eventinfo}
    {$unapprovedStr}
    {$printerStr}
    {$trailerStr}
EOT;
include_once 'footer.php';
?>
