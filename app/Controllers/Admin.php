<?php
 
namespace App\Controllers;

class Admin extends HF_Controller
{
    public function index()
    {        
        $this->loginheaderfooter('login');
    }
    public function register()
    {
        $this->loginheaderfooter('register');
    }
    public function forgot_password()
    {
        $this->loginheaderfooter('forgot_password');
    }
    public function dashboard()
    {
        $this->headerfooter('dashboard');
    }
    
}