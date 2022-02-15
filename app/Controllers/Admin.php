<?php
 
namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {        
        $baseurl = base_url("/public/assets");
        $siteurl = base_url();
        $data = [];
        $data['title']         = 'Login - TheIToons';
        $data['main_content']  = 'admin/login';// page name
        $data['base_url']      = $baseurl;
        $data['site_url']      = $siteurl;
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function register()
    {
        $baseurl = base_url("/public/assets");
        $siteurl = base_url();
        $data = [];
        $data['title']         = 'Registration - TheIToons';
        $data['main_content']  = 'admin/register';// page name
        $data['base_url']      = $baseurl;
        $data['site_url']      = $siteurl;
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function forgot_password()
    {
        $baseurl = base_url("/public/assets");
        $siteurl = base_url();
        $data = [];
        $data['title']         = 'Forgot Password - TheIToons';
        $data['main_content']  = 'admin/forgot_password';// page name
        $data['base_url']      = $baseurl;
        $data['site_url']      = $siteurl;
        echo view('admin/innerpages/logintemplate',$data);
    }
    public function dashboard()
    {
        $baseurl = base_url("/public/assets");
        $siteurl = base_url();
        $data = [];
        $data['title']         = 'Dashboard - TheIToons';
        $data['main_content']  = 'admin/dashboard';// page name
        $data['base_url']      = $baseurl;
        $data['site_url']      = $siteurl;
        echo view('admin/innerpages/template',$data);
    }
    
}