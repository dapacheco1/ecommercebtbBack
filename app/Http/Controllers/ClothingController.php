<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    public function getClothes($categoryId){
        $clothe  = Clothing::where("category_id",$categoryId)->get();
        
        $response = [];

        if($clothe){
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
}
