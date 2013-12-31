<?php 
    include_once('controllers/student/class.student.php');
    $studentviewObj = new Student;
    $row = $studentviewObj->getAll();
	$retdata=$studentviewObj->search();
 ?>
<h4 class="clearboth" style="margin-top:-5px; padding-bottom:7px;">Student Table :</h4>
        <div class="tblstudent"><!--student table starts here-->
        	<div class="top">
        		<a href="home.php?view=studentnew&folder=std" class="buttons">Add new record</a>
                <a href="home.php?action=student&mode=truncate" class="buttons">Delete all records</a>
               
        	</div>
<table>
	<thead>
		<tr>
			<th>Id</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact</th>
            <th colspan="2">Actions</th>
   		</tr>
	</thead>
    <tbody>
	<?php 
		foreach ($row as $val){
	?>
    	<tr>
        	<td style="text-align:center;"><?php echo $val['s_id'];?></td>
            <td><?php echo $val['s_name'];?></td>
            <td><?php echo $val['s_address'];?></td>
            <td><?php echo $val['s_contact'];?></td>
            <td width="10%" style="text-align:center;">
           		<a href= "home.php?view=studentnew&folder=std&id=<?php echo $val['s_id'];?>" style="font-family:'Times New Roman', Times, serif; font-size:15px; font-weight:bold;">Edit</a>
         	</td>
            <td width="10%">
            	<a href= "home.php?action=student&folder=std&mode=delete&id=<?php echo $val['s_id'];?>" style="font-family:'Times New Roman', Times, serif; font-size:15px; font-weight:bold;">Delete</a>
        	</td>
      	</tr>
  	<?php } ?>
    </tbody>
    <tfoot>
    	<tr>
        	<!-- <td colspan="6" style="color:#06C; text-align:center; font-size:14px;">Total number of rows (data inserted) = <?php echo $ct; ?></td> -->
        </tr>
    </tfoot>
</table><br />
 			<form action="home.php?action=student&folder=std&mode=search">
                	<label>Search with</label>
                	<select name="searchwith">
					  <option value="id">ID</option>
					  <option value="name">Name</option>
					  <option value="address">Address</option>
					
					</select>
                	<input  type="text" name="search" />
                	<input type="submit" value="Search" />
       			</form>
       		
