<?

	class Database extends mysqli {
	
		public 	$mysqli;
		protected 	$toSelect;
		protected 	$table;
		protected 	$whereClauses;
		protected 	$whereString;
		private 	$query;
	
		public function setConnector($mysqli) {
			$this->mysqli = $mysqli;
		} //construct
		
		public function select($toSelect, $table, $whereClauses=false) {
			$this->toSelect 	= $toSelect;
			$this->table 		= $table;
			$this->whereClauses = $whereClauses;
			$where				= '';
			
			if(is_array($this->toSelect)) {
				$this->toSelect = implode(',', $this->toSelect);
			} //if is_array
			
			if($this->whereClauses) {
				if(is_array($this->whereClauses)) {
					$first = true;
					$where = ' WHERE ';
					foreach($this->whereClauses as $key=>$val) {
						if(!$first) {
							$where .= ' AND ';
						} else {
							$first = false;
						} //else
						$where .= $val;
					} //foreach
				} //if is_array
				else {
					Tools::throwError(__CLASS__, __FUNCTION__, __FILE__, __LINE__);
				}
			} //if whereclauses
			
			$this->query		= 'SELECT ' . $this->toSelect . ' FROM ' . $this->table . $where;
			
			print $this->query;
			
		} //function select
		
		public function escape($string) {
			return mysqli_real_escape_string($this->mysqli, $string);
		} // function escape
		
		// $where = array('id'=>array('1','=');
		
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
				
				if($val[1] && ($val[1] == "=" || $val[1] == "<" || $val[1] == ">" || $val[1] == "<=" || $val[1] == ">=")) {
					$operator = $val[1];
				} else {
					$operator = "=";
				} //ifelse
				
				$this->whereString .= $key . ' ' . $operator . ' ? ';
				
			} //foreach
			
		} //function createWhereString
	
	} //class
	
?>