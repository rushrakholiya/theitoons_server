<?php
namespace App\Models;

use \CodeIgniter\Model;

class TaskrequestModel extends Model
{
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
}