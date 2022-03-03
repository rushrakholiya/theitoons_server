<?php
 
namespace App\Controllers\Admin;

class Dashboard extends \App\Controllers\Admin\HFA_Controller
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