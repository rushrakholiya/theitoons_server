<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiteDetailSeeder extends Seeder
{
    public function run()
    {
        $generaldata = [
            ['option_name' => 'site_name','option_value' => "",],
            ['option_name' => 'site_favicon','option_value' => "",],
            ['option_name' => 'site_logo','option_value' => "",],  
            ['option_name' => 'admin_email','option_value' => "",],
            ['option_name' => 'smtpadmin_email','option_value' => "",],
            ['option_name' => 'smtpadmin_pass','option_value' => "",],
            ['option_name' => 'paypal_enable_disable','option_value' =>"" ,],
            ['option_name' => 'paypal_sandbox','option_value' =>"" ,],
            ['option_name' => 'paypal_email','option_value' => "",],   
            ['option_name' => 'receiver_email','option_value' => "",],
            ['option_name' => 'live_API_username','option_value' => "",],
            ['option_name' => 'live_API_password','option_value' => "",],
            ['option_name' => 'live_API_signature','option_value' => "",],
        ];
        $builder = $this->db->table('site_details');
        $res = $builder->insertBatch($generaldata);
    }
}
