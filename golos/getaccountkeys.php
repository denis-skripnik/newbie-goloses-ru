<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getaccountkeys extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		if(array_key_exists('author', $params))
		{
			$author = $params['author'];
		}
		else
		{
			return;
		}
		
		$accounts = array();
		$sql = "select * from dbo.TxAccountCreates WITH (NOLOCK) where new_account_name = '$author'"; 
		if(array_key_exists('sql', $params))
		{
			$accounts[] = $sql;
		} 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['creator'] = $row['creator'];
			$data['owner_key'] = $row['owner_key'];
			$data['active_key'] = $row['active_key'];
			$data['posting_key'] = $row['posting_key'];
			$data['memo_key'] = $row['memo_key'];
			$accounts[] = $data;
		}	
		
		$this->count = count($accounts);
		echo json_encode($accounts);
		return; 
	}
}
