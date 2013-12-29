<?PHP
	class FunctionInitializer
	{
		public static function initialize()
		{
			require DOC_ROOT . FUNC_PATH . 'specialfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'datetimefunctions.php';
			require DOC_ROOT . FUNC_PATH . 'filefunctions.php';
			require DOC_ROOT . FUNC_PATH . 'generalfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'securityfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'numberfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'textfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'urlfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'validationfunctions.php';
			require DOC_ROOT . FUNC_PATH . 'smartyfunctions.php';
		}
	}
?>