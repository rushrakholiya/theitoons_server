<?php
 
namespace App\Controllers;

class Admin extends \CodeIgniter\Controller
{
    public function index()
    {
        return view('admin/login');
    }
    public function register()
    {
        return view('admin/register');
    }
    public function dashboard()
    {
        return view('admin/dashboard');
    }
    public function forgot_password()
    {
        return view('admin/forgot_password');
    }
    
}