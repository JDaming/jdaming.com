<?php
	ob_start();
	session_start();

	//database creadentials
	define('DBHOST','localhost');
	define('DBUSER','database username');
	define('DBPASS','database password');
	define('DBNAME','database name');

	$db = new pdo("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME,DBUSER,DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	function _autoload($class){
		$class = strtolower($class);
		
		$classpath = 'classes/class.'.$class.'.php';
		if (file_exists($classpath)){
			require_once $classpath;
		}

		$classpath = '../classes/class.'.$class.'.php';
		if ( file_exists($classpath)) {
			require_once $classpath;
		}
	}
	
	//$user = new User($db);
?>

