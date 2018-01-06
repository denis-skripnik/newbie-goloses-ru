<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getaccount extends APICall
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
		$sql = "select * from dbo.Accounts WITH (NOLOCK) where name = '$author'"; 
		if(array_key_exists('sql', $params))
		{
			$accounts[] = $sql;
		} 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['name'] = $row['name'];
			$data['json_metadata'] = $row['json_metadata'];
			$data['created'] = $row['created'];
			$data['recovery_account'] = $row['recovery_account'];
			$data['post_count'] = $row['post_count'];
			$data['voting_power'] = $row['voting_power'];
			$data['balance'] = $row['balance'];
			$data['balance_gbg'] = $row['sbd_balance'];
			$data['vesting_shares'] = $row['vesting_shares'];
			$data['last_post'] = $row['last_post'];
			$data['last_root_post'] = $row['last_root_post'];
			$data['reputation'] = $row['reputation'];
			$data['witness_votes'] = $row['witness_votes'];
			$accounts[] = $data;
		}	
		
		$this->count = count($accounts);
		echo json_encode($accounts);
		return; 
	}
}
