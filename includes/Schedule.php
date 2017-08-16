<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 3/25/2017
 * Time: 2:07 AM
 */

namespace App;


use \DateTime;
use \DateInterval;
use \DatePeriod;


class Schedule {

    protected $datesFinal = [];
    protected $dates = [];
    protected $resultStandard = [];
    protected $resultCustom = [];
    protected $totalDays = 14;
    protected $partnerId = 0;
    protected $conn;

    function __construct($resultStandard, $resultCustom, $partnerId, $conn)
    {
        // Final dates outputs
        $datesFinal = [];

        // Init
        $dates = [];

        // Result from db in standard
        $this->resultStandard = $resultStandard;

        // Result from db in custom
        $this->resultCustom = $resultCustom;

        // Set timezone as uk
        $this->setTimeZone();

        // Initialized partner id
        $this->partnerId = $partnerId;

        // assign connection
        $this->conn = $conn;
    }


    public function setOpenDays($totalDays=0)
    {

        if(empty($totalDays)) {
            $totalDays = $this->totalDays;
        }

        /**
         * get date today
         */
        $dates[0]['date']       =  date("Y-m-d");
        $dates[0]['close']      = 'no';
        $dates[0]['day']        = strtolower(date('l', strtotime($dates[0]['date'])));

        // get 7 days from date today

        for($i=1; $i<$totalDays; $i++) {
            $dates[$i]['date'] = date('Y-m-d', strtotime($dates[0]['date'] . ' + '. $i . ' days'));
            $dates[$i]['close'] = 'no';
            $dates[$i]['day'] = strtolower(date('l', strtotime($dates[$i]['date'])));
        }
        //$this->print_r_pre($dates, "get 7 days");
        return $dates;
    }

    /**
     * filter date by standard
     */
    public function filterByStandard()
    {
        $dates = $this->setOpenDays();
        foreach($dates as $index => $date) {
            $dates[$index]['close'] = ($this->resultStandard[0][$date['day'] . '_close'] == 'yes') ? "yes" : "no";
        }

        //        $this->print_r_pre($dates, "after filter with standard");
        return $dates;
    }

    /**
     * filter date by custom and do override with the standard filter
     * standard data, don't allow override with custom if book time type is "book time of day"
     */
    public function filterByCustom() {

        $dates = $this->filterByStandard();

        $bookTimeType = $this->resultStandard[0]['book_time_type'];

        if($bookTimeType == 'Book Time Of Day') {
            return $dates;
        } else {

            // do override the standard data with custom for open and close dates
            foreach ($dates as $index => $date) {
                foreach ($this->resultCustom as $custom) {
                    if ($date['date'] == $custom['date']) {
                        $dates[$index]['close'] = $custom['close'];
                    }
                }
            }
            return $dates;
        }

    }

    /**
     * remove all closed date, meaning if yes then its closed date
     * if no then its not closed date
     */
    public function removeAllClosed()
    {

        $dates = $this->filterByCustom();
        $datesFinal  = [];
        $datesFinal1 = [];

        // only get date if open time
        foreach($dates as $index => $date) {
            if($date['close'] == 'no') {
                $datesFinal[] = $date;
            }
        }

        //$this->print_r_pre($dates);

        foreach($dates as $index => $date) {
            // remove all date with zero schedule
           if($this->isStillAvailableDate($date['date']) == true) {
               $datesFinal1[] = $date;
           }
        }

        return $datesFinal1;
    }


//    public function removeNoScheduledDates($dates)
//    {
//
//        $this->print_r_pre($dates);
//        return $dates;
//    }



    //
    //    private function print_r_pre($array) {
    //        print "<pre>";
    //        print_r($array);
    //        print "<pre>";
    //        exit;
    //    }




    public function getFinalDates()
    {
        return $this->removeAllClosed();
    }


    public function getFinalDatesFlatten()
    {
        $dates = $this->removeAllClosed();
        $finalDates = [];
        foreach($dates as $date) {
            $finalDates[] = $date['date'];
        }

        return $finalDates;
    }

    public function getFinalDatesFlattenToJson()
    {
        return json_encode($this->convertToCalendarDateFormat());
    }

