<?php
 
namespace App\Controllers;

class Login extends HF_Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {        
        $data = [];
        $this->loginheaderfooter('login',$data);
    }   
    
}