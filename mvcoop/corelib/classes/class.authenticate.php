<?PHP
	
	class Authenticate {
		###############################################
		/*
			PURPOSE		:	To check whether the username exists or not
			AUTHOR		:	depace <depace@mountdigit.com>
			MODIFIED BY : 	sanjay <sanjay@mountdigit.com>
			IN			:	String	-->	username
			OUT			:	Boolean	--> TRUE/FALSE
							ERROR	--> if any other circumstances occured
		*/
		function CheckValidUser($table, $uidfield, $ufield = "", $pfield = "")
		{
			if(@$_SESSION["USER"]["LOGIN"] == 'TRUE')
			{
				@$UNAME	=	$_SESSION["USER"]["USERNAME"];
				@$UID	=	decryptData($_SESSION["USER"]['UID']);
				if($pfield)
					@$PASSWD	=	$_SESSION["USER"]['PWD'];
				
				//$USERTYPE	=	$_SESSION["USER"]['USERTYPE'];
				
				//if($USERTYPE == 'employer')
				//{
				//}
				
				$strSql	=	"SELECT * FROM $table WHERE $ufield = '{$UNAME}' AND $uidfield = '{$UID}' AND status = 'active'";
				if($pfield)
					$strSql .= " AND $pfield = '{$PASSWD}' ";
				
				//echo $strSql;	
				
				$dbSql	=	mysql_query($strSql);
				
				$intTotal	=	mysql_num_rows($dbSql);
				
				if($intTotal != 0)
					return "TRUE";
				elseif($intTotal == 0)
					return "FALSE";
			}
			else 
			{
				return "FALSE";
			}
		}//end of function
		
		/**
		PURPOSE	:	To check login
		IN		:	String	--> Username/Password
		OUT		:	Bollean	--> TRUE/FALSE
					ERROR	--> if any other circumstances occured
		*/
		function CheckLogin($UNAME , $PASSWD , $table, $ufield, $pfield, $memberstatus = " |N| ")
		{
			//include_once('corelib/classes/class.cypher.php');
			//format $UID
			//$UID	=	strtolower($UID);
			//echo $PASSWD	=	strtolower($PASSWD);
			//echo '<br>';
			$objCypher	=	New cypher();
			$PASSWD		=	$objCypher->encrypt(AUTH_SALT , $PASSWD);
			//die();
			$strSql = "SELECT * FROM $table WHERE $ufield = '$UNAME' AND $pfield = '$PASSWD'";
			
			### check if member is enabled or disabled // if option of member to be active or inactive
			$sepstat = explode('|' , $memberstatus);
			$sfield = $sepstat[0];
			$checkstatus = $sepstat[1];
			$statusvalue = $sepstat[2];
			if($checkstatus == 'Y')
				$strSql .= " AND $sfield = '$statusvalue'";
			
			## test query
			//echo $strSql;
			//die();
			
			$dbSql = mysql_query($strSql);
			
			$_SESSION['INFO'] 	=	mysql_fetch_assoc($dbSql);
			//debug($_SESSION['INFO'],1);
			
			$_SESSION["USER"]["LOGIN"]	=	"FALSE";
			
			$intTotal	=	mysql_num_rows($dbSql);
			
			if($intTotal != 0)
				return "TRUE";
			elseif($intTotal == 0)
				return "FALSE";
		}//end of function
		
		
	}