<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getreblogs extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		if(array_key_exists('permlink', $params) and array_key_exists('author', $params))
		{
			$permlink = $params['permlink'];
			$author = $params['author'];
		}
		else
		{
			return;
		}
		
		$votes = array();
		$sql = "select * from dbo.Reblogs WITH (NOLOCK) where permlink = '$permlink' and author = '$author' order by timestamp"; 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['account'] = $row['account'];
			$data['timestamp'] = $row['timestamp'];
			$votes[] = $data;
		}	
		
		$this->count = count($votes);
		echo json_encode($votes);
		return; 
	}
}
