<?php
class dbConn{
    private $hostname;
    private $username;
    private $password;
    private $databasename;
   //this function connect with the mysql database
    function connectToDb($host,$user,$pass,$dbname){
        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->databasename = $dbname;
         mysql_connect($this->hostname,$this->username, $this->password);
        mysql_select_db($this->databasename);
	
    }
}
