<?php
 
namespace App\Controllers;

class Admin extends HF_Controller
{
    public function index()
    {        
        $this->loginheaderfooter('login',$data);
    }
    public function register()
    {
        $this->loginheaderfooter('register',$data);
    }
    public function forgot_password()
    {
        $this->loginheaderfooter('forgot_password',$data);
    }
    public function dashboard()
    {
        $this->headerfooter('dashboard',$data);
    }
    
}