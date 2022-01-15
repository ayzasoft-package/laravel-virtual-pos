<?php
namespace Ibrahimcadirci\VirtualPos\Methods;

use Ibrahimcadirci\VirtualPos\Methods\MethodInterface as MethodsMethodInterface;
use Ibrahimcadirci\VirtualPos\VirtualPos;
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