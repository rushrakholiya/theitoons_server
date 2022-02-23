<?php
if(!function_exists('display_error')) {
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