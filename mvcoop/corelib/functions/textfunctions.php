<?PHP
	##### trim text
	function trim_text($TEXT, $LIMIT, $TAGS = 0) {
	    // TRIM TEXT
	    $TEXT = trim($TEXT);

		// STRIP TAGS IF PREVIEW IS WITHOUT HTML
		if ($TAGS == 0) $TEXT = preg_replace('/\s\s+/', ' ', strip_tags($TEXT));
	
		// IF STRLEN IS SMALLER THAN LIMIT RETURN
		if (strlen($TEXT) < $LIMIT) return $TEXT;
	
		if ($TAGS == 0) return substr($TEXT, 0, $LIMIT) . " ...";
		else {
	
			$COUNTER = 0;
			for ($i = 0; $i<= strlen($TEXT); $i++) {
	
				if ($TEXT{$i} == "<") $STOP = 1;
	
				if ($STOP != 1) {
	
					$COUNTER++;
				}
	
				if ($TEXT{$i} == ">") $STOP = 0;
				$RETURN .= $TEXT{$i};
	
				if ($COUNTER >= $LIMIT && $TEXT{$i} == " ") break;
	
			}
	
			return $RETURN . "...";
		}
	}
	
	##### trim char
	function removeChar($data,$char)
	{
		$clear_data = trim($data,$char);
		return $clear_data;
	}
	
	##### change case of a particular character in a word to upper
	function characterToUpper( $_word , $_index = '' ) {
		#### conversion
		if(is_array($_index)) {
			foreach($_index as $index) {
				$myString = $_word; // required word 
				$charToChange = $myString{$index}; // find character to change case to upper
			
				$changedChar = strtoupper($charToChange); // convert character to upper
				$myString{$index} = $changedChar; //replace the character
				$_word = $myString;
			}
			return $_word;	
		}
		else {
			$myString = $_word; // required word 
			$myChar = $myString{$_index}; // find character to change case to upper
			
			$changedChar = strtoupper($myChar); // convert character to upper
			$myString{$_index} = $changedChar; //replace the character
			
			return $myString;
		}
	}
	
	##### change case of a particular character in a word to lower
	function characterToLower( $_word , $_index) {
		#### conversion
		if(is_array($_index)) {
			foreach($_index as $index) {
				$myString = $_word; // required word 
				$charToChange = $myString{$index}; // find character to change case to upper
			
				$changedChar = strtolower($charToChange); // convert character to upper
				$myString{$index} = $changedChar; //replace the character
				$_word = $myString;
			}	
		}
		else {
			$myString = $_word; // required word 
			$myChar = $myString{$_index}; // find character to change case to upper
			
			$changedChar = strtolower($myChar); // convert character to upper
			$myString{$_index} = $changedChar; //replace the character
			
			return $myString;
		}
	}
	
	## 
	/*function max_words($str, $num)
	{
		$words = explode(" ", $str);
		if(count($words) < $num)
			return $str;
		else
			return implode(" ", array_slice($words, 0, $num));
	}*/
	
	//This is totally free to use by anyone for any purpose.

	// BadWordFilter
	// This function does all the work. If $replace is 1 it will replace all bad words
	// with the wildcard replacements.  If $replace is 0 it will not replace anything.
	// In either case, it will return 1 if it found bad words or 0 otherwise.
	// Be sure to fill the $bads array with the bad words you want filtered.
	function BadWordFilter(&$text, $replace)
	{
		//fill this array with the bad words you want to filter and their replacements
		$bads = array (
			array("butt","b***"),
			array("poop","p***"),
			array("crap","c***")
		);
	
		if($replace==1) {								//we are replacing
			$remember = $text;
			
			for($i=0;$i<sizeof($bads);$i++) {			//go through each bad word
				$text = eregi_replace($bads[$i][0],$bads[$i][1],$text); //replace it
			}
	
			if($remember!=$text) return 1; 				//if there are any changes, return 1
			
		} else {										//we are just checking
		
			for($i=0;$i<sizeof($bads);$i++) {			//go through each bad word
				if(eregi($bads[$i][0],$text)) return 1; //if we find any, return 1
			}	
			
		}
	
	
		//this will replace all bad words with their replacements. $any is 1 if it found any
		$any = BadWordFilter($wordsToFilter,1); 
	
		//this will not repace any bad words. $any is 1 if it found any
		$any = BadWordFilter($wordsToFilter,0); 
	}

	// Returns the first $num words of $str
	function max_words($str, $num)
	{
		$words = explode(" ", $str);
		if(count($words) < $num)
			return $str;
		else
			return implode(" ", array_slice($words, 0, $num));
	}

?>