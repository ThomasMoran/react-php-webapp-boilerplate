<?php
	include_once dirname(dirname(__file__)).'/sys/core/init.inc.php';

	if($_POST['token'] === $_SESSION['token']) {

		$action = $_POST['action'];

		if($action === 'checkLoggedIn') {
			if(!isset($_SESSION['company']['id']) || !isset($_SESSION['company']['email']) || !isset($_SESSION['company']['name'])) {
				echo 'false';   
			}
			else {
				echo 'true';   
			}
		} 

		else if($action === 'registerCompany') {
			$data = json_decode($_POST['data']);
			$admin = new Admin();
			$admin->registerCompany($data->name, $data->email, $data->address, $data->password);
		} 

		else if($action === 'loginCompany') {
			$data = json_decode($_POST['data']);
			$admin = new Admin();
			$admin->loginCompany($data->email, $data->password);	
		}	

		else if($action === 'logoutCompany') {
			$admin = new Admin();
			$admin->logoutCompany();			
		} 	

		else if($action === 'companyVerifyEmail') {
			$data = json_decode($_POST['data']);
			$admin = new Admin();
			$admin->companyVerifyEmail($data->email);			
		} 	

		else if($action === 'activateCompany') { 
			$data = json_decode($_POST['data']);
			$admin = new Admin();
			$admin->activateCompany($data->email, $data->token);		
		} 
			
		else if($action === 'companyForgotPassword') { 
			$data = json_decode($_POST['data']);
			$admin = new Admin();
			$admin->companyForgotPassword($data->email);		
		} 

		else {
			throw new Exception('Invalid request');
		}
	
  	} else {
  		throw new Exception('Invalid token');
  	}
?>