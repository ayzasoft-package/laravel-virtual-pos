<?php

namespace Ibrahimcadirci\VirtualPos;

use Exception;
use Illuminate\Http\Request;

abstract class VirtualPos {
    protected static $methods, $paymentMethod;

    public static function genarateCardForm(){

        $new        =  new self::$paymentMethod->file;

        $html           = $new->genarePaymentForm();

        return $html;
    }
    public function defaultForm(string $otherInputs = null){
        $html   = '<form action="'.route('virtualpos-payment',self::$paymentMethod->slug).'" method="post" id="virtual-pos-form" >
                <div class="w-96 mx-auto border border-gray-400 rounded-lg">
                <div class="w-full h-auto p-4 flex items-center border-b border-gray-400">
                <h1 class="w-full">Kart Bilgileri</h1>
                <!-- <a href="" class="w-full text-right text-sm font-semibold text-indigo-700">Other payment methods</a> -->
                </div>
                <div class="w-full h-auto p-4">
                <form action="">
                    <div class="mb-4 px-3 py-1 bg-white rounded-sm border border-gray-300 focus-within:text-gray-900 focus-within:border-gray-500">
                    <label for="cc-name" class="text-xs tracking-wide uppercase font-semibold">Kart üzerindeki isim</label>
                    <input id="cc-name" type="text" name="cc-name" class="w-full h-8 focus:outline-none" placeholder="Ad Soyad" autocomplete="off">
                    </div>
                    <div class="mb-4 px-3 py-1 bg-white rounded-sm border border-gray-300 focus-within:text-gray-900 focus-within:border-gray-500">
                    <label for="cc-number" class="text-xs tracking-wide uppercase font-semibold">Kart Numarası</label>
                    <input id="cc-number" type="text" name="cc-number" class="w-full h-8 focus:outline-none" placeholder="16 haneli kart numarası" autocomplete="off">
                    </div>
            
                    <div class="flex mb-4 px-3 py-1 bg-white rounded-sm border border-gray-300 focus-within:border-gray-500">
                    <div class="w-full focus-within:text-gray-900">
                        <label for="" class="text-xs tracking-wide uppercase font-semibold">Son Kullanım</label>
                        <input id="cc-expiry" type="text" class="w-full h-8 focus:outline-none" placeholder="AA / YYYY" autocomplete="off">
                    </div>
            
                    <div class="w-auto focus-within:text-gray-900">
                        <label for="" class="text-xs tracking-wide uppercase font-semibold">CVV</label>
                        <input id="cc-cvv" type="text" class="w-full h-8 focus:outline-none" maxlength="3" autocomplete="off">
                    </div>
                    </div>
                    '
                    .(is_null($otherInputs) ? '' : $otherInputs).
                    '<button class="h-16 w-full rounded-sm bg-indigo-600 tracking-wide font-semibold text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-600">Ödeme Yap</button>
                </form>
                </div>
            </div>
            </form>';
        return $html;
    }

    public function responseFormat($resultStatus,$data,$errorMessage = null){
        return response()->json( [
            "success"       => $resultStatus,
            "resultData"    => $data,
            "errorMessage"  => $errorMessage
        ]);
    }

    public static function allMethods() {
        $methods            = file_get_contents(__DIR__ . '/methods.json');
        self::$methods      = json_decode($methods);
        
        return self::$methods;
    }

    public static function setPaymentMethod(string $method){
        try{
            self::$paymentMethod            = self::allMethods()->{$method};             
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    abstract public function payment(Request $request,string $method);

}