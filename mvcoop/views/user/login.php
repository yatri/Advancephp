<?php
	include_once 'controllers/user/class.user.php';
	if($_POST){
		$userobj=new user;
		$userobj->validatefunction();
	}

?>
<form method="post" action="index.php?view=login&folder=user">
	<label>User Name</label>
	<input type="text" name="username" placeholder="Username" /><br />
	<label>Password</label>
	<input type="password" name="pass" placeholder="Password" />
	<input type="submit" value="Login" />
</form>