<?php
namespace App\Libraries;

use Omnipay\Omnipay;

class Omnipaygateway extends Omnipay {

    protected $gateway = null;

    //public function __construct($set_gateway='PayPal_Express',$test_mode=true)
    public function __construct($set_gateway,$test_mode,$live_API_username,$live_API_password,$live_API_signature)
    {
        $this->gateway = Omnipay::create($set_gateway);
        // Initialise the gateway
        $this->gateway->initialize(array(
            'clientId' => $live_API_password,
            'secret'   => $live_API_signature,
            'testMode' => $test_mode, // Or false when you are ready for live transactions
        ));
    }

    public function sendPurchase($valTransaction)
    {
        $paypalResponse = "";
        $payArray = array(
            'amount' => $valTransaction['amount'],
            'currency' => $valTransaction['currency'],
            'description'=> $valTransaction['description'],
            'returnUrl' => $valTransaction['returnUrl'],
            'cancelUrl' => $valTransaction['cancelUrl']
        );
        $response = $this->gateway->purchase($payArray)->send();
        if($response->isRedirect())
        {
            $response->redirect();            
        }
        elseif($response->isSuccessful())
        {
            $paypalResponse = $response->getData();
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
        
        if ($response->isSuccessful())
        {
            $paypalResponsecomplete = $response->getData();
        }
        else
        {
            $paypalResponsecomplete = $response->getMessage();
        }
        return $paypalResponsecomplete;
    }            
}