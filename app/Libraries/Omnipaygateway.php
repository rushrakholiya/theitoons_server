<?php
namespace App\Libraries;

use Omnipay\Omnipay;

class Omnipaygateway extends Omnipay {

    protected $gateway = null;

    //public function __construct($set_gateway='PayPal_Express',$test_mode=true)
    public function __construct($set_gateway,$test_mode,$live_API_username,$live_API_password,$live_API_signature)
    {
        $this->gateway = Omnipay::create($set_gateway); 
        $this->gateway->setUsername($live_API_username);
        $this->gateway->setPassword($live_API_password);
        $this->gateway->setSignature($live_API_signature);
        $this->gateway->setTestMode($test_mode);
    }

    public function sendPurchase($valTransaction)
    {
        $paypalResponse = "";
        $payArray = array(
            'amount' => $valTransaction['amount'],
            'currency' => $valTransaction['currency'],
            'returnUrl' => $valTransaction['returnUrl'],
            'cancelUrl' => $valTransaction['cancelUrl']
        );
        $response = $this->gateway->purchase($payArray)->send();        
        if($response->isSuccessful())
        {
            $paypalResponse = $response->getData();
        }
        elseif($response->isRedirect())
        {
            if ($response->getRedirectMethod() == "GET"){
                /*$paypalResponse = "<h4>Amount : ".$valTransaction['amount']." ".$valTransaction['currency']."</h4><p><a href=".$response->getRedirectUrl()." class='btn btn-success'>Pay Now </a></p>";*/
               /* $paypalResponse = "<p><a href=".$response->getRedirectUrl()." class='btn btn-primary btn-block'>Pay with paypal</a></p>";*/
               $response->redirect();
            } 
        }
        else
        {
            $paypalResponse = $response->getMessage();
        }       
        return $paypalResponse;       
    }

    public function complete($parameters)
    {

        $paypalResponsecomplete = "";
        $response = $this->gateway->completePurchase($parameters)->send();

        //return $response;
        if ($response->isSuccessful()) {
            //$paypalResponse = $response->getTransactionReference();
            $paypalResponsecomplete = $response->getData();
        }
        else{
            $paypalResponsecomplete = $response->getMessage();
        }
        return $paypalResponsecomplete;
    }  

    public function testFetchCheckout($options)
    {
        $response = $this->gateway->fetchCheckout($options);

        $data = $response->getData();
        return $data;
    }  
            
}