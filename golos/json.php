<?php 
error_reporting(E_ALL) ;
ini_set('display_errors', 'On');

$params = json_decode(file_get_contents('php://input'));
if(file_exists($method . '.php'))
{
	$params['author'] = 'captain';
	require_once($method . '.php');
	$class = "APICall_$method";
	$API = new $class;
	$result = $API->query($params);
	if($result === false)
	{
		echo "{error: invalid result}";
		return;
	}
	echo json_encode($result);
}

?>