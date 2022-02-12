<?php

use Ibrahimcadirci\VirtualPos\Methods\Iyzico;
use Ibrahimcadirci\VirtualPos\Payment;
use Illuminate\Support\Facades\Route;

Route::post('virtualpos/payment/{method}',[Payment::class, "payment"])->name("virtualpos-payment");

