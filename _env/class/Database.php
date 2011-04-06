<?

	/**
	 * Database Class
	 * 
	 * This is a very usable database class which uses mysqli.
	 * Tried to abstract all usable usecases.
	 *
	 * @author Christoph S. Ackermann, info@acki.be
	 */

	class Database {
	
		public 		$mysqli;
		protected 	$toSelect;
		protected 	$table;
		protected 	$whereString;
		protected 	$whereValues 		= array();
		private 	$query;
		private 	$stmt;
		
		public function __construct($host, $user, $pass, $db) {
			$this->mysqli = new mysqli($host, $user, $pass, $db);
		} //function construct
		
		/**
		 * Select database entries
		 * @param string $table
		 * @param array $whereClauses (Format: array(field=>value) or array(field=>array(value, operator)))
		 * @param string|array $toSelect (Format: string(value) or array(value, value))
		*/
	
		public function select($table, $whereClauses=false, $toSelect='*') {
			$this->toSelect 		= $toSelect;
			$this->table 			= $table;
			$whereClauseValuable 	= false;

			//look if toSelect is an array			
			if(is_array($this->toSelect)) {
				$this->toSelect = implode(',', $this->toSelect);
			} //if is_array
			
			//if $whereClauses exists, create a string for it
			if(isset($whereClauses) && is_array($whereClauses) && count($whereClauses)>0) {
				$whereClauseValuable = true;
				$this->createWhereString($whereClauses);
			} //if whereclauses
			
			//creates a query with our known data
			$this->query			= 'SELECT ' . $this->toSelect . ' FROM ' . $this->table . $this->whereString;
			
			//prepare the statement
			if(!$this->stmt = $this->mysqli->prepare($this->query)) {
				print 'Database select failed. Sorry.';
				exit;
			}
			
			//bind params if $whereClauseValuable exists
			if($whereClauseValuable) {
				if(!$this->bindParams()) {
					print 'Database bind params failed. Sorry.';
					exit;
				}
			}
			
			//execute the statement
			if(!$this->stmt->execute()) {
				print 'Database execute failed. Sorry.';
				exit;
			} 
			
			//get the data
			$meta = $this->stmt->result_metadata();
			while($field = $meta->fetch_field()) {
				$params[] = &$row[$field->name];
			}//while
			call_user_func_array(array($this->stmt, 'bind_result'), $params);

			//creates array with all results
			$allRows = array();
			$i=0;
			while($this->stmt->fetch()) {
				foreach($row as $key => $val){
					$allRows[$i][$key] = $val;
				}//foreach
				$i++;
			}//while
			
			//return data if available, otherwise return false
			if(count($allRows)>0) {
				return $allRows;
			} else {
				return false;
			}			
			
		} //function select
		
		/**
		 *
		*/
		public function escape($string) {
			return mysqli_real_escape_string($this->mysqli, $string);
		} // function escape
		
		// $where = array('id'=>array('1','=');
		
		/**
		 * Bind the params to the statement
		*/
		public function bindParams() {
			$values = array();
			//generates array for each value
			foreach($this->whereValues as $val) {
				//difference between string and integer
				if((int)$val) {
					$values[0] .= 'i';
					$values[] = &$val;
				} else {
					$values[0] .= 's';
					$values[] = &$val;
				}//ifelse
			}//foreach
			
			//bind parameters to statement
			if(call_user_func_array(array($this->stmt, "bind_param"), $values)) {
				return true;
			}//if call_user_func_array

			return false;

		}//function bindparams
		
		/**
		 * Creates the where string with an array of data
		 * @param array $where (Format: array(field=>value) or array(field=>array(value, operator)))
		*/
		public function createWhereString($where) {
		
			$this->whereString 	= '';
			$this->first 		= true;
		
			//function die if is not an array
			if(!is_array($where)) {
				return false;
			}//if
			
			//create the string for each value
			foreach($where as $key=>$val) {
				//in the first call add a WHERE, after that add an AND
				if($this->first) {
					$this->whereString .= ' WHERE ';
					$this->first = false;
				} else {
					$this->whereString .= ' AND ';
				} //ifelse
				
				//create an array if not
				if(!is_array($val)) {
					$val = array($val);
				}//if
				
				//creates the operator for where statement
				if($val[1] && (
								$val[1] == "=" || 
								$val[1] == "!=" || 
								$val[1] == "<" || 
								$val[1] == ">" || 
								$val[1] == "<=" || 
								$val[1] == ">="
							)) {
					$operator = $val[1];
				} else {
					$operator = "=";
				} //ifelse
				
				//add the key and operator to the classwide where string
				$this->whereString .= $key . ' ' . $operator . ' ? ';
				
				//add the values to the classwide value cache
				$this->whereValues[] = $val[0];
				
			} //foreach
			
		} //function createWhereString
	
	} //class
	
?>