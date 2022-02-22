<?php
 
namespace App\Controllers;

class ForgotPassword extends HF_Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {       
        $data = [];
        $this->loginheaderfooter('forgot_password',$data);  
    }    
}