<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function getSizes(){
        $size = Size::all();
        $response = [];

        if(count($size)>0){
            foreach($size as $s){
                $s->category;
            }
            $response = ResponseBuilderServiceProvider::buildResponse(true,"All sizes from database",$size);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"No data found on size",false);
        }

        return response()->json($response);
    }
}
