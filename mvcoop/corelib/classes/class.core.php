<?PHP
class Core {
    #smarty object
    var $smarty;
		
    #params array for including javascript
    var $JSParams = array();
    
    #title
    var $title;
    
    public $DefaultModule = 'main';
    
    #sub menu
    #properties to be used by magic get and set methods
    private $properties = array();
    
    function __construct()
    {
		die();
        echo 'here';
        singletonPattern(self::$instance , $this);    
    }
    
	function smartyTest()
	{
		//die('smartytest');
		//$this->smarty->testInstall(); 
		//echo $this->smarty->version; 
	}
	
    function ini_temp($_tpl_path = '') {
		$this->smarty = new smarty();
		
		$this->smartyTest();
		$_compile_path = CMPL_PATH;
		
		if(!$_tpl_path)
			$_tpl_path = $this->setTemplatePath();
		
		$this->smarty->template_dir = $_tpl_path;
		$this->smarty->compile_dir = $_compile_path;
    }
    
    function setTemplatePath() {
    	$module = $this->DefaultModule;
		if(@$_GET['option']) {
				$module = $_GET['option'];
			}
		if(@$_GET['sub'])
			$module .= '/'.$_GET['sub'];
	
		$templatepath = "modules/{$module}/templates/";
		return $templatepath;
    }
		
    function assign( $name , $value ) {
		$this->smarty->assign( $name , $value );
    }
		
    function display( $_filename ) {
		$this->smarty->display( $_filename );
    }
    
    public function setTitle($title) {
		$this->title = $title;
    }
		
    public function getTitle() {
		return $this->title;
    }
		
    ###### Magic Methods to Set/Get Class Properties
    function __get($property) {
		return $this->properties[$property];
    }
		
    function __set($property, $value) {
		//$this->properties[$property]="AutoSet {$property} as: ".$value;
		$this->properties[$property]=$value;
    }
		
    /*## example usage of magic get/ set properties
    $st = new Student();
    $st->name = "Afif";
    $st->roll=16;
    echo $st->name."\n";
    echo $st->roll;
    */

}