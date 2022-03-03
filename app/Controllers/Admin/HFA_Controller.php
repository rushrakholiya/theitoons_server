<?php
namespace App\Controllers\Admin;

class HFA_Controller extends \App\Controllers\BaseController
{    
	function headerfooter($template_name,$data){
        if (! is_file(APPPATH . 'Views/admin/' . $template_name . '.php')) {
          throw new \CodeIgniter\Exceptions\PageNotFoundException($template_name);
        }
        $site_name = getGeneralData("site_name");
        if(!empty($site_name->option_value))
        {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}
        
        $template_name1 = str_replace('_', ' ', $template_name);
        $data['title'] = ucwords($template_name1)." - ".$sitename; // Capitalize the first letter
        //$data['title'] = ucfirst($template_name)." - ".$sitename; // Capitalize the first letter

		  echo view('admin/header',$data);
  		echo view('admin/'.$template_name,$data);
  		echo view('admin/footer',$data);
	}
}