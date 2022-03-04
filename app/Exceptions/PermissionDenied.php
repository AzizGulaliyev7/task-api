<?php

namespace App\Exceptions;

use Exception;

class PermissionDenied extends Exception
{
    public function __construct($message = '')
    {
        if ($message){
            $this->message = $message;
        }
    }
}
