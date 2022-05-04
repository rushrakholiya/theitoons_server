<?php
 
namespace App\Controllers;

use App\Models\TaskrequestModel;

class TaskRequest extends HF_Controller
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
            $data['totaltaskno'] = null;
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }

            $totaltask = $this->taskrequestModel->viewAllTaskRequestByUserid($uid);
            if(!empty($totaltask) && $totaltask >= 3){
                //$data['totaltaskno'] = $totaltask;
                $data['totaltaskno'] = "There are 3 requests open, you will be able to submit new requests once any one requests gets resolved";
            }
            if( $this->request->getMethod() == "post" )
            {                
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
                        //sent mail to admin and user
                        $userdata = getLoggedInUserData($cid);
                        $useremail = $userdata->user_email;
                        $username = $userdata->user_name;

                        $requesttype = getTaskRequestMeta("requesttype", $taskid);
                        $priority=getTaskRequestMeta("priority", $taskid);
                        $task_description = getTaskRequestMeta("task_description", $taskid);
                        $reference_img = getTaskRequestMeta("reference_img", $taskid);
                          if($reference_img->meta_value){                 
                          $refimg = explode('/', $reference_img->meta_value);
                          $refimgname = array_reverse($refimg);
                          }
                        $img = file_get_contents($reference_img->meta_value);
                        $imgdata = base64_encode($img);
                        $constraint=getTaskRequestMeta("constraint", $taskid);
                        $deadline=getTaskRequestMeta("deadline", $taskid);
                        $budget=getTaskRequestMeta("budget", $taskid);
                        
                        $site_name = getGeneralData("site_name");
                        if(!empty($site_name->option_value)){$sitename=$site_name->option_value;}else{$sitename="TheIToons";}

                        $admin_email = getGeneralData("admin_email");
                        if(!empty($admin_email->option_value)){$admin_email=$admin_email->option_value;}else{$admin_email="me@preraktrivedi.com";}
                        
                        //sent mail to user
                        $to = $useremail;
                        $subject = 'Thank you! | '.$sitename;
                        $message = "";
                        $message .= 'Dear user ('.$username.'),<br><br>Thank you for contacting us!';
                        $message .= '<table cellpadding="5"><tbody><tr><th valign="top" align="right">Email:</th><td>'.$useremail.'</td></tr><tr><th valign="top" align="right">Type:</th><td>'.$requesttype->meta_value.'</td></tr><tr><th valign="top" align="right">Task title:</th><td>'.$this->request->getVar('title').'</td></tr><tr><th valign="top" align="right">Priority:</th><td>'.$priority->meta_value.'</td></tr><tr><th valign="top" align="right">Task description:</th><td>'.$task_description->meta_value.'</td></tr><tr><th valign="top" align="right">Reference files:</th><td>'.$refimgname[0].'</td></tr><tr><th valign="top" align="right">Constraint:</th><td>'.$constraint->meta_value.'</td></tr><tr><th valign="top" align="right">Deadline:</th><td>'.$deadline->meta_value.'</td></tr><tr><th valign="top" align="right">Estimated budget:</th><td>$'.$budget->meta_value.'</td></tr></tbody></table>';
                        $message .= 'We will reply within 48 hours.<br>Best Regards, '.$sitename;
                        $message .= "<img src='data:image/x-icon;base64,$imgdata'/>";
                        $email = \Config\Services::email();
                        $email->setHeader('Content-Type', 'text/html; charset=UTF-8\r\n');
                        $email->setTo($to);
                        $email->setFrom($admin_email,$sitename);
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        $email->send();  

                        //sent mail to admin
                        $toa = $useremail;//$admin_email;
                        $subjecta = 'New question | '.$sitename;
                        $messagea = "";
                        $messagea .= 'The following information has been send by the submitter:';
                        $messagea .= '<table cellpadding="5"><tbody><tr><th valign="top" align="right">Name:</th><td>'.$username.'</td></tr><tr><th valign="top" align="right">Email:</th><td>'.$useremail.'</td></tr><tr><th valign="top" align="right">Type:</th><td>'.$requesttype->meta_value.'</td></tr><tr><th valign="top" align="right">Task title:</th><td>'.$this->request->getVar('title').'</td></tr><tr><th valign="top" align="right">Priority:</th><td>'.$priority->meta_value.'</td></tr><tr><th valign="top" align="right">Task description:</th><td>'.$task_description->meta_value.'</td></tr><tr><th valign="top" align="right">Reference files:</th><td>'.$refimgname[0].'</td></tr><tr><th valign="top" align="right">Constraint:</th><td>'.$constraint->meta_value.'</td></tr><tr><th valign="top" align="right">Deadline:</th><td>'.$deadline->meta_value.'</td></tr><tr><th valign="top" align="right">Estimated budget:</th><td>$'.$budget->meta_value.'</td></tr></tbody></table>';
                        $messagea .= 'We will reply within 48 hours.<br>Best Regards, '.$sitename;
                        $messagea .= "<img src='data:image/x-icon;base64,$imgdata'/>";
                        $emaila = \Config\Services::email();
                        $emaila->setHeader('Content-Type', 'text/html; charset=UTF-8\r\n');
                        $emaila->setTo($toa);
                        $emaila->setFrom($admin_email,$sitename);
                        $emaila->setSubject($subjecta);
                        $emaila->setMessage($messagea);
                        $emaila->send();             

                        $this->session->setTempdata('success','Thank you! Your request has been successfully received.',2);
                        return redirect()->to(base_url().'/dashboard'); 
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
                return $this->loginheaderfooter('task_request',$data);
            }                    
        }    
    }
}