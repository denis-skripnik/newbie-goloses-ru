<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getwitnesses extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		$votes = array();
		$sql = "select * from dbo.Witnesses WITH (NOLOCK) order by votes desc"; 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['name'] = $row['name'];
			$data['votes_count'] = $row['votes_count'];
			$data['created'] = $row['created'];
			$data['url'] = $row['url'];
			$data['votes'] = $row['votes'];
			$data['total_missed'] = $row['total_missed'];
			$data['signing_key'] = $row['signing_key'];
			$data['account_creation_fee'] = $row['account_creation_fee'];
			$data['running_version'] = $row['running_version'];
			$data['hardfork_version_vote'] = $row['hardfork_version_vote'];
			$data['exchange_rate'] = $row['sbd_exchange_rate_base'];
			$votes[] = $data;
		}	
		
		$this->count = count($votes);
		echo json_encode($votes);
		return; 
	}
}
