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
    public function addDeliverDataTask($id=null)
    {
        $data = [];
        if( $this->request->getMethod() == "post" ){
            $deliver_file = getTaskRequestMeta("deliver_file", $id);
            $task_deliver_description = getTaskRequestMeta("task_deliver_description", $id);
            if($deliver_file || $task_deliver_description){
                if(!empty($deliver_file->meta_value) || !empty($task_deliver_description->meta_value))
                {
                    $path = "";
                    /*$file =  $this->request->getFile('deliver_file');
                    if(!empty($file->getName()))
                    {                      
                        $filename = "deliver_".$file->getName();
                        if($file->move(FCPATH.'public/taskrequest', $filename ))
                        {
                            $path = base_url().'/public/taskrequest/'.$filename ;
                        } 
                    } else {$path = $deliver_file->meta_value;}*/
                    
                    if($_FILES['deliver_file']['size'][0] <= 0)
                    {
                       $path = $deliver_file->meta_value;
                    }
                    else{
                        foreach($this->request->getFileMultiple('deliver_file') as $file)
                        {   
                            $filename = "deliver_".$file->getName();
                            if($file->move(FCPATH.'public/taskrequest', $filename ))
                            {
                                $fileBasename = base_url().'/public/taskrequest/'.$filename;
                                $path .= "'".$fileBasename."',";
                            }                    
                        }                 
                    }
                    $utaskdeliverdata = [                
                        ['meta_key' => 'deliver_file','meta_value' => $path,],
                        ['meta_key' => 'task_deliver_description','meta_value' => $this->request->getVar('task_deliver_description'),],                
                    ];
                    if($this->taskrequestModel->updateTaskRequestMeta($id,$utaskdeliverdata))
                    {
                        $requesttitle = getTaskRequest($id);
                        $userdata = getLoggedInUserData($requesttitle->user_id);
                        $useremail = $userdata->user_email;
                        $username = $userdata->user_name;
                        $adeliver_file = getTaskRequestMeta("deliver_file", $id);

                        $site_name = getGeneralData("site_name");
                        if(!empty($site_name->option_value)){$sitename=$site_name->option_value;}else{$sitename="TheIToons";}

                        $admin_email = getGeneralData("admin_email");
                        if(!empty($admin_email->option_value))
                        {$admin_email=$admin_email->option_value;}
                        
                        //sent mail to client
                        $to = $useremail;
                        $subject = 'Deliver a file | '.$sitename;
                        $message = "";
                        $message .= 'Dear user ('.$username.'),<br><br>';
                        $message .= 'Please find Updated Deliver file in attachment for your "'.$requesttitle->task_title.'" request.<br>You can check in your <a href="'.base_url().'/dashboard" target="_blank">Dashboard</a> too.<br>';
                        $message .= '<br>If any changes required, you can contact us via email.<br><br>Best Regards,<br>'.$sitename;
                        $email = \Config\Services::email();
                        $email->setTo($to);
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        //$email->attach($path);
                        if($adeliver_file->meta_value){
                            $adeliverarray = array_filter(explode(',',$adeliver_file->meta_value));
                            if(!empty($adeliverarray)){
                                foreach($adeliverarray as $adimga){
                                    $adimgaaresult = str_replace("'", '', $adimga);
                                    $email->attach($adimgaaresult);
                                }
                            }
                        }
                        $email->send();

                        //$email->printDebugger(['headers']);
                        //$this->session->setTempdata('success',$email->printDebugger(['headers']),2);

                        $this->session->setTempdata('success','Deliver Data updated Successfully.',2);
                        return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                    }
                    else
                    {
                        $this->session->setTempdata('error','Sorry! Deliver Data not updated, Try again.',2);
                        return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                    }

                }
            }else{
                $path = "";
                /*$file =  $this->request->getFile('deliver_file');
                if(!empty($file->getName()))
                {                      
                    $filename = "deliver_".$file->getName();
                    if($file->move(FCPATH.'public/taskrequest', $filename ))
                    {
                        $path = base_url().'/public/taskrequest/'.$filename ;
                    } 
                }*/
                if($_FILES['deliver_file']['size'][0] > 0){                    
                    foreach($this->request->getFileMultiple('deliver_file') as $file)
                    {   
                        $filename = "deliver_".$file->getName();
                        if($file->move(FCPATH.'public/taskrequest', $filename ))
                        {
                            $fileBasename = base_url().'/public/taskrequest/'.$filename;
                            $path .= "'".$fileBasename."',";
                        }                    
                    }                    
                }
                $taskdeliverdata = [                
                    ['task_id' => $id,'meta_key' => 'deliver_file','meta_value' => $path,],
                    ['task_id' => $id,'meta_key' => 'task_deliver_description','meta_value' => $this->request->getVar('task_deliver_description'),],                
                ];
                if($this->taskrequestModel->addNewTaskRequestMeta($taskdeliverdata))
                {
                    $requesttitle = getTaskRequest($id);
                    $userdata = getLoggedInUserData($requesttitle->user_id);
                    $useremail = $userdata->user_email;
                    $username = $userdata->user_name;
                    $adeliver_file = getTaskRequestMeta("deliver_file", $id);

                    $site_name = getGeneralData("site_name");
                    if(!empty($site_name->option_value)){$sitename=$site_name->option_value;}else{$sitename="TheIToons";}

                    $admin_email = getGeneralData("admin_email");
                    if(!empty($admin_email->option_value))
                    {$admin_email=$admin_email->option_value;}
                    
                    //sent mail to client
                    $to = $useremail;
                    $subject = 'Deliver a file | '.$sitename;
                    $message = "";
                    $message .= 'Dear user ('.$username.'),<br><br>';
                    $message .= 'Please find Deliver file in attachment for your "'.$requesttitle->task_title.'" request.<br>You can check in your <a href="'.base_url().'/dashboard" target="_blank">Dashboard</a> too.<br>';
                    $message .= '<br>If any changes required, you can contact us via email.<br><br>Best Regards,<br>'.$sitename;
                    $email = \Config\Services::email();
                    $email->setTo($to);
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    //$email->attach($path);
                    if($adeliver_file->meta_value){
                        $adeliverarray = array_filter(explode(',',$adeliver_file->meta_value));
                        if(!empty($adeliverarray)){
                            foreach($adeliverarray as $adimga){
                                $adimgaaresult = str_replace("'", '', $adimga);
                                $email->attach($adimgaaresult);
                            }
                        }
                    }
                    $email->send();

                    $this->session->setTempdata('success','Deliver Data added Successfully.',2);
                    return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! Deliver Data not added, Try again.',2);
                    return redirect()->to(base_url().'/admin/allTaskRequests/viewTaskRequest/'.$id);
                }
            }       
        }
        else
        {
            $data = [];
            return $this->headerfooter('editTaskRequest',$data);
        }
    }
    /*public function sendRevisedDate($id=null)
    {
        $data = [];
        $taskinfo = $this->taskrequestModel->viewTaskRequest($id);
        print_r($taskinfo->user_id);
        /*if(session()->has('logged_user')){$uid=session()->get('logged_user'); }
        if( $this->request->getMethod() == "post" ){                
            $rdeadline = [
                'task_id'=>$id,
                'user_id'=>$uid,
                'revised_deadline'=> $this->request->getVar('rdeadline'),
                'revised_deadline_status'=>'reject',
            ];
            if($this->taskrequestModel->sendRevisedDate($rdeadline))
            {
               
                $userdata = getLoggedInUserData($cid);
                $useremail = $userdata->user_email;
                $username = $userdata->user_name;

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
        } */
    /*}*/
}