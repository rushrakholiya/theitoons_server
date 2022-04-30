<?php
 
namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends HF_Controller
{    
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->dashboardModel = new DashboardModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {    
        $data = [];
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['totaltaskno'] = null;
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }

            $totaltask = $this->dashboardModel->viewAllTaskRequestByUserid($uid);
            if(!empty($totaltask) && $totaltask >= 3){
                //$data['totaltaskno'] = $totaltask;
                $data['totaltaskno'] = "There are 3 requests open, you will be able to submit new requests once any one requests gets resolved";
            }

            $data['taskrequestdata'] = $this->dashboardModel->displayAllTaskRequests($uid);
            if(!empty($data['taskrequestdata']))
            {
                return $this->loginheaderfooter('dashboard',$data);
            }
            else
            { 
                $data = [];
                $data['error'] = "Requests not found!!!";
                return $this->loginheaderfooter('dashboard',$data);
            }
            
            return $this->loginheaderfooter('dashboard',$data);
                               
        }    
    }
    public function deleteTaskRequest($id=null)
    {
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }
            $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
            if( $checkauthorizeduser == true )
            {
                $deleteresponse = $this->dashboardModel->deleteTaskRequest($id);
                if( $deleteresponse == true )
                {            
                    $this->session->setTempdata('success','Task Request Deleted Successfully.',2);
                    return redirect()->to(base_url().'/dashboard');
                }
                else
                { 
                    $this->session->setTempdata('error','Not Deleted. Try again.',2);
                    return redirect()->to(base_url().'/dashboard');
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user to delete the request.',2);
                return redirect()->to(base_url().'/dashboard');
            }

        }
    }
    public function completeTaskRequest($id=null)
    {
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }
            $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
            if( $checkauthorizeduser == true )
            {
                $completeresponse = $this->dashboardModel->completeTaskRequest($id);
                if( $completeresponse == true )
                {            
                    $this->session->setTempdata('success','Task Request Completed Successfully.',2);
                    return redirect()->to(base_url().'/dashboard');
                }
                else
                { 
                    $this->session->setTempdata('error','Not Completed. Try again.',2);
                    return redirect()->to(base_url().'/dashboard');
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user to complete the request.',2);
                return redirect()->to(base_url().'/dashboard');
            }
        }
    }
    public function viewTaskRequest($id=null)
    {
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }
            $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
            if( $checkauthorizeduser == true )
            {
                $data['taskrequestinfo'] = $this->dashboardModel->viewTaskRequest($id);
                if(!empty($data['taskrequestinfo']))
                {
                    return $this->loginheaderfooter('viewTaskRequest',$data);
                }
                else
                { 
                    $data = [];
                    $data['error'] = "Sorry! No Records found, Try again.";
                    return $this->loginheaderfooter('viewTaskRequest',$data);
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user to view the request.',2);
                return redirect()->to(base_url().'/dashboard');
            }
        }
    }
    public function editTaskRequest($id=null)
    {
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];$uid = "";
            if(session()->has('logged_user_client')){
                $uid=session()->get('logged_user_client'); 
            }
            $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
            if( $checkauthorizeduser == true )
            {

                if( $this->request->getMethod() == "post" ){                    
                    $path = "";
                    $file =  $this->request->getFile('reference');
                    if(empty($file->getName())){
                        $reference_img = getTaskRequestMeta("reference_img", $id);
                        if(!empty($reference_img->meta_value)){
                            $path = $reference_img->meta_value;
                        }
                    }
                    else{
                        if($file->move(FCPATH.'public/taskrequest', $file->getName()))
                        {
                            $path = base_url().'/public/taskrequest/'.$file->getName();
                        } 
                    }

                    $taskdata = [
                        'task_title' => $this->request->getVar('title'),
                    ];
                    $taskmetadata = [
                    ['meta_key' => 'requesttype','meta_value' => $this->request->getVar('requesttype'),],
                    ['meta_key' => 'priority','meta_value' => $this->request->getVar('priority'),],
                    ['meta_key' => 'task_description','meta_value' => $this->request->getVar('task_description'),],
                    ['meta_key' => 'reference_img','meta_value' => $path,],
                    ['meta_key' => 'constraint','meta_value' => $this->request->getVar('constraint'),],
                    ['meta_key' => 'deadline','meta_value' => $this->request->getVar('deadline'),],
                    ['meta_key' => 'budget','meta_value' => $this->request->getVar('budget'),],
                    ];
                    if($this->dashboardModel->editTaskRequest($id,$taskdata,$taskmetadata))
                    {
                        $this->session->setTempdata('success','Task Request updated Successfully.',2);
                        return redirect()->to(base_url().'/dashboard');
                    }
                    else
                    {
                        $this->session->setTempdata('error','Sorry! Task Request not updated, Try again.',2);
                        return redirect()->to(base_url().'/dashboard');
                    }            
                }
                else
                {
                    $data['taskrequestinfo'] = $this->dashboardModel->viewTaskRequest($id);
                    if(!empty($data['taskrequestinfo']))
                    {
                        return $this->loginheaderfooter('editTaskRequest',$data);
                    }
                    else
                    { 
                        $data['error'] = "Sorry! No Records found, Try again.";
                        return $this->loginheaderfooter('editTaskRequest',$data);
                    }
                    //return $this->loginheaderfooter('dashboard/editTaskRequest/'.$id,$data);
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user to view the request.',2);
                return redirect()->to(base_url().'/dashboard');
            }
        }
    }
}