<?php
namespace App\Models;

use \CodeIgniter\Model;

class TaskrequestModel extends Model
{
	public function viewAllTaskRequestByUserid($uid)
	{
		$builder = $this->db->table('task_requests');
		$builder->select('*');
		$where = "user_id='".$uid."' AND task_status='pending' OR task_status='processing' OR task_status='in_review'";
		$query = $builder->where($where);
		$result = $query->get();
		$totaltaskno = count($result->getResultArray());
		return $totaltaskno;		
	}
	public function addNewTaskRequest($taskdata)
	{		
		$builder = $this->db->table('task_requests');
		$res = $builder->insert($taskdata);
		$taskid = $this->db->insertID();		
		if( ($this->db->affectedRows()) == 1 && (!empty($taskid)) )
		{			
			return $taskid ;	
		}
		else
		{
			return false;
		}	
	}
	public function addNewTaskRequestMeta($taskmetadata)
	{
		$buildermetadata = $this->db->table('task_request_meta');
		$resmeta = $buildermetadata->insertBatch($taskmetadata);
		if( $this->db->affectedRows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function displayAllTaskRequests()
	{
		$builder = $this->db->table('task_requests');
		$builder->join('task_request_meta','task_request_meta.task_id = task_requests.task_id AND task_request_meta.meta_key = "priority" ','left');
		$builder->select('task_requests.*,task_request_meta.meta_key,task_request_meta.meta_value');
	    $query = $builder->get();
	    return $query->getResult();
	}
	public function viewTaskRequest($id)
	{
		$builder = $this->db->table('task_requests');
		$builder->select('*');
		$query = $builder->getWhere(['task_id' => $id], 1);
		return $query->getRow();	   
	}
	public function editTaskRequest($id,$taskdata,$taskmetadata)
	{		
		$builder = $this->db->table('task_requests');
		$builder->where('task_id', $id);
		$builder->update($taskdata);		

		$builder = $this->db->table('task_request_meta');
		$builder->where('task_id', $id);
		$builder->updateBatch($taskmetadata,'meta_key');		

		return true;		
	}
	public function deleteTaskRequest($id)
	{
		$builder = $this->db->table('task_requests');
		$builder->delete(['task_id' => $id]);

		$builder = $this->db->table('task_request_meta');
		$builder->delete(['task_id' => $id]);        
		
		return true;		
	}
}