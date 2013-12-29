<?PHP
###########   REDIRECTING   PAGES   #################
	function redirectPHP($location) {
		header("location:".$location);
	}

	function redirectJS($_url) {
		echo "<script language='javascript'>
				window.location.href='$_url'
			</script>"; 
	}
	
	// Redirects user to $url
	function redirect($url = null)
	{
		if(is_null($url)) $url = $_SERVER['PHP_SELF'];
		header("Location: $url");
		exit();
	}
	
	// Returns the user's browser info.
	// browscap.ini must be available for this to work.
	// See the PHP manual for more details.
	function browser_info()
	{
		$info    = get_browser(null, true);
		$browser = $info['browser'] . " " . $info['version'];
		$os      = $info['platform'];	
		$ip      = $_SERVER['REMOTE_ADDR'];		
		return array("ip" => $ip, "browser" => $browser, "os" => $os);
	}

	##
	function safeInclude($val)
	{
		$ret_val = trim($val,".\/");
		return $ret_val;
	}
	
	## url parsing function
	function parseURL($_module = '' , $_page = '') {
		## default module and page call
		$module = $_module; 
		$page = $_page;
		
		/*
		echo $uri =  $_SERVER['REQUEST_URI']; echo '<br>';
		//echo $uri = ltrim('/' , $uri); echo '<br>';
		## 1st method of spliting position -- might not be suiteble in the production server
		$url = explode('/' , $uri);
		// leave 0 index - it is main root folder or domain name
		echo '<pre>'; echo '<br>';
		var_dump($url);
		
		echo $module = $url[3]; echo '<br>';
		echo $page = $url[4]; echo '<br>';
		*/
		
		
		## second method of splitting url -- might be suitable in the server
		$uri =  $_SERVER['REQUEST_URI'];
		
		## check whether index.php exists or not ie check whether needle exists in heystack or not
		## here index.php is needle and $uri is heystack where the keyword index.php is to be be checked
		$pos = stripos($uri , 'index.php');
		
		if($pos === false) {
			 //echo 'string needle NOT found in haystack';
			 
		}
		else {
		 	//echo 'string needle found in haystack';
		 	
		 	## split main url, will be splitted into two indexed 0 and 1 array
		 	$spliturl = explode('index.php' , $uri);
			
		 	## ignore 0th index array, take index 1 array, it is the remaining part of the url which contains necessary items
		 	## for processing. It contains modules, sub modules, pages, action pages and ids or arguments
		 	@$suburl = $spliturl[1];
			
		 	## remove preceeding '/' in the suburl coz it will give extra empty array data in 0th index
		 	if(!empty($suburl)) {
				$suburl = ltrim($suburl , '/');
				
				## now split the url for final time
				$finalsplit = explode('/' , $suburl);
				
				## count no of data in array - coz no of data in the array determines the module name , page name, operation
				## folder and arguments or ids 
				$count = count($finalsplit);
				
				## if no of array data is greater than 2 then check whether they are modules, page , ids or other 
				## ie modules, submodules, operation, page, ids or 
				## modules, operation, pages, ids or some other format urls
				$module = $finalsplit[0];
				
				## checking for submodules or operation folder
				if($finalsplit[1] == 'act') {
					$act = $finalsplit[1];
					$page = $finalsplit[2];
				}
				else if($finalsplit[1] == 'sub') {
					$sub = $finalsplit[1];
					if($finalsplit[2] == 'act') {
						$act = $finalsplit[2];
						$page = $finalsplit[3];
						## id retrieve
						for ($i = 4; $i < $count; $i++) {
							$id[] = $finalsplit[$id];
						}
					}
					else {
						$page = $finalsplit[2];
						## for id
						if($count > 3) {
							for ($i = 3; $i < $count; $i++) {
								$id[] = $finalsplit[$i];
							}
						}
					}
				}
				else {
					$page = $finalsplit[1];
					## for id 
					if($count > 2) {
						for($i = 2; $i < $count; $i++) {
							$id[] = $finalsplit[$i];
						}
					}
				}
		 	}
			//echo 'module = '.$module = $finalsplit[0];echo '<br>';
			//echo 'page = '.$page = $finalsplit[1];
		}
		
		if(!$module) $module = 'main';
		if(!$page) $page = 'index';
		
		$classname = $page;
		$include = "modules/$module/$page".".php";
			
		$status = include($include);
			
		//$obj = & new $classname( @$id );
		$obj = new $classname( @$id );
		
	}
	
	##
	function loadModule($_module = '' , $_page = ''){
		$module = $_module;
		$sub = '';
		$act = '';
		$page = $_page;
		if(!$module) $module = 'main';
		if(!$page) $page = 'index';
		
		## check if the module(i.e. option) , sub module or subpage and display page exists or not, if not then display error page (to be done)
		//$dir = dir("/modules/");
		//echo $dir = $_SERVER['REQUEST_URI'];
		//echo '<br>';
		if(isset($_GET['option'])) $module = safeInclude($_GET['option']); //option=folder name inside module or option=module name
		if(isset($_GET['sub'])) $sub = safeInclude($_GET['sub']); //sub=sub folder name inside folder inside module
		if(isset($_GET['act'])) $act = safeInclude($_GET['act']);
		if(isset($_GET['page'])) $page = safeInclude($_GET['page']);
		
		
		
		if(empty($_GET['sub'])) {
			if(empty($_GET['act'])) {
				$include = "modules/$module/$page".".php";
			}
			else $include = "modules/$module/$act/$page".".php";
		}
		if(!empty($_GET['sub'])) {
			if(empty($_GET['act'])) {
				$include = "modules/$module/$sub/$page".".php";
			}
			else $include = "modules/$module/$sub/$act/$page".".php";
		}
		
		//echo $include;
		if(!file_exists($include) || !is_readable($include)) {
			//redirect('pagenotfound.php'); 
			include('pnf.php');
			//echo '<span style="color:red; font-weight:bold;">Error 404: &nbsp;The requested file is not found.</span><br><br>';
			//echo '<span style="color:green">Hit <a style="cursor:pointer" onclick="javascript: history.back();">back</a> button to go to previous page.</span>';
			die();
		} 
		
		
		$status = include($include);
			
		#### call module object
		if($status == 1) {
			if(isset($_GET['page'])) {
				
				# convert page name to class name
				$page = ucfirst($_GET['page']);
				
				# change page to proper cases for class name
				if(isset($_GET['c']) && $_GET['c'] > 0) {
					$charpos = $_GET['c'];
				}
				if(isset($_GET['cl']) && $_GET['cl'] > $_GET['c']) {
					unset($charpos);
					$charpos = array($_GET['c'] , $_GET['cl']);
				}
				if(isset($_GET['cli']) && $_GET['cli'] > $_GET['cl']) {
					unset($charpos);
					$charpos = array($_GET['c'] , $_GET['cl'] , $_GET['cli']);
				}
				if(!empty($charpos)) 
					$page = characterToUpper( $page , $charpos );
				
				# assign page as class name
				$classname = $page;
			}
			else $classname = ucfirst('index');
			
			# call class object
			//$obj = & new $classname();
			$obj = new $classname();
		}
		
		//return $include;
	}
	/*function GetDisplayPage()
	{
		$module = 'main';
		$page = 'main';
		if($_GET['option']) $module = safeInclude($_GET['option']);
		if($_GET['page']) $page = safeInclude($_GET['page']);
		$include = "modules/$module/$page".".php";
		return $include;
	}*/
	
	// Creates a friendly URL slug from a string
	function slugify($str)
	{
		$str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str);
		$str = strtolower(str_replace(' ', '-', trim($str)));
		$str = preg_replace('/-+/', '-', $str);
		return $str;
	}

	// Computes the *full* URL of the current page (protocol, server, path, query parameters, etc)
	function full_url()
	{
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
	
	// Processes mod_rewrite URLs into key => value pairs
	// See .htacess for more info.
	function pick_off($grabFirst = false, $sep = "/")
	{
		$ret = array();
		$arr = explode($sep, trim($_SERVER['REQUEST_URI'], $sep));
		if($grabFirst) $ret[0] = array_shift($arr);
		while(count($arr) > 0)
			$ret[array_shift($arr)] = array_shift($arr);
		return (count($ret) > 0) ? $ret : false;
	}
	
	// Grabs the contents of a remote URL. Can perform basic authentication if un/pw are provided.
	function geturl($url, $username = null, $password = null)
	{
		if(function_exists("curl_init"))
		{
			$ch = curl_init();
			if(!is_null($username) && !is_null($password))
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' .  base64_encode("$username:$password")));
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			$html = curl_exec($ch);
			curl_close($ch);
			return $html;
		}
		elseif(ini_get("allow_url_fopen") == true)
		{
			if(!is_null($username) && !is_null($password))
				$url = str_replace("://", "://$username:$password@", $url);
			$html = file_get_contents($url);
			return $html;
		}
		else
		{
			// Cannot open url. Either install curl-php or set allow_url_fopen = true in php.ini
			return false;
		}
	}
	
	function paginate($limit)	{
	global $admin;
	$sql="select FOUND_ROWS();";
	$result=mysql_query($sql) or die (mysql_error());
	$row=mysql_fetch_array($result);
	$numrows=$row[0];
	//$pagelinks="<div class=\"nav\">";
	$pagelinks="";
	if($numrows>$limit)	{
		if(isset($_GET['pg']))	{
			$pg=$_GET['pg'];
		} else {
		$pg=1;	
	}
	$currpage= $_SERVER['PHP_SELF']	. "?" . $_SERVER['QUERY_STRING'];
	$currpage= str_replace("&pg=".$pg,"",$currpage);
	
	if($pg==1) {
		//$pagelinks .="<span class=\"pageprevdead\">&laquo;</span>"; //do not show previous button in first page.
	} else {
		$pageprev=$pg-1;
		$pagelinks .="<a class=\"bluebold\" href=\"".$currpage."&pg=" . $pageprev . "\"> &laquo; </a>";
	}
	$numofpages= ceil($numrows/$limit);
	$range=$admin['pageRange']['value'];
	if($range=="" or $range==0) $range=5; //change the range value as per requirements. This is the number of links that are displayed at bottom. 
	$lrange=max(1,$pg-(($range-1)/2));
	$rrange=min($numofpages,$pg+(($range-1)/2));
	if(($rrange-$lrange) <($range-1))	{
		if($lrange==1)	{
			$rrange=min($lrange +($range-1),$numofpages);
		} else {
			$lrange=max($rrange-($range-1),0);
		}
	}
	if($lrange>1)	{
		$pagelinks .="&nbsp;<a class=\"bluebold\" href=\"".$currpage."&pg=1 \"> First </a>&nbsp;...";
	} else {
		$pagelinks .="&nbsp;"; //space between previous button and first page link
	}
	for($i=1;$i<=$numofpages;$i++)	{
		if($i==$pg)	{
			$pagelinks .="<span class=\"on\">$i</span>";
		} else {
			if($lrange <=$i and $i<=$rrange) {
				$pagelinks .= " <a class=\"bluebold\" ".
				"href=\"" . $currpage . "&pg=" . $i .
				"\">" . $i . "</a> ";
			}
		}
	}
	if($rrange<$numofpages)	{
		$pagelinks .= "... <a class=\"bluebold\" href=\"".$currpage."&pg=".$numofpages." \"> Last </a>&nbsp;";
	} else {
		$pagelinks .="&nbsp";//space between next button and last page link
	}
	
	if(($numrows-($limit*$pg)) >0)	{
		$pagenext =$pg+1;
		$pagelinks .= "<a class=\"bluebold\" href=\"" .$currpage .
					  "&pg=" .$pagenext . "\">&raquo;</a>";
	} //else {
		//$pagelinks .="<span class=\"pagenextdead\">&raquo;&raquo;</span>";
	//}
	
} 
//$pagelinks .="</div>";
@$_SESSION['numofpages'] = $numofpages;
return $pagelinks;
}
?>