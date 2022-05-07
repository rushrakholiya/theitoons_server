<?php
namespace App\Models;

use \CodeIgniter\Model;

class DashboardModel extends Model
{
	public function displayAllTaskRequests($uid)
	{
	    $builder = $this->db->table("task_requests");
	  	$builder->select('*');
	  	$builder->where('user_id', $uid);
	  	$query = $builder->get();
     	return $query->getResult();
	}
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
	public function checkAuthorizedUser($id,$uid)
	{
		$builder = $this->db->table("task_requests");
	  	$builder->select('user_id');
	  	$query = $builder->getWhere(['task_id' => $id], 1);
		$row = $query->getRow();
		if(!empty($row)){
			if($row->user_id == $uid){
				return true;
			}
		}
	}
	public function deleteTaskRequest($id)
	{
		$builder = $this->db->table('task_requests');
		$builder->delete(['task_id' => $id]);

		$builder = $this->db->table('task_request_meta');
		$builder->delete(['task_id' => $id]);        
		
		return true;		
	}
	public function completeTaskRequest($id)
	{		
		$taskdata = ['task_status'=> "completed"];
        $builder = $this->db->table('task_requests');
		$builder->where('task_id', $id);
		$builder->update($taskdata);       
		
		return true;		
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
	public function verifyPaymentMethod()
	{
		$builder = $this->db->table('site_details');
        $builder->select('*');        
		$query = $builder->where('option_name', 'paypal_enable_disable');
        $result = $query->get();
        $paypalactive = $result->getRow();
        if( $paypalactive->option_value ==1)
        {
        	$names = ['paypal_sandbox','live_API_username','live_API_password','live_API_signature'];
			$builder = $this->db->table('site_details');
        	$builder->select('*');        
			$query = $builder->whereIn('option_name', $names);
        	$result = $query->get();
        	return $result->getResultArray();
        }
        else
        {
        	return false;
        }
	}
	public function addPaymentDataTaskRequest($taskpaymentdata)
	{
		$builder = $this->db->table('task_request_payments');
		$res = $builder->insert($taskpaymentdata);
		$paymentid = $this->db->insertID();		
		if( ($this->db->affectedRows()) == 1 && (!empty($paymentid)) )
		{			
			return $paymentid ;	
		}
		else
		{
			return false;
		}	
	}
	public function addPaymentDataTaskRequestMeta($taskpaymentmetadata)
	{
		$buildermetadata = $this->db->table('task_request_payment_meta');
		$resmeta = $buildermetadata->insert($taskpaymentmetadata);
		if( $this->db->affectedRows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function foundPaypalRecord($id)
	{
		$builder = $this->db->table('task_request_payments');
		$builder->select('*');
		$query = $builder->getWhere(['payment_title' => $id], 1);
		return $query->getRow();
	}
}