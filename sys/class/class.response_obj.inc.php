<?php
	class Response_Obj {
		public $repsonse = null;
		public $message = null;
		public $responseCode = null;
		public $data = array();

		public function __construct($options = null) {
			if($options !== null) {
				$this->message = $options['message'];
				$this->responseCode = $options['responseCode'];

				if(isset($options['data'])) {
					$this->data = $options['data'];
				}
			}
		}
	} 
?>