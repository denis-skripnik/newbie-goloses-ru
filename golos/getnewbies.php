<?php 
//error_reporting(E_ALL) ;
//ini_set('display_errors', 'On');

require_once('api.php');

class APICall_getnewbies extends APICall
{
	public function query($params = array())
	{
		parent::query($params);
		$author = '';
		$category = '';
		$title = '';
		$author = '';
		$exclude_category = '';
		$offset = '';
		$from = '';
		$to = '';
		if(array_key_exists('ignore_body', $params) and !array_key_exists('count', $params))
		{
				$top = 500;		
		}
		else
		{
			if(!array_key_exists('count', $params))
			{
				$params['count'] = 100;
			}		
			$top = $params['count'];
			if($top > 100)
			{
				$top = 100;
			}
		}	
		
		if(!array_key_exists('order', $params))
		{
			$params['order'] = 'id desc';
		}
		$order = $params['order'];
		if(array_key_exists('author', $params))
		{
			$author = " and author = '{$params['author']}'";
		}
		if(array_key_exists('title', $params))	
		{
			$title = " and title LIKE '%{$params['title']}%'";
		}
		else
		{
			$title = " and title <> ''";
		}
		if(array_key_exists('from', $params))	
		{
			$from = " and created >= '{$params['from']}'";
		}
		if(array_key_exists('to', $params))	
		{
			$to = " and created <= '{$params['to']}'";
		}
		if(array_key_exists('offset', $params))	
		{
			$offset = " offset {$params['offset']} ROWS FETCH NEXT $top ROWS ONLY";
			$top = '';
		}
		else
		{
			$top = "top $top";
		}
		if(array_key_exists('search', $params))	
		{
			$title = " and body LIKE '%{$params['search']}%' and title LIKE '%{$params['search']}%'";
		}
		if(array_key_exists('category', $params))
		{
			$catslist = "";
			$cats = $params['category'];
			$parts = explode(',', $cats);
			foreach($parts as $part)
			{
				if(strlen($catslist) > 0)
				{
					$catslist .= ", ";
				}
				$catslist .= "'$part'";
			}
			$category = " and parent_permlink in ($catslist)";
		}
		if(array_key_exists('exclude_category', $params))
		{
			$catslist = "";
			$cats = $params['exclude_category'];
			$parts = explode(',', $cats);
			foreach($parts as $part)
			{
				if(strlen($catslist) > 0)
				{
					$catslist .= ", ";
				}
				$catslist .= "'$part'";
			}
			$exclude_category = " and parent_permlink not in ($catslist)";
		}
		if(!array_key_exists('ignore_body', $params))
		{
			$sql = "select $top * from Comments where body not LIKE '@@%' and parent_author = '' and title <> '' and author in (select author from Comments group by author having count(author) < 3) $title $category $from $to $exclude_category $author order by $order $offset";
		}
		else
		{
			$sql = "select $top ID, author, permlink, parent_author, parent_permlink, title, json_metadata, active_votes, last_update, pending_payout_value, total_pending_payout_value, total_payout_value, created from Comments where body not LIKE '@@%' and parent_author = '' and title <> '' and author in (select author from Comments group by author having count(author) < 3) $title $category $from $to $exclude_category $author order by $order $offset";
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
		//echo sqlsrv_num_rows ( $stmt );
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$data = array();
			$metadata = json_decode($row['json_metadata']);
			if(!property_exists($metadata, 'tags') and array_key_exists('tags', $params))
			{
				continue;
			}
			if(property_exists($metadata, 'tags'))
			{
				$data['tags'] = $metadata->tags;
				$ok = false; // считаем что тэга нет
				if(array_key_exists('tags', $params))
				{
					
					$tags = explode(',', $params['tags']);
					foreach($tags as $tag)
					{
						if(in_array($tag, $metadata->tags)) // такой тэг есть
						{
							$ok = true;
							break;
						}
					}
					if(!$ok) // ни одного тэга нет
					{
						continue;
					}
				}
			}
			if(!property_exists($metadata, 'tags') and array_key_exists('exclude_tags', $params))
			{
				continue;
			}
			if(property_exists($metadata, 'tags'))
			{
				$data['tags'] = $metadata->tags;
				$ok = true; // считаем что тэга нет
				if(array_key_exists('exclude_tags', $params))
				{
					$tags = explode(',', $params['exclude_tags']);
					foreach($tags as $tag)
					{
						if(in_array($tag, $metadata->tags)) // такой тэг есть
						{
							$ok = false;
							break;
						}
					}
					if(!$ok) // тэг есть, пропускаем запись
					{
						continue;
					}
				}
			}	
			$data['title'] = $row['title'];
			/*if(!array_key_exists('ignore_body', $params))
			{
				$data['body'] = $row['body'];
			}*/
			$data['author'] = $row['author'];
			$data['permlink'] = $row['permlink'];			
			$data['parent_permlink'] = $row['parent_permlink'];
			$data['permlink'] = $row['permlink'];
			$active_votes = json_decode($row['active_votes']);
			$data['active_votes'] = count($active_votes);
			$data['last_update'] = $row['last_update'];
			$data['created'] = $row['created'];
			$data['pending_payout_value'] = $row['pending_payout_value'];
			$data['total_pending_payout_value'] = $row['total_pending_payout_value'];
			$data['total_payout_value'] = $row['total_payout_value'];	
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
			$out[] = $data;
		}
		echo json_encode($out);
		return; 
	}
}
