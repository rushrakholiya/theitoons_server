<?php
namespace App\Models;

use \CodeIgniter\Model;

class RegisterModel extends Model
{
	public function createUser($data)
	{
		$builder = $this->db->table('users');
		$res = $builder->insert($data);
		$userid = $this->db->insertID();		
		if( ($this->db->affectedRows()) == 1 && (!empty($userid)) )
		{			
			$query = $builder->getWhere(['user_id' => $userid],1);
			$result = $query->getRow();
			$metadata = [
			    ['user_id' => $userid,'meta_key' => 'nickname','meta_value' => $result->user_name,],
			    ['user_id' => $userid,'meta_key' => 'profile_picture','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'first_name','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'last_name','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_description','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_role','meta_value' => 'admin',],
			    ['user_id' => $userid,'meta_key' => 'company_name','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'address_one','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'address_two','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_country','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_state','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_city','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_zip','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_phone','meta_value' => '',],
			    ['user_id' => $userid,'meta_key' => 'user_anoter_email','meta_value' => '',],
			];
			$buildermetadata = $this->db->table('user_meta');
			$resmeta = $buildermetadata->insertBatch($metadata);
			if( $this->db->affectedRows() > 0 )
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			return false;
		}
	}
}