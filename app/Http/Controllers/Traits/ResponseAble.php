<?php


namespace App\Http\Controllers\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ResponseAble
{
    protected function sendError($validator_errors, $message = '', $code = 422){
        throw new HttpResponseException(
            response()->json([
                'result' => [
                    'success' => false,
                    'data'     => []
                ],
                'error' => [
                    'message' => $message,
                    'code'    => 422
                ],
                'validation_errors' => $validator_errors,
            ])->setStatusCode($code)
        );
    }
}
