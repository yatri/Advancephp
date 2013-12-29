<?php
	/*
		PURPOSE		:	Data Encryption and Decryption(256 bit encryption)
		VERSION		:	1.0.0
		AUTHOR		:	
		DATE		:	2003-03-30
		
		Look in components for latest version of clsCypher
	*/
	
	class Cypher
		{
			//===================================================================================================================
			/*
				PURPOSE	:	Encrypt Data
				IN		:	$KEY --> Key that is to be used in  data encryption
							$DATA --> Data to encrypt
				OUT		:	Encrypted Data($cypher)
			*/
			function encrypt($KEY,$DATA)
				{
					$key	=	$this->process_key($KEY);
					$data	=	$this->process_message(chop($DATA));
					
					$digest	=	md5($data);
					$keyst	=	$key;
					
					while(strlen($key) < strlen($data))
						{
							$key .= $keyst;
						}
					
					$data	=	$key ^ $data;
					
					$data	=	bin2hex($data);
					$cipher	=	$digest . "|" . $data;
					return $cipher;
				}
			//===================================================================================================================
			
			//===================================================================================================================
			/*
				PURPOSE	:	Decrypt Data
				IN		:	$KEY --> Key that was used during data encryption
							$DATA --> Data to decrypt
				OUT		:	Original Data($data)
			*/
			function decrypt($KEY,$DATA)
				{
					$key	=	$this->process_key($KEY);
					$cypher	=	$this->process_cypher($DATA);
					
					list($digest, $data) = explode("|", $cypher);
					$data	=	$this->hex2bin($data);
					$keyst	=	$key;
					
					while(strlen($key) < strlen($data))
						{
							$key .= $keyst;
						}
					
					$data	=	$key ^ $data;
		
					$new_digest	=	md5($data);
					
					if ($digest != $new_digest)
						{
							//changed : 2003-04-01 (depace)
							//$check = "<b>Message Authentication Failed</b>";
							$check	=	"ERROR";
							return "$check";
						}
					else
						return $data;
				}
			//===================================================================================================================
			
			//===================================================================================================================
			//function to check if the message is authenticated or not
			function CheckMessage($ENC_MSG)
				{
					//TODO 2003-04-02
					if($ENC_MSG != "ERROR")
						return $ENC_MSG;
				}//end of function
			//===================================================================================================================
			
			//===================================================================================================================
			/*
				PURPOSE	:	Process Key
				IN		:	$keyinput --> Key
			*/
			function process_key($keyinput)
				{
					if(@!eregi("[^ \t\n\r\f\v]+",$keyinput))
						{
							echo "<div align=\"center\"><font color=\"red\"> ERROR!  Please enter your key for this message!</font></div><p>\n";
							exit;
						}
					$keyinput = @eregi_replace("[\"\\\/\+\-\&\*\:\;\.\<\>\?\=]+", "", $keyinput);
					$allowed_tags = ""; 
					$keyinput = strip_tags($keyinput, $allowed_tags);
					$keyinput = stripslashes($keyinput);
					
					return $keyinput;
				}
			//===================================================================================================================
			
			//===================================================================================================================
			/*
				PURPOSE	:	Process Message
				IN		:	$messageinput --> Data
			*/
			function process_message($messageinput)
				{
			
					if(@!eregi("[^ \t\n\r\f\v]+",$messageinput))
						{
							echo "<div align=\"center\"><font color=\"red\"> ERROR!  Please enter a message to encrypt!</font></div><p>\n";
							exit;
						}
					$messageinput = stripslashes($messageinput);
					
					return $messageinput;
				}
			//===================================================================================================================
			
			//===================================================================================================================
			/*
				PURPOSE	:	Process Encrypted Data
				IN		:	$cypherinput --> Encrypted Data
			*/
			function process_cypher($cypherinput)
				{
			
					if(@!eregi("[^ \t\n\r\f\v]+",$cypherinput))
						{
							echo "<div align=\"center\"><font color=\"red\"> ERROR!  Please enter a message cypher to decrypt!</font></div><p>\n";
							exit;
						}
					$cypherinput = @eregi_replace("[\"\\\/\+\-\&\*\:\;\.\<\>\?\=]+", "", $cypherinput);
					$allowed_tags = ""; 
					$cypherinput = strip_tags($cypherinput, $allowed_tags);
					$cypherinput = stripslashes($cypherinput);
					
					return $cypherinput;
				}
			//===================================================================================================================
			
			//===================================================================================================================
			/*
				PURPOSE	:	Convert from hex to binary
				IN		:	$data
			*/
			function hex2bin($data)
				{ 
					$len = strlen($data); 
					return @pack("H" . $len, $data); 
				}
			//===================================================================================================================
		}//end of class
?>