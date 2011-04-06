<?

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
	
		public function select($table, $whereClauses=false, $toSelect='*') {
			$this->toSelect 	= $toSelect;
			$this->table 		= $table;
//			$where				= $this->createWhereString(array(id=>array('4', '!='),name=>array('name', '=')));
//			print $where;
//			exit;
			
			if(is_array($this->toSelect)) {
				$this->toSelect = implode(',', $this->toSelect);
			} //if is_array
			
			if($whereClauses) {
				$this->createWhereString($whereClauses);
			} //if whereclauses
			
			$this->query		= 'SELECT ' . $this->toSelect . ' FROM ' . $this->table . $this->whereString;
			
			if(!$this->stmt = $this->mysqli->prepare($this->query)) {
				print 'Database select failed. Sorry.';
				exit;
			}
			
			if(isset($whereClauses) && is_array($whereClauses) && count($whereClauses)>0) {
				if(!$this->bindParams()) {
					print 'Database bind params failed. Sorry.';
					exit;
				}
			}
			
			if(!$this->stmt->execute()) {
				print 'Database execute failed. Sorry.';
				exit;
			} 
			
			$meta = $this->stmt->result_metadata();
			while($field = $meta->fetch_field()) {
				$params[] = &$row[$field->name];
			}//while
			call_user_func_array(array($this->stmt, 'bind_result'), $params);

			$allRows = array();
			$i=0;
			while($this->stmt->fetch()) {
				foreach($row as $key => $val){
					$allRows[$i][$key] = $val;
				}//foreach
				$i++;
			}//while
			
			if(count($allRows)>0) {
				return $allRows;
			} else {
				return false;
			}			
			
		} //function select
		
		public function escape($string) {
			return mysqli_real_escape_string($this->mysqli, $string);
		} // function escape
		
		// $where = array('id'=>array('1','=');
		
		public function bindParams() {
			$values = array();
			foreach($this->whereValues as $val) {
				if((int)$val) {
					$values[0] .= 'i';
					$values[] = &$val;
				} else {
					$values[0] .= 's';
					$values[] = &$val;
				}//ifelse
			}
			
			if(call_user_func_array(array($this->stmt, "bind_param"), $values)) {
				return true;
			}

			return false;

		}//function bindparams
		
		public function createWhereString($where) {
		
			$this->whereString 	= '';
			$this->first 		= true;
		
			if(!is_array($where)) {
				return false;
			}
			
			foreach($where as $key=>$val) {
				if($this->first) {
					$this->whereString .= ' WHERE ';
					$this->first = false;
				} else {
					$this->whereString .= ' AND ';
				} //ifelse
				
				if(!is_array($val)) {
					$val = array($val);
				}//if
				
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
				
				$this->whereString .= $key . ' ' . $operator . ' ? ';
				
				$this->whereValues[] = $val[0];
				
			} //foreach
			
		} //function createWhereString
	
	} //class
	
?>