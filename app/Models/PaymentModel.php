<?php
namespace App\Models;

use \CodeIgniter\Model;

class PaymentModel extends Model
{
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
}