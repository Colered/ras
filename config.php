<?php
//include classes
//require_once('classes/users.class.php');
//DB connection
/*$db_user='root';
$db_password='';
$db_host='localhost';
$db_name='ras';
$http_root="http://localhost/";
$link = mysql_connect($db_host, $db_user, $db_password);
if (!$link) {
    die('Not connected : ' . mysql_error());
}
$db_selected = mysql_select_db($db_name, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}*/


require_once('classes/users.class.php');
//database server
define('DB_SERVER', "localhost");
define('DB_DATABASE', "ras");
define('DB_USER', "root");
define('DB_PASS', "");

// include database and object files
if(!function_exists('classAutoLoader')){
	function classAutoLoader($class){
		$class=strtolower($class);
		$classFile=$_SERVER['DOCUMENT_ROOT'].'/ras/classes/'.$class.'.class.php';
		if(is_file($classFile)&&!class_exists($class)) include $classFile;
	}
}
spl_autoload_register('classAutoLoader');

// instantiate database object
$database = new Database();
$db = $database->getConnection();
?>