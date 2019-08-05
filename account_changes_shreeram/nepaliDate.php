<?php
$nepali = true;
class NepaliDate {
    private $_bs = array(
        0 => array(2000,30,32,31,32,31,30,30,30,29,30,29,31),
        1 => array(2001,31,31,32,31,31,31,30,29,30,29,30,30),
        2 => array(2002,31,31,32,32,31,30,30,29,30,29,30,30),
        3 => array(2003,31,32,31,32,31,30,30,30,29,29,30,31),
        4 => array(2004,30,32,31,32,31,30,30,30,29,30,29,31),
        5 => array(2005,31,31,32,31,31,31,30,29,30,29,30,30),
        6 => array(2006,31,31,32,32,31,30,30,29,30,29,30,30),
        7 => array(2007,31,32,31,32,31,30,30,30,29,29,30,31),
        8 => array(2008,31,31,31,32,31,31,29,30,30,29,29,31),
        9 => array(2009,31,31,32,31,31,31,30,29,30,29,30,30),
        10 => array(2010,31,31,32,32,31,30,30,29,30,29,30,30),
        11 => array(2011,31,32,31,32,31,30,30,30,29,29,30,31),
        12 => array(2012,31,31,31,32,31,31,29,30,30,29,30,30),
        13 => array(2013,31,31,32,31,31,31,30,29,30,29,30,30),
        14 => array(2014,31,31,32,32,31,30,30,29,30,29,30,30),
        15 => array(2015,31,32,31,32,31,30,30,30,29,29,30,31),
        16 => array(2016,31,31,31,32,31,31,29,30,30,29,30,30),
        17 => array(2017,31,31,32,31,31,31,30,29,30,29,30,30),
        18 => array(2018,31,32,31,32,31,30,30,29,30,29,30,30),
        19 => array(2019,31,32,31,32,31,30,30,30,29,30,29,31),
        20 => array(2020,31,31,31,32,31,31,30,29,30,29,30,30),
        21 => array(2021,31,31,32,31,31,31,30,29,30,29,30,30),
        22 => array(2022,31,32,31,32,31,30,30,30,29,29,30,30),
        23 => array(2023,31,32,31,32,31,30,30,30,29,30,29,31),
        24 => array(2024,31,31,31,32,31,31,30,29,30,29,30,30),
        25 => array(2025,31,31,32,31,31,31,30,29,30,29,30,30),
        26 => array(2026,31,32,31,32,31,30,30,30,29,29,30,31),
        27 => array(2027,30,32,31,32,31,30,30,30,29,30,29,31),
        28 => array(2028,31,31,32,31,31,31,30,29,30,29,30,30),
        29 => array(2029,31,31,32,31,32,30,30,29,30,29,30,30),
        30 => array(2030,31,32,31,32,31,30,30,30,29,29,30,31),
        31 => array(2031,30,32,31,32,31,30,30,30,29,30,29,31),
        32 => array(2032,31,31,32,31,31,31,30,29,30,29,30,30),
        33 => array(2033,31,31,32,32,31,30,30,29,30,29,30,30),
        34 => array(2034,31,32,31,32,31,30,30,30,29,29,30,31),
        35 => array(2035,30,32,31,32,31,31,29,30,30,29,29,31),
        36 => array(2036,31,31,32,31,31,31,30,29,30,29,30,30),
        37 => array(2037,31,31,32,32,31,30,30,29,30,29,30,30),
        38 => array(2038,31,32,31,32,31,30,30,30,29,29,30,31),
        39 => array(2039,31,31,31,32,31,31,29,30,30,29,30,30),
        40 => array(2040,31,31,32,31,31,31,30,29,30,29,30,30),
        41 => array(2041,31,31,32,32,31,30,30,29,30,29,30,30),
        42 => array(2042,31,32,31,32,31,30,30,30,29,29,30,31),
        43 => array(2043,31,31,31,32,31,31,29,30,30,29,30,30),
        44 => array(2044,31,31,32,31,31,31,30,29,30,29,30,30),
        45 => array(2045,31,32,31,32,31,30,30,29,30,29,30,30),
        46 => array(2046,31,32,31,32,31,30,30,30,29,29,30,31),
        47 => array(2047,31,31,31,32,31,31,30,29,30,29,30,30),
        48 => array(2048,31,31,32,31,31,31,30,29,30,29,30,30),
        49 => array(2049,31,32,31,32,31,30,30,30,29,29,30,30),
        50 => array(2050,31,32,31,32,31,30,30,30,29,30,29,31),
        51 => array(2051,31,31,31,32,31,31,30,29,30,29,30,30),
        52 => array(2052,31,31,32,31,31,31,30,29,30,29,30,30),
        53 => array(2053,31,32,31,32,31,30,30,30,29,29,30,30),
        54 => array(2054,31,32,31,32,31,30,30,30,29,30,29,31),
        55 => array(2055,31,31,32,31,31,31,30,29,30,29,30,30),
        56 => array(2056,31,31,32,31,32,30,30,29,30,29,30,30),
        57 => array(2057,31,32,31,32,31,30,30,30,29,29,30,31),
        58 => array(2058,30,32,31,32,31,30,30,30,29,30,29,31),
        59 => array(2059,31,31,32,31,31,31,30,29,30,29,30,30),
        60 => array(2060,31,31,32,32,31,30,30,29,30,29,30,30),
        61 => array(2061,31,32,31,32,31,30,30,30,29,29,30,31),
        62 => array(2062,30,32,31,32,31,31,29,30,29,30,29,31),
        63 => array(2063,31,31,32,31,31,31,30,29,30,29,30,30),
        64 => array(2064,31,31,32,32,31,30,30,29,30,29,30,30),
        65 => array(2065,31,32,31,32,31,30,30,30,29,29,30,31),
        66 => array(2066,31,31,31,32,31,31,29,30,30,29,29,31),
        67 => array(2067,31,31,32,31,31,31,30,29,30,29,30,30),
        68 => array(2068,31,31,32,32,31,30,30,29,30,29,30,30),
        69 => array(2069,31,32,31,32,31,30,30,30,29,29,30,31),
        70 => array(2070,31,31,31,32,31,31,29,30,30,29,30,30),
        71 => array(2071,31,31,32,31,31,31,30,29,30,29,30,30),
        72 => array(2072,31,32,31,32,31,30,30,29,30,29,30,30),
        73 => array(2073,31,32,31,32,31,30,30,30,29,29,30,31),
        74 => array(2074,31,31,31,32,31,31,30,29,30,29,30,30),
        75 => array(2075,31,31,32,31,31,31,30,29,30,29,30,30),
        76 => array(2076,31,32,31,32,31,30,30,30,29,29,30,30),
        77 => array(2077,31,32,31,32,31,30,30,30,29,30,29,31),
        78 => array(2078,31,31,31,32,31,31,30,29,30,29,30,30),
        79 => array(2079,31,31,32,31,31,31,30,29,30,29,30,30),
        80 => array(2080,31,32,31,32,31,30,30,30,29,29,30,30),
        81 => array(2081,31,31,32,32,31,30,30,30,29,30,30,30),
        82 => array(2082,30,32,31,32,31,30,30,30,29,30,30,30),
        83 => array(2083,31,31,32,31,31,30,30,30,29,30,30,30),
        84 => array(2084,31,31,32,31,31,30,30,30,29,30,30,30),
        85 => array(2085,31,32,31,32,30,31,30,30,29,30,30,30),
        86 => array(2086,30,32,31,32,31,30,30,30,29,30,30,30),
        87 => array(2087,31,31,32,31,31,31,30,30,29,30,30,30),
        88 => array(2088,30,31,32,32,30,31,30,30,29,30,30,30),
        89 => array(2089,30,32,31,32,31,30,30,30,29,30,30,30),
        90 => array(2090,30,32,31,32,31,30,30,30,29,30,30,30)
    );

