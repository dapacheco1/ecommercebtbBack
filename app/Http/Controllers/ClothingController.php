<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothing;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Http\Request;

class ClothingController extends Controller
{

    public function createClothes(Request $request){

        $response = [];

        $clt = new Clothing();
        $clt->category_id = $request->category_id;
        $clt->size_id = $request->size_id;
        $clt->price = $request->price;
        $clt->stock = $request->stock;
        $clt->image = $request->image;
        $clt->name = $request->name;
        $clt->detail = $request->detail;
        $clt->genre_id =$request->genre_id;
        $clt->status = $request->status;
        $clt->save();
        $response = ResponseBuilderServiceProvider::buildResponse(true,"Clothe created",$clt);
        return response()->json($response);
    }


    public function getClothes($categorySlug){
        //$clothe  = Clothing::where("category_id",$categoryId)->get();
        $slugR = validateExistanceServiceProvider::validateExistanceData($categorySlug,Category::class,"slug");
        $response = [];

        if($slugR["success"]){
            $clothe  = Clothing::where("category_id",$slugR["data"]["id"])->get();
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

    public function getClotheBySlug($slug){
        $find = Clothing::where("slug",$slug)->get();
        $response = [];
        if(count($find)!=0){
            $response = ResponseBuilderServiceProvider::buildResponse(true,"cloth finded",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"no data found",false);
        }

        return $response;
    }
}
