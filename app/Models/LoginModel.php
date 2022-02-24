<?php
namespace App\Models;

use \CodeIgniter\Model;

class LoginModel extends Model
{
	public function verifyUser($useremail)
	{
		$builder = $this->db->table('users');
		$builder->select('*');
		$query = $builder->where('user_email',$useremail);
		$result = $query->get();
		if(count($result->getResultArray()) == 1)
		{
			return $result->getRowArray();
		}
		else
		{
			return false;
		}
		
	}
	public function verifyToken($token)
	{
		$builder = $this->db->table('users');
		$builder->select('*');
		$query = $builder->where('user_id',$token);
		$result = $query->get();
		if(count($result->getResultArray()) == 1)
		{
			return $result->getRowArray();
		}
		else
		{
			return false;
		}
			
	}
	public function updateUserPassword($token,$usernewpassword)
	{		
		$builder = $this->db->table('users');
		$builder->where('user_id', $token);
		$builder->update(['user_password'=>$usernewpassword]);
		if($this->db->affectedRows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
		
}