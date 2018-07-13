<?php
	class Admin extends DB_Connect{
		private $_saltLength = 7;
		private $_expirationPeriod = 7;
		private $ROOT = null;

		public function __construct($db = NULL, $saltLength = NULL) {
			parent::__construct($db);
			$this->ROOT = $_SERVER['SERVER_NAME'];
			if(is_int($saltLength)) {
				$this->_saltLength = $saltLength;
			}
		}

		public function registerCompany($name, $email, $address, $password) {
			if($_POST['action'] != 'registerCompany') {
				return "Invalid action supplied for registerCompany.";
			}

			$uname = $this->sanitizeValue($name);
			$email = $this->sanitizeValue($email);
			$address = $this->sanitizeValue($address);
			$pword = $this->sanitizeValue($password);

			$userhash = $this->_getHashFromPassword($pword);
			$token = $this->genActivationToken($email);
			$companyId = md5($email.time());
		
			if($this->isUniqueForCompanies('email', $email)) {
				$query ="INSERT INTO company". "(companyId, name, email, address, password, tempActivationToken, tokenSent) ";
				$values = "values ('$companyId', '$uname', '$email', '$address', '$userhash', '$token', now())";

				try {
				    $this->getDb()->beginTransaction();
					$this->getDb()->exec($query . $values);		
				    $this->getDb()->commit();

				    $mh = new Mail_Handler();
					$mh->sendVerificationEmail($email, $this->generateVefificationLink($email, $token));

					echo "Your registration was successful. Check your inbox!";
			    }
				catch(PDOException $e) {
				    $this->getDb()->rollback();
				    echo "Error: " . $e->getMessage();
			    }
			}
			else {
				echo "The e-mail address you used was already registered. Please try again with another!";
			}			
		}

		private function generateVefificationLink($email, $token) {
			if(!$email || !$token) {
				throw new Exception('missing key info');
				exit();
			}
			return $this->ROOT."/authentication.php#!/verify?email=".$email."&token=".$token;
		}

		private function genActivationToken($email) {
			return hash('sha256', time().uniqid($email, true), false);
		}

		public function loginCompany($userName, $password) {
			if($_POST['action'] != 'loginCompany') {
				return "Invalid action supplied for loginCompany.";
			}

			$uname = $this->sanitizeValue($userName);
			$pword = $this->sanitizeValue($password);

			$sql = "SELECT
				`id`, `companyId`, `name`, `email`, `password`, `isActivated`
				FROM `company`
				WHERE
				`email` = '$uname' 
				LIMIT 1";

			$user = $this->query($sql)[0];

			$res = new Response_Obj();

			if (!isset($user) || empty($user)){
				$res->responseCode = 400;
				$res->message = "Your username or password is invalid.";
			} else if(!boolVal($user['isActivated'])) {
				$res->responseCode = 400;
				$res->message = 'Your account is not activated yet. Please check your email.';
				echo json_encode($res);
			}

			$hash = $user['password'];

			if(password_verify($pword, $hash)) {
				$_SESSION['company'] = array(
					'id' => $user['id'],
					'name' => $user['name'],
					'email' => $user['email']
				);
				$res->responseCode = 200;
				$res->message = '';
			} else {
				$res->responseCode = 400;
				$res->message = 'Your username or password is invalid.';
			}
			echo json_encode($res);
		}

		private function createResponse($code, $message) {
			return new Response_Obj(array(
				'responseCode' => $code,
				'message'=> $message
			));
		}

		public function companyVerifyEmail($email) {
			if($_POST['action'] != 'companyVerifyEmail') {
				return "Invalid action supplied for companyVerifyEmail.";
			}

			$email = $this->sanitizeValue($email);

			$sql = "SELECT `email` FROM `company` WHERE `email` = '$email' LIMIT 1";

			$user = $this->query($sql);
			$res = new Response_Obj();

			if(!empty($user)) {
				$res->message = 'E-mail already registered.';
				$res->responseCode = 400;
			} else {
				$res->message = 'E-mail ok.';
				$res->responseCode = 200;
			}

			return $res;
		}

		public function companyForgotPassword($email) {
			if($_POST['action'] != 'logoutCompany') {
				echo "Invalid action supplied for logoutCompany.";
			}

			$email = $this->sanitizeValue($email);

			// TODO
		}

		public function logoutCompany() {
			if($_POST['action'] != 'logoutCompany') {
				echo "Invalid action supplied for logoutCompany.";
			}

			$_SESSION['company'] = array(
				'id' => '',
				'name' => '',
				'email' => ''
			);
		}

		private function fetchCompany($email, $token) {
			if(!isset($email) || !isset($token)) {
				exit('Invalid request');
			}

			$sql = "SELECT
				`id`, `email`, `tempActivationToken`, `isActivated`, `tokenSent`, `isActivationTokenExpired` 
				FROM `company`
				WHERE `email` = '$email' AND `tempActivationToken` = '$token' 
				LIMIT 1";

			$company = $this->query($sql);

			return empty($company) ? null : $company[0];
		}

		public function activateCompany($email, $token) {
			if($_POST['action'] != 'activateCompany') {
				return "Invalid action supplied for activateCompany.";
			}
			
			$email = $this->sanitizeValue($email);
			$token = $this->sanitizeValue($token);

			$company = $this->fetchCompany($email, $token);

			if(!isset($company) || $company['isActivationTokenExpired'] || $this->isActivationTokenExpired($company['tokenSent'], $this->_expirationPeriod)) {
				echo 'Session expired.';

				return new Response_Obj(array(
					'message' => 'Session expired.',
					'responseCode' => 400
				));

				exit('Session expired.');
			} else {
				$sql = "UPDATE `company` SET `isActivated`=1, `isActivationTokenExpired`=1 WHERE `email`='$email' and tempActivationToken='$token'";

				$this->query($sql);
				echo "Company activated.";
			}
		}

		private function isActivationTokenExpired($sentTime, $limit) {
			$today = new DateTime('now');
			$sentDate  = new DateTime($sentTime);
			$diff = $today->diff($sentDate)->days;

			return $diff >= $limit;
		}

		private function _getHashFromPassword($string) {
			return password_hash($string, PASSWORD_DEFAULT, ['cost' => 12]);		
		}

		public function testHash($string) {
			return $this->_getHashFromPassword($string);
		}

		public function sanitizeValue($val) {
			if(empty($val)) return '';

			return htmlentities(strip_tags(trim($val)), ENT_QUOTES);
		}

		public function isUniqueForCompanies($field, $value) {
		 	$allowedFields = ['name', 'email'];

		 	if(in_array($field, $allowedFields)) {
				$sql = "SELECT 
					`name`, `email` 
					from
					`company` 
					where ". $field ."=". "'".$value. "'";

				return empty($this->query($sql));
		 	}
		 	return false;
		}

		public function query($q) {
			try {
				$stmt = $this->db->prepare($q);
				$stmt->execute();
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$stmt->closeCursor();
				return $results;
			} catch (Exception $e) {
				die ($e->getMessage());
			}
		}
	}
?>