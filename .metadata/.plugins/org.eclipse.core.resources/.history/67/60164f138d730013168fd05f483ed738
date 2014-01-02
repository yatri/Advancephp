<?php
	include 'corelib/functions/function.autoload.php';
	$dbConnObj = new dbConn();
	//$testObj = new Test();  error
	$dbConnObj->connectToDb('localhost','root','','student');
	
	if(@$_GET['view']){
		if(@$_GET['folder']=='user'){
			include_once 'views/user/'.$_GET['view'].'.php';
		}
		
	}
	else {
		include 'views/user/login.php';
	}