<?php include_once('includes/header.php'); ?>

		<?php 
		if(@$_GET['msg']){ //show div class notify only if get 'msg'
					?>
		<div class="notify">
        	<p>
            		<?php
							if(@$_GET['msg']==1){
								echo "One row Added Successfully";
							}
							else if($_GET['msg']==2){
								echo "All rows have been deleted";
							}
							else if(@$_GET['msg']==3){
								echo "Your record updated successfully.";
							}
							else if($_GET['msg']==4){
								echo "Selected row has been deleted successfully";
							}
					?>
            </p>
        </div>
<?php } ?>
		<?php 
				$folder=@$_GET['folder'];
			
				if($folder=='std'){
					if(@$_GET['view']){
						include 'views/student/'.$_GET['view'].'.php';
					}
					if(@$_GET['action']){
						include 'controllers/student/'.'class.'.$_GET['action'].'.php';
					}
					
				}
				else if($folder=='cmpy'){
					if(@$_GET['view']){
						include 'views/employee/'.$_GET['view'].'.php';
					}
					if(@$_GET['action']){
						include 'controllers/employee/'.'class.'.$_GET['action'].'.php';
					}
				}
				elseif ($folder=='user') {
						
					include 'controllers/user/'.'class.'.$_GET['action'].'.php';
				}
					
				
				else{
						include 'welcome.php';
					}
			
		?>
<?php include_once('includes/footer.php'); ?>
        
