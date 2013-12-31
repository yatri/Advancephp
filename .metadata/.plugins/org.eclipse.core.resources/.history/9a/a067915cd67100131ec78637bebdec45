<?php 
    include_once('controllers/employee/class.employee.php');
    $employeeviewObj = new employee;
    $row =   $employeeviewObj->getAll();
 ?>
<h4 class="clearboth" style="margin-top:-5px; padding-bottom:7px;">Employee Table :</h4>
        <div class="tblstudent"><!--student table starts here-->
        	<div class="top">
        		<a href="index.php?view=employeenew&folder=cmpy" class="buttons">Add new record</a>
                <a href="index.php?action=employee&mode=truncate" class="buttons">Delete all records</a>
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
        	<td style="text-align:center;"><?php echo $val['e_id'];?></td>
            <td><?php echo $val['e_name'];?></td>
            <td><?php echo $val['e_address'];?></td>
            <td><?php echo $val['e_contact'];?></td>
            <td width="10%" style="text-align:center;">
           		<a href= "index.php?view=employeenew&folder=cmpy&id=<?php echo $val['e_id'];?>" style="font-family:'Times New Roman', Times, serif; font-size:15px; font-weight:bold;">Edit</a>
         	</td>
            <td width="10%">
            	<a href= "index.php?action=employee&folder=cmpy&mode=delete&id=<?php echo $val['e_id'];?>" style="font-family:'Times New Roman', Times, serif; font-size:15px; font-weight:bold;">Delete</a>
        	</td>
      	</tr>
  	<?php } ?>
    </tbody>
    <tfoot>
    	<tr>
        	<!-- <td colspan="6" style="color:#06C; text-align:center; font-size:14px;">Total number of rows (data inserted) = <?php echo $ct; ?></td> -->
        </tr>
    </tfoot>
</table>
