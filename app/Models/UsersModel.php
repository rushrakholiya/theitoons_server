<?php
namespace App\Models;

use \CodeIgniter\Model;

class UsersModel extends Model
{
	public function displayUsers()
	{
		$builder = $this->db->table('users');
		$builder->join('user_meta','user_meta.user_id = users.user_id AND user_meta.meta_key = "user_role" ','left');
		$builder->select('users.*,user_meta.meta_key,user_meta.meta_value');
	    $query = $builder->get();
	    return $query->getResult();

	}
	public function viewUser($id)
	{
		$builder = $this->db->table('users');
		$builder->select('*');
		$query = $builder->getWhere(['user_id' => $id], 1);
		return $query->getRow();	   
	}
	public function editUser($id,$userdata,$usermetadata)
	{		
		$builder = $this->db->table('users');
		$builder->where('user_id', $id);
		$builder->update($userdata);		

		$builder = $this->db->table('user_meta');
		$builder->where('user_id', $id);
		$builder->updateBatch($usermetadata,'meta_key');		

		return true;		
	}
	public function deleteUser($id)
	{
		$builder = $this->db->table('users');
		$builder->delete(['user_id' => $id]);

		$builder = $this->db->table('user_meta');
		$builder->delete(['user_id' => $id]);        
		
		return true;		
	}
}