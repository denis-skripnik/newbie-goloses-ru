<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getcomments extends APICall
{
	protected function getChildComments($permlink)
	{
		$comments = array();
		$sql = "select * from dbo.Comments where parent_permlink = '$permlink' order by created"; 
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
			$comments[] = $data;	
			//print_r($data);
			if($data['depth'] >= 4)
			{
				continue;
			}
			$c2 = $this->getChildComments($data['permlink']);
			$comments = array_merge($comments, $c2);
		}
		return $comments;
	}
	
	public function query($params = array())
	{
		parent::query($params);
		if(array_key_exists('permlink', $params))
		{
			$permlink = $params['permlink'];
			$comments = $this->getChildComments($permlink);
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
