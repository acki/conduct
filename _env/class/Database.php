<?

	class Database extends mysqli {
	
		public 	$mysqli;
		protected 	$toSelect;
		protected 	$table;
		protected 	$whereClauses;
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
				if(!is_array($this->whereClauses)) {
					$first = true;
					$where = ' WHERE ';
					foreach($this->whereClauses as $val) {
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
	
	} //class
	
?>