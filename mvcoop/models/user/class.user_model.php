<?php
class user_model{
	//private $user_name;
	//private $pass;
	function __construct(){
		
	}
	function checkIfUserExists($username,$password){
		$sql="SELECT * FROM user WHERE user_name='$username' AND password='$password'";
		$res=mysql_query($sql);
		$row=mysql_num_rows($res);
		
		if($row==0){
			?><script>window.location.href='index.php?view=login';</script>
			<?php
		}
		else{
			session_start();
			$_SESSION['user_data']=mysql_fetch_assoc($res);
			?><script>window.location.href='home.php';</script><?php
		}
		
	}
}
?>