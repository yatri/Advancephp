<?php
include 'corelib/functions/function.autoload.php';
$dbConnObj = new dbConn();
//$testObj = new Test();  error
$dbConnObj->connectToDb('localhost','root','','student');
?>
<!DOCTYPE html>
<html>
<head>
	<title>MVC OOP PHP</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="container">
		<div id="wrapper">
        <div class="date">Current Date: <?php echo date("D-m-y"); ?></div><br>

        <span><a class="buttons" href="add_menu.php">>>Go to Nav Menu CPanel</a></span> <a class="buttons" href="index.php">>>Go to home page</a><hr>
        <!--<a style="cursor:pointer; font-weight:bold; color:#eeeeee; background:#687bbf; border-radius:6px 6px 0 0; padding:5px;" href="index.php">Home Page</a>-->        
        <div class="title" style="padding-bottom:7px;">Database Information:</div>
        <span class="title" style="font-size:18px; text-decoration:none; margin-top:-20px;">All tables inside db_student database:</span><span><a href="index.php?view=student&folder=std" style="margin-left:5em; font-weight:bold;">1) Student Table</a><a href="index.php?view=employee&folder=cmpy" style="font-weight:bold; margin-left:5em;">2) Employee Table</a></span><br>
		<br>

