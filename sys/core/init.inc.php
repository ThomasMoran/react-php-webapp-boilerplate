<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

	if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
	    session_unset();      
	    session_destroy();   
	}

	$_SESSION['LAST_ACTIVITY'] = time(); 

	if(!isset($_SESSION['token'])) {
	 	$_SESSION['token'] = (uniqid(mt_rand(), TRUE));
	}

	include_once dirname(dirname(__FILE__)).'/config/db_cred.inc.php';

	foreach($DB_ACCESS as $name => $value) {
		define($name, $value);
	}

	$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
	$dbo = new PDO($dsn, DB_USER, DB_PASS);

	function autoLoad($className) {
        $filename = dirname(dirname(__FILE__)).'/class/class.'. $className . '.inc.php';
 
        $filename = str_replace('\\', '/', strtolower($filename));
        if(file_exists($filename)) {
            require_once($filename);
        }
        else {
            echo "$filename not found<br>\n";
        }
    }

    function autoLoadInterface($interfaceName) {
        $filename = dirname(dirname(__FILE__)).'/interface/interface.'. $interfaceName . '.inc.php';
 
        $filename = str_replace('\\', '/', strtolower($filename));
        if(file_exists($filename)) {
            require_once($filename);
        }
        else {
            echo "$filename not found<br>\n";
        }
    }

	spl_autoload_register('autoLoad');
?>