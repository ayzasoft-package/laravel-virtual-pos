<?php
namespace Ayzasoft\VirtualPos\Methods;

use Ayzasoft\VirtualPos\Methods\MethodInterface as MethodsMethodInterface;
use Ayzasoft\VirtualPos\VirtualPos;
use Illuminate\Http\Request;

class KuveytTurk extends VirtualPos implements MethodsMethodInterface{
    public function payment(Request $request, $method){
        dd($request->all());
    }

    public function genarePaymentForm(){
        return $this->defaultForm();
    }
    
    public function callBack(Request $request){
        dd("geri döndü");
    }
}