<?php
 
namespace App\Controllers;

use App\Models\TaskrequestModel;

class taskRequest extends HF_Controller
{    
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->taskrequestModel = new TaskrequestModel();
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
            $data['validation'] = null;
            /*if( $this->request->getMethod() == "post" )
            {                
                $rules = [
                'title'     => 'required',
                'priority'  => 'required',
                'task_description' => 'required',
                ];      
            
                if( $this->validate($rules) ){
                    $path = ""; $cid = "";
                    $file =  $this->request->getFile('reference');
                    if(!empty($file->getName()))
                    {                      
                        if($file->move(FCPATH.'public/taskrequest', $file->getName()))
                        {
                            $path = base_url().'/public/taskrequest/'.$file->getName();
                        } 
                    }
                    if(session()->has('logged_user_client')){$cid=session()->get('logged_user_client'); }
                    $taskdata = [
                        'user_id'=> $cid,                        
                        'task_title' => $this->request->getVar('title'),
                        'task_status'=> "pending",                        
                    ];
                    $taskid = $this->taskrequestModel->addNewTaskRequest($taskdata);
                    if(!empty($taskid))
                    {
                        $taskmetadata = [
                            ['task_id' => $taskid,'meta_key' => 'requesttype','meta_value' => $this->request->getVar('requesttype'),],
                            ['task_id' => $taskid,'meta_key' => 'priority','meta_value' => $this->request->getVar('priority'),],
                            ['task_id' => $taskid,'meta_key' => 'task_description','meta_value' => $this->request->getVar('task_description'),],
                            ['task_id' => $taskid,'meta_key' => 'reference_img','meta_value' => $path,],
                            ['task_id' => $taskid,'meta_key' => 'constraint','meta_value' => $this->request->getVar('constraint'),],
                            ['task_id' => $taskid,'meta_key' => 'deadline','meta_value' => $this->request->getVar('deadline'),],
                            ['task_id' => $taskid,'meta_key' => 'budget','meta_value' => $this->request->getVar('budget'),],
                        ];
                        if($this->taskrequestModel->addNewTaskRequestMeta($taskmetadata))
                        {
                            $this->session->setTempdata('success','Thank you! Your request has been successfully received.',2);
                            return redirect()->to(base_url().'/taskRequest'); 
                        }
                        else
                        {
                            $this->session->setTempdata('error','Sorry! Your request not received, Try again.',2);
                            return redirect()->to(current_url());
                        }
                       
                    }
                    else
                    {
                        $this->session->setTempdata('error','Sorry! Your request not received, Try again.',2);
                        return redirect()->to(current_url());
                    }
                }
                else
                {
                    $data['validation'] = $this->validator;
                    return $this->loginheaderfooter('task_request',$data);
                }
            }
            else
            {*/
                return $this->loginheaderfooter('task_request',$data);
            //}                    
        }    
    }    
}