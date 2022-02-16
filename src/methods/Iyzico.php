<?php
namespace Ibrahimcadirci\VirtualPos\methods;

use Ibrahimcadirci\VirtualPos\VirtualPos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\One\User;

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
    public function genarePaymentForm($data){
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($data['orderId'].'-'.$data['orderPaymentId']);
        $request->setPrice($data['totalPrice']);
        $request->setPaidPrice($data['totalPrice']);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId(reset($data['cart'])['basketId'].'-'.$data['orderId'].'-'.$data['orderPaymentId']);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('virtualpos.callback.iyzico'));
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($data['buyer']['userId']);
        $buyer->setName($data['buyer']['name']);
        $buyer->setSurname($data['buyer']['surname']);
        $buyer->setGsmNumber($data['buyer']['phone']);
        $buyer->setEmail($data['buyer']['email']);
        $buyer->setIdentityNumber($data['buyer']['identity']);
        $buyer->setLastLoginDate(" ");
        $buyer->setRegistrationDate(" ");
        $buyer->setRegistrationAddress($data['buyer']['address']);
        $buyer->setIp($data['buyer']['ip']);
        $buyer->setCity($data['buyer']['city']);
        $buyer->setCountry($data['buyer']['country']);
        $buyer->setZipCode($data['buyer']['zipCode']);
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($data['shipping']['name'].' '.$data['shipping']['surname']);
        $shippingAddress->setCity($data['shipping']['shippingCity']);
        $shippingAddress->setCountry($data['shipping']['shippingCountry']);
        $shippingAddress->setAddress($data['shipping']['shippingAddress']);
        $shippingAddress->setZipCode($data['shipping']['shippingZipCode']);
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($data['shipping']['name'].' '.$data['shipping']['surname']);
        $billingAddress->setCity($data['shipping']['shippingCity']);
        $billingAddress->setCountry($data['shipping']['shippingCountry']);
        $billingAddress->setAddress($data['shipping']['shippingAddress']);
        $billingAddress->setZipCode($data['shipping']['shippingZipCode']);
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        foreach ($data['basketItems'] as $basketItem)
        {
            $firstBasketItem = new \Iyzipay\Model\BasketItem();
            $firstBasketItem->setId($basketItem['id']);
            $firstBasketItem->setName($basketItem['name']);
            $firstBasketItem->setCategory1($basketItem['category']);
            $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $firstBasketItem->setPrice($basketItem['price']);
            $basketItems[] = $firstBasketItem;
        }
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
