<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothing;
use App\Models\Genre;
use App\Models\Size;
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
        $clt->genre_id =$request->genre_id;
        $exist_cat = validateExistanceServiceProvider::validateExistanceData($request->category_id,Category::class,"id");
        $exist_size = validateExistanceServiceProvider::validateExistanceData($request->size_id,Size::class,"id");
        $exist_genre = validateExistanceServiceProvider::validateExistanceData($request->genre_id,Genre::class,"id");
        if($exist_cat["success"] && $exist_size["success"] && $exist_genre["success"]){
            $clt->price = $request->price;
            $clt->stock = $request->stock;
            $clt->image = $request->image;
            $clt->name = $request->name;
            $clt->detail = $request->detail;

            $clt->status = $request->status;
            $clt->save();
            $response = ResponseBuilderServiceProvider::buildResponse(true,"Clothe created",$clt);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Cannot create the clothe",false);
        }

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


    public function getAllClothes(){
        $req = Clothing::all();
        $response = [];
        if(count($req)>0){
            foreach($req as $r){
                $r->category;
                $r->size;
                $r->genre;
            }
            $response = ResponseBuilderServiceProvider::buildResponse(true,"all clothes",$req);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"no clothes available",false);

        }
        return response()->json($response);

    }



    public function deleteClotheById($id){
        $find = Clothing::find($id);

        $response  = [];

        if($find){
            $find->delete();
            $response = ResponseBuilderServiceProvider::buildResponse(true,"clothe deleted",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"no clothe found",false);
        }

        return response()->json($response);
    }


    public function updateClotheById(Request $request){
        $find = Clothing::find($request->id);

        $response = [];

        if($find){
            $find->category_id = $request->category_id;
            $find->size_id = $request->size_id;
            $find->price = $request->price;
            $find->stock = $request->stock;
            $find->image = $request->image;
            $find->name = $request->name;
            $find->detail = $request->detail;
            $find->genre_id = $request->genre_id;
            $find->status  = $request->status;

            $find->save();

            $response = ResponseBuilderServiceProvider::buildResponse(true,"Clothe update successfully",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Cannot update clothe",false);
        }


        return response()->json($response);

    }

}
