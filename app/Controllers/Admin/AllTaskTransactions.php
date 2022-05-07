<?php
 
namespace App\Controllers\Admin;

use App\Models\AllTaskTransactionsModel;

class AllTaskTransactions extends \App\Controllers\Admin\HFA_Controller
{
    public $usersModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->tasktransactionsModel = new AllTaskTransactionsModel();
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
            $data['tasktransactionsdata'] = $this->tasktransactionsModel->displayAllTaskTransactions();
            if(!empty($data['tasktransactionsdata']))
            {
                return $this->headerfooter('allTaskTransactions',$data);
            }
            else
            { 
                $data = [];
                $data['error'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('allTaskTransactions',$data);
            }
        }
    }
    public function viewTaskTransaction($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $data['tasktransactioninfo'] = $this->tasktransactionsModel->viewTaskTransaction($id);
            if(!empty($data['tasktransactioninfo']))
            {
                return $this->headerfooter('viewTaskTransaction',$data);
            }
            else
            { 
                $data = [];
                $data['error'] = "Sorry! No Records found, Try again.";
                return $this->headerfooter('viewTaskTransaction',$data);
            }
        }
    }
    
    public function deleteTaskTransaction($id=null)
    {
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            $data = [];
            $deleteresponse = $this->tasktransactionsModel->deleteTaskTransaction($id);
            if( $deleteresponse == true )
            {            
                $this->session->setTempdata('success','Task Transaction Deleted Successfully.',2);
                return redirect()->to(base_url().'/admin/allTaskTransactions');
            }
            else
            { 
                $this->session->setTempdata('error','Not Deleted. Try again.',2);
                return redirect()->to(base_url().'/admin/allTaskTransactions');
            }
        }
    }
}