<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('kalender'))
{
	function kalender($month,$year,$array_date) {
 		//array untuk mengganti bulan ke bahasa Indonesia
 		$array_bulan = array('January'=>'Januari','February'=>'Februari','March'=>'Maret','April'=>'April','May'=>'Mei','June'=>'Juni','July'=>'Juli','August'=>'Agustus','September'=>'September','October'=>'Oktober','November'=>'November','December'=>'Desember');

	    // Create array containing abbreviations of days of week.
	    $daysOfWeek = array('Min','Sen','Sel','Rab','Kam','Jum','Sab');
	 
	    // What is the first day of the month in question?
	    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	 
	    // How many days does this month contain?
	    $numberDays = date('t',$firstDayOfMonth);
	 
	    // Retrieve some information about the first day of the
	    // month in question.
	    $dateComponents = getdate($firstDayOfMonth);
	 
	    // What is the name of the month in question?
	    $monthName = $array_bulan[$dateComponents['month']];
	 
	    // What is the index value (0-6) of the first day of the
	    // month in question.
	    $dayOfWeek = $dateComponents['wday'];
	 
	    // Create the table tag opener and day headers
	 
	    $calendar = "<table class='calendar'>";
	    $calendar .= "<caption>$monthName $year</caption>";
	    $calendar .= "<tr>";
	 
	    // Create the calendar headers
	 
	    foreach($daysOfWeek as $day) {
	         $calendar .= "<th class='header'>$day</th>";
	    }
	 
	    // Create the rest of the calendar
	 
	    // Initiate the day counter, starting with the 1st.
	 
	    $currentDay = 1;
	 
	    $calendar .= "</tr><tr>";
	 
	    // The variable $dayOfWeek is used to
	    // ensure that the calendar
	    // display consists of exactly 7 columns.
	 
	    if ($dayOfWeek > 0) {
	         $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
	    }
	 
	    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
	 
	    while ($currentDay <= $numberDays) {
	 
	         // Seventh column (Saturday) reached. Start a new row.
	 
	         if ($dayOfWeek == 7) {
	 
	              $dayOfWeek = 0;
	              $calendar .= "</tr><tr>";
	 
	         }
	 
	         $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
	 
	         $date = "$year-$month-$currentDayRel";

			$checked = (!empty($array_date[$date])) ? 'checked' : '';

	         $calendar .= "<td class='day' rel='$date' id='$year-$month-$currentDay'> $currentDay <br> <input type='checkbox' name='check-tgl' value='$date' class='check-tgl' $checked/></td>";
	 
	         // Increment counters
	 
	         $currentDay++;
	         $dayOfWeek++;
	 
	    }
	 
	    // Complete the row of the last week in month, if necessary
	 
	    if ($dayOfWeek != 7) {
	 
	         $remainingDays = 7 - $dayOfWeek;
	         $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
	 
	    }
	 
	    $calendar .= "</tr>";
	 
	    $calendar .= "</table>";
	 
	    return $calendar;
	 
	}
}

if (! function_exists('iterasi_tgl'))
{
	function iterasi_tgl($tanggal1, $tanggal2)
	{
		$begin = new DateTime( $tanggal1 ); 
		$end = new DateTime( $tanggal2 ); 
		for($i = $begin; $i <= $end; $i->modify('+1 day')){ 
			//$tanggal_1 = $i->format("d")-1;
			$hari = date("l",mktime (0,0,0,$i->format("m"),$i->format("d"),$i->format("Y")));
			$minggu = date("w",mktime (0,0,0,$i->format("m"),$i->format("d"),$i->format("Y")));
	    	//echo $i->format("Y-m-d").' '.$i->format("m").' '.$hari.' '.$minggu.'<br>';
	    	$array[$i->format("Y")][$i->format("m")] = $i->format("d");
	    	//$item_tgl[$i->format("Y-m-d")] = $array_waktu[$i->format("Y-m-d")];
		}
		return $array;
	}
}

if (! function_exists('tanggalToDbs'))
{
	function tanggalToDbs($tgl_kegiatan)
	{
		$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
		$tgl_array = explode(" ", $tgl_kegiatan);
		$d = $tgl_array[0]; 
		$month = array_search($tgl_array[1], $bulan) + 1;
		$m = (strlen($month)==2) ? $month : '0'.$month; 
		$y = $tgl_array[2];
		$tgl = $y."-".$m."-".$d;
		$tgl_kegiatan = $tgl;
		return $tgl;
	}
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */