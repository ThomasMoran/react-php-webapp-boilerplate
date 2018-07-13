<?php

	class Base_Model extends DB_Connect {
		public $id = null;
		public $data = array();
		public $tableName;
		protected $records = array();
		protected $mapping = array();

		public function __construct($dbo = NULL) {
			parent::__construct($dbo);
		}

		public $fields = array();

		public function update() {
			$this->updateRecords();
		}

		public function getRecords() {
			return $this->records;
		}

		public function insert($records=NULL) {
			if(empty($records)) {
				$records = $this->records;
			}
			return $this->insertRecords($records);
		}

		public function escapeChar($str) {
			return htmlentities($str, ENT_QUOTES);
		}

		public function createUpdateStr($r) {
			$str = [];
			if(empty($r['id'])) { return null; }
			foreach($r as $key => $v) {
				array_push($str, $key . '=\'' . $this->sanitizeValue($v) . '\'');
			}
			return join(',', $str) . ' WHERE id=' . $r['id'];
		}

		private function updateRecords() {
			$temp = "UPDATE ". $this->tableName ." SET ";
			$q = '';
		
			try{
				foreach($this->records as $r){
					$q = $temp;
					$str = $this->createUpdateStr($r);

					if(!empty($str)) {
						$q.= $str;
					}
					
					$stmt = $this->getDb()->prepare($q);
					$stmt = $this->bindParamToStatement($stmt, $r);
					$stmt->execute();
					$stmt->closeCursor();
					return TRUE;
				}
			} catch(PDOException $e) {
				$this->getDb()->rollback();
			    echo "Error: " . $e->getMessage();
			}
		}

		protected function bindParamToStatement($stmt, $bindedData) {
			foreach ($bindedData as $key => $d) {
				$stmt->bindParam(":" . $key, $d);
			}
			return $stmt;
		}

		private function insertRecords($records) {
			$ids = [];
			$query ="INSERT INTO " . "`" . $this->tableName ."`". "(" . $this->assembleAllFields() . ") ";
			$values = "";

			try{
			    $this->getDb()->beginTransaction();
			    foreach($records as $r) {
				    $values = $this->assembleValues($r);
				    $this->getDb()->exec($query . $values);
				    array_push($ids, $this->getDb()->lastInsertId());
			    }

			    $this->getDb()->commit();
			    return $ids;
		    }
			catch(PDOException $e){
			    $this->getDb()->rollback();
			    echo "Error: " . $e->getMessage();
		    }
		}

		protected function assembleValues($record) {
			$str = array();
			foreach($this->mapping as $m) {
				if(array_key_exists($m['name'], $record)) {
					array_push($str, "'" . $this->sanitizeValue($record[$m['name']]) . "'");
				} else {
					array_push($str, "''");
				}
			}
			return "VALUES(". join(',', $str) .")";
		}

		public function sanitizeValue($val) {
			if(empty($val)) return '';
			return htmlentities(strip_tags(trim($val)), ENT_QUOTES);
		}

		protected function assembleInsertString() {
			$str = "INSERT INTO " . 
				$this->tableName . "(". $this->assembleAllFields() .") ".
				"VALUES(". $this->assembleAllFields(true) .")";
			return $str;
		}

		protected function assembleAllFields() {
			$fs = array();
			foreach($this->mapping as $m) {
				array_push($fs, "`" . $m['name'] . "`");
			}
			return join(',', $fs);
		}

		public function loadData($dataList) {
			return $this;
		}

		public function query($q, $fetchType=null) {
			if(empty($fetchType)) $fetchType = PDO::FETCH_ASSOC;
			$stmt = $this->getDb()->prepare($q);
			$stmt->execute();
			$results = $stmt->fetchAll($fetchType);
			$stmt->closeCursor();
			return $results;
		}
	}
?>