<?php
namespace App\Libraries;

use Omnipay\Omnipay;

class Omnipaygateway extends Omnipay {

    protected $gateway = null;

    //public function __construct($set_gateway='PayPal_Express',$test_mode=true)
    public function __construct($set_gateway,$test_mode,$live_API_username,$live_API_password,$live_API_signature)
    {
        /*$this->gateway = Omnipay::create($set_gateway); 
        $this->gateway->setUsername($live_API_username);
        $this->gateway->setPassword($live_API_password);
        $this->gateway->setSignature($live_API_signature);
        $this->gateway->setTestMode($test_mode);*/

        $this->gateway = Omnipay::create($set_gateway);

        // Initialise the gateway
        $this->gateway->initialize(array(
            'clientId' => 'AeHkW6pzEEODPHaZH4W1Gk7B73rbJgmVVU7gzKKUaYFpGi5qF9GMYrWSd1awyvjBmIA6thWUWfXODREx',
            'secret'   => 'ECVGJOn88VTJ9vBq8Lvhju6fu6WBQnwNNEXNN1-QoAXkV9TvtnDXpLdJGQf5EKReqFtIG06tsxQapqAh',
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
        /*echo "<pre>";
        print_r($response);
        echo "</pre>";
        $data = $response->getData();
        echo "Gateway purchase response data == ";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo $response->getRedirectUrl();exit;*/
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