<?php
namespace Ibrahimcadirci\VirtualPos;

use Ibrahimcadirci\VirtualPos\VirtualPos;
use Illuminate\Http\Request;

class Payment extends VirtualPos {
    public function payment(Request $request,string $method){

        self::setPaymentMethod($method);

        $new        =  new self::$paymentMethod->file;

        $new->payment($request,$method);

        dd($request->all(),$method);
    } 
}