<?php
namespace App\Controllers;

class HF_Controller extends BaseController
{    
    function loginheaderfooter($template_name){
        if (! is_file(APPPATH . 'Views/admin/' . $template_name . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($template_name);
        }
        $data['title'] = ucfirst($template_name)." - TheIToons"; // Capitalize the first letter

        echo view('admin/innerpages/loginheader',$data);
        echo view('admin/'.$template_name,$data);
        echo view('admin/innerpages/loginfooter',$data);
    }
	function headerfooter($template_name){
        if (! is_file(APPPATH . 'Views/admin/' . $template_name . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($template_name);
        }
        $data['title'] = ucfirst($template_name)." - TheIToons"; // Capitalize the first letter

		echo view('admin/innerpages/header',$data);
  		echo view('admin/'.$template_name,$data);
  		echo view('admin/innerpages/footer',$data);
	}
}