<?php
 
namespace App\Controllers\Admin;

use App\Models\CommentsModel;

class Comments extends \App\Controllers\Admin\HFA_Controller
{
    public $commentsModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->commentsModel = new CommentsModel();
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
            $auid = session()->get('logged_user'); 
            $data['commentsdata'] = $this->commentsModel->displayComments($auid);
            if(!empty($data['commentsdata']))
            {
                return $this->headerfooter('comments',$data);
            }
            else
            { 
                $data = [];
                $data['commentdataerror'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('comments',$data);
            }
        }
    }
    public function addCommentReply()
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
                $commentreplydata = [
                    'user_id' => $this->request->getVar('cuser_id'),
                    'task_id' => $this->request->getVar('ctask_id') ,
                    'comment_author' => $this->request->getVar('comment_author'),
                    'comment_author_email' => $this->request->getVar('comment_author_email'),
                    'comment_parent' => $this->request->getVar('comment_parent'),
                    'comment_content' => $this->request->getVar('comment_text'),
                    'comment_type'=>'comment',
                    'comment_status'=> 1,
                ];
                if($this->commentsModel->addCommentReply($commentreplydata))
                {
                    $this->session->setTempdata('success','Comment added Successfully.',2);
                    return redirect()->to(base_url().'/admin/comments'); 
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! Comment not added, Try again.',2);
                    return redirect()->to(base_url().'/admin/comments');
                }               
            }
            else
            {
                return $this->headerfooter('comments',$data);
            }
        }
    }
    /*public function viewUser($id=null)
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

                $user_manager=getUserMeta("user_manager", $id);
                if(empty($user_manager) && empty($user_manager->meta_value)){
                    $user_managerdata = [
                        ['user_id' => $id,'meta_key' => 'user_manager','meta_value' => $this->request->getVar('user_manager'),],                        
                    ];
                    $this->usersModel->addNewUserMeta($user_managerdata);
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
                    ['meta_key' => 'user_manager','meta_value' => $this->request->getVar('user_manager'),],
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
    }*/
    public function deleteComment($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $deleteresponse = $this->commentsModel->deleteComment($id);
            if( $deleteresponse == true )
            {            
                $this->session->setTempdata('success','Comment Deleted Successfully.',2);
                return redirect()->to(base_url().'/admin/comments');
            }
            else
            { 
                $this->session->setTempdata('error','Not Deleted. Try again.',2);
                return redirect()->to(base_url().'/admin/comments');
            }
        }
    }
}