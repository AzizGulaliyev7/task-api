<?php

namespace App\Exceptions;

use RuntimeException;

class ApiModelNotFoundException extends RuntimeException
{
    public function __construct($message = '')
    {
        if ($message){
            $this->message = $message;
        }else{
            $this->message = "obyekt topilmadi";
        }
    }
}
