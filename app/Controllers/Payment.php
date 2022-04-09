<?php
 
namespace App\Controllers;

use App\Libraries\Omnipaygateway; 
use App\Models\PaymentModel;

class Payment extends HF_Controller
{    
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->session = \Config\Services::session();
        $this->paymentModel = new PaymentModel();
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
            $paymentdata = $this->paymentModel->verifyPaymentMethod();            
            if(!empty($paymentdata))
            {
                //print_r($paymentdata);
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
                
                $this->purchaseProc = new Omnipaygateway('PayPal_Express', $test_mode,$live_API_username,$live_API_password,$live_API_signature);

                /*echo "Paypal Integration";*/
                if(isset($_GET['token']) && isset($_GET['PayerID'])){
                    $parameters = array(
                        'amount' => 10.00,
                        'currency'=>'USD',
                        'token' => $_GET['token'],
                        'payerid' => $_GET['PayerID'],
                        'returnUrl'=> base_url()."/payment",
                        'cancelUrl'=> base_url()."/payment");
                    $datacomplete = $this->purchaseProc->complete($parameters);
                    /*echo '<pre>'; 
                    print_r($datacomplete);
                    echo '</pre>';*/
                    $data['datacomplete'] = $datacomplete;
                    return $this->loginheaderfooter('payment',$data);
                }
                elseif(isset($_GET['token']))
                {
                    $valTransc = array(
                        'amount' => 10.00,
                        'currency'=>'USD',
                        'returnUrl'=> base_url()."/payment",
                        'cancelUrl'=> base_url()."/payment");
                    $datapurchasec = $this->purchaseProc->sendPurchase($valTransc);
                    /*echo '<pre>'; 
                    print_r($datapurchasec);
                    echo '</pre>';*/
                    $data['datapurchasec'] = $datapurchasec;
                    return $this->loginheaderfooter('payment',$data);
                } 
                else
                {
                    $valTransc = array(
                        'amount' => 10.00,
                        'currency'=>'USD',
                        'returnUrl'=> base_url()."/payment",
                        'cancelUrl'=> base_url()."/payment");
                    $datapurchase = $this->purchaseProc->sendPurchase($valTransc);
                    /*echo '<pre>'; 
                    print_r($datapurchase);
                    echo '</pre>';*/
                    $data['datapurchase'] = $datapurchase;
                    return $this->loginheaderfooter('payment',$data);
                }            
            }
            else
            {
                $data['paypalerror'] = "Paypal Disabled, Try again.";
                return $this->loginheaderfooter('payment',$data);
            }
        }    
    }
}