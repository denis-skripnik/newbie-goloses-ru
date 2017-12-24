<?php 
error_reporting(E_ALL) ;
ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getfollowing extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		if(array_key_exists('login', $params))
		{
			$login = $params['login'];
		}
		else
		{
			return;
		}
		
		$f = array();
		$sql = "select * from dbo.Followers where follower = '$login' order by follower"; 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['following'] = $row['following'];
			$data['follower'] = $row['follower'];
			$f[] = $data;
		}	
		
		$this->count = count($f);
		echo json_encode($f);
		return; 
	}
}