    public function convertToCalendarDateFormat() {

        $finalDate = [];
        $dates = $this->removeAllClosed();

        foreach($dates as $date) {
            $newDate = date("Y-n-j", strtotime($date['date']));
            $newDate1 = explode("-", $newDate);
            $newDate2 = $newDate1[2] . '-' . $newDate1[1] . '-' . $newDate1[0];
            $finalDate[] = $newDate2;
        }

        return $finalDate;
    }

    public function setTimeZone($timeZone='Europe/London')
    {
        date_default_timezone_set($timeZone);
    }

    /**
     * Pre functions
     * @param $array
     * @param $message
     */
    public function print_r_pre($array, $message = null) {
        print "<pre>";
        print "\n $message \n";
        print_r($array);
        print "</pre>";
    }

    public function isStillAvailableDate($openDate) {



        // $datenow      = $openDate;

        // print "<br> open date selected " . $datenow . '<br>';

        $partner_id   =  $this->partnerId;

        // $datepiece    = explode("/", $datenow); // 22/01/2017 -dd/mm/yyyy

        $datetofetch  = $openDate; //$datepiece[2] . '-' . $datepiece[1] . '-' . $datepiece[0]; //2017-01-16 - yyyy-mm-dd

        $mydb         = $this->conn;

        $morning      = '';

        $afternoon    = '';

        $evening      = '';


        //        print " <Br> today date  " . date('Y-m-d') . '<br>';


        $dateToday  =  date('Y-m-d');



        /**
         * Get current user standard settings
         */
        $standardSetting = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id ", ARRAY_A);

        $book_time_type  = $standardSetting[0]['book_time_type'];




        if($book_time_type == 'Book Time Of Day') {



            //print("<br>  currently its Book Time Of Day <br>");

            //print "<br>inside book time of day if condition";
            /**
             * Get current day of the selected date
             */
            $day = strtolower(date('l', strtotime($datetofetch)));

            //print "<Br> current day selected " . $day;

            /**
             * Get selected checked for morning, noon and evening in specific day to standard
             * check current uk time and get status morning, noon or evening
             * then only display button the match the day status of uk time
             * so if uk time is noon then only display noon and evening
             * display ui for morning, noon, evening
             */
            $Hour = date('G');

            //print "<br> current horu $Hour";


            // check if selected date is today


            //print("<br>selected date <br><br><br>$datetofetch == current date " . $dateToday . '<br>');

            if($datetofetch == $dateToday) {

                //print("<br>  current selected is today <br>");

                if ( $Hour >= 5 && $Hour <= 11 ) {

                    // allow morning, noon and evening
                    //echo "<br>Good Morning";
                    $morning   =  $standardSetting[0][$day . '_morning'];
                    $afternoon =  $standardSetting[0][$day . '_afternoon'];
                    $evening   =  $standardSetting[0][$day . '_evening'];

                } else if ( $Hour >= 12 && $Hour <= 18 ) {

                    // allow noon and evening
                    //echo "<br>Good Afternoon";
                    $afternoon =  $standardSetting[0][$day . '_afternoon'];
                    $evening   =  $standardSetting[0][$day . '_evening'];

                } else if ( $Hour >= 19 || $Hour <= 4 ) {

                    // allow evening
                    //echo "<br>Good Evening";
                    $evening   =  $standardSetting[0][$day . '_evening'];

                }

            } else {

                //print("<br>  current selected is not today <Br>");
                $morning   =  $standardSetting[0][$day . '_morning'];
                $afternoon =  $standardSetting[0][$day . '_afternoon'];
                $evening   =  $standardSetting[0][$day . '_evening'];

            }


            // print "<br> morning = $morning afternoon = $afternoon evening = $evening <br>";
            if($morning == '' && $afternoon == '' && $evening == '') {


                //print "<br> no schedule " . $datenow . '<br>';
                // print "<br> -------------------------------------------------- <br>";
                // no schedule
                return false;

            }  else {
                //print "<br> with schedule " . $datenow . '<br>';
                //print "<br> -------------------------------------------------- <br>";

                return true;
            }


        } else  {

            // print "<br>inside book exact time ";

            // Get appointment settings based on specific date and partner id
            $rows = $mydb->get_results("SELECT * FROM wp_bpc_appointment_settings WHERE partner_id = $partner_id && date = '$datetofetch'");

            // print_r_pre($rows);

            if (!empty($rows)) {
                // print " from wp_bpc_appointment_settings database table ";
               // bpc_print_console_js(" from wp_bpc_appointment_settings database table ");


                /** Initialized the retrieved data from database table phone settings in testing */
                foreach ($rows as $obj) :
                    $id                 = $obj->id;
                    $date               = $obj->date;
                    $open_from          = $obj->open_from;
                    $open_to            = $obj->open_to;
                    $call_back_length   = $obj->call_back_length;
                    $call_back_delay    = $obj->call_back_delay;
                    $updated_at         = $obj->updated_at;
                    $updatepiece        = explode(" ", $updated_at); // 2017-01-21 16:44:31 -yyyy-mm-dd hh:mm:ss
                    $updateddate        = $updatepiece[0]; //2017-01-21
                    $updatedpiece       = $updatepiece[1]; //16:44:31
                    $updatetimepiece    = explode(":", $updatedpiece);
                    $updatedtime        = $updatetimepiece[0] . ':' . $updatetimepiece[1];
                endforeach;



                /**
                 * Get custom break
                 */
                $resultBreaks = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_breaks WHERE appointment_setting_id = " . $id, ARRAY_A);

                // print "<pre>";
                //     print_r($resultBreaks);
                // print "</pre>";

            } else {

                // print " empty from wp_bpc_appointment_setting_standard database table ";
                //bpc_print_console_js(" empty from wp_bpc_appointment_setting_standard database table ");

                /** get standard settings */
                $resultStandard = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id", ARRAY_A);
                $rows = $resultStandard[0];

                /** Get day based on query date */
                $day = strtolower(date('l', strtotime($datetofetch)));
                // print "<br> clicked day $day";

                /** Get specific open_from and open_to based on standard settings results */
                $open_from = $rows[$day . '_open_from'];
                $open_to = $rows[$day . '_open_to'];
                // print "<br> open from $open_from <br> open to $open_to";

                /** if call back lenght is empty then set 15 mins default call back lenght */
                $call_back_delay = $rows['call_back_delay'];

                /** if call back delay is empty then set 15 mins default call back delay */
                $call_back_length = $rows['call_back_length'];

                /** specific date set */
                $date =  $datetofetch;

                // print "<br> date $date";
                /**
                 * Set updated at but this is actually the open from time of standard time
                 * @var [type]
                 */
                $updated_at         = date('Y-m-d') . ' ' . $open_from . ':00';
                $updatepiece        = explode(" ", $updated_at); // 2017-01-21 16:44:31 -yyyy-mm-dd hh:mm:ss
                $updateddate        = $updatepiece[0]; //2017-01-21
                $updatedpiece       = $updatepiece[1]; //16:44:31
                $updatetimepiece    = explode(":", $updatedpiece);
                $updatedtime        = $updatetimepiece[0] . ':' . $updatetimepiece[1];
                // print "<br> Updated at " .  $updated_at;
                // print "<br> date piece  " .  $updateddate;
                // print "<br> time peice " .  $updatedpiece;

                /**
                 * Get custom break
                 */
                $resultBreaks = [];
                $resultBreaks = $rows[$day . '_break'];
                $breakTime = unserialize($resultBreaks);
                if(!empty($breakTime['break_time_hour_min'])) {
                    $resultBreaks = bpc_convertToPropperDateTime($breakTime['break_time_hour_min']);
                }

                // print "<pre>";
                // print "<br> breaks";
                // print_r( $resultBreaks );
                // print "</pre>";
            }



            /**
             * if call back lenght is empty then set 15 mins default call back lenght
             */
            if ($call_back_length == '') {
                $call_back_length = '15 mins';
            }

            /**
             * if call back delay is empty then set 15 mins default call back delay
             */
            if ($call_back_delay == '') {
                $call_back_delay = '15 mins';
            }

            /**
             *  This is needed so that client can't book any of the callbacks delay
             */
            $call_back_delay_1 = str_replace('mins', 'minutes', $call_back_delay);
            $call_back_delay_1 = str_replace('hours', 'hour', $call_back_delay_1);
            $time_1 = strtotime($open_from);
            $open_from = date("H:i", strtotime($call_back_delay_1, $time_1));
            // print " <br> newTimeWithCallBackDelay $open_from";

            // print "<br> call back length $call_back_length ";
            // print "<br> call back delay $call_back_delay ";

            //            bpc_print_console_js(" call back length $call_back_length ");
            //            bpc_print_console_js(" call back delay $call_back_delay ");


            // print "begin $open_from, interval $call_back_length, end $open_to date to fetch $datetofetch <br>";

            /**
             * initialized open from and open to as date
             */
            $begin = new DateTime($open_from);
            $end = new DateTime($open_to);

            /**
             * compose the interval as date
             */
            $interval = DateInterval::createFromDateString($call_back_length);

            /**
             * set begin, interval and end as date period
             */
            $times = new DatePeriod($begin, $interval, $end);

//            print '<ul class="left-time">';

            //print "test date breaks";
            /**
             * Inialized data
             */
            $currenttime = date('H:i');
            $currentdate = date("Y-m-d");
            $callbackdelayandcurrenttime = strtotime($call_back_delay, strtotime($updatedtime));
            $callbackdelayandupdatedtimetotal = date('H:i', $callbackdelayandcurrenttime);
            $container = 0;
            $counter = 0;

            $active  = false;
            /**
             * Calculate date times
             */
            $appointmentConflictWithBreak = false;
            foreach ($times as $time) {


                /**
                 * check if open appointment schedule is not conflict with break
                 */
                $appointmentConflictWithBreak = bpc_isAppointmentConflictWithBreak($resultBreaks, $time->format('H:i'));


                /**
                 * If today and current time and available appointment schedule is greater than current time
                 * then allow execute
                 */
                if (($time->format('H:i') >= $currenttime) and ($date == $currentdate)) {


                    if (($updateddate == $currentdate) and ($time->format('H:i') >= $updatedtime) and ($time->format('H:i') <= $callbackdelayandupdatedtimetotal)) {
                        // print "before call back delay arrive";
                        //'In between the Call Back Delay';
                    } else {

                        // print "<br> date today i think, and display available appointment time ";



                        if($appointmentConflictWithBreak == false) {
                            $counter++;
                            $container = 1;
//                            $timeA = $time->format('h:i A');
//                            $timeField[] = '';
//                            return true;
                            $active = true;
                        } else {
//                            $timeA = $time->format('h:i A');
                            //print "<br> conflict with break " . $timeA;
                            //bpc_print_console_js( " conflict with break " . $timeA );
                        }

                    }
                }   else if ($date <> $currentdate) {
                    if($appointmentConflictWithBreak == false) {

                        // print " date is not today";
//                        $timeA = $time->format('h:i A');
//                        $counter++;
//                        $timeField[] = "";

                        $active = true;
                    } else {
//                        $timeA = $time->format('h:i A');
                        //print "<br> conflict with break " . $timeA;
                        //bpc_print_console_js( " conflict with break " . $timeA );
                    }
                }
            }

            /**
             * if timme field is not empty then display date times
             */
            if ($active == true) {

                return true;

            } else {

                /**
                 * if time field is empty then display, No Schedule Display
                 */
                return false;

            }

        }


    }


}
    //
    //$resultStandard = [
    //    [
    //        'monday_close'      => 'yes',
    //        'tuesday_close'     => 'yes',
    //        'wednesday_close'   => '',
    //        'thursday_close'    => '',
    //        'friday_close'      => '',
    //        'saturday_close'    => '',
    //        'sunday_close'      => ''
    //    ]
    //];
    //
    //$resultCustom = [
    //    [
    //        'date'  => '2017-03-24',
    //        'close' => 'yes'
    //    ],
    //    [
    //        'date'  => '2017-03-25',
    //        'close' => 'yes'
    //    ]
    //];
    //
    //$schedule = new Schedule($resultStandard, $resultCustom);
    //
    //$schedule->print_r_pre($schedule->getFinalDatesFlattenToJson(), "Final Output");


