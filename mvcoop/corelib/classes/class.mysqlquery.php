<?php
	

	class MYSQLQuery implements ISQLQueryBinding {
		
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
		
		################ SIMPLE QUERY FUNCTIONS ################
		
		function queryField($qry) {
			$i = 0;
			$data = array();
			$qry_result = mysql_query($qry) or die("QUERY ERROR,Field => ".mysql_error());
			//$qry_row=mysql_fetch_assoc($qry_result);
			while ($row = mysql_fetch_field($qry_result)) {
				$data[$i] = $row;
				$i++;
			}
			return $data;
		}
		
		function querySelect($qry) {
			$i = 0;
			$data = array();
			$qry_result = mysql_query($qry) or die("QUERY ERROR1,SELECT => ".mysql_error());
			//$qry_row=mysql_fetch_assoc($qry_result);
			while ($row = mysql_fetch_assoc($qry_result)) {
				$data[$i] = $row;
				$i++;
			}
			return $data;
		}
		
		function querySelectSingle($qry) {
			$qry_result = mysql_query($qry) or die("QUERY ERROR2,SingleSELECT => ".mysql_error());
			$row = mysql_fetch_assoc($qry_result);
			return $row;
		}
		
		function numRows($nr) {
			$qry_result1 = mysql_query($nr) or die("QUERY ERROR3,numRows => ".mysql_error());
			$num_row = mysql_num_rows($qry_result1);
			return $num_row;
		}
		
		function queryDelete($qd) {
			$result_delete = mysql_query($qd) or die("QUERY ERROR4,DELETE => ".mysql_error());
			return $result_delete;
		}
		
		function queryInsert($qd) {
			$result_insert = mysql_query($qd) or die("QUERY ERROR5,INSERT => ".mysql_error());
			return $result_insert;
		}
		
		function queryUpdate($qd) {
			$result_update = mysql_query($qd) or die("QUERY ERROR5,UPDATE => ".mysql_error());
			return $result_update;
		}
		
		function queryExecute($query) {
			$result_update = mysql_query($query) or die("QUERY ERROR6,EXECUTE => ".mysql_error());
			return mysql_affected_rows();
		}
		
		################# ADVANCED QUERY FUNCTIONS ##################
		
		function insert( $table , $arfields , $return_query = "" ) {
			$fields=array_keys($arfields);
			$values=array_values($arfields);
	
			//create useful array  of values that will
			//be imploded to the values clauses of the insert statement
			//Run the mysql_escape_string function on those 
			//values that are something other than numeric.	
				
			$escvals=array();
			
			foreach($values as $val) {
				if(!is_numeric($val)) {
					if(is_array($val))
					{
						//if(key($val) == )
						//die(key($val));
						foreach($val as $key=>$v)
						{
							if($key == 'mysql')
								$val= $v ;
							else
								$val="'". addslashes($v) ."'";
						}
					}
					else
						$val="'". addslashes($val) ."'";
				}
				$escvals[]=$val;
			}	
		
			//generate the SQL statement
			$sql = "INSERT INTO $table (";
			$sql .= join(', ', $fields);
			$sql .= ') VALUES (';
			$sql .= join(', ',$escvals);
			$sql .= ')';
			
			if($return_query == 1)
				$result = $sql;
			else  {
				$result = mysql_query($sql) or die("QUERY ERROR,ADVANCEDINSERT => ".mysql_error());
			}
			/*	
			if(!is_resource($result)) {
				$error="mysql error";//mysql_error($this->con);
				throw new Exception($error);
			}
			*/
			return $result;
		}
	
		function update( $table , $arfield , $arcondition , $return_query = "" ) {
			//create a useful array for the SET clause 
			$arupdate = array();
			
			foreach($arfield as $field=>$val) {
				if(! is_numeric($val)) {
					//make sure the values are properly escaped
					if(is_array($val))
					{
						//if(key($val) == )
						//die(key($val));
						foreach($val as $key=>$v)
						{
							if($key == 'mysql')
								$val= $v ;
							else
								$val="'". addslashes($v) ."'";
						}
					}
					else
						$val="'" .mysql_escape_string($val) . "'";
				}
	
				$arupdate[] = "$field = $val";
			}

			//create a useful array for the WHERE clause
			$arwhere = array();
		
			foreach($arcondition as $field=>$val) {
				if(! is_numeric($val)){
					//make sure the values are properly escaped
					$val = "'" . mysql_escape_string($val). "'";
				}
				
				$arwhere[] = "$field=$val";
			}

			$sql = "UPDATE $table SET ";
			$sql .= join(', ',$arupdate);
			$sql .= ' WHERE '. join (' AND ', $arwhere);
	
			//$result = mysql_query($sql);
			
			if($return_query == 1)
				$result = $sql;
			else  {
				$result = mysql_query($sql) or die("QUERY ERROR,ADVANCEDUPDATE => ".mysql_error());
			}
			
			return $result;
		}
		
		function delete($table,$arconditions , $return_query = "") {
			//create a useful array for generating the WHERE clause
			$where = array();
			foreach($arconditions as $fields=>$val) {
				if(!is_numeric($val)) {
					//make sure the values are properly escaped
					$val = "'" . mysql_escape_string($val) ."'";
				}
				$where[] = "$fields=$val";
			}
			
			$sql = "DELETE FROM $table WHERE " .join(' AND ', $where);
			//$result = mysql_query($sql);
			
			if($return_query == 1)
				$result = $sql;
			else  {
				$result = mysql_query($sql) or die("QUERY ERROR,ADVANCEDDELETE => ".mysql_error());
			}
			
			return $result;
		}
	
		function buildQuery( $type='INSERT', $table, $values, $whereClause='', $doNotEnclose=array() ) {	
			if( empty($table) || empty($values)) {
				return;
			}
	
			$type = strtoupper($type);
			switch($type) {
				case 'INSERT':
						$q = "INSERT INTO `$table` (`";
						$q .= implode( "`,\n`", array_keys($values) );
						$q .= "`) VALUES (\n";
						$count = count( $values );
						$i = 1;
					
						foreach ( $values as $key => $value ) {
							if( in_array( $key, $doNotEnclose )) {
								// Important when using MySQL functions like "AES_ENCRYPT", "ENCODE", "REPLACE" or such
								$q .= $value;
							} 
							else {
								$q .= '\'' . $this->getEscaped($value)."'\n";
							}
							if( $i++ < $count ) {
								$q.= ',';
							}
						}
						$q .= ')';
				break;
					
				case 'UPDATE':
						$q = "UPDATE `$table` SET ";
						$count = count( $values );
						$i = 1;
						
						foreach ( $values as $key => $value ) {
							$q .= "`$key` = '" . $value . "'";
							if( $i++ < $count ) {
								$q.= ",\n";
							}
						}
						$q .= "\n$whereClause";
						return $q;
				break;
	
				default:
					return;
			}
		} //end of build query
	}
?>