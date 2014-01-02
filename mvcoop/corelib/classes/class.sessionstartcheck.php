<?php
	
	class sessionstartcheck{
		function __construct(){
			$session=$_SESSION['user_data'];
			if(empty($session)){
				header('location:index.php');
			}
		}
		
	}
?>