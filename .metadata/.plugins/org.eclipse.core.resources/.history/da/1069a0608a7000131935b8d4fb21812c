<?php
	include_once 'dbconn.php';
	if($_POST){	
		$name = $_POST['name'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$sql = "INSERT INTO tbl_student VALUES('','$name','$address','$contact')";
		if(mysql_query($sql)){
			//header('Location:index.php?msg=1');
			echo 1;
		}
		else{
			echo 0;
		} 
	}
?>