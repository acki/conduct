<?

	class Login {
	
		public function login($username, $password) {
			
			$salt = substr(md5($username), 0, 20);
			$hash = hash('sha256', $salt . $GLOBALS['secure']['salted'] . $password);
			$db = $GLOBALS['mysqli']->select('user', array('username'=>$username));
			
			
			if($db[0]['password'] === $hash) {
				$this->setLogin($username);
			} else {
				print 'haha. FAILED! GO AWAY!';
			}
			
		}
		
		private function setLogin($username) {
			
			session_regenerate_id();
			
			$_SESSION['username'] = $username;

			$GLOBALS['mysqli']->update('user', array('session_id' => session_id()), array('username' => $username));
			
		}
		
		public static function isAuthed() {
					
			$database = $GLOBALS['mysqli']->select('user', array('session_id'=>session_id()));
			
			if($database[0]['id'] >0) {
				$_SESSION['user_id'] = $database[0]['id'];
				return true;
			}
			
			return false;
		
		}
		
		public static function logout() {
		
			$session_id = session_id();
			
			$database = $GLOBALS['mysqli']->select('user', array('session_id'=>session_id()));
			$GLOBALS['mysqli']->update('user', array('session_id' => ''), array('id' => $database[0]['id']));
			
			$_SESSION = array();
			
			if (ini_get("session.use_cookies")) {
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000, $params["path"],
			        $params["domain"], $params["secure"], $params["httponly"]
			    );
			}

			session_destroy();
		
		}		
	
	}
	
?>