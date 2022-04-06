<?php
namespace App\Libraries;

use Omnipay\Omnipay;

class Omnipaygateway extends Omnipay {

    protected $gateway = null;

    public function __construct($set_gateway='PayPal_Express',$test_mode=true)
    {
        $this->gateway = Omnipay::create($set_gateway);
        $this->gateway->setUsername('rushabhpaypal-facilitator_api1.gmail.com');
        $this->gateway->setPassword('FUTEDYRAG3AEBA5A');
        $this->gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31A58fGU4N.nfYx2zgzMXid7PRQPWQ');
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
            if ($response->getRedirectMethod() == "GET"){?>
            <h4>Amount : <?= $valTransaction['amount']." ".$valTransaction['currency'];?></h4>
            <p><a href="<?= $response->getRedirectUrl();?>" class="btn btn-success">Pay Now </a></p><?php 
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
            
}