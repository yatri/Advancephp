<?php
	$sql="TRUNCATE table tbl_student";
	if(mysql_query($sql)){
		//header('Location:index.php?msg=2');
		?><script>window.location.href="index.php?page=student&msg=2";</script><?php
	}
	else { echo "Error while deleting all rows.";}
?>