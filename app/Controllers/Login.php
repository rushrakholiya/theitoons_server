<?php
 
namespace App\Controllers;

use App\Models\LoginModel;

class Login extends HF_Controller
{
    public $loginModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->loginModel = new LoginModel();
        $this->session = \Config\Services::session();
        if(session()->has('logged_user'))
        {
            session()->remove('logged_user');
            session()->destroy();
        }
        if(session()->has('logged_user_client'))
        {
            session()->remove('logged_user_client');
            session()->destroy();
        }
    }
    public function index()
    {       
        $data = [];
        $data['validation'] = null;
        if( $this->request->getMethod() == "post" )
        {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[6]|max_length[16]',
            ];      
        
            if( $this->validate($rules) )
            {
                $useremail = $this->request->getVar('email',FILTER_SANITIZE_EMAIL);
                $userpassword = md5($this->request->getVar('password'));
                $userdata = $this->loginModel->verifyUser($useremail);
                if($userdata)
                {
                    if( $userpassword == $userdata['user_password'] )
                    {
                        if($userdata['user_status']==1 )
                        {
                            $user_role = getUserMeta("user_role", $userdata['user_id']);
                            if($user_role->meta_value=="admin"){ 
                                $this->session->set('logged_user',$userdata['user_id']);
                                return redirect()->to(base_url()."/admin/dashboard");
                            }
                            else
                            {
                                $this->session->set('logged_user_client',$userdata['user_id']);
                                return redirect()->to(base_url()."/taskRequest");
                            }
                        }
                        else
                        {
                            $this->session->setTempdata('error','Please activate your account, Contact Admin.',2);
                            return redirect()->to(current_url());
                        }
                    }
                    else
                    {
                        $this->session->setTempdata('error','Password not match, Try again.',2);
                        return redirect()->to(current_url());
                    }                    
                }
                else
                {
                    $this->session->setTempdata('error','Email does not exists, Try again.',2);
                    return redirect()->to(current_url());
                }
            }
            else
            {
                $data['validation'] = $this->validator;
                return $this->loginheaderfooter('login',$data);
            }
        }
        else
        {
            return $this->loginheaderfooter('login',$data);
        }
    }
    public function forgotPassword()
    {       
        $data = [];
        $data['validation'] = null;
        if( $this->request->getMethod() == "post" )
        {
            $rules = [
                'email'    => 'required|valid_email',
            ];      
        
            if( $this->validate($rules) )
            {
                $useremail = $this->request->getVar('email',FILTER_SANITIZE_EMAIL);
                
                $userdata = $this->loginModel->verifyUser($useremail);
                if($userdata)
                {
                       $site_name = getGeneralData("site_name");
                        if(!empty($site_name->option_value))
                        {$sitename=$site_name->option_value;}else{$sitename="TheIToons";}
                       $admin_email = getGeneralData("admin_email");
                        if(!empty($admin_email->option_value))
                        {$admin_email=$admin_email->option_value;}else{$admin_email="me@preraktrivedi.com";}
                       $to = $useremail;
                       $subject = 'Reset Password Link | '.$sitename;
                       $token = $userdata['user_id'];
                       $message = 'Hi '.$userdata['user_name'].',<br><br> Your reset password request has been received. Please click the below link to reset your password.<br><br><a href="'.base_url().'/login/resetPassword/'.$token.'" target="_blank">Click here to reset password</a><br><br> Thanks,<br>'.$sitename;
                       $email = \Config\Services::email();
                       $email->setHeader('Content-Type', 'text/html; charset=UTF-8\r\n');
                       $email->setTo($to);
                       $email->setFrom($admin_email,$sitename);
                       $email->setSubject($subject);
                       $email->setMessage($message);

                       if($email->send())
                       {
                            $this->session->setTempdata('success','Reset passowrd link sent to your registered email. Please verify',2);
                            return redirect()->to(current_url());
                       }
                       else
                       {
                            $this->session->setTempdata('error',$email->printDebugger(['headers']),2);
                            return redirect()->to(current_url());
                       }
                }
                else
                {
                    $this->session->setTempdata('error','Email does not exists, Try again.',2);
                    return redirect()->to(current_url());
                }
            }
            else
            {
                $data['validation'] = $this->validator;
                return $this->loginheaderfooter('forgot_password',$data); 
            }
        }
        else
        {
            return $this->loginheaderfooter('forgot_password',$data); 
        }
    } 
    public function resetPassword($token=null)
    {       
        $data = [];
        $data['validation'] = null;
        if(!empty($token))
        {       
            $userdata = $this->loginModel->verifyToken($token);
            if($userdata)
            {
                if( $this->request->getMethod() == "post" )
                {
                    $rules = [
                    'password'     => 'required|min_length[6]|max_length[16]',
                    'confirm_password' => 'required|matches[password]',
                    ];      
                
                    if( $this->validate($rules) ){
                        
                        $usernewpassword = md5( $this->request->getVar('password') );
                        
                        if($this->loginModel->updateUserPassword($token,$usernewpassword))
                        {
                            $this->session->setTempdata('success','Password updated Successfully, Login now',2);
                            return redirect()->to(base_url()."/login"); 
                        }
                        else
                        {
                            $this->session->setTempdata('error','Sorry! Unable to update, Try again.',2);
                            return redirect()->to(current_url());
                        }
                    }
                    else{
                        $data['validation'] = $this->validator;
                        return $this->loginheaderfooter('reset_password',$data);
                    }

                }
                else
                {
                    return $this->loginheaderfooter('reset_password',$data); 
                }
            }
            else
            {
                $data['error'] = "Unable to find user account.";
                return $this->loginheaderfooter('reset_password',$data); 
            }
        }
        else
        {
            $data['error'] = "Sorry! Unauthourized access.";
            return $this->loginheaderfooter('reset_password',$data); 
        }
        
    }
    
}