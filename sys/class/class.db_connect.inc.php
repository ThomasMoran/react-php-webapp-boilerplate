<?php 

	class DB_Connect {
		protected $db;
		protected $dbi;

		public function __construct($dbo = NULL, $dbi = NULL){
			$this->initDbo($dbo);
			$this->initDbi($dbi);
		}

		private function initDbo($dbo) {
			if(is_object($dbo)) {
				$this->db = $dbo;
			} else {
				$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
				try {
					$this->db = new PDO(
						$dsn, 
						DB_USER, 
						DB_PASS,
						array(
                    		PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                    		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                  		)
					);
				} catch(Exception $e) {
					die($e->getMessage());
				}
			}
		}

		private function initDbi($dbi) {
			if(is_object($dbi)) {
				$this->dbi = $dbi;
			} else {
				try {
					$this->dbi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				} catch(Exception $e) {
					die($e->getMessage());
				}
			}
		}

		public function getDb() {
			return $this->db;
		}

		public function getDbi() {
			return $this->dbi;
		}
	}
?>