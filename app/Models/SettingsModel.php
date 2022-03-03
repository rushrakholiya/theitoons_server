<?php
namespace App\Models;

use \CodeIgniter\Model;

class SettingsModel extends Model
{
	public function saveGeneralSetting($data)
	{
		$builder = $this->db->table('site_details');
		$builder->updateBatch($data,'option_name');
		if( $this->db->affectedRows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	public function savepaypalSetting($data)
	{
		$builder = $this->db->table('site_details');
		$builder->updateBatch($data,'option_name');
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