<?PHP
	# last ver 02.06.2008
	# DateFunctions file
	# Created by Sanjay Khadka
	# copyright sanjaykhadka.com.np - checksanjay2000@yahoo.com

	/**
	 * CALCULATES THE NO OF DAYS BETWEEN TWO DATES
	 *
	 * @param $st date(YY-mm-dd)
	 * @param $nd date(YY-mm-dd)
	 * @return int
	 */
	function getDays($st,$nd)
	{ //gtime('2008-05-8','2008-06-20');
		$i['start'] = strtotime($st);
		$i['end'] = strtotime($nd);
		//echo $nd;
		if($i['start'] !== -1 && $i['end'] !== -1 )
		{
			if($i['end'] >= $i['start'])
			{
				$dif = $i['end'] - $i['start'];
				if($days = intval((ceil($dif / 86400)))) $dif =$dif % 86400; 
				if($hours = intval((ceil($dif / 3600)))) $dif =$dif % 3600; 
				if($minutes = intval((ceil($dif / 60)))) $dif =$dif % 60;
				$dif = intval($dif); 
				return $days;
			}
		}
		return false;
	}
	
	/**
	 * This custom function finds the no of days in a month
	 *
	 * @param $date date(YYYY-MM)
	 * @return int
	 */
	function no_of_days($date)//value in format YYYY-MM
	{
		$sd=$date.'-01';
		$date_split=explode("-",$date);
		if($date_split[1]==12) { $mth=1; $year=$date_split[0]+1; } else { $mth=$date_split[1]+1; $year=$date_split[0]; }
		$ed=$year.'-'.$mth.'-01';
		return(getdays($sd,$ed));
	}
	
	/**
	 * This custom function returns the day from a date eg sunday,monday
	 *
	 * @param $_date date(YY/MM/DD)
	 * @return string
	 */
	function find_day($_date) //date format 2008/07/20 or YY/MM/DD
	{
		$split = explode('/',$_date);
		$yy = $split[0];
		$mm = $split[1];
		$dd = $split[2];
		$day = date("l",mktime(0,0,0,$mm,$dd,$yy));
		return $day;
	}
	
	// Returns an English representation of a past date within the last month
	// Graciously stolen from http://ejohn.org/files/pretty.js
	function time2str($ts)
	{
		if(!ctype_digit($ts))
			$ts = strtotime($ts);

		$diff = time() - $ts;
		if($diff == 0)
			return "now";
		elseif($diff > 0)
		{
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 60) return "just now";
				if($diff < 120) return "1 minute ago";
				if($diff < 3600) return floor($diff / 60) . " minutes ago";
				if($diff < 7200) return "1 hour ago";
				if($diff < 86400) return floor($diff / 3600) . " hours ago";
			}
			if($day_diff == 1) return "Yesterday";
			if($day_diff < 7) return $day_diff . " days ago";
			if($day_diff < 31) return ceil($day_diff / 7) . " weeks ago";
			if($day_diff < 60) return "last month";
			return date("F Y", $ts);
		}
		else
		{
			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 120) return "in a minute";
				if($diff < 3600) return "in " . floor($diff / 60) . " minutes";
				if($diff < 7200) return "in an hour";
				if($diff < 86400) return "in " . floor($diff / 3600) . " hours";
			}
			if($day_diff == 1) return "Tomorrow";
			if($day_diff < 4) return date("l", $ts);
			if($day_diff < 7 + (7 - date("w"))) return "next week";
			if(ceil($day_diff / 7) < 4) return "in " . ceil($day_diff / 7) . " weeks";
			if(date("n", $ts) == date("n") + 1) return "next month";
			return date("F Y", $ts);
		}
	}

	// Returns an array representation of the given calendar month.
	// The array values are timestamps which allow you to easily format
	// and manipulate the dates as needed.
	function calendar($month = null, $year = null)
	{
		if(is_null($month)) $month = date("n");
		if(is_null($year)) $year = date("Y");

		$first = mktime(0, 0, 0, $month, 1, $year);
		$last = mktime(23, 59, 59, $month, date("t", $first), $year);

		$start = $first - (86400 * date("w", $first));
		$stop = $last + (86400 * (7 - date("w", $first)));

		$out = array();
		while($start < $stop)
		{
			$week = array();
			if($start > $last) break;
			for($i = 0; $i < 7; $i++)
			{
				$week[$i] = $start;
				$start += 86400;
			}
			$out[] = $week;
		}

		return $out;
	}
	
	// Converts a date/timestamp into the specified format
	function dater($format = null, $date = null)
	{
		if(is_null($format))
			$format = "Y-m-d H:i:s";

		if(is_null($date))
			$date = time();

		// if $date contains only numbers, treat it as a timestamp
		if(ctype_digit($date) === true)
			return date($format, $date);
		else
			return date($format, strtotime($date));
	}

	// Outputs hour, minute, am/pm dropdown boxes
	function hourmin($hid = "hour", $mid = "minute", $pid = "ampm", $hval = null, $mval = null, $pval = null)
	{
		if(is_null($hval)) $hval = date("h");
		if(is_null($mval)) $mval = date("i");
		if(is_null($pval)) $pval = date("a");

		$hours = array(12, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11);
		$out = "<select name='$hid' id='$hid'>";
		foreach($hours as $hour)
			if(intval($hval) == intval($hour)) $out .= "<option value='$hour' selected>$hour</option>";
			else $out .= "<option value='$hour'>$hour</option>";
		$out .= "</select>";

		$minutes = array("00", 15, 30, 45);
		$out .= "<select name='$mid' id='$mid'>";
		foreach($minutes as $minute)
			if(intval($mval) == intval($minute)) $out .= "<option value='$minute' selected>$minute</option>";
			else $out .= "<option value='$minute'>$minute</option>";
		$out .= "</select>";
		
		$out .= "<select name='$pid' id='$pid'>";
		$out .= "<option value='am'>am</option>";
		if($pval == "pm") $out .= "<option value='pm' selected>pm</option>";
		else $out .= "<option value='pm'>pm</option>";
		$out .= "</select>";
		
		return $out;
	}
	
	// Outputs month, day, and year dropdown boxes with default values and custom id/names
	function mdy($mid = "month", $did = "day", $yid = "year", $mval = null, $dval = null, $yval = null)
	{
		// Dumb hack to let you just pass in a timestamp instead
		if(func_num_args() == 1)
		{
			list($yval, $mval, $dval) = explode(" ", date("Y m d", $mid));
			$mid = "month";
			$did = "day";
			$yid = "year";
		}
		else
		{
			if(is_null($mval)) $mval = date("m");
			if(is_null($dval)) $dval = date("d");
			if(is_null($yval)) $yval = date("Y");
		}
		
		$months = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
		$out = "<select name='$mid' id='$mid'>";
		foreach($months as $val => $text)
			if($val == $mval) $out .= "<option value='$val' selected>$text</option>";
			else $out .= "<option value='$val'>$text</option>";
		$out .= "</select> ";

		$out .= "<select name='$did' id='$did'>";
		for($i = 1; $i <= 31; $i++)
			if($i == $dval) $out .= "<option value='$i' selected>$i</option>";
			else $out .= "<option value='$i'>$i</option>";
		$out .= "</select> ";

		$out .= "<select name='$yid' id='$yid'>";
		for($i = date("Y") - 2; $i <= date("Y") + 2; $i++)
			if($i == $yval) $out.= "<option value='$i' selected>$i</option>";
			else $out.= "<option value='$i'>$i</option>";
		$out .= "</select>";
		
		return $out;
	}


?>