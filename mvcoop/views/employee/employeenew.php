<?php
	@$id=$_GET['id'];
	
	if(@$_GET['id']){
		
		include_once 'controllers/employee/class.employee.php';
		$enployeeobj=new employee();
		$data=$enployeeobj->getsinglerow($id);
	}
	
	
?>
<style>
	.error { font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#F00;}
</style>
<h4 class="clearboth" style="margin-top:-5px;">Employee Table :</h4>
        <div class="tblstudent"><!--company table starts here-->
        	<div class="top">
        		<a href="home.php?view=studentnew&folder=cmpy" class="buttons">Add new record</a>
                <a href="home.php?page=newmulti" class="buttons">Add new multi record</a>
                <a href="home.php?action=employee&folder=cmpy&mode=truncate" class="buttons">Delete all records</a>
        	</div>
            
            
<form method="post" id="addstudent" action="home.php?action=employee&folder=cmpy&mode=add">
<p>
<label>Name:</label>
<input id="name" type="text" name="name"  style="width:200px;" value="<?php echo @$data['e_name']; ?>" placeholder="Enter your name">
<span class="error"></span>
<input type="hidden" value="<?php echo @$id; ?>" name="editid" />
</p>
<p>
<label>Address:</label>
<input type="text" id="address" name="address" style="width:250px;" value="<?php echo @$data['e_address']; ?>"  placeholder="Enter address">
<span class="error"></span>
</p>
<p>
<label>Contact No.:</label>
<input type="text" id="contact" name="contact" value="<?php echo @$data['e_contact'] ?>"  placeholder="Enter contact no.">
<span class="error"></span>
</p>
<p>
<input type="submit" value="Save" class="buttons" style="border:none; height:25px;">
<a href="home.php?view=employee&folder=cmpy" class="buttons">Cancel</a>
</p>
</form>
