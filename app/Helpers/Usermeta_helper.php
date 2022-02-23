<?php
if(!function_exists('display_error')) {
	function display_error($validation,$field)
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
?>