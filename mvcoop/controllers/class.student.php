<?php 
require 'models/class.student_model.php';
class student{


	function __construct(){
		
	}

	function getAll(){
		$studentmodelObj = new student_model();
		$retdata = $studentmodelObj->returnAll();
		return $retdata;

	}
	function addnew(){
		$sid=$_POST['editid'];
		$studentmodelObj = new student_model();
		if($_POST){
			$sname=$_POST['name'];
			$address=$_POST['address'];
			$contact=$_POST['contact'];
		}
		if($sid){
			$studentmodelObj->update($sid,$sname,$address,$contact);
		}
		else{
			$studentviewObj->addstudent($name,$address,$contact);
		}
		
	}
	function deleteStudent(){
		$s_id=@$_GET['id'];
		$studentmodelObj = new student_model();
		$studentmodelObj->deletestd($s_id);
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
		default:

		}
	}


