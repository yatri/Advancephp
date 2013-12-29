<?php
	if($_POST){	
		$name = $_POST['name'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$sql = "insert into tbl_student values('','$name','$address','$contact')";
		if(mysql_query($sql)){
			header('Location:index.php?msg=1');
		}
	}
?>
<h4 class="clearboth" style="margin-top:-5px;">tbl_company :</h4>
        <div class="tblstudent"><!--company table starts here-->
        	<div class="top">
        		<a href="index.php?page=new" class="buttons">Add new record</a>
                <a href="index.php?page=newmulti" class="buttons">Add new multi record</a>
                <a href="index.php?page=deleteall" class="buttons">Delete all records</a>
        	</div>
            
            
<form method="post" action="index.php?page=new">
<p>
<label>Name:</label>
<input id="name" name="name" required="required" style="width:200px;">
<label style="margin-left:150px;">Name:</label>
<input id="name2" name="name2" required="required" style="width:200px;">
</p>
<p>
<label>Address:</label>
<input type="text" id="address" name="address" style="width:250px;" required="required">
<label style="margin-left:84px;">Address:</label>
<input type="text" id="address2" name="address2" style="width:250px;" required="required">
</p>
<p>
<label>Contact No.:</label>
<input type="tel" id="contact" name="contact" required="required">
<label style="margin-left:155px;">Contact No.:</label>
<input type="tel" id="contact2" name="contact2" required="required">
</p>
<p>
<input type="submit" value="Save" class="buttons" style="border:none; height:25px;">
<a href="index.php?page=student" class="buttons">Cancel</a>
</p>
</form>
