<?php
 
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {        
        $data = [];
        $data['title']         = 'Login - TheIToons';
        $data['main_content']  = 'admin/login';// page name
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function register()
    {
        $data = [];
        $data['title']         = 'Registration - TheIToons';
        $data['main_content']  = 'admin/register';// page name
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function forgot_password()
    {
        $data = [];
        $data['title']         = 'Forgot Password - TheIToons';
        $data['main_content']  = 'admin/forgot_password';// page name
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function dashboard()
    {
        $data = [];
        $data['title']         = 'Dashboard - TheIToons';
        $data['main_content']  = 'admin/dashboard';// page name
        echo view('admin/innerpages/template',$data);
    }
    
}