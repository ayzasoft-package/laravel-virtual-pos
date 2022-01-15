<?php
namespace Ibrahimcadirci\VirtualPos\Methods;

use Illuminate\Http\Request;

interface MethodInterface {
    public function callBack(Request $request);
}