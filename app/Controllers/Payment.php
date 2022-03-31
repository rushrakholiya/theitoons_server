<?php
 
namespace App\Controllers;

use App\Libraries\Omnipaygateway; 

class Payment extends HF_Controller
{    
    public function __construct()
    {
        helper(['form', 'url','usererror']);
        //$this->taskrequestModel = new TaskrequestModel();
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
            //return $this->loginheaderfooter('payment',$data);
            echo "Paypal Integration";
            /*$cardInput = array(
            'firstName'=>'test',
            'lastName'=>'test',
            'number'=>'4111 1111 1111 1111 ',
            'cvv'=>'132',
            'expiryMonth'=> 06,
            'expiryYear'=> 30,
            'email'=> 'test@gmail.com');*/
            $formData = [
                'number' => '4242424242424242',
                'expiryMonth' => '6',
                'expiryYear' => '2016',
                'cvv' => '123'
            ];
            $valTransc = array(
                //amount' => number_format(2, 2,'.',' '),
                'amount' => 10.00,
                //'transactionId'=>3,
                //'description' => 'test',
                'currency'=>'USD',
                //'clientIp'=>'',
                'returnUrl'=> base_url()."/payment",
                'cancelUrl'=> base_url()."/payment");
            //$data = $this->purchaseProc->sendPurchase($cardInput,$valTransc);
            $data1 = $this->purchaseProc->sendPurchase($valTransc);
            echo '<pre>'; 
            print_r($data1);
            echo '</pre>';                 
        }    
    }
}