<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../class/Rest.php');
$api = new Rest();
switch($requestMethod) {
	case 'POST':	
		$data = file_get_contents("php://input"); 
		$api->insertEmployee($data);
		break;
	default:
	header("HTTP/1.0 405 Method Not Allowed");
	break;
}
?>