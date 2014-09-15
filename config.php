<?php
session_start();
//database server
define('DB_SERVER', "172.16.220.164");
define('DB_DATABASE', "cidot_ras");
define('DB_USER', "root");
define('DB_PASS', "cidot@123");
/*define('DB_SERVER', "localhost");
define('DB_DATABASE', "cidot_ras");
define('DB_USER', "root");
define('DB_PASS', "");
*/
// include database and object files
if(!function_exists('classAutoLoader')){
	function classAutoLoader($class){
		$class=strtolower($class);
		$classFile='classes/'.$class.'.class.php';
		if(!class_exists($class)) include $classFile;
	}
}
spl_autoload_register('classAutoLoader');
// instantiate database object
$database = new Database();
$db = $database->getConnection();


?>