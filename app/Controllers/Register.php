<?php
 
namespace App\Controllers;

use App\Models\RegisterModel;

class Register extends HF_Controller
{
    public $registerModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->registerModel = new RegisterModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {        
        $data = [];
        $data['validation'] = null;
        if( $this->request->getMethod() == "post" ){
            
            $rules = [
            'username'     => 'required|min_length[4]|max_length[20]',
            'email'        => 'required|valid_email|is_unique[users.user_email]',
            'password'     => 'required|min_length[6]|max_length[16]',
            'confirm_password' => 'required|matches[password]',
            'terms'        => 'required',
            ];      
        
            if( $this->validate($rules) ){
                $userdata = [
                    'user_name' => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                    'user_password' => md5( $this->request->getVar('password') ),
                    'user_email' => $this->request->getVar('email'),
                ];
                if($this->registerModel->createUser($userdata))
                {
                    $this->session->setTempdata('success','Welcome! Account created Successfully.',2);
                    return redirect()->to(base_url().'/taskRequest'); 
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! Unable to create account, Try again.',2);
                    return redirect()->to(current_url());
                }
            }
            else{
                $data['validation'] = $this->validator;
                return $this->loginheaderfooter('register',$data);
            }
        }
        else
        {
            return $this->loginheaderfooter('register',$data);
        }
        
    }    
}