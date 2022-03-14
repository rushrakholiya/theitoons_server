<?php
 
namespace App\Controllers\Admin;

use App\Models\TaskrequestModel;

class AllTaskRequests extends \App\Controllers\Admin\HFA_Controller
{
    public $usersModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->taskrequestModel = new TaskrequestModel();
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
            $data['taskrequestdata'] = $this->taskrequestModel->displayAllTaskRequests();
            if(!empty($data['taskrequestdata']))
            {
                return $this->headerfooter('allTaskRequests',$data);
            }
            else
            { 
                $data = [];
                $data['error'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('allTaskRequests',$data);
            }
        }
    }
    public function viewTaskRequest($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['taskrequestinfo'] = $this->taskrequestModel->viewTaskRequest($id);
            if(!empty($data['taskrequestinfo']))
            {
                return $this->headerfooter('editTaskRequest',$data);
            }
            else
            { 
                $data = [];
                $data['error'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('editTaskRequest',$data);
            }
        }
    }
    public function editTaskRequest($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            if( $this->request->getMethod() == "post" ){
                $taskdata = [
                    'task_status'=> $this->request->getVar('task_status'),
                ];
                $taskmetadata = [
                ['meta_key' => 'requesttype','meta_value' => $this->request->getVar('requesttype'),],
                ['meta_key' => 'priority','meta_value' => $this->request->getVar('priority'),],
                ['meta_key' => 'task_description','meta_value' => $this->request->getVar('task_description'),],
                ['meta_key' => 'constraint','meta_value' => $this->request->getVar('constraint'),],
                ['meta_key' => 'deadline','meta_value' => $this->request->getVar('deadline'),],
                ['meta_key' => 'budget','meta_value' => $this->request->getVar('budget'),],
                ];
                if($this->taskrequestModel->editTaskRequest($id,$taskdata,$taskmetadata))
                {
                    $this->session->setTempdata('success','Task Request updated Successfully.',2);
                    return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! Task Request not updated, Try again.',2);
                    return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                }               
                
            }
            else
            {
                $data = [];
                return $this->headerfooter('editTaskRequest',$data);
            }
        }
    }
    public function deleteTaskRequest($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $deleteresponse = $this->taskrequestModel->deleteTaskRequest($id);
            if( $deleteresponse == true )
            {            
                $this->session->setTempdata('success','Task Request Deleted Successfully.',2);
                return redirect()->to(base_url().'/admin/allTaskRequests');
            }
            else
            { 
                $this->session->setTempdata('error','Not Deleted. Try again.',2);
                return redirect()->to(base_url().'/admin/allTaskRequests');
            }
        }
    }
}