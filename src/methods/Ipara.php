<?php
namespace Ibrahimcadirci\VirtualPos\Methods;

use Ibrahimcadirci\VirtualPos\VirtualPos;
use Illuminate\Http\Request;

class Ipara extends VirtualPos  implements MethodInterface{ 
    public function payment(Request $request, $method){
        dd($request->all(),"ipara");
    }

    public function genarePaymentForm(){
        return $this->defaultForm();

    }

    public function callBack(Request $request){
        dd("geri döndü");
    }
}