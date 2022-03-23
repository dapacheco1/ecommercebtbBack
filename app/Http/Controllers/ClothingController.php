<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    public function getClothes($categoryId){
        //$clothe  = Clothing::where("category_id",$categoryId)->get();
        $clotheR = validateExistanceServiceProvider::validateExistanceData($categoryId,Clothing::class,"category_id");
        $response = [];

        if($clotheR["success"]){
            $clothe  = Clothing::where("category_id",$categoryId)->get();
            foreach($clothe as $c){
                $c->genre;
                $c->category;
                $c->size;
            }
            $response = ResponseBuilderServiceProvider::buildResponse(true,"Category data clothes",$clothe);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"No data found of clothe",false);
        }

        return response()->json($response);

    }


    public function getClotheById($id){
        $find = Clothing::find($id);
        $response = [];
        if($find){
            $response = ResponseBuilderServiceProvider::buildResponse(true,"cloth finded",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"no data found",false);
        }

        return $response;
    }
}
