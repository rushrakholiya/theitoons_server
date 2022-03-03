<?php
namespace App\Controllers;

class HF_Controller extends BaseController
{    
    function loginheaderfooter($template_name,$data){
        print_r($template_name);
        /*if (! is_file(APPPATH . 'Views/' . $template_name . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($template_name);
        }*/
        $site_name = getGeneralData("site_name");
        if(!empty($site_name->option_value))
        {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}
        
        $template_name1 = str_replace('_', ' ', $template_name);
        $data['title'] = ucwords($template_name1)." - ".$sitename; // Capitalize the first letter

        echo view('loginheader',$data);
        echo view($template_name,$data);
        echo view('loginfooter',$data);
    }
}