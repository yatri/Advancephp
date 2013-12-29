<?PHP
	// Creates a list of <option>s from the given database table.
	// table name, column to use as value, column(s) to use as text, default value(s) to select (can accept an array of values), extra sql to limit results
	function get_options($table, $val, $text, $default = null, $sql = "")
	{
		global $db;
		$out = "";

		$db->query("SELECT * FROM `$table` $sql");
		while($row = mysql_fetch_array($db->result, MYSQL_ASSOC))
		{
			$the_text = "";
			if(!is_array($text)) $text = array($text); // Allows you to concat multiple fields for display
			foreach($text as $t)
				$the_text .= $row[$t] . " ";
			$the_text = htmlspecialchars(trim($the_text));

			if(!is_null($default) && $row[$val] == $default)
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '" selected="selected">' . $the_text . '</option>';
			elseif(is_array($default) && in_array($row[$val],$default))
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '" selected="selected">' . $the_text . '</option>';
			else
				$out .= '<option value="' . htmlspecialchars($row[$val], ENT_QUOTES) . '">' . $the_text . '</option>';
		}
		return $out;
	}

	// Fixes MAGIC_QUOTES - for php 6 these functions will not be required to strip slashed those are automatically added because php 6 has removed magic quotes
	function fix_magic_slashes($arr = "")
	{
		//echo 'here';
		if(is_null($arr) || $arr == "") return null;
		if(!get_magic_quotes_gpc()) return $arr;
		return is_array($arr) ? array_map('fix_magic_slashes', $arr) : stripslashes($arr); 
		
		//array_map — Applies the callback to the elements of the given arrays
		//example of array_map function
		/*
		function cube($n)
		{
		    return($n * $n * $n);
		}
		
		$a = array(1, 2, 3, 4, 5);
		$b = array_map("cube", $a);
		print_r($b);
		?> 
		
		Result:
		This makes $b have: 
		Array
		(
		    [0] => 1
		    [1] => 8
		    [2] => 27
		    [3] => 64
		    [4] => 125
		)
		*/
	}
	
	# Fixes Magic quotes - slashes automatically added by server if magic quote is on - works similarly to fix_slashes function
	function removeMagicQuotes() {
		if (@get_magic_quotes_gpc()) {
			function stripslashes_auto($value) {
				$value = is_array($value) ? array_map('stripslashes_auto', $value) : stripslashes($value);
				return $value;
			}
			$_POST = array_map('stripslashes_auto', $_POST);
			$_GET = array_map('stripslashes_auto', $_GET);
			$_REQUEST  = array_map('stripslashes_auto', $_REQUEST);
			$_COOKIE = array_map('stripslashes_auto', $_COOKIE);
		}
	}
	
	// Quick wrapper for preg_match
	function match($regex, $str, $i = 0)
	{
		if(preg_match($regex, $str, $match) == 1)
			return $match[$i];
		else
			return false;
	}

	// Sends an HTML formatted email
	function send_html_mail($to, $subject, $msg, $from, $plaintext = "")
	{
		if(!is_array($to)) $to = array($to);
		
		foreach($to as $address)
		{
			$boundary = uniqid(rand(), true);

			$headers  = "From: $from\n";
			$headers .= "MIME-Version: 1.0\n"; 
			$headers .= "Content-Type: multipart/alternative; boundary = $boundary\n";
			$headers .= "This is a MIME encoded message.\n\n"; 
			$headers .= "--$boundary\n" . 
			   			"Content-Type: text/plain; charset=ISO-8859-1\n" .
			   			"Content-Transfer-Encoding: base64\n\n"; 
			$headers .= chunk_split(base64_encode($plaintext)); 
			$headers .= "--$boundary\n" . 
			   			"Content-Type: text/html; charset=ISO-8859-1\n" . 
			   			"Content-Transfer-Encoding: base64\n\n";
			$headers .= chunk_split(base64_encode($msg));
			$headers .= "--$boundary--\n" . 

			mail($address, $subject, "", $headers);
		}		
	}

	// Returns a file's mimetype based on its extension
	function mime_type($filename)
	{
		$mime_types = array("323" => "text/h323", "acx" => "application/internet-property-stream", "ai" => "application/postscript", "aif" => "audio/x-aiff", "aifc" => "audio/x-aiff", "aiff" => "audio/x-aiff", "asf" => "video/x-ms-asf", "asr" => "video/x-ms-asf", "asx" => "video/x-ms-asf", "au" => "audio/basic", "avi" => "video/x-msvideo", "axs" => "application/olescript", "bas" => "text/plain", "bcpio" => "application/x-bcpio", "bin" => "application/octet-stream", "bmp" => "image/bmp", "c" => "text/plain", "cat" => "application/vnd.ms-pkiseccat", "cdf" => "application/x-cdf", "cer" => "application/x-x509-ca-cert", "class" => "application/octet-stream", "clp" => "application/x-msclip", "cmx" => "image/x-cmx", "cod" => "image/cis-cod", "cpio" => "application/x-cpio", "crd" => "application/x-mscardfile", "crl" => "application/pkix-crl", "crt" => "application/x-x509-ca-cert", "csh" => "application/x-csh", "css" => "text/css", "dcr" => "application/x-director", "der" => "application/x-x509-ca-cert", "dir" => "application/x-director", "dll" => "application/x-msdownload", "dms" => "application/octet-stream", "doc" => "application/msword", "dot" => "application/msword", "dvi" => "application/x-dvi", "dxr" => "application/x-director", "eps" => "application/postscript", "etx" => "text/x-setext", "evy" => "application/envoy", "exe" => "application/octet-stream", "fif" => "application/fractals", "flr" => "x-world/x-vrml", "gif" => "image/gif", "gtar" => "application/x-gtar", "gz" => "application/x-gzip", "h" => "text/plain", "hdf" => "application/x-hdf", "hlp" => "application/winhlp", "hqx" => "application/mac-binhex40", "hta" => "application/hta", "htc" => "text/x-component", "htm" => "text/html", "html" => "text/html", "htt" => "text/webviewhtml", "ico" => "image/x-icon", "ief" => "image/ief", "iii" => "application/x-iphone", "ins" => "application/x-internet-signup", "isp" => "application/x-internet-signup", "jfif" => "image/pipeg", "jpe" => "image/jpeg", "jpeg" => "image/jpeg", "jpg" => "image/jpeg", "js" => "application/x-javascript", "latex" => "application/x-latex", "lha" => "application/octet-stream", "lsf" => "video/x-la-asf", "lsx" => "video/x-la-asf", "lzh" => "application/octet-stream", "m13" => "application/x-msmediaview", "m14" => "application/x-msmediaview", "m3u" => "audio/x-mpegurl", "man" => "application/x-troff-man", "mdb" => "application/x-msaccess", "me" => "application/x-troff-me", "mht" => "message/rfc822", "mhtml" => "message/rfc822", "mid" => "audio/mid", "mny" => "application/x-msmoney", "mov" => "video/quicktime", "movie" => "video/x-sgi-movie", "mp2" => "video/mpeg", "mp3" => "audio/mpeg", "mpa" => "video/mpeg", "mpe" => "video/mpeg", "mpeg" => "video/mpeg", "mpg" => "video/mpeg", "mpp" => "application/vnd.ms-project", "mpv2" => "video/mpeg", "ms" => "application/x-troff-ms", "mvb" => "application/x-msmediaview", "nws" => "message/rfc822", "oda" => "application/oda", "p10" => "application/pkcs10", "p12" => "application/x-pkcs12", "p7b" => "application/x-pkcs7-certificates", "p7c" => "application/x-pkcs7-mime", "p7m" => "application/x-pkcs7-mime", "p7r" => "application/x-pkcs7-certreqresp", "p7s" => "application/x-pkcs7-signature", "pbm" => "image/x-portable-bitmap", "pdf" => "application/pdf", "pfx" => "application/x-pkcs12", "pgm" => "image/x-portable-graymap", "pko" => "application/ynd.ms-pkipko", "pma" => "application/x-perfmon", "pmc" => "application/x-perfmon", "pml" => "application/x-perfmon", "pmr" => "application/x-perfmon", "pmw" => "application/x-perfmon", "pnm" => "image/x-portable-anymap", "pot" => "application/vnd.ms-powerpoint", "ppm" => "image/x-portable-pixmap", "pps" => "application/vnd.ms-powerpoint", "ppt" => "application/vnd.ms-powerpoint", "prf" => "application/pics-rules", "ps" => "application/postscript", "pub" => "application/x-mspublisher", "qt" => "video/quicktime", "ra" => "audio/x-pn-realaudio", "ram" => "audio/x-pn-realaudio", "ras" => "image/x-cmu-raster", "rgb" => "image/x-rgb", "rmi" => "audio/mid", "roff" => "application/x-troff", "rtf" => "application/rtf", "rtx" => "text/richtext", "scd" => "application/x-msschedule", "sct" => "text/scriptlet", "setpay" => "application/set-payment-initiation", "setreg" => "application/set-registration-initiation", "sh" => "application/x-sh", "shar" => "application/x-shar", "sit" => "application/x-stuffit", "snd" => "audio/basic", "spc" => "application/x-pkcs7-certificates", "spl" => "application/futuresplash", "src" => "application/x-wais-source", "sst" => "application/vnd.ms-pkicertstore", "stl" => "application/vnd.ms-pkistl", "stm" => "text/html", "svg" => "image/svg+xml", "sv4cpio" => "application/x-sv4cpio", "sv4crc" => "application/x-sv4crc", "t" => "application/x-troff", "tar" => "application/x-tar", "tcl" => "application/x-tcl", "tex" => "application/x-tex", "texi" => "application/x-texinfo", "texinfo" => "application/x-texinfo", "tgz" => "application/x-compressed", "tif" => "image/tiff", "tiff" => "image/tiff", "tr" => "application/x-troff", "trm" => "application/x-msterminal", "tsv" => "text/tab-separated-values", "txt" => "text/plain", "uls" => "text/iuls", "ustar" => "application/x-ustar", "vcf" => "text/x-vcard", "vrml" => "x-world/x-vrml", "wav" => "audio/x-wav", "wcm" => "application/vnd.ms-works", "wdb" => "application/vnd.ms-works", "wks" => "application/vnd.ms-works", "wmf" => "application/x-msmetafile", "wps" => "application/vnd.ms-works", "wri" => "application/x-mswrite", "wrl" => "x-world/x-vrml", "wrz" => "x-world/x-vrml", "xaf" => "x-world/x-vrml", "xbm" => "image/x-xbitmap", "xla" => "application/vnd.ms-excel", "xlc" => "application/vnd.ms-excel", "xlm" => "application/vnd.ms-excel", "xls" => "application/vnd.ms-excel", "xlt" => "application/vnd.ms-excel", "xlw" => "application/vnd.ms-excel", "xof" => "x-world/x-vrml", "xpm" => "image/x-xpixmap", "xwd" => "image/x-xwindowdump", "z" => "application/x-compress", "zip" => "application/zip");
		list($dir, $base, $ext, $file) = pathinfo($filename);
		return isset($mime_types[$ext]) ? $mime_types[$ext] : "application/octet-stream";
	}
	
	// Returns the lat, long of an address via Google
	function geocode($address, $key, $output = "xml")
	{
		$address = urlencode($address);
		$key     = urlencode($key);
		$data    = geturl("http://maps.google.com/maps/geo?q=$address&key=$key&output=$output");

		if($output == "xml")
		{
			$xml = simplexml_load_string($data);
			if($xml === false) return false;
			if($xml->Response->Status->code != "200") return false;
			return explode(",", (string) $xml->Response->Placemark->Point->coordinates);
		}
		else
			return $data;
	}

	// Quick and dirty wrapper for curl
	function curl($url, $referer = null, $post = null)
	{
		global $last_url;
		static $tmpfile;
		
		if(!isset($tmpfile) || ($tmpfile == "")) $tmpfile = tempnam("/tmp", "FOO");
	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfile);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfile);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1) Gecko/20061024 BonEcho/2.0");
		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_VERBOSE, 1);

		if($referer) curl_setopt($ch, CURLOPT_REFERER, $referer);
		if($post)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		ob_start();
		curl_exec($ch);
		$html = ob_get_contents();
		ob_end_clean();
	
		$last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		return $html;
	}

	// Accepts any number of arguments and returns the first non-empty one
	function pick()
	{
		foreach(func_get_args() as $arg)
			if(!empty($arg))
				return $arg;
		return "";
	}

	// This is easier than typing "echo WEB_ROOT"
	function WEBROOT()
	{
		echo WEB_ROOT;
	}
	
	function singletonPattern(&$selfinstance , &$this) { //singleton pattern function
		if (!$selfinstance) {
			$selfinstance = $this;
		//	echo "New Instance\n";
			return $selfinstance;
		} else {
		//	echo "Old Instance\n";
			return $selfinstance;
		}
		
		/*
		 if (!self::$instance) {
			self::$instance = $this;
			//echo "New Instance\n";
			return self::$instance;
		} else {
			//echo "Old Instance\n";
			return self::$instance;
		}
		*/
	}
	
	### set variables and call unsetsession function
	function ResetSession()
	{
		$sessionkey = array('js_step_1' , 'js_var_step1' , 'step2_education' , 'short_term_course' , 'step2_experience');
		
		UnsetSession($sessionkey);
	}
	
	#### (unset) unwanted sessions
	function UnsetSession($sessionKey = "")
	{
		if(!empty($sessionKey))
		{
			if(is_array($sessionKey))
			{
				foreach($sessionKey as $val)
				{
					unset($_SESSION[$val]);
				}
			}
			else
			{
				unset($_SESSION[$sessionKey]);
			}
		}
		else
		{
			session_destroy();
		}
	}
