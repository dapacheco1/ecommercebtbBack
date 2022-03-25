<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function addCategory(Request $request){
        

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
}
