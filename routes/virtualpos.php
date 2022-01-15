<?php

use Ibrahimcadirci\VirtualPos\Methods\Iyzico;
use Ibrahimcadirci\VirtualPos\Payment;
use Illuminate\Support\Facades\Route;

Route::post('virtualpos/payment/{method}',[Payment::class, "payment"])->name("virtualpos-payment");

Route::post('virtualpos/callback/iyzico',[Iyzico::class, "callback"])->name("virtualpos.callback.iyzico");