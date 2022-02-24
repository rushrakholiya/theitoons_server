<?php
 
namespace App\Controllers;

class Dashboard extends HF_Controller
{
    public $dashboardModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
    }
    public function index()
    {       
        $data = [];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            return $this->headerfooter('dashboard',$data);
        }
            
    } 
    public function logout()
    {       
        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url()."/login");            
    }    
}