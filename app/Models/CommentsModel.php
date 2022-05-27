<?php
namespace App\Models;

use \CodeIgniter\Model;

class CommentsModel extends Model
{
	public function displayComments($auid)
	{
		$userrole = getUserMeta('user_role',$auid);
		if($userrole->meta_value == "client_manager"){
			$builder = $this->db->table('user_meta');
			$builder->select('user_meta.user_id');
			$query = $builder->getWhere(['meta_key'=> 'user_manager','meta_value' => $auid],1);
		    $userid = $query->getRow();

			$builder = $this->db->table('task_request_comments');
			$builder->select('*');
			$query = $builder->where('user_id',$userid->user_id);
			$result = $builder->get();
			return $result->getResultArray();
		}else{
			$builder = $this->db->table('task_request_comments');
			$builder->select('*');
			//$query = $builder->where('user_id',$userid->user_id);
			$result = $builder->get();
			return $result->getResultArray();
		}
	}
	public function addCommentReply($commentreplydata)
	{		
		$builder = $this->db->table('task_request_comments');
		$res = $builder->insert($commentreplydata);		
		if( $this->db->affectedRows() > 0 )
		{			
			return true ;	
		}
		else
		{
			return false;
		}	
	}
	/*public function viewUser($id)
	{
		$builder = $this->db->table('users');
		$builder->select('*');
		$query = $builder->getWhere(['user_id' => $id], 1);
		return $query->getRow();	   
	}
	
	public function addNewUserMeta($usermetadata)
	{
		$buildermetadata = $this->db->table('user_meta');
		$resmeta = $buildermetadata->insertBatch($usermetadata);
		if( $this->db->affectedRows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
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
	}*/
	public function deleteComment($id)
	{
		$builder = $this->db->table('task_request_comments');
		$builder->delete(['comment_id' => $id]);      
		
		return true;		
	}
}