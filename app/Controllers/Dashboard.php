<?php
 
namespace App\Controllers;

use App\Models\DashboardModel;
use App\Libraries\Omnipaygateway; 

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
                    $taskstatus = $data['taskrequestinfo']->task_status;
                    if( !empty($data['taskrequestinfo']) && $taskstatus=="pending" )
                    {
                        return $this->loginheaderfooter('editTaskRequest',$data);
                    }
                    else
                    { 
                        $data['taskrequestinfo'] = '';
                        $data['error'] = "Sorry! No Records found, Try again.";
                        return $this->loginheaderfooter('editTaskRequest',$data);
                    }
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user to view the request.',2);
                return redirect()->to(base_url().'/dashboard');
            }
        }
    }
    public function paymentTaskRequest($id=null)
    {
        if(!session()->has('logged_user_client'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }
            $task_budget = getTaskRequestMeta("budget",$id);
            $amount = $task_budget->meta_value;

            $data['taskrequestinfo'] = $this->dashboardModel->viewTaskRequest($id);
            $tasktitle = $data['taskrequestinfo']->task_title;

            $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
            if( $checkauthorizeduser == true )
            {
                $paymentdata = $this->dashboardModel->verifyPaymentMethod();            
                if(!empty($paymentdata))
                {
                   foreach($paymentdata as $row){
                        if($row['option_name'] == 'paypal_sandbox' )
                            {$paypal_sandbox = $row['option_value'];}
                        if($row['option_name'] == 'live_API_username' )
                            {$live_API_username = $row['option_value'];;}
                        if($row['option_name'] == 'live_API_password' )
                            {$live_API_password = $row['option_value'];}
                        if($row['option_name'] == 'live_API_signature' )
                            {$live_API_signature = $row['option_value'];}                   
                    }
                    if($paypal_sandbox==1){$test_mode = true;}else{$test_mode = false;}
                    
                    $this->purchaseProc = new Omnipaygateway('PayPal_Rest', $test_mode,$live_API_username,$live_API_password,$live_API_signature);

                    $valTransc = array(
                        'amount' => number_format($amount , 2, '.', ''),
                        'currency'=>'USD',
                        'description' => $tasktitle.'-'.$id,
                        'returnUrl'=> base_url()."/dashboard/thankYouPaypal/".$id,
                        'cancelUrl'=> base_url()."/dashboard/canceledPaypal/".$id);
                    $datapurchase = $this->purchaseProc->sendPurchase($valTransc);         
                }
                else
                {
                    $data['error'] = "Paypal Disabled, Try again.";
                    return $this->loginheaderfooter('dashboard',$data);
                }
            }
            else
            {
                $this->session->setTempdata('error','Sorry, You are not authorised user.',2);
                return redirect()->to(base_url().'/dashboard');
            }
        }
    }
    public function canceledPaypal()
    {
        $data = [];
        return $this->loginheaderfooter('canceledPaypal',$data);
    }
    public function thankYouPaypal($id=null)
    {
        $data = [];
        if(session()->has('logged_user_client')){$uid=session()->get('logged_user_client'); }
        $task_budget = getTaskRequestMeta("budget",$id);
        $amount = $task_budget->meta_value;

        $data['taskrequestinfo'] = $this->dashboardModel->viewTaskRequest($id);
        $tasktitle = $data['taskrequestinfo']->task_title;                 
        
        $paymentdata = $this->dashboardModel->verifyPaymentMethod();            
        $checkauthorizeduser = $this->dashboardModel->checkAuthorizedUser($id,$uid);
        if( $checkauthorizeduser == true )
        {
            if(!empty($paymentdata))
            {
                foreach($paymentdata as $row){
                    if($row['option_name'] == 'paypal_sandbox' )
                        {$paypal_sandbox = $row['option_value'];}
                    if($row['option_name'] == 'live_API_username' )
                        {$live_API_username = $row['option_value'];;}
                    if($row['option_name'] == 'live_API_password' )
                        {$live_API_password = $row['option_value'];}
                    if($row['option_name'] == 'live_API_signature' )
                        {$live_API_signature = $row['option_value'];}                   
                }
                if($paypal_sandbox==1){$test_mode = true;}else{$test_mode = false;}
                
                $this->cpurchaseProc = new Omnipaygateway('PayPal_Rest', $test_mode,$live_API_username,$live_API_password,$live_API_signature);

                if(isset($_GET['token']) && isset($_GET['PayerID']) && isset($_GET['paymentId'])){
                    
                    $parameters = array(
                        'amount' => number_format($amount, 2, '.', ''),
                        'currency'=>'USD',
                        'transactionReference' => $_GET['paymentId'],
                        'payer_id' => $_GET['PayerID'],
                        'description' => $tasktitle.'-'.$id,
                        'returnUrl'=> base_url()."/dashboard/thankYouPaypal/".$id,
                        'cancelUrl'=> base_url()."/dashboard/canceledPaypal/".$id);
                    $datacomplete = $this->cpurchaseProc->complete($parameters);
                    //$data['datacomplete'] = $datacomplete;

                    $recordfound = $this->dashboardModel->foundPaypalRecord($datacomplete['id']);
                    //$data['datacomplete'] = $recordfound;
                    if(empty($recordfound) || $recordfound->payment_title != $datacomplete['id'])
                    {
                        $pydate = $datacomplete['create_time'];
                        $pdate = date_create($pydate);
                        $payment_date = date_format($pdate,"d-m-Y h:i a");
                        $taskpaymentdata = [
                            'task_id' =>$id,
                            'user_id'=> $uid,                        
                            'payment_title' => $datacomplete['id'],
                            //'payment_status'=> $datacomplete['state'],
                            'payment_status'=> $datacomplete['transactions'][0]['related_resources'][0]['sale']['state'],
                            'payment_date'=> $payment_date                    
                        ];
                        //$data['datacomplete'] = $taskpaymentdata;
                        
                        $paymentid = $this->dashboardModel->addPaymentDataTaskRequest($taskpaymentdata);
                        if(!empty($paymentid))
                        {
                            $taskpaymentmetadata = [
                                'payment_id' => $paymentid,
                                'meta_key' => 'payment_txn_data',
                                'meta_value' => json_encode($datacomplete)
                            ];
                            $this->dashboardModel->addPaymentDataTaskRequestMeta($taskpaymentmetadata);
                        }
                    }                    
                }
            }
            else
            {
                $data['error'] = "Paypal Disabled, Try again.";
                return $this->loginheaderfooter('dashboard',$data);
            }
        }
        else
        {
            $this->session->setTempdata('error','Sorry, You are not authorised user.',2);
            return redirect()->to(base_url().'/dashboard');
        }
        return $this->loginheaderfooter('thankYouPaypal',$data);
    }
    public function addTaskComment()
    {
        $data = [];$uid = "";
        if(session()->has('logged_user_client')){
            $uid=session()->get('logged_user_client'); 
        }
        //print_r($_POST['comment_text']);        
        if( $this->request->getMethod() == "post" ){  
            $userdata = getLoggedInUserData($uid);
            if(!empty($userdata)){ $task_useremail = $userdata->user_email;
            $task_username = $userdata->user_name;}
            $commentdata = [
                'user_id'=> $uid,
                'task_id'=> $_POST['ctask_id'],
                'comment_author'=> $task_username,
                'comment_author_email'=> $task_useremail,
                'comment_parent'=> 0,
                'comment_content' => $_POST['comment_text'],
                'comment_type'=>'comment',
                'comment_status'=> 1,
            ];
            $this->dashboardModel->addTaskComment($commentdata);
            $getTaskRequestCommentData = getTaskRequestCommentData($_POST['ctask_id']);
            //print_r($getTaskRequestCommentData);
            $taskuserid = $taskrequestinfo->uid;
            if(!empty($getTaskRequestCommentData)){
                foreach($getTaskRequestCommentData as $cmd){
                  $profile_picture = getUserMeta("profile_picture", $cmd['user_id']);
                  if(!empty($profile_picture->meta_value)){$userimage = $profile_picture->meta_value;}else{$userimage = base_url()."/public/assets/dist/img/default_avatar.jpg";}
                  $comment_content = $cmd['comment_content'];
                  if($taskuserid == $cmd['user_id']){$commentauthor="You";}else{$commentauthor=$cmd['comment_author'];}
                  echo '<li class="li">
                    <div class="inline">
                      <img src="'.$userimage.'" class="img">
                    </div>
                    <div class="inline pt-2">
                      <span style="color: #5F65FF !important;">'.$commentauthor.'</span><br><span>'.$comment_content.'</span>
                    </div>
                    </li>';
                }
              }
        }
        
    }
}