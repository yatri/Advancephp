<?PHP
class Factory {
	public static function sqlFactory() {
		$dbtype = getDatabaseTypeFromConfig();
		
		switch ( $dbtype ) {
			case 'MYSQL':
				return new MYSQLQuery();
				break;
				
			case 'PGSQL':
				return new PGSQLQuery();
				break;
				
			case 'MYSQLITE':
				return new MYSQLITEQuery();
				break;
		}
	}
	
	public static function ObjFactory($classname)
	{
		//die($classname);
		include_once("modules/kernel/classes/class.{$classname}.php");
		
		switch($classname)
		{
			case $classname :
				return new $classname();
				break;
			
			default :
				die('no class found');
		}
	}
	
	public static function imageFactory() {
		
	}
	
	public static function dbFactory() {
		
	}
}