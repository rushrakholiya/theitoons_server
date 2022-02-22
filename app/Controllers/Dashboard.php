<?php
 
namespace App\Controllers;

class Dashboard extends HF_Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
    }
    public function index()
    {       
        $data = [];
        $this->headerfooter('dashboard',$data);    
    }    
}