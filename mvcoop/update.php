<?php
if ($_POST)
{	
	$id = $_GET['id'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];
	$sql = "UPDATE tbl_student SET s_name='$name',s_address='$address',s_contact='$contact' where s_id='$id'";
	if(mysql_query($sql)){
		//header('Location:index.php?msg=3');
	?><script>window.location.href="index.php?page=student&msg=3";</script><?php
	}
	else { echo "Error while updating";}
	echo $id,$name,$address,$contact;
}
?>