<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

if(!array_key_exists('method', $_GET))
{
	echo 'Отсутствует ключевой параметр method';
	return;
}
$method = $_GET['method'];
$params = $_GET;
if(file_exists($method . '.php'))
{
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