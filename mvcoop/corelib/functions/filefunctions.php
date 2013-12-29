<?PHP
	## removing file
	function RemoveFile($file)
	{
		if(unlink($file))return true; else return false;
	}

	## upload docs - created by sanjay khadka 
	## created date : wednesday , November 18 2009
	## supports for any extensions
	## parameters : $_FILE and $_par
	## sample passing of parameters:
	## 1. $_FILE = $_FILES['name'] where name is form file field name
	## 2. $_par = array(
	##		'ext_format'	=>	"(doc|docx|pdf)",
	##		'dir_path'	=>	"docs/resume/",
	##		'new_name'	=>	"200011_ram"
	##		)
	function UploadDocs($_FILE , $_par = array()) // pass argument as $_FILES['name'] for $_FILE where name = fieldname
	{
		$allowed = $_par['ext_format']; // format : "(doc|docx|pdf)";
		
		$FILE = $_FILE["name"];		// alias for $_FILES["file"]["name"]; ie $_FILE = $_FILES['name']
		
		$tmp = $_FILE["tmp_name"];
		
		if(preg_match("/\.".$allowed."$/i", $FILE))
		{
			$fullnamenpath = 'none';
			
			if($_par['new_name'])
			{
				## ratrieve file extension
				$filext = explode('.' , $_FILE["name"]);
				$ext = $filext[1];
		
				$fullnamenpath = $_par['dir_path'].$_par['new_name'].'.'.$ext;
				copy($tmp, $fullnamenpath);
				$uploadedfilename = $_par['new_name'].'.'.$ext;
				
			}else{
				$fullnamenpath = $_par['dir_path'].$FILE;
				copy($tmp, $fullnamenpath);
				$uploadedfilename = $FILE;
			}
			
			return array($fullnamenpath , $uploadedfilename , 'true');
		}else{
			return array('' , '' , 'false');
		}
	}
	
	## pdf upload
	function PDFUpload($field,$dir_path,$filename)
	{
		//echo $_FILES[$field]['type'];
		if($_FILES[$field]['type']=='application/pdf')
		{
			//echo $field;
			$_FILES[$field]['name'] = $filename;
			$uploadfile = $dir_path . $_FILES[$field]['name'];
			//echo $field;
			if(move_uploaded_file($_FILES[$field]['tmp_name'], $uploadfile))return true;
			else return false;
		}
		else return false;
	}
	
	## image upload
	function ImgUpload( $field , $dir_path , $filename ) {
		//echo $_FILES[$field]['type'];
		if($_FILES[$field]['type']=='image/jpeg'||$_FILES[$field]['type']=='image/jpg'||$_FILES[$field]['type']=='image/pjpeg'||$_FILES[$field]['type']=='image/gif')
		{
			$_FILES[$field]['name'] = $filename;
			$uploadfile = $dir_path . $_FILES[$field]['name'];
			//echo $field;
			if(move_uploaded_file($_FILES[$field]['tmp_name'], $uploadfile))return true;
			else return false;
		}
		else return false;
	}
	
	## image upload
	function image_upload( $fieldname , $dir_path , $name ) {
		// $file=name in the form
		// $dir_path = directory path
		// $name = new file name (renamed file name)
		$filename = $_FILES[$fieldname]['name'];
		$ext = explode( "." , $filename );
		
		$uploadfile = $dir_path.$name;
		
		if( $ext[1] == strtolower("jpg") || $ext[1] == strtolower("jpeg") || $ext[1] == strtolower("gif") || $ext[1] == strtolower("png")) {
			if( move_uploaded_file( $_FILES[$fieldname]['tmp_name'] , $uploadfile ) ) {
				return 1;
			} 
			else 
				return false;
		} 
		else
			return false;
	}

	
	### rename upload filename
	function rename_file( $filename , $id , $_pre ) {
		// $filename is the file name in the form field
		// $id is the id of the table
		// $_pre is the name of the related name i.e.  if it is article then basename may be 'ART'
		
		if($filename) {
			$exp = explode('.',$filename);
			$val = $_pre.'_'.$id.'.'.$exp[1];
		}
		return $val;
	}
	
	// Serves an external document for download as an HTTP attachment.
	function download_document($filename, $mimetype = "application/octet-stream")
	{
		if(!file_exists($filename) || !is_readable($filename)) return false;
		$base = basename($filename);
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Disposition: attachment; filename=$base");
		header("Content-Length: " . filesize($filename));
		header("Content-Type: $mimetype");
		readfile($filename);
		exit();
	}
	
	// Retrieves the filesize of a remote file.
	function remote_filesize($url, $user = null, $pw = null)
	{
		ob_start();
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);

		if(!is_null($user) && !is_null($pw))
		{
			$headers = array('Authorization: Basic ' .  base64_encode("$user:$pw"));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}

		curl_exec($ch);
		curl_close($ch);
		$head = ob_get_contents();
		ob_end_clean();

		$regex = '/Content-Length:\s([0-9].+?)\s/';
		preg_match($regex, $head, $matches);

		return isset($matches[1]) ? $matches[1] : "unknown";
	}
	
	// Outputs a filesize in human readable format.
	function bytes2str($val, $round = 0)
	{
		$unit = array('','K','M','G','T','P','E','Z','Y');
		while($val >= 1000)
		{
			$val /= 1024;
			array_shift($unit);
		}
		return round($val, $round) . array_shift($unit) . "B";
	}


?>