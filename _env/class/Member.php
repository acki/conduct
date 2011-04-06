<?php

	class Member {
	
		protected 	$mysqli;
		protected 	$id;

		public function __construct($mysqli, $id=false) {
			$this->id 		= $id;
			$this->mysqli 	= $mysqli;
		}//function construct
		
		public function getFullName() {
			$value = $this->mysqli->select('member',array('id'=>$this->id),'prename,name');
			return $value[0]['prename'] . ' ' . $value[0]['name'];
		}//function getName
		
	} //class
	
?>