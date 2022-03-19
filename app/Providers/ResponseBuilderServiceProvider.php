<?php

namespace App\Providers;

class ResponseBuilderServiceProvider
{
    //build a default response
    public static function buildResponse($success,$message,$data){
        return [
            "success" => $success,
            "message" => $message,
            "data" => $data
        ];
    }
}