<?php
 
namespace App\Controllers;

use App\Models\UsersModel;

class Users extends HF_Controller
{
    public $usersModel;
    public function __construct()
    {
        helper(['form', 'url','usermeta']);
        $this->usersModel = new UsersModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {       
        $data = [];
        $data['userdata'] = $this->usersModel->displayUsers();
        if(!empty($data['userdata']))
        {
            $this->headerfooter('users',$data);
        }
        else
        { 
            $data = [];
            $data['userdataerror'] = "Sorry! No Records found, Try again.";
            $this->headerfooter('users',$data);
        }
    }
    public function viewUser($id=null)
    {
        $data = [];
        $data['userinfo'] = $this->usersModel->viewUser($id);
        if(!empty($data['userinfo']))
        {
            $this->headerfooter('editUser',$data);
        }
        else
        { 
            $data = [];
            $data['userinfoerror'] = "Sorry! No Records found, Try again.";
            $this->headerfooter('editUser',$data);
        }

    }
    public function editUser($id=null)
    {
        if( $this->request->getMethod() == "post" ){
            $data = []; 
            $path = "";
            $file =  $this->request->getFile('avatar');
            if($file->move(FCPATH.'public\profiles', $file->getName()))
            {
                $path = base_url().'/public/profiles/'.$file->getName();
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
                return redirect()->to(base_url().'/users/viewUser/'.$id);
            }
            else
            {
                $this->session->setTempdata('erroreditUser','Sorry! User not updated, Try again.',2);
                return redirect()->to(base_url().'/users/viewUser/'.$id);
            }
            
        }
        else
        {
            return $this->headerfooter('editUser',$data);
        }
    }
    public function deleteUser($id=null)
    {
        $data = [];
        $deleteresponse = $this->usersModel->deleteUser($id);
        if( $deleteresponse == true )
        {            
            $this->session->setTempdata('successdelete','User Deleted Successfully.',2);
            return redirect()->to('users');
        }
        else
        { 
            $this->session->setTempdata('errordelete','Not Deleted. Try again.',2);
            return redirect()->to('users');
        }

    }   
}