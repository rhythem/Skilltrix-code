<?php
	require_once('users.php');
	class profile extends users{
		public $profile_data = array();
		public function __construct() {
			parent::__construct();			//constructing database class
			
		}
		function profile_user_data($user_id) {
			$this->select('users','*',"user_id = $user_id");
			$this->profile_data=$this->getResult();

		}
	}
?>