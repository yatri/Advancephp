<?PHP
	# last modified date: 07.02.2009
	# last ver 28.06.2008
	# Autoload file
	# Created by Sanjay Khadka
	# copyright sanjaykhadka.com.np - checksanjay2000@yahoo.com
	
		/**
		 * Autoload magic method that automatically invokes the particular or respective Class or Interfaces 
		 *
		 * @param $class_name string
		 */
		function __autoload($class_name)   //$class_name may be classname or interfacename
		{
			//echo '<br>'.$class_name;
			try {
//				if($class_name{0} == 'I') {	
//					$interface_name = trim($class_name , 'I');
//					$include = DOC_ROOT . '/corelib/interfaces/interface.' . strtolower($interface_name) . '.php';
//					
//					$msg = buildError('i' , $class_name);
//					includeFile($include , $msg);
//				}
//				else
//				{ 
//					$include = DOC_ROOT . '/corelib/classes/class.' . strtolower($class_name) . '.php';
//					
//					$msg = buildError('c' , $class_name);
//					includeFile($include , $msg);
//				}

				$class['interface_name'] = trim($class_name , 'I');
				$class['class_name'] = $class_name;
				$include['interface'] = DOC_ROOT . '/corelib/interfaces/interface.' . strtolower($class['interface_name']) . '.php';
				$include['class'] = DOC_ROOT . '/corelib/classes/class.' . strtolower($class['class_name']) . '.php';
				$msg = buildError($class);
				includeFile($include , $msg);
				
			} catch (Exception $e) {
				//trigger_error("Unable to load class: {$class_name}", E_USER_WARNING);
				//echo $e->getMessage();
				die($e->getMessage());
			}
			
			/*
				eg. usage of trimming character - trim will wipe out either 1st or last character only
				$a = IRATion;
				echo $a;
				echo '<br>='.trim($a, 'I');
				result = RATion
			*/
		}
		
		function includeFile($include , $msg) {
			if(file_exists($include['interface'])) {
				require $include['interface'];
				
			}
			else if(file_exists($include['class'])) { 
				require $include['class'];
			}
			else throw new Exception($msg);
		}
		
		function buildError($class , $_par = '') {
			if($_par == 'i') {
				$a = 'Interface'; 
			}
			if($_par == 'c') {
				$a = 'Class';
			}
			
			//$msg = "<strong>Unable to load {$a}:</strong> <span style=\"color:blue; font-weight:bold;\">{$class_name}</span><br>";
			$msg = "<strong>Unable to load class or interface:</strong> <span style=\"color:blue; font-weight:bold;\">{$class['class_name']}</span><br>";
			$msg .= "<span style=\"color:red; font-weight:bold;\">Error 404: &nbsp;The requested File class.".strtolower($class['class_name']).".php or interface.".strtolower($class['interface_name']).".php is not found.</span>.";
				
			return $msg;
		}
	