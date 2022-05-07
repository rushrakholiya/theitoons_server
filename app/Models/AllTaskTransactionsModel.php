<?php
namespace App\Models;

use \CodeIgniter\Model;

class AllTaskTransactionsModel extends Model
{
	public function displayAllTaskTransactions()
	{
		$builder = $this->db->table('task_request_payments');
		$builder->join('task_request_payment_meta','task_request_payment_meta.payment_id = task_request_payments.payment_id','left');
		$builder->select('*');
	    $query = $builder->get();
	    return $query->getResult();

	}	
	public function viewTaskTransaction($id)
	{
		$builder = $this->db->table('task_request_payments');
		$builder->join('task_request_payment_meta','task_request_payment_meta.payment_id = task_request_payments.payment_id','left');
		$builder->select('*');
		$query = $builder->getWhere(['task_request_payments.payment_id' => $id,'task_request_payment_meta.payment_id' => $id], 1);
		return $query->getRow();	   
	}	
	public function deleteTaskTransaction($id)
	{
		$builder = $this->db->table('task_request_payments');
		$builder->delete(['payment_id' => $id]);

		$builder = $this->db->table('task_request_payment_meta');
		$builder->delete(['payment_id' => $id]);        
		
		return true;		
	}
}