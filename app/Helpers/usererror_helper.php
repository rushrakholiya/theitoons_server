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
?>