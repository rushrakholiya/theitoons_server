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