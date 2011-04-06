<?php

	class Tools {

		public static function throwError($class, $function, $file, $line) {
			print "Error!!<br /><br />
			Class: ".$class."<br />
			Method: ".$function."<br />
			File: ".$file."<br />
			Line: ".$line."<br />
			";
			exit;
		}
		
	} //class
	
?>