    private $_nep_date = array('year' => '', 'month' => '', 'date' => '', 'day' => '', 'nmonth' => '', 'num_day' => '');

    private $_eng_date = array('year' => '', 'month' => '', 'date' => '', 'day' => '', 'nmonth' => '', 'num_day' => '');

    public $debug_info = "";

    /**
     * Return day
     *
     * @param int $day
     * @return string
     */
    private function _get_day_of_week($day,$nepali=false)
    {
        switch ($day)
        {
            CASE 1:
                $day = $nepali?"आईतबार ":"Sunday";
                break;
            CASE 2:
                $day = $nepali?"सोमबार ":"Monday";
                break;
            CASE 3:
                $day = $nepali?"मंगलबार ":"Tuesday";
                break;
            CASE 4:
                $day = $nepali?"बुधबार ":"Wednesday";
                break;
            CASE 5:
                $day = $nepali?"बिहीबार ":"Thursday";
                break;
            CASE 6:
                $day = $nepali?"शुक्रबार ":"Friday";
                break;
            CASE 7:
                $day = $nepali?"शनिबार ":"Saturday";
                break;
        }
        return $day;
    }

    /**
     * Return english month name
     *
     * @param int $m
     * @return string
     */
    private function _get_english_month($m)
    {
        $eMonth = FALSE;
        switch ($m)
        {
            case 1:
                $eMonth = "January";
                break;
            case 2:
                $eMonth = "February";
                break;
            case 3:
                $eMonth = "March";
                break;
            case 4:
                $eMonth = "April";
                break;
            case 5:
                $eMonth = "May";
                break;
            case 6:
                $eMonth = "June";
                break;
            case 7:
                $eMonth = "July";
                break;
            case 8:
                $eMonth = "August";
                break;
            case 9:
                $eMonth = "September";
                break;
            case 10:
                $eMonth = "October";
                break;
            case 11:
                $eMonth = "November";
                break;
            case 12:
                $eMonth = "December";
        }
        return $eMonth;
    }

