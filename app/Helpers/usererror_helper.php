<?php
if(!function_exists('displayError')) {
	function displayError($validation,$field)
	{
		if(isset($validation))
		{
			if($validation->hasError($field))
			{
				return $validation->getError($field);
			}
			else
			{
				return false;
			}

		}

	}
}

if(!function_exists('getUserMeta')) {
	function getUserMeta($metakey,$id)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('user_meta');
		$builder->select('user_meta.meta_value');
		$query = $builder->getWhere(['user_id' => $id,'meta_key'=> $metakey], 1);
		return $query->getRow();
	}
}

if(!function_exists('getGeneralData')) {
	function getGeneralData($option_name)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('site_details');
		$builder->select('option_value');
		$query = $builder->where('option_name',$option_name);
		$result = $query->get();
		if(count($result->getResultArray()) == 1)
		{
			return $result->getRow();
		}
		else
		{
			return false;
		}
	}
}

if(!function_exists('getLoggedInUserData')) {
	function getLoggedInUserData($id)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('users');
		$builder->select('*');
		$query = $builder->where('user_id',$id);
		$result = $query->get();
		if(count($result->getResultArray()) == 1)
		{
			return $result->getRow();
		}
		else
		{
			return false;
		}
	}
}

if(!function_exists('getTaskRequestMeta')) {
	function getTaskRequestMeta($metakey,$id)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('task_request_meta');
		$builder->select('task_request_meta.meta_value');
		$query = $builder->getWhere(['task_id' => $id,'meta_key'=> $metakey], 1);
		return $query->getRow();
	}
}

if(!function_exists('getTaskRequestPaymentData')) {
	function getTaskRequestPaymentData($id)
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('task_request_payments');
		$builder->select('*');
		$query = $builder->getWhere(['task_id' => $id], 1);
		return $query->getRow();
	}
}

if(!function_exists('getManagerUsers')) {
	function getManagerUsers()
	{
		$db      = \Config\Database::connect();
		$builder = $db->table('users');
		$builder->join('user_meta','user_meta.user_id = users.user_id AND user_meta.meta_value = "client_manager"');
		$builder->select('users.*');
	    $query = $builder->get();
	    return $query->getResult();
	}
}

if(!function_exists('time_Ago')) {
	function time_Ago($time) {
  
	    $diff    = time() - $time;
	    $sec     = $diff;
	    $min     = round($diff / 60 );
	    $hrs     = round($diff / 3600);
	    $days    = round($diff / 86400 );
	    $weeks   = round($diff / 604800);
	    $mnths   = round($diff / 2600640 );
	    $yrs     = round($diff / 31207680 );
	    if($sec <= 60) {
	        echo "$sec seconds ago";
	    }
	    else if($min <= 60) {
	        if($min==1) {
	            echo "one minute ago";
	        }
	        else {
	            echo "$min minutes ago";
	        }
	    }
	    else if($hrs <= 24) {
	        if($hrs == 1) { 
	            echo "an hour ago";
	        }
	        else {
	            echo "$hrs hours ago";
	        }
	    }
	    else if($days <= 7) {
	        if($days == 1) {
	            echo "Yesterday";
	        }
	        else {
	            echo "$days days ago";
	        }
	    }
	    else if($weeks <= 4.3) {
	        if($weeks == 1) {
	            echo "a week ago";
	        }
	        else {
	            echo "$weeks weeks ago";
	        }
	    }
	    else if($mnths <= 12) {
	        if($mnths == 1) {
	            echo "a month ago";
	        }
	        else {
	            echo "$mnths months ago";
	        }
	    }
	    else {
	        if($yrs == 1) {
	            echo "one year ago";
	        }
	        else {
	            echo "$yrs years ago";
	        }
	    }
	}
}
?>