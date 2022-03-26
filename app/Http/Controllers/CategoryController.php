<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function addCategory(Request $request){
        $find = validateExistanceServiceProvider::validateExistanceData($request->slug,Category::class,"slug");
        $response  = [];
        if(!$find["success"]){
            $cat = new Category();
            $cat->slug = $request->slug;
            $cat->detail = $request->detail;
            $cat->status = $request->status;
            $cat->save();
            $response = ResponseBuilderServiceProvider::buildResponse(true,"Category saved",$cat);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"This category already exists",false);
        }

        return response()->json($response);

    }

    public function deleteCategoryById($id){
        $find = Category::find($id);

        $response = [];

        if($find){
            $find->delete();
            $response = ResponseBuilderServiceProvider::buildResponse(true,"category deleted succesfully",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"category doesnt exist",false);
        }

        return $response;
    }



    public function getCategories(){
        $cat = Category::all();
        $response = [];

        if($cat){
            $response = ResponseBuilderServiceProvider::buildResponse(true,"All categories from database",$cat);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"No data found",false);
        }

        return response()->json($response);
    }

    public function updateCategory(Request $request){

        $findId = Category::find($request->id);
        $existSlug = Category::where("slug",$request->slug)->get();

        $response = [];

        if($findId && count($existSlug)!=2){
            $findId->id = $request->id;
            $findId->slug = $request->slug;
            $findId->detail = $request->detail;
            $findId->status = $request->status;
            $findId->save();
            $response = ResponseBuilderServiceProvider::buildResponse(true,"Category Updated Succesfully",$findId);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Cannot update category",false);
        }

        return response()->json($response);
    }
}
