<?php 

class employee_model{
	private $id;
	private $name;
	private $address;
	private $contact;
	
	function __construct(){
	
	}

	function returnAll(){
		$query_Recordset1 = "SELECT * FROM employee ORDER BY e_id ASC";
		$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
		$row=array();
		while($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
			$row[]=$row_Recordset1;
			
		}
		return $row;
	}
	function getonerow($sid){
		$this->id=$sid;
		$query_Recordset1 = "SELECT * FROM employee WHERE e_id=$this->id";
		$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
		$data=mysql_fetch_assoc($Recordset1); //mysql_fetch_assoc($res) for one row result
		return $data;
	}
	
	function update($s_id,$s_name,$s_address,$s_contact){
		$this->id=$s_id;
		$this->name=$s_name;
		$this->address=$s_address;
		$this->contact=$s_contact;
				
		$sql= "UPDATE employee SET e_name='$this->name',e_address='$this->address',e_contact='$this->contact' WHERE e_id='$this->id'";
		if(mysql_query($sql)){
			?><script>window.location.href='home.php?view=student&msg=3';</script><?php
		}
		else {
			echo "error in editing";
		}
	}
	function addemployee($s_name,$s_address,$s_contact){
		$this->name=$s_name;
		$this->address=$s_address;
		$this->contact=$s_contact;
		$sql="INSERT INTO employee VALUES('','$this->name','$this->address','$this->contact')";
		if(mysql_query($sql)){
			?> <script>window.location.href='home.php?view=student&msg=1';</script> <?php
		}
		else {
			 echo "Error while inserting.";
		}
	}
	function deleteemployee($s_id){
		$this->id=$s_id;
		
		$sql="DELETE FROM employee WHERE e_id='$this->id'";
		if(mysql_query($sql)){
			?><script>window.location.href="home.php?page=student&msg=4";</script><?php
		}
		else {
			echo"error while deleting data";
		}
	}
	function truncatetable(){
		$sql="TRUNCATE table employee";
		if(mysql_query($sql)){
			//header('Location:home.php?msg=2');
			?><script>window.location.href="home.php?page=student&msg=2";</script><?php
		}
		else {
		 	echo "Error while deleting all rows.";
		}	
	}
}
?>


