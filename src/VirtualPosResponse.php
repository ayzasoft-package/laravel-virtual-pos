<?php

interface VirtualPosResponse {
    public function success();
    public function errors();
    public function response();
}