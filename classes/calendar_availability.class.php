<?php
//date_default_timzeone_set('America/Chicago');
class Calendar_Availability {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
     
    /********************* PROPERTY ********************/  
    public $dayLabels = array("Mo","Tu","We","Th","Fr","Sa","Su");
     
    public $currentYear=0;
     
    public $currentMonth=0;
     
    public $currentDay=0;
     
    public $currentDate=null;
     
    public $daysInMonth=0;
     
    public $naviHref= null;
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show($month = null, $year=null, $cycleNo, $startDay, $endDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult) {
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<div class="box-content">'.
                                '<ul class="label">'.$this->_createLabels().'</ul>';   
                                $content.='<div class="clear"></div>';     
                                $content.='<ul class="dates">';    
                                 
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                // Create weeks in a month
                                for( $i=0; $i<$weeksInMonth; $i++ ){
                                     
                                    //Create days in a week
                                    for($j=1;$j<=7;$j++){
                                        $content.=$this->_showDay($i*7+$j, $cycleNo, $startDay, $endDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult);
                                    }
                                }
                                 
                                $content.='</ul>';
                                 
                                $content.='<div class="clear"></div>';     
             
                        $content.='</div>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber, $cycleNo, $startDay, $endDay, $fsStartMonth, $fsEndMonth, $finalSelectedDay, $startYear, $endYear, $holidaysResult){
         
		$arrDays = $arrColorCode = $arrtemplateIds = array();
		//get the list of holidays
		if(count($finalSelectedDay[0]>0)){
				$arrDays = $finalSelectedDay['0'];
				$arrColorCode = $finalSelectedDay['1'];
				$arrtemplateIds = $finalSelectedDay['2'];
		}
		if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
		
		$checkIt = $bgcol = '';
		$checkedValue = 'Cy'.$cycleNo.'--'.$this->currentDate;
		$key = array_search($this->currentDate, $arrDays); 
		if ($key !== false) {
		//if(in_array($this->currentDate, $arrDays)){
			$checkIt = 'checked="checked"';
			$bgcol = 'background-color:'.$arrColorCode[$key];
			$checkedValue = 'Cy'.$cycleNo.'--'.$this->currentDate.'__'.$arrtemplateIds[$key];
		
		}
        //echo "<pre>";
		//echo $cellContent;
		//print_r($holidaysResult);
		if(in_array($this->currentDate, $holidaysResult ))
		{
			return '<li style="background-color:gray; color:#fff; font-weight:bold; cursor:default;" id="Cy'.$cycleNo.'--'.$this->currentDate.'" class="'.'monthDayDS '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
			($cellContent==null?'mask':'').'">H&nbsp;&nbsp;</li>';
		}elseif((($this->currentMonth == $fsStartMonth) && ($this->currentYear == $startYear) && ($cellContent < $startDay)) || (($this->currentMonth == $fsEndMonth) && ($this->currentYear == $endYear) && ($cellContent > $endDay)))
		{
			return '<li style="background:#FFFFFF; opacity:.35; cursor:default;" id="Cy'.$cycleNo.'--'.$this->currentDate.'" class="'.'monthDayDS '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
			($cellContent==null?'mask':'').'">'.$cellContent.'</li>';
		}else{
			return '<li  style="'.($cellContent!=null?'cursor:pointer; ':'cursor:default; '). $bgcol.'" id="Cy'.$cycleNo.'--'.$this->currentDate.'" class="'.($cellContent!=null?'monthDay ':'monthDayDS ').($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
			($cellContent==null?'mask':'').'">'.$cellContent.'</li>'.($cellContent!=null?'<input '.$checkIt.' type="checkbox" style="display:none;" name="DaysSelect[]" class="Cy'.$cycleNo.'--'.$this->currentDate.'" value="'.$checkedValue.'" />':'');
		
		}
        /*return '<li id="Cy'.$cycleNo.'--'.$this->currentDate.'" class="'.'monthDay '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'">'.$cellContent.'</li>'.($cellContent!=null?'<input type="checkbox" style="display:none;" name="DaysSelect[]" class="Cy'.$cycleNo.'--'.$this->currentDate.'" value="Cy'.$cycleNo.'--'.$this->currentDate.'" />':'');*/
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+2:$this->currentYear;
		$nextYear = intval($this->currentYear)+1;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header-cal">'.
                /*'<a class="prev" href="'.$this->naviHref.'?year='.$preYear.'">Prev</a>'.*/
                    '<span class="title">'.date('M Y ',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                /*'<a class="next" href="'.$this->naviHref.'?year='.$nextYear.'">Next</a>'.*/
            '</div>';
    }
	public function _createNaviYear($currentYear, $cycleNo){
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        /*$nextYear = $this->currentMonth==12?intval($this->currentYear)+2:$this->currentYear;*/
		$nextYear = intval($currentYear)+1;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        //$preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
		$preYear = intval($currentYear)-1;
		if($cycleNo == 1){
			$cycleTest = "1st Cycle Calendar";
		}else if($cycleNo == 2){
			$cycleTest = "2nd Cycle Calendar";
		}else if($cycleNo == 3){
			$cycleTest = "3rd Cycle Calendar";
		}
         
        return
            /*'<div class="header-cal">'.
                '<a class="prev" href="'.$this->naviHref.'?year='.$preYear.'">Prev</a>'.
					'<span class="title" style="float:left; margin-left:85px; font-size:12px; font-weight:bold; color:#006e2f;">'.$cycleTest.'</span>'.
                    '<span class="title" style="margin-left:-85px;">'.$currentYear.'</span>'.
                '<a class="next" href="'.$this->naviHref.'?year='.$nextYear.'">Next</a>'.
            '</div>';*/
			
			'<div class="header-cal">'.
					'<span class="title" style="text-align:center; font-size:12px; font-weight:bold; color:#006e2f;">'.$cycleTest.'</span>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}
?>