    /**
     * Return nepali month name
     *
     * @param int $m
     * @return string
     */
    private function _get_nepali_month($m,$nepali=false)
    {
        $n_month = FALSE;

        switch ($m)
        {
            case 1:
                $n_month = $nepali?"बैशाख":"Baisakh";
                break;
            case 2:
                $n_month = $nepali?"जेठ":"Jestha";
                break;
            case 3:
                $n_month = $nepali?"असार":"Ashar";
                break;
            case 4:
                $n_month = $nepali?"सावन":"Shrawan";
                break;
            case 5:
                $n_month = $nepali?"भदौ":"Bhadra";
                break;
            case 6:
                $n_month = $nepali?"असोज":"Aswin";
                break;
            case 7:
                $n_month = $nepali?"कार्तिक":"Kartik";
                break;
            case 8:
                $n_month = $nepali?"मंसिर":"Mangsir";
                break;
            case 9:
                $n_month = $nepali?"पौष":"Poush";
                break;
            case 10:
                $n_month = $nepali?"माघ":"Magh";
                break;
            case 11:
                $n_month = $nepali?"फागुन":"Falgun";
                break;
            case 12:
                $n_month = $nepali?"चैत":"Chaitra";
                break;
        }
        return $n_month;
    }

    /**
     * Check if date range is in english
     *
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return bool
     */
    private function _is_in_range_eng($yy, $mm, $dd)
    {
        if ($yy < 1944 || $yy > 2033)
        {
            return 'Supported only between 1944-2022';
        }

        if ($mm < 1 || $mm > 12)
        {
            return 'Error! month value can be between 1-12 only';
        }

        if ($dd < 1 || $dd > 31)
        {
            return 'Error! day value can be between 1-31 only';
        }

        return TRUE;
    }

    /**
     * Check if date is with in nepali data range
     *
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return bool
     */
    private function _is_in_range_nep($yy, $mm, $dd)
    {
        if ($yy < 2000 || $yy > 2089)
        {
            return 'Supported only between 2000-2089';
        }

        if ($mm < 1 || $mm > 12)
        {
            return 'Error! month value can be between 1-12 only';
        }

        if ($dd < 1 || $dd > 32)
        {
            return 'Error! day value can be between 1-31 only';
        }

        return TRUE;
    }

    /**
     * Calculates wheather english year is leap year or not
     *
     * @param int $year
     * @return bool
     */
    public function is_leap_year($year)
    {
        $a = $year;
        if ($a % 100 == 0)
        {
            if ($a % 400 == 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            if ($a % 4 == 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
     * currently can only calculate the date between AD 1944-2033...
     *
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return array
     */
    public function eng_to_nep($yy, $mm='', $dd='',$nepali=false)
    {
        if($mm=='') {
            $temp = explode('-', $yy);
            $yy = $temp[0];
            $mm = $temp[1];
            $dd = $temp[2];
        }
        // Check for date range
        $chk = $this->_is_in_range_eng($yy, $mm, $dd);

        if($chk !== TRUE)
        {
            die($chk);
        }
        else
        {
            // Month data.
            $month  = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

            // Month for leap year
            $lmonth = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

            $def_eyy     = 1944;	// initial english date.
            $def_nyy     = 2000;
            $def_nmm     = 9;
            $def_ndd     = 17 - 1;	// inital nepali date.
            $total_eDays = 0;
            $total_nDays = 0;
            $a           = 0;
            $day         = 7 - 1;
            $m           = 0;
            $y           = 0;
            $i           = 0;
            $j           = 0;
            $numDay      = 0;

            // Count total no. of days in-terms year
            for ($i = 0; $i < ($yy - $def_eyy); $i++) //total days for month calculation...(english)
            {
                if ($this->is_leap_year($def_eyy + $i) === TRUE)
                {
                    for ($j = 0; $j < 12; $j++)
                    {
                        $total_eDays += $lmonth[$j];
                    }
                }
                else
                {
                    for ($j = 0; $j < 12; $j++)
                    {
                        $total_eDays += $month[$j];
                    }
                }
            }

            // Count total no. of days in-terms of month
            for ($i = 0; $i < ($mm - 1); $i++)
            {
                if ($this->is_leap_year($yy) === TRUE)
                {
                    $total_eDays += $lmonth[$i];
                }
                else
                {
                    $total_eDays += $month[$i];
                }
            }

            // Count total no. of days in-terms of date
            $total_eDays += $dd;


            $i           = 0;
            $j           = $def_nmm;
            $total_nDays = $def_ndd;
            $m           = $def_nmm;
            $y           = $def_nyy;

            // Count nepali date from array
            while ($total_eDays != 0)
            {
                $a = $this->_bs[$i][$j];

                $total_nDays++;		//count the days
                $day++;				//count the days interms of 7 days

                if ($total_nDays > $a)
                {
                    $m++;
                    $total_nDays = 1;
                    $j++;
                }

                if ($day > 7)
                {
                    $day = 1;
                }

                if ($m > 12)
                {
                    $y++;
                    $m = 1;
                }

                if ($j > 12)
                {
                    $j = 1;
                    $i++;
                }

                $total_eDays--;
            }

            $numDay = $day;
            $date = new stdClass();
            $date->year    = $y;
            $date->nmonth   = $m;
            $date->date    = $total_nDays;
            $date->day     = $this->_get_day_of_week($day,$nepali);
            $date->month  = $this->_get_nepali_month($m,$nepali);
            $date->num_day = $numDay;
            $date->full    = "$y-$m-$total_nDays";
            $date->words   = "$date->month - $date->date, $y, $date->day";
            return $date;
        }
    }


    /**
     * Currently can only calculate the date between BS 2000-2089
     *
     * @param int $yy
     * @param int $mm
     * @param int $dd
     * @return array
     */
    public function nep_to_eng($yy, $mm='', $dd='')
    {
        if($mm=='') {
            $temp = explode('-', $yy);
            $yy = $temp[0];
            $mm = $temp[1];
            $dd = $temp[2];
        }
        $def_eyy     = 1943;
        $def_emm     = 4;
        $def_edd     = 14 - 1;	// initial english date.
        $def_nyy     = 2000;
        $def_nmm     = 1;
        $def_ndd     = 1;		// iniital equivalent nepali date.
        $total_eDays = 0;
        $total_nDays = 0;
        $a           = 0;
        $day         = 4 - 1;
        $m           = 0;
        $y           = 0;
        $i           = 0;
        $k           = 0;
        $numDay      = 0;

        $month  = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
        $lmonth = array(0,31,29,31,30,31,30,31,31,30,31,30,31);

        // Check for date range
        $chk = $this->_is_in_range_nep($yy, $mm, $dd);

        if ( $chk !== TRUE)
        {
            die($chk);
        }
        else {
            // Count total days in-terms of year
            for ($i = 0; $i < ($yy - $def_nyy); $i++)
            {
                for ($j = 1; $j <= 12; $j++)
                {
                    $total_nDays += $this->_bs[$k][$j];
                }
                $k++;
            }

            // Count total days in-terms of month
            for ($j = 1; $j < $mm; $j++)
            {
                $total_nDays += $this->_bs[$k][$j];
            }

            // Count total days in-terms of dat
            $total_nDays += $dd;

            // Calculation of equivalent english date...
            $total_eDays = $def_edd;
            $m           = $def_emm;
            $y           = $def_eyy;
            while ($total_nDays != 0)
            {
                if ($this->is_leap_year($y))
                {
                    $a = $lmonth[$m];
                }
                else
                {
                    $a = $month[$m];
                }

                $total_eDays++;
                $day++;

                if ($total_eDays > $a)
                {
                    $m++;
                    $total_eDays = 1;
                    if ($m > 12)
                    {
                        $y++;
                        $m = 1;
                    }
                }

                if ($day > 7)
                {
                    $day = 1;
                }

                $total_nDays--;
            }

            $numDay = $day;
            $date = new stdClass();
            $date->year    = $y;
            $date->nmonth   = $m;
            $date->date    = $total_eDays;
            $date->day     = $this->_get_day_of_week($day);
            $date->month  = $this->_get_english_month($m);
            $date->num_day = $numDay;
            $date->full    = "$y-$m-$total_eDays";
            $date->words   = "$date->month - $date->date, $y, $date->day";

            return $date;
        }
    }

    public function getInfoOnDate($y,$nmonth='',$d='') {
        if($nmonth == '') {
            if(strpos($y,'-')!==false) {
                $date = explode('-',$y);
                $y = $date[0];
                $nmonth = $date[1];
                $d = isset($date[2])?$date[2]:'';
            } else {
                return false;
            }
        }
        $index = (int)$y - 2000;
        $monthLast = $this->_bs[$index][$nmonth];
        $yearLast = $this->_bs[$index][12];
        $obj = new stdClass();
        $obj->monthEnd = $y.'-'.$nmonth.'-'.$monthLast;
        $obj->yearEnd = $y.'-12-'.$yearLast;
        if($d!=='') {
            $eng_date = $this->nep_to_eng($y,$nmonth,$d);
            $weekEnds = getWeekEnds($eng_date->full);
            $obj->start = $this->eng_to_nep($weekEnds->start)->full;
            $obj->end = $this->eng_to_nep($weekEnds->end)->full;
        }
        $obj->monthStartEn = $this->nep_to_eng($y,$nmonth,1)->full;
        $obj->monthEndEn = $this->nep_to_eng($y,$nmonth,$monthLast)->full;
        $obj->yearEndEn = $this->nep_to_eng($y,12,$yearLast)->full;
        return $obj;
    }
}

function getWeekEnds($date) {
    $time = strtotime($date);
    $obj = new stdClass();
    $obj->start = date('Y-m-d', strtotime('Last Sunday', $time));
    $obj->end = date('Y-m-d', strtotime('Next Saturday', $time));
    $obj->monthEnd = date("t", strtotime($date));
    return $obj;
}

    $today = getdate();
    $date = $today['year'].'-'.$today['mon'].'-'.$today['mday'];
    $dateInWords = date("jS F, Y", strtotime($date));
    $nday = $today['mday'];
    if($nday==1||$nday==21||$nday==31) {
        $prefix = '<sup>st</sup>';
    } else if($nday==2||$nday==22||$nday==32) {
        $prefix = '<sup>nd</sup>';
    } else if($nday==3||$nday==23) {
        $prefix = '<sup>rd</sup>';
    } else {
        $prefix = '<sup>th</sup>';
    }
    $dateHTML = "$nday $prefix - ".$today['month'].", ".$today['year'];
	$cal = new NepaliDate();
	$nepaliDate  = $cal->eng_to_nep($today['year'],$today['mon'],$today['mday']);
	$x = $cal->getInfoOnDate($nepaliDate->full);
	$y = getWeekEnds($date);
	$DATE = new stdClass();
	$DATE->year               = $today['year'];
	$DATE->month              = $today['month'];
	$DATE->nmonth             = $today['mon'];
    $DATE->nday               = $today['mday'];
    $DATE->day                = $today['weekday'];
    $DATE->weekStart          = $y->start;
    $DATE->weekEnd            = $y->end;
    $DATE->monthEnd           = $y->monthEnd;
    $DATE->full               = $date;
    $DATE->words              = $dateInWords.', '.$DATE->day;
    $DATE->HTML               = $dateHTML.', '.$DATE->day;
    $nepaliDate->weekStart    = $x->start;
    $nepaliDate->weekEnd      = $x->end;
    $nepaliDate->monthEnd     = $x->monthEnd;
    $nepaliDate->yearEnd      = $x->yearEnd;
    $nepaliDate->monthStartEn = $x->monthStartEn;
    $nepaliDate->monthEndEn   = $x->monthEndEn;
    $nepaliDate->yearEndEn    = $x->yearEndEn;

    unset($cal,$x,$y,$date,$today,$dateInWords);