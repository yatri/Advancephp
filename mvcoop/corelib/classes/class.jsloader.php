<?PHP
//defined(); or die();

// class jsloader ver 1.0
// created by sanjay khadka
// url: http://www.sanjaykhadka.com.np
// created date: 1st Jan 2009
// last modified: 26th jan 2009

/*
#################### functions overview 
function __construct()       -> initializes jsloader object instance
function loadPrototype()     -> loads prototype
function loadScriptaculous() -> loads scriptaculous
function loadJquery()        -> loads jquery library    
function loadJScript()        -> loads javascript
function loadTinyMCE()       -> loads tinyMCE editor
function dGCalen()           -> loads dhtmlgoodiescalender
	
#################### examples of using functions 
##### example usage of loadTinyMCE
	1. Initialize JSLoader object 
		$tm = new JSLoader();
	2. Provide text editor properties as array
		$arr_attribute = array(
								'editor_type' => 'advanced', //simple or advanced
								'mode' => 'exact', //exact or textareas
								'id' => 'article_content',
								'name' => 'article_content', 
								'rows' => '15',
								'cols' => '50',
								'width' => '80',
								'value' => ''
							);
	3. Call function 
		$editor = $tm->loadTinyMCE( DDS , $arr_attribute ); //from admin
		$editor = $tm->loadTinyMCE( '' , $arr_attribute ); //from frontend
		
##### example usage of loadJScript
	1. Initialize JSLoader object 
		$tm = new JSLoader();
	2. Provide file path as array or as string
		As array 
		$jsfile = array(
								//PATH								//FILE
								'../js/'					=>		'jsfunctions', //simple or advanced // .js extension is optional
								'modules/product/js/'		=>		'product.js', //exact or textareas // .js extension is optional
								.....						=>		.....
							);
							
		As string
		// for single js file call 
		// for multiple file call you have to repeatedly call the function by providing file path every time
		$jsfile = '../js/jsfunctions.js'; //.js is optional 
	3. Call function 
		$editor = $tm->loadJScript( $jsfile ); //from admin or frontend
		
##### example usage of dGCalen function
	1. Initialize object
	2. call function 
		dGCalen( DDS.LIB_PATH )  // for admin - use constants DDS.LIB_URL for admin
		dGCalen( LIB_PATH )  // for frontend - use constant LIB_URL for frontend

*/	
	
	
	######## 
	
	/**
	* Javascript Manager/Loader
	*
	*/
	class JSLoader {
/*		function __construct( $_filename = NULL , $_path = NULL ) {
			
			### loading application specific javascript directly from constructor, 
			### bettr option is to use loadScript() function (recommended)
			if( $_filename != NULL ) {
				//echo $_path.$_filename;
				if( $_path == NULL ) $_path = DOC_ROOT.'/js/'; //define path as required
				echo '<script src="'.$_path.$_filename.'.js"></script>';
			}
			if($_filename == NULL) {
				echo '<script src="js/functions.js"></script>';
			}
			
		}*/

		### For singleton pattern
		static $instance;
		
		#### constructor ####
		public function __construct() {
			if (!self::$instance) {
				self::$instance = $this;
				//echo "New Instance\n";
				return self::$instance;
			} else {
				//echo "Old Instance\n";
				return self::$instance;
			}
		}

		/**
		* Prototype libraries
		*
		* 
		*/
		function loadPrototype() {
			//$base = base::baseUrl();
			$base = DOC_ROOT;
			//echo "<script type='text/javascript' src='{$base}/core/js/gzip.php?js=prototypec.js'>\n";
			echo "<script type='text/javascript' src='{$base}/js/gzip.php?js=prototypec.js'>\n";
		}
		
		/**
		* Scriptaculous libraries
		*
		* 
		*/
		function loadScriptaculous()
		{
			$base = DOC_ROOT;
			echo "<script type='text/javascript' src='{$base}/js/gzip.php?js=scriptaculousc.js'>\n";
		}
		
		function loadProtaculous()
		{
			$base = DOC_ROOT;
			echo "<script type='text/javascript' src='{$base}/js/gzip.php?js=prototypec.js'>\n";
			echo "<script type='text/javascript' src='{$base}/js/gzip.php?js=scriptaculousc.js'>\n";
		}
		
		function loadJquery()
		{
			$base = DOC_ROOT;
			echo "<script type='text/javascript' src='{$base}/js/gzip.php?js=jqueryc.js'>\n";
		}
		
		/**
		* app specific libraries
		*
		* @param string $filename
		*/
		function loadJScript($_file_path = NULL , $_echo = 0)
		{
			//$base = DOC_ROOT;
			//$script = $base."/app/js/{$filename}.js";
			//echo "<script type='text/javascript' src='{$base}/js/gzip.php?js={$script}'>\n";
			if(is_array($_file_path) )
			{
				foreach($_file_path as $path => $file)
				{
					if(substr_compare($file, ".js", -3, 3) == 0)
						$file .= '';
					else 
						$file .= '.js'; 
					
					if($_echo == 1) 
						echo  "<script type='text/javascript' src='".$path.$file."'></script>";
					else
						$script[] = "<script type='text/javascript' src='".$path.$file."'></script>";
				}
			}
			else
			{
				if(substr_compare($_file_path, ".js", -3, 3) == 0)
					$_file_path .= '';
				else 
					$_file_path .= '.js';
					
				if($_echo == 1) 
					echo  "<script type='text/javascript' src='".$_file_path."'></script>";
				else
					$script[] = "<script type='text/javascript' src='".$_file_path."'></script>";
			}
			
			//echo $script;
			if($_echo == 0)
			{
				return $script;
			}
		}
		
		/**
		* TinyMCE editor
		*
		* @param 
		*/
		function loadTinyMCE( $_DDS = '' , $attr_val ) //dot dot slash  for access from admin
		{ 	
			## mode is either 'textareas' or 'exact' .. may be others are also available, i dont know
			
			echo '<script type="text/javascript" src="'.$_DDS.'library/tiny_mce/tiny_mce.js"></script>';
			
			$editor =  '<script type="text/javascript">
						tinyMCE.init({
							// General options
							mode : "'.$attr_val['mode'].'",
							theme : "'.$attr_val['editor_type'].'",
							plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
					
							// Theme options
							theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
							theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
							theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
							theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
							theme_advanced_toolbar_location : "top",
							theme_advanced_toolbar_align : "left",
							theme_advanced_statusbar_location : "bottom",
							theme_advanced_resizing : true,
					
							// Example content CSS (should be your site CSS)
							content_css : "css/content.css",
							elements : "'.$attr_val['id'].'",
					
							// Drop lists for link/image/media/template dialogs
							template_external_list_url : "lists/template_list.js",
							external_link_list_url : "lists/link_list.js",
							external_image_list_url : "lists/image_list.js",
							media_external_list_url : "lists/media_list.js",
					
							// Replace values for the template plugin
							template_replace_values : {
								username : "Some User",
								staffid : "991234"
							}
						});
					</script>
					';
			//}
			
			//<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
			$editor .= '<textarea id="'.$attr_val['id'].'" name="'.$attr_val['name'].'" rows="'.$attr_val['rows'].'" cols="'.$attr_val['cols'].'" style="width: '.$attr_val['width'].'%">'.$attr_val['value'].'</textarea>';
			
			return $editor;
		}
		
		/**
		* TinyMCE editor with ajax file manager
		* tinymce3.2.1.1 downloaded from http://www.phpletter.com/
		* @param 
		*/
		function TinyMCEAFM( $_DDS = '' , $attr_val ) //dot dot slash  for access from admin
		{ 	
			
			echo '<script type="text/javascript" src="'.$_DDS.'library/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
			
			$editor =  '<script language="javascript" type="text/javascript">
					tinyMCE.init({
						mode : "exact",
						elements : "'.$attr_val['id'].'",
						theme : "advanced",
						plugins : "advimage,advlink,media,contextmenu",
						theme_advanced_buttons1_add_before : "newdocument,separator",
						theme_advanced_buttons1_add : "fontselect,fontsizeselect",
						theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
						theme_advanced_buttons2_add_before: "cut,copy,separator,",
						theme_advanced_buttons3_add_before : "",
						theme_advanced_buttons3_add : "media",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						extended_valid_elements : "hr[class|width|size|noshade]",
						file_browser_callback : "ajaxfilemanager",
						paste_use_dialog : false,
						theme_advanced_resizing : true,
						theme_advanced_resize_horizontal : true,
						apply_source_formatting : true,
						force_br_newlines : true,
						force_p_newlines : false,	
						relative_urls : true
					});
			
					function ajaxfilemanager(field_name, url, type, win) {
						var ajaxfilemanagerurl = "../../../../jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
						switch (type) {
							case "image":
								break;
							case "media":
								break;
							case "flash": 
								break;
							case "file":
								break;
							default:
								return false;
						}
				    tinyMCE.activeEditor.windowManager.open({
					url: "../../../../jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
					width: 782,
					height: 440,
					inline : "yes",
					close_previous : "no"
				    },{
					window : win,
					input : field_name
				    });
				    
					}
				</script>';
			//}
			
			//<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
			$editor .= '<textarea id="'.$attr_val['id'].'" name="'.$attr_val['name'].'" rows="'.$attr_val['rows'].'" cols="'.$attr_val['cols'].'" style="width: '.$attr_val['width'].'%">'.$attr_val['value'].'</textarea>';
			
			/*$editor .= '<textarea id="ajaxfilemanager" name="ajaxfilemanager" style="width: 100%; height: 6000px"><h1>Ajax File/Image Manager Plugin</h1>
	<p>
		<b>Author:</b> Logan Cai<br>
		<b>Website:</b> <a href="http://www.phpletter.com">http://www.phpletter.com</a>
		<b>Forum:</b> <a href="http://www.phpletter.com/forum">http://www.phpletter.com/forum</a>
	</p>
		
	</textarea>';*/
			
			return $editor;
		}
		
		/**
		* This function loads dhtml Goodies Calendar
		*
		* @param $_PATH_LIB string
		*/
		function dGCalen( $_PATH_LIB ) {
			# load css
			echo '<link type="text/css" rel="stylesheet" href="'.$_PATH_LIB.'dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>';
			# load javascript
			echo '<SCRIPT type="text/javascript" src="'.$_PATH_LIB.'dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>';
		}
		
		/**
		* This function loads sexy alert box
		*
		* @param $_PATH_LIB string
		*/
		function SexyAlertBox( $_PATH_LIB ) {
			#load mootools
			echo '<script src="'.$_PATH_LIB.'SexyAlertBox/mootools.js" type="text/javascript"></script>'; // later on will be included globally
			//$this->loadMootools();
            # load css
			echo '<link rel="stylesheet" href="'.$_PATH_LIB.'SexyAlertBox/sexyalertbox.css" type="text/css" media="all" />';
			echo '<script src="'.$_PATH_LIB.'SexyAlertBox/sexyalertbox.packed.js" type="text/javascript"></script>';


			echo "<script type=\"text/javascript\">
            	window.addEvent('domready', function() {
                	Sexy = new SexyAlertBox();
            	});
				</script>";
		}
		
		function tooltip( $_PATH_LIB ) {
			echo '<link rel="stylesheet" type="text/css" href="'.$_PATH_LIB.'tooltip/style.css" />';
			echo '<script type="text/javascript" language="javascript" src="'.$_PATH_LIB.'tooltip/script.js"></script>';
		}
	}
	
	