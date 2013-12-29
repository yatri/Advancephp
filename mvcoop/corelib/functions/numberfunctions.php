<?PHP
	################ GENERATING UNIQUE INVOICE NUMBERS #####################
	############## 10 DIGIT RANDOM NUMBERS #####################
	//function generate_unique_invoicenumber()
	/**
	 * Generates random values
	 *
	 * @param $table name
	 * @param $field name
	 * @param $len length of random values
	 * @param $pintype type of characters to be generated N-allnumeric, A-allalphabet, a-allsmallalphabet, Aa-CapitalSmall Alphabet, NAa-Numeric CapicalSmall Alphabet
	 * @return string
	 */
	function generateRandomVal( $table = '' , $field = '' , $len = '' , $pintype = "" )
	{ 
		$pin_Length = $len;
		
		if($pin_Length == '') $pin_Length =10;
		$pin_Range = 1;
		
		if($pintype == "N")
			$acceptednumbers = '1234567890';
		else if($pintype == "A")
			$acceptednumbers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		else if($pintype == "a")
			$acceptednumbers = 'abcdefghijklmnopqrstuvwxyz';
		else if($pintype == "Aa")
			$acceptednumbers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		else if($pintype == "NAa")
			$acceptednumbers = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		else
			$acceptednumbers = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$max = strlen($acceptednumbers)-1;
		$pin_num = null;

		for($x=0; $x < $pin_Range; $x++)
		{
			for($i=0; $i < $pin_Length; $i++)
			{
				$pin_num .= $acceptednumbers{rand(0, $max)};
			}
			
			if(!empty($table) && !empty($field))
			{
				$query = "select $field from $table where $field = '$pin_num' ";
				$result = mysql_query($query) or die("Query failed : " . mysql_error());


				if (!($result = mysql_fetch_array($result, MYSQL_ASSOC))) 
				{
 					$retrn_value = $pin_num;
				}
				else
				{
					continue;
				}
			}
			else
			{
				$retrn_value = $pin_num;
			}
			$pin_num = null;
		}
 		//$msg="Pin numbers generated successfully";
		
		return $retrn_value;
	}
	
	### random no generation function
	function GenerateRandomNo() 
	{
		return mt_rand(1000000000,99999999999);
   	}
	
	### returns ordinal extension for any number. e.g. 1 = 'st', 2 = 'nd', 3 = 'rd' and so on
	function ordinal($cdnl) {
		$test_c = abs($cdnl) % 10;
		$ext = ((abs($cdnl) %100 < 21 && abs($cdnl) %100 > 4) ? 'th'
				: (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1)
				? 'th' : 'st' : 'nd' : 'rd' : 'th'));
		return $cdnl.$ext;
	}
	// example echo ordinal(311). '<br />' .ordinal(-321);
	
	// Formats a phone number as (xxx) xxx-xxxx or xxx-xxxx depending on the length.
	function format_phone($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);

		if(strlen($phone) == 7)
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		else
			return $phone;
	}

	### This small simple function will display leading zero numbers as string, when the number provided is less than 10 (like '07'), '00' when it's 0, an untouched if bigger than 10.
	### Note: modified to handle 0 to 9 and -9 to -1
	function lz($int)
	{
		$int = (int) $int;
		if (strlen($int) == 1) { // 0 to 9
			return "0$int";
		}
		if ($int < 0) {
			if (strlen($int) == 2) { // -1 to -9
				return '-0'.substr($int, 1);
			}
		}
		return $int;
	}
	# $lz = str_pad($lz, 2, "0", STR_PAD_LEFT);
	# $lz = str_pad($lz, 2, "0", STR_PAD_LEFT); -> Does not work on -5 for example
	
	
	### rounding function 
	####### $total_weight rounding up operation to .0 or 0.5 ######
	function roundFloat($val) {
		if(is_int($val))
		{
			$val = $val;
		}
		if(is_float($val))
		{ 
			##### round up values to .0 or 0.5 ... eg 4.4 to 4.5 and 4.6 to 5
			
			#### method 1 ::: excellent
			/*echo '<br>floored value='.$floored_total = floor($val);
			echo '<br>fraction='.$fraction =($val - $floored_total);
			if($fraction>0 && $fraction<=0.5) $to_add = 0.5;
			else if($fraction>0.5) $to_add = 1;
			else $to_add = 0;
			$val = $floored_total + $to_add;
			*/
			
			#### method 2 ::: like this too .Fantastic!!!
			$keep_original = false;
			$val=explode('.' , number_format($val,2));
			$val[1] = $val[1]/100;
			
			if($val[1]>0 && $val[1]<=0.5) 
				$to_add = 0.5;
			else if($val[1]>0.5) 
				$to_add = 1;
			else 
				$keep_original = true;
			
			if($keep_original == true) 
				$val = $val;
			else 
				$val = $val[0] + $to_add;
		}
		
		return $val;
	}
	
	### format numeric value to decimal value
	function formatNumbertoDecimal($val , $default = 2) {
		$noofdecimalpoints = $default;
		if(is_numeric($val))
			$val = number_format($val , $noofdecimalpoints);
		else
			$val = $val;
			
		return $val;	
	}
	
	
	#### Need to extract numeric/alpha characters from string
	function extractCharacters($string , $type = 'numeric') 
	{
		$string = $string;
		$chars = '';
		$nums = '';
		$fnums = '';
		$returnval = '';
		
		for ($index=0;$index<strlen($string);$index++) {
			
			/*if(isNumber($string[$index]))
					$nums .= $string[$index];
				else    
					$chars .= $string[$index];*/
			
			if($type == 'numeric')
			{
				if(isNumber($string[$index]))
					$nums .= $string[$index];
			}
			if($type == 'float')
			{
				if(isFloat($string[$index]))
					$fnums .= $string[$index];
			}
			if($type == 'character')
			{
				if(!isNumber($string[$index]))
					$chars .= $string[$index];
			}
		}
		//echo "Chars: -$chars-<br>Nums: -$nums-";
		if($type == 'numeric')
			$returnval = $nums;
		if($type == 'character')
			$returnval = $chars;
		if($type == 'float')
			$returnval = $fnums;
		
		//die();
		return $returnval;
	}	
	
	function isNumber($c) {
		return preg_match('/[0-9]/', $c);
	}
	
	function isFloat($c) {
		return preg_match('/[0-9.]/', $c);
	}
	
?>