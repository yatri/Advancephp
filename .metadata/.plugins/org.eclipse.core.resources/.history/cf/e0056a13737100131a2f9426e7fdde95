<?php 
require 'models/student/class.student_model.php';
class student{
	private $id;
	
	function __construct(){
		
	}

	function getAll(){
		$studentmodelObj = new student_model();
		$retdata = $studentmodelObj->returnAll();
		return $retdata;

	}
	
	function getsinglerow($id){
		$this->id=$id;
		$studentmodelobj=new student_model();
		$val=$studentmodelobj->getonerow($this->id);
		return $val;
	}
	
	function addnew(){
		$sid=$_POST['editid'];
		$studentmodelObj = new student_model();
		if($_POST){
			$sname=$_POST['name'];
			$saddress=$_POST['address'];
			$scontact=$_POST['contact'];
		}
		if($sid){
			$studentmodelObj->update($sid,$sname,$saddress,$scontact);
		}
		else{
			$studentmodelObj->addstudent($sname,$saddress,$scontact);
		}
		
	}
	function deleteStudent(){
		$s_id=@$_GET['id'];
		$studentmodelObj = new student_model();
		$studentmodelObj->deletestd($s_id);
	}
	function deleteallrecord(){
		$studentmodelobj=new student_model();
		$studentmodelobj->truncatetable();
	}
}//end of class
//for add and edit operations
if(@$_GET['mode']){
	$studentObj = new student();
	$mode = $_GET['mode'];
	switch($mode){
		case 'add':
			$studentObj->addNew();
		break;
		case 'delete':
			$studentObj->deleteStudent();
			break;
		case 'truncate':
			$studentObj->deleteallrecord();
			break;
		default:

		}
	}


