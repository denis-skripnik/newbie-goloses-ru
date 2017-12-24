<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_gettransfers extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		
		$from = '';
		if(array_key_exists('from', $params))		
		{
			$from = "and \"from\" = '{$params['from']}'";			
		}
		$to = '';
		if(array_key_exists('to', $params))
		{
			$to = "and \"to\" = '{$params['to']}'";
		}
		if(!array_key_exists('count', $params))
		{
			$params['count'] = 100;
		}		
		$top = $params['count'];
		if($top > 100)
		{
			$top = 100;
		}
		if(!array_key_exists('order', $params))
		{
			$params['order'] = 'id desc';
		}
		$order = $params['order'];
		if(array_key_exists('from_date', $params))	
		{
			$from_date = " and timestamp >= '{$params['from']}'";
		}
		else
		{
			$from_date = '';
		}
		if(array_key_exists('to_date', $params))	
		{
			$to_date = " and timestamp <= '{$params['to']}'";
		}
		else
		{
			$to_date = '';
		}
		$offset = '';
		if(array_key_exists('offset', $params))	
		{
			$offset = " offset {$params['offset']} ROWS FETCH NEXT $top ROWS ONLY";
			$top = '';
		}
		else
		{
			$top = "top $top";
		}
		
		$transactions = array();
		$sql = "select $top * from TxTransfers WITH (NOLOCK) where type = 'transfer' $from $to $from_date $to_date order by $order $offset"; 
		if(array_key_exists('sql', $params))
		{
			$transactions[] = $sql;
		}
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['tx_id'] = $row['tx_id'];
			$data['from'] = $row['from'];
			$data['to'] = $row['to'];
			$data['amount'] = $row['amount'];
			$data['currency'] = $row['amount_symbol'];
			$data['memo'] = $row['memo'];
			$data['timestamp'] = $row['timestamp'];
			$transactions[] = $data;
		}	
		
		$this->count = count($transactions);
		echo json_encode($transactions);
		return; 
	}
}
