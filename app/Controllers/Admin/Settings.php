<?php
 
namespace App\Controllers\Admin;

use App\Models\SettingsModel;

class Settings extends \App\Controllers\Admin\HFA_Controller
{
    public $settingsModel;
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->settingsModel = new SettingsModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {       
        $data = [];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            return $this->headerfooter('settings',$data);
        }
            
    } 
    public function generalSetting()
    {       
        $data = [];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            if( $this->request->getMethod() == "post" )
            {
                $sitefaviconpath = "";
                $sitefavicon =  $this->request->getFile('sitefavicon');
                $sitelogo =  $this->request->getFile('sitelogo');
                
                if(empty($sitefavicon->getName()))
                {                    
                    $site_favicon = getGeneralData("site_favicon");
                    if(!empty($site_favicon->option_value)){
                        $sitefaviconpath = $site_favicon->option_value;
                    }
                    else{
                        $sitefaviconpath = base_url()."/public/assets/dist/img/logo.png";
                    }
                }
                else
                {
                    if($sitefavicon->move(FCPATH.'public/profiles', $sitefavicon->getName()))
                    {
                        $sitefaviconpath = base_url().'/public/profiles/'.$sitefavicon->getName();
                    } 
                }
                if(empty($sitelogo->getName())){
                    $site_logo = getGeneralData("site_logo");
                    if(!empty($site_logo->option_value)){
                        $sitelogopath = $site_logo->option_value;
                    }
                    else{
                        $sitelogopath = base_url()."/public/assets/dist/img/logo.png";
                    }
                }
                else{
                    if($sitelogo->move(FCPATH.'public/profiles', $sitelogo->getName()))
                    {
                        $sitelogopath = base_url().'/public/profiles/'.$sitelogo->getName();
                    } 
                }
                $generaldata = [
                    ['option_name' => 'site_name','option_value' => $this->request->getVar('sitename'),],
                    ['option_name' => 'admin_email','option_value' => $this->request->getVar('admin_email'),],
                    ['option_name' => 'site_favicon','option_value' => $sitefaviconpath,],
                    ['option_name' => 'site_logo','option_value' => $sitelogopath,],
                        
                ];
                if($this->settingsModel->saveGeneralSetting($generaldata))
                {
                    $this->session->setTempdata('success','Data updated Successfully.',2);
                    return redirect()->to(base_url()."/admin/settings");
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! data not updated, Try again.',2);
                    return redirect()->to(base_url()."/admin/settings");
                }
            }
            else
            {
                return $this->headerfooter('settings',$data);
            }
            
        }
            
    }
    public function paypalSetting()
    {       
        $data = [];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url()."/login");
        }
        else
        {
            if( $this->request->getMethod() == "post" )
            {
                $paypaldata = [
                    ['option_name' => 'paypal_enable_disable','option_value' => $this->request->getVar('paypalenable'),],
                    ['option_name' => 'paypal_sandbox','option_value' => $this->request->getVar('paypalsandbox'),],
                    ['option_name' => 'paypal_email','option_value' => $this->request->getVar('paypalemail'),],   
                    ['option_name' => 'receiver_email','option_value' => $this->request->getVar('paypalreceiveremail'),],
                    ['option_name' => 'live_API_username','option_value' => $this->request->getVar('live_API_username'),],
                    ['option_name' => 'live_API_password','option_value' => $this->request->getVar('live_API_password'),],
                    ['option_name' => 'live_API_signature','option_value' => $this->request->getVar('live_API_signature'),],
                        
                ];
                if($this->settingsModel->savepaypalSetting($paypaldata))
                {
                    $this->session->setTempdata('success','Data updated Successfully.',2);
                    return redirect()->to(base_url()."/admin/settings");
                }
                else
                {
                    $this->session->setTempdata('error','Sorry! data not updated, Try again.',2);
                    return redirect()->to(base_url()."/admin/settings");
                }
            }
            else
            {
                return $this->headerfooter('settings',$data);
            }
            
        }
            
    }
}