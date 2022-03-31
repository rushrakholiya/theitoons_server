<?php
namespace App\Libraries;

//include("./vendor/autoload.php"); 

use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

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
        //$card = new CreditCard($cardInput);
        $payArray = array(
            'amount'=> $valTransaction['amount'],
            //'transactionId' => $valTransaction['transactionId'],
           // 'description'=> $valTransaction['description'],
            'currency'=> $valTransaction['currency'],
            //'clientIp'=> $valTransaction['clientIp'],
            'returnUrl'=> $valTransaction['returnUrl'],
            'cancelUrl'=> $valTransaction['cancelUrl'],
           // 'card'=> $card
        );
        $response = $this->gateway->purchase($payArray)->send();
        echo '<pre>';
        print_r($response);
        echo '</pre>';
        /*if($response->isSuccessful()){
            $paypalResponse = $response->getData();
        }elseif($response->isRedirect()){
            //$response->redirect();
            $paypalResponse = $response->getRedirectData();
        }else{
            $paypalResponse = $response->getMessage();
            //echo $response->getMessage();
        }
        return $paypalResponse;*/
        if ($response->isSuccessful())
        {    
            $paypalResponse = $response->getData();
        } 
        elseif ($response->isRedirect())
        {
            $response->redirect();
            //$paypalResponse = $response->getRedirectData();

        } else 
        {
            $paypalResponse = $response->getMessage();
        }
        return $paypalResponse;
    }
}