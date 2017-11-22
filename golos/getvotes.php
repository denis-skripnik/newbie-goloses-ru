<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getvotes extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		if(array_key_exists('permlink', $params))
		{
			$permlink = $params['permlink'];
		}
		else
		{
			return;
		}
		
		$votes = array();
		$sql = "select * from dbo.TxVotes where permlink = '$permlink' order by timestamp"; 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['tx_id'] = $row['tx_id'];
			$data['voter'] = $row['voter'];
			$data['weight'] = $row['weight'];
			$data['timestamp'] = $row['timestamp'];
			$votes[] = $data;
		}	
		
		$this->count = count($votes);
		echo json_encode($votes);
		return; 
	}
}
