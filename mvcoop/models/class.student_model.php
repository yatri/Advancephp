<?php 

class student_model{
	private $id;
	private $name;
	private $address;
	private $contact;
	
	function __construct(){
	
	}

	function returnAll(){
		$query_Recordset1 = "SELECT * FROM tb1_student ORDER BY s_id ASC";
		$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
		$row=array();
		while($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
			$row[]=$row_Recordset1;
			
		}
		return $row;
	}
	function update($s_id,$s_name,$s_address,$s_contact){
		$this->id=$s_id;
		$this->name=$s_name;
		$this->address=$s_address;
		$this->contact=$s_contact;
				
		$sql= "UPDATE tb1_student SET s_name='$this->name',s_address='$this->address',s_contact='$this->contact' WHERE s_id='$this->id'";
		if(mysql_query($sql)){
			?><script>window.location.href='index.php?view=student&msg=3';</script><?php
		}
		else {
			echo "error in editing";
		}
	}
	function adstudent($s_name,$s_address,$s_contact){
		$this->name=$s_name;
		$this->address=$s_address;
		$this->contact=$s_contact;
		$sql="INSERT INTO tb1_student VALUES('','$this->name','$this->address','$this->contact')";
		if(mysql_query($sql)){
			?> <script>window.location.href='index.php?view=student&msg=1';</script> <?php
		}
		else { echo "Error while inserting.";
		}
	}
}


