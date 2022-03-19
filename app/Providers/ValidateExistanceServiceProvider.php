<?php

    namespace App\Providers;

    use Illuminate\Database\Eloquent\Model;

    class validateExistanceServiceProvider{

        //function to validate Existance of an specific data in table

        public static function validateExistanceData($stringSearch,$model,$whereArg){
            $response = [];

            $find = $model::where($whereArg,$stringSearch)->first();
            $className = explode("\\",$model)[2];
            if($find){
                $response = ResponseBuilderServiceProvider::buildResponse(false,"$className already exists",$find);
            }else{
                $response = ResponseBuilderServiceProvider::buildResponse(true,"$className doesnt exists",false);
            }
            return $response;
        }


    }