<?PHP
	##########  SQL INJECTION PREVENT  ###############
	function escapeData($data , $addslashes = '') {
		if(ini_get('magic_quotes_gpc'))
		{
			$data=stripslashes($data);
		}
		if($addslashes == 1) {
			$resultdata = addslashes($data);
		}
		else {
			$resultdata = mysql_escape_string($data);
		}
		
		return $resultdata;
	}
	
	function escapeDataArray($data) {
		$val=array();
		if(ini_get('magic_quotes_gpc'))
		{
			foreach($data as $i=>$data1)
			{
			  echo $data1;
			    $a=stripslashes($data1);
			    
			    $val[]=mysql_escape_string($a);
			}
			return $val;
		}
    }
	
	#### XSS (cross site scripting) prevent ######
	function escapeXSS($input , $_par = '') {
		if($_par == 'strip') {
			return strip_tags(trim($input)); //strips html and php tags
		}
		elseif ($_par == 'entity') {
			return htmlentities(trim($input)); //Convert all applicable characters to HTML entities
		}
		else { // by default it will be called
			return htmlspecialchars(trim($input)); //Convert special characters to HTML entities 

		}
	}
	
		//===================================================================================
	// IN	:	normal data
	// OUT	:	256 bit encrypted data
	// DESC	:	encrypts data using cls.Cypher.php
	//		:	cls.cypher.php file must be included in the calling php file
	//		:	AppVars.php file must be included in the calling php file
	function encryptData($DATA)
	{ 
		//global $AppKey;
		if(empty($DATA))
			$strReturn	=	"Please enter data to ENCRYPT!";
		else
		{
			$objCypher	=	New Cypher();
			$strReturn	=	$objCypher->encrypt(KEY , $DATA);
		}
		return $strReturn;
	}
	//===================================================================================
	
	//===================================================================================
	// IN	:	256 bit encrypted data
	// OUT	:	normal data(orignial data)
	// DESC	:	decrypts data using cls.Cypher.php
	//		:	cls.cypher.php file must be included in the calling php file
	//		:	AppVars.php file must be included in the calling php file
	function decryptData($DATA)
	{
		global $AppKey;
		if(empty($DATA))
			$strReturn	=	"Please enter data to Decrypt!";
		else
		{
			$objCypher	=	New Cypher();
			$strReturn	=	$objCypher->decrypt(KEY , $DATA);
		}
		return $strReturn;
	}

	/**
	The features of that programs are :
	1.) Hacker injects code, increasing the file size.
	2.) Next request to serve the home page (or other page of your choice) triggers the detector, which compares current file size with that for archived original.
	3.) Detector sends email with file mod timestamp to webmaster.
	4.) Script replaces hacked file with copy of an archived original, exits.
	
	You need to add the following code on the top of index.php after DOCTYPE declaration and also enter your email address in this code.
	*/
	function hackDet () {
		$tst = "";
		$gzt = "index.php";
		$stat = stat($gzt);
		$gzt2 = "refz/x_" . $gzt;
		$rstat = stat($gzt2);
		$ref = $rstat[size];
		$rtim = $_SERVER['REQUEST_TIME'];
		$rtim2 = date("F d Y H:i:s.", $rtim) . " Eastern";
		$mtim = filemtime($gzt);
		$mtim2 = date("F d Y H:i:s.", $mtim) . " Eastern";
		
		if ($stat[size] <> $ref)
		{
			$fw = "index.php";
			$hak = file_get_contents($fw);
			
			$msg = "$gzt has $stat[size] bytes and not $ref as it should.\n\n";
			$msg .= "FILE MOD TIME $mtim: $mtim2\n";
			$msg .= "REQUEST_TIME $rtim: $rtim2\n\n";
			$msg .= "=================\n\n";
			$msg .= $hak;
			
			$msg = wordwrap($msg, 70);
			mail(' sanjay.khadka@hotmail.com ', 'HACK ALERT', $msg);
			
			$fr = "refz/x_index.php";
			$str = file_get_contents($fr);
			$tst = file_put_contents($fw, $str);
		}
		return $tst;
	}

	//$tst = hackDet(); // calls the hack detection function
?>