<?php

namespace ShipFree;

use \Illuminate\Contracts\Debug\ExceptionHandler;
class Exception implements ExceptionHandler
{
    public function report(\Exception $e) {
        throw $e;
    }
    public function render($request, \Exception $e) {
        throw $e;
    }
    public function renderForConsole($output, \Exception $e) {
        throw $e;
    }
}