<?php

namespace App\Exceptions;

use Exception;

class CanNotBeDeleted extends Exception
{
    public function __construct($message = '')
    {
        if ($message){
            $this->message = $message;
        }
    }
}
