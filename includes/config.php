<?php
	ob_start();
	session_start();

	//database creadentials
	define('DBHOST','localhost');
	define('DBUSER','root');
	define('DBPASS','147258');
	define('DBNAME','daming_blog');

	$db = new pdo("mysql:host=".DBHOST.";port=8889;dbname=".DBNAME,DBUSER,DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	function __autoload($class){
		$class = strtolower($class);
		
		//if call from within/assets adjust path
		$classpath = 'classes/class.'.$class.'.php';
		if (file_exists($classpath)){
			require_once $classpath;
		}
			
		//if call from within admin adjust the path
		$classpath = '../classes/class.'.$class.'.php';
		if ( file_exists($classpath)) {
			require_once $classpath;
		}

		//if call from within admin adjust the path
		$classpath = '../../classes/class.'.$class.'.php';
		if (file_exists($classpath)){
			require_once $classpath;
		}
	}

	
	$user = new User($db);
?>

