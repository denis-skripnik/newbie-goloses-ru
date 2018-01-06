<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getcomments extends APICall
{
	protected function getChildComments($permlink, $author)
	{
		$comments = array();
		$sql = "select * from dbo.Comments WITH (NOLOCK) where parent_permlink = '$permlink' and parent_author = '$author' order by created"; 
		$stmt = sqlsrv_query( $this->ms, $sql);
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$data['author'] = $row['author'];
			$data['permlink'] = $row['permlink'];
			$data['parent_author'] = $row['parent_author'];
			$data['parent_permlink'] = $row['parent_permlink'];
			$data['title'] = $row['title'];
			$data['body'] = $row['body'];
			$data['created'] = $row['created'];
			$data['last_update'] = $row['last_update'];
			$data['depth'] = $row['depth'];
			$data['pending_payout_value'] = $row['pending_payout_value'];
			$data['total_pending_payout_value'] = $row['total_pending_payout_value'];
			$data['total_payout_value'] = $row['total_payout_value'];
			$active_votes = json_decode($row['active_votes']);
			$data['active_votes'] = count($active_votes);
			$comments[] = $data;	
			//print_r($data);
			if($data['depth'] >= 4)
			{
				continue;
			}
			$c2 = $this->getChildComments($data['permlink'], $data['author']);
			$comments = array_merge($comments, $c2);
		}
		return $comments;
	}
	
	public function query($params = array())
	{
		parent::query($params);
		if(array_key_exists('permlink', $params) and array_key_exists('author', $params))
		{
			$permlink = $params['permlink'];
			$author = $params['author'];
			$comments = $this->getChildComments($permlink, $author);
		}
		else
		{
			return;
		}
		
		
		$this->count = count($comments);
		
		//print_r($comments);
		echo json_encode($comments);
		//return; 
	}
}
