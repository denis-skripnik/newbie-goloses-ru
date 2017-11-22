<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getpost extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		if(array_key_exists('permlink', $params))
		{
			$permlink = $params['permlink'];
			$sql = "select top 1 * from Comments where permlink = '$permlink' and parent_author = '' order by ID desc";
		}
		else
		{
			$sql = "select top 1 * from Comments where parent_author = '' order by id desc";
		}
		
		$out = array();
		if(array_key_exists('sql', $params))
		{
			$out[] = $sql;
		}
		$stmt = sqlsrv_query( $this->ms, $sql);
		if( $stmt === false ) {
			print_r(sqlsrv_errors());
			return false;
		}
		$this->count = sqlsrv_num_rows ( $stmt );
		
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			
			$data['id'] = $row['ID'];
			$data['title'] = $row['title'];
			if(!array_key_exists('ignore_body', $params))
			{
				$data['body'] = $row['body'];
			}
			$data['author'] = $row['author'];
			$data['permlink'] = $row['permlink'];			
			$data['created'] = $row['created'];
			$data['last_update'] = $row['last_update'];	
			$data['parent_permlink'] = $row['parent_permlink'];
			$data['permlink'] = $row['permlink'];
			$data['children'] = $row['children'];
			$data['pending_payout_value'] = $row['pending_payout_value'];
			$data['total_pending_payout_value'] = $row['total_pending_payout_value'];
			$data['total_payout_value'] = $row['total_payout_value'];
			$metadata = json_decode($row['json_metadata']);
			if(property_exists($metadata, 'app'))
			{
				$data['app'] = $metadata->app;
			}
			if(property_exists($metadata, 'format'))
			{
				$data['format'] = $metadata->format;
			}
			if(property_exists($metadata, 'links'))
			{
				$data['links'] = $metadata->links;
			}
			if(property_exists($metadata, 'image'))
			{
				$data['images'] = $metadata->image;
			}			
			if('{"tags":["nsfw"]}' == $metadata)
			{
				$data['tags'] = "nsfw";
			}	
			else
			{
				$data['tags'] = $metadata->tags;
			}
			$data['votes'] = json_decode($row['active_votes']);
			$out[] = $data;
		}
		//print_r($out);
		echo json_encode($out);
		//return; 
	}
}
