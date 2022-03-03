<?php
 
namespace App\Controllers\Admin;

use App\Models\UsersModel;

class Users extends \App\Controllers\Admin\HFA_Controller
{
    public $usersModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->usersModel = new UsersModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {       
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['userdata'] = $this->usersModel->displayUsers();
            if(!empty($data['userdata']))
            {
                return $this->headerfooter('users',$data);
            }
            else
            { 
                $data = [];
                $data['userdataerror'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('users',$data);
            }
        }
    }
    public function addNewUser()
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['validation'] = null;
            if( $this->request->getMethod() == "post" ){
                
                $rules = [
                'username'     => 'required|min_length[4]|max_length[20]',
                'email'        => 'required|valid_email|is_unique[users.user_email]',
                'password'     => 'required|min_length[6]|max_length[16]',
                ];      
            
                if( $this->validate($rules) ){
                    $path = "";
                    $file =  $this->request->getFile('avatar');
                    if(!empty($file->getName()))
                    {                      
                        if($file->move(FCPATH.'public/profiles', $file->getName()))
                        {
                            $path = base_url().'/public/profiles/'.$file->getName();
                        } 
                    }
                    $userdata = [
                        'user_name' => $this->request->getVar('username',FILTER_SANITIZE_STRING),
                        'user_password' => md5( $this->request->getVar('password') ),
                        'user_email' => $this->request->getVar('email'),
                        'user_status' => $this->request->getVar('userstatus'),
                    ];
                    $userid = $this->usersModel->addNewUser($userdata);
                    if(!empty($userid))
                    {      
                        $usermetadata = [
                        ['user_id' => $userid,'meta_key' => 'profile_picture','meta_value' => $path,],
                        ['user_id' => $userid,'meta_key' => 'first_name','meta_value' => $this->request->getVar('firstname'),],
                        ['user_id' => $userid,'meta_key' => 'last_name','meta_value' => $this->request->getVar('lastname'),],
                        ['user_id' => $userid,'meta_key' => 'user_description','meta_value' => $this->request->getVar('userdescription'),],
                        ['user_id' => $userid,'meta_key' => 'user_role','meta_value' => $this->request->getVar('user_role'),],
                        ['user_id' => $userid,'meta_key' => 'company_name','meta_value' => $this->request->getVar('companyname'),],
                        ['user_id' => $userid,'meta_key' => 'address_one','meta_value' => $this->request->getVar('useraddressone'),],
                        ['user_id' => $userid,'meta_key' => 'address_two','meta_value' => $this->request->getVar('useraddresstwo'),],
                        ['user_id' => $userid,'meta_key' => 'user_country','meta_value' => $this->request->getVar('countryId'),],
                        ['user_id' => $userid,'meta_key' => 'user_state','meta_value' => $this->request->getVar('stateId'),],
                        ['user_id' => $userid,'meta_key' => 'user_city','meta_value' => $this->request->getVar('cityId'),],
                        ['user_id' => $userid,'meta_key' => 'user_zip','meta_value' => $this->request->getVar('userzip'),],
                        ['user_id' => $userid,'meta_key' => 'user_phone','meta_value' => $this->request->getVar('userphone'),],
                        ['user_id' => $userid,'meta_key' => 'user_anoter_email','meta_value' => $this->request->getVar('useranotheremail'),],
                    ];
                        if($this->usersModel->addNewUserMeta($usermetadata))
                        {
                            $this->session->setTempdata('success','User created Successfully.',2);
                            return redirect()->to(base_url().'/admin/users'); 
                        }
                        else
                        {
                            $this->session->setTempdata('error','Sorry! Unable to create user, Try again.',2);
                            return redirect()->to(base_url().'/admin/users/addNewUser');
                        }
                    }
                    else
                    {
                        $this->session->setTempdata('error','Sorry! Unable to create user, Try again.',2);
                        return redirect()->to(base_url().'/admin/users/addNewUser');
                    }
                }
                else{
                    $data['validation'] = $this->validator;
                    return $this->headerfooter('addNewUser',$data);
                }
            }
            else
            {
                return $this->headerfooter('addNewUser',$data);
            }
        }
    }
    public function viewUser($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['userinfo'] = $this->usersModel->viewUser($id);
            if(!empty($data['userinfo']))
            {
                return $this->headerfooter('editUser',$data);
            }
            else
            { 
                $data = [];
                $data['userinfoerror'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('editUser',$data);
            }
        }
    }
    public function editUser($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            if( $this->request->getMethod() == "post" ){
                $data = []; 
                $path = "";
                $file =  $this->request->getFile('avatar');
                if(empty($file->getName())){
                    $profile_picture=getUserMeta("profile_picture", $id);
                    if(!empty($profile_picture->meta_value)){
                        $path = $profile_picture->meta_value;
                    }
                }
                else{
                    if($file->move(FCPATH.'public/profiles', $file->getName()))
                    {
                        $path = base_url().'/public/profiles/'.$file->getName();
                    } 
                }
                $userdata = [
                    'user_status' => $this->request->getVar('userstatus'),
                ];
                $usermetadata = [
                    ['meta_key' => 'profile_picture','meta_value' => $path,],
                    ['meta_key' => 'first_name','meta_value' => $this->request->getVar('firstname'),],
                    ['meta_key' => 'last_name','meta_value' => $this->request->getVar('lastname'),],
                    ['meta_key' => 'user_description','meta_value' => $this->request->getVar('userdescription'),],
                    ['meta_key' => 'user_role','meta_value' => $this->request->getVar('user_role'),],
                    ['meta_key' => 'company_name','meta_value' => $this->request->getVar('companyname'),],
                    ['meta_key' => 'address_one','meta_value' => $this->request->getVar('useraddressone'),],
                    ['meta_key' => 'address_two','meta_value' => $this->request->getVar('useraddresstwo'),],
                    ['meta_key' => 'user_country','meta_value' => $this->request->getVar('countryId'),],
                    ['meta_key' => 'user_state','meta_value' => $this->request->getVar('stateId'),],
                    ['meta_key' => 'user_city','meta_value' => $this->request->getVar('cityId'),],
                    ['meta_key' => 'user_zip','meta_value' => $this->request->getVar('userzip'),],
                    ['meta_key' => 'user_phone','meta_value' => $this->request->getVar('userphone'),],
                    ['meta_key' => 'user_anoter_email','meta_value' => $this->request->getVar('useranotheremail'),],
                ];
                if($this->usersModel->editUser($id,$userdata,$usermetadata))
                {
                    $this->session->setTempdata('successeditUser','User updated Successfully.',2);
                    return redirect()->to(base_url().'/admin/users/viewUser/'.$id);
                }
                else
                {
                    $this->session->setTempdata('erroreditUser','Sorry! User not updated, Try again.',2);
                    return redirect()->to(base_url().'/admin/users/viewUser/'.$id);
                }
                
            }
            else
            {
                $data = [];
                return $this->headerfooter('editUser',$data);
            }
        }
    }
    public function deleteUser($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $deleteresponse = $this->usersModel->deleteUser($id);
            if( $deleteresponse == true )
            {            
                $this->session->setTempdata('success','User Deleted Successfully.',2);
                return redirect()->to(base_url().'/admin/users');
            }
            else
            { 
                $this->session->setTempdata('error','Not Deleted. Try again.',2);
                return redirect()->to(base_url().'/admin/users');
            }
        }
    }   
}