<?php
class user_model{
	//private $user_name;
	//private $pass;
	function __construct(){
		
	}
	function checkIfUserExists($username,$password){
		$password_hash=md5($password);
		$sql="SELECT * FROM user WHERE user_name='$username' AND password='$password_hash'";
		$res=mysql_query($sql);
		$row=mysql_num_rows($res);
		
		if($row==0){
			?><script>window.location.href='index.php?msg=1';</script>
			<?php
		}
		else{
			session_start();
			$_SESSION['user_data']=mysql_fetch_assoc($res);
			?><script>window.location.href='home.php';</script><?php
		}
		
	}
	function createuser($username,$pass){
		$password_hash=md5($pass);
		$sql="SELECT * FROM user WHERE user_name='$username'";
		$res=mysql_query($sql) or die(mysql_error());
		$row=mysql_num_rows($res);
		if($row<1){
			$sqlnew="INSERT INTO user VALUES('','$username','$password_hash')";
			if(mysql_query($sqlnew)){
				?> <script>window.location.href='index.php?view=login&folder=user'</script>
				<?php 
			}
		}
		else{
			
			?> <script>window.location.href='index.php?view=usernew&folder=user&msg=2'</script>
				<?php 
		}
	}
}
?>