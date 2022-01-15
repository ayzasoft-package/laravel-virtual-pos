<?php
namespace Ibrahimcadirci\VirtualPos\Methods;

use Ibrahimcadirci\VirtualPos\VirtualPos;
use Illuminate\Http\Request;

class Iyzico extends VirtualPos implements MethodInterface{ 

    protected $options;
    public function __construct()
    {
        $this->options          = new \Iyzipay\Options();
        $this->options->setApiKey(config('virtualpos.iyzico.apiKey'));//deneme hesabı urli
        $this->options->setSecretKey(config('virtualpos.iyzico.secretKey'));//deneme hesabı urli
        $this->options->setBaseUrl(config('virtualpos.iyzico.baseUrl'));
    }
    public function payment(Request $request,string $method){
        dd($request->all(),"twest");
    }
    public function genarePaymentForm(){




        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId("123456789");
        $request->setPrice("50");
        $request->setPaidPrice("50");
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId("BI101");
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('virtualpos.callback.iyzico'));
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("88956878458");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("63000");

        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("63000");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("63000");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("50");
        $basketItems[0] = $firstBasketItem;

        $request->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->options);
        return '<div id="iyzipay-checkout-form" class="responsive"></div>'  . $checkoutFormInitialize->getcheckoutFormContent();
    }

    public function callBack(Request $request){
        $token          = $request->input('token');

        $data = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $data->setLocale(\Iyzipay\Model\Locale::TR);
        $data->setConversationId("123456789");
        $data->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($data, $this->options);
        $resultStatus           = true;
        $errorMessage           = null;
        $data               = $checkoutForm->getRawResult();
        
       
        if($checkoutForm->getPaymentStatus() != "SUCCESS"){
            $resultStatus           = false;
            $errorMessage           = $checkoutForm->getErrorMessage();
            
        }
        return $this->responseFormat($resultStatus,$data,$errorMessage);
    
    }
}