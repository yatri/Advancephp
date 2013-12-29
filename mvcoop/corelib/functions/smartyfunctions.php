<?PHP

/*
File smartyfunctions.php
created date: MOnday July 6th 2009 
## according to study and research
Start time : 10:30 AM 
End time : 12:22 PM
created by Sanjay Khadka <sanjay@mountdigit.com> <sanjay.khadka@hotmail.com>
*/


	/**
	Smarty Block
	file_exists block for smarty
	checks whether file exists or not 
	Eg. call from tpl file
	{file_exists file="js/jquery-1.2.6.js"}
		<script language="javascript" type="text/javascript" src="js/jquery-1.2.6.js"></script>
    	{file_exists file="js/jquery-ui-personalized-1.6b.packed.js"}
    		<script language="javascript" type="text/javascript" src="js/jquery-ui-personalized-1.6b.packed.js"></script>
    	{/file_exists}
	{/file_exists}
	*/
	function smarty_file_exists($params, $content, &$smarty, &$repeat)
	{
   		if (file_exists($params['file'])) {
       		return $content;
   		}
	}
	
	/**
	Smarty MOdifier
	concat modifier for smarty
	concats to string
	@@params : $string - first string, $concat - second string
	Eg. calling from inside of tpl file :
	{"images/"|concat:$val.image_name}
	*/	
	function smarty_modifier_concat($string, $concat)
	{ 
		if($concat)
			$concatedstring = $string.$concat;
		else 
			$concatedstring = $string.'noimage';
		
		return $concatedstring;
	}
	
	/**
	Smarty modifier
	file exists modifier
	checks if file exists or not
	returns 1 or 0
	*/
	function smarty_modifier_filexists($file)
	{
		//die('called');
		//echo 'hererer';
		return file_exists($file);
	}
	
	
	
	
/*
usage of smarty block
#php file
function smarty_file_exists($params, $content, &$smarty, &$repeat)
{
    if (file_exists($params['file'])) {
        return $content;
    }
}
$oSmarty->register_block('file_exists', 'smarty_file_exists');
	
	
# tpl file	
{file_exists file="js/jquery-1.2.6.js"}
<script language="javascript" type="text/javascript" src="js/jquery-1.2.6.js"></script>
    {file_exists file="js/jquery-ui-personalized-1.6b.packed.js"}
    <script language="javascript" type="text/javascript" src="js/jquery-ui-personalized-1.6b.packed.js"></script>
    {/file_exists}
{/file_exists}	
*/