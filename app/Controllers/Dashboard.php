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
            $data['validation'] = null;
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
}