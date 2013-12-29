<?php
$id = $_GET['id'];
$sql = "DELETE from tbl_student where s_id='$id'";
if(mysql_query($sql)){
	//header('Location:index.php?msg=4');
	?><script>window.location.href="index.php?page=student&msg=4";</script><?php
}
else { echo "Error while deleting a selected row";}
?>