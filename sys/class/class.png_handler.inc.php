<?php
	include_once '../sys/core/init.inc.php';
	include_once '../sys/class/phpqrcode/qrlib.php';

	class PNG_Handler{
		private $pngOutputPath = '';
		private $emailAddress = '';
		private $imagePaths = [];

		public function __construct() {
			$this->pngOutputPath = dirname(dirname(__FILE__)).'\cache\tickets';
		}

		public function getPngOutputPath() {
			return $this->pngOutputPath;
		}

		public function createQrCode($tokens) {
			$path = '';

			foreach($tokens as $str) {
				$path = $this->getPngOutputPath().'\qr-'.$str;
				array_push($this->imagePaths, $this->getPngOutputPath().'\qr-'.$str);
				QRcode::png($str, $path.'.png', 'Q', 6, 3);
			}
			return $this;
		}

		public function sendTicketEmail($email) {
			$mh = new Mail_Handler();
			$mh->sendTicketEmail($email, $this->imagePaths);
		}
	}
?>