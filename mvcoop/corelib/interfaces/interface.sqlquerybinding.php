<?PHP
interface ISQLQueryBinding {
	function querySelect( $qry );
	
	function querySelectSingle( $qry );
	
	function numRows( $nr );
	
	function queryDelete( $qd );
	
	function queryInsert( $qd );
	
	function queryUpdate( $qd );
	
	function queryExecute( $query );
	
	function insert( $table , $arfields );
	
	function update( $table , $arfield , $arcondition );
	
	function delete( $table,$arconditions );
	
	function buildQuery( $type='INSERT', $table, $values, $whereClause='', $doNotEnclose=array() );
}
