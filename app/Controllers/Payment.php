<?php
 
namespace App\Controllers;

use App\Libraries\Omnipaygateway; 

class Payment extends HF_Controller
{    
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        $this->session = \Config\Services::session();
        $this->purchaseProc = new Omnipaygateway('PayPal_Express', true);
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
            echo "Paypal Integration";
            if($_GET['token'] && $_GET['PayerID']){
                $parameters = array(
                    'amount' => 10.00,
                    'currency'=>'USD',
                    'token' => $_GET['token'],
                    'payerid' => $_GET['PayerID'],
                    'returnUrl'=> base_url()."/payment",
                    'cancelUrl'=> base_url()."/payment");
                $datacomplete = $this->purchaseProc->complete($parameters);
                echo '<pre>'; 
                print_r($datacomplete);
                echo '</pre>';
            }
            elseif($_GET['token'])
            {
                echo "<br><br>You have cancelled your recent PayPal payment, Please try again!<br>";
                $valTransc = array(
                    'amount' => 10.00,
                    'currency'=>'USD',
                    'returnUrl'=> base_url()."/payment",
                    'cancelUrl'=> base_url()."/payment");
                $datapurchase = $this->purchaseProc->sendPurchase($valTransc);
                echo '<pre>'; 
                print_r($datapurchase);
                echo '</pre>';
            } 
            else
            {
                $valTransc = array(
                    'amount' => 10.00,
                    'currency'=>'USD',
                    'returnUrl'=> base_url()."/payment",
                    'cancelUrl'=> base_url()."/payment");
                $datapurchase = $this->purchaseProc->sendPurchase($valTransc);
                echo '<pre>'; 
                print_r($datapurchase);
                echo '</pre>';

            }
            
            
        }    
    }
}