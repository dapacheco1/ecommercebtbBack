<?php

namespace App\Http\Controllers;

use App\Models\saleDetail;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class saleDetailController extends Controller
{
    public function getMostSell($top){
        $find = DB::table('salesdetail') 
        ->select(DB::raw('clothing_id,COUNT(clothing_id) as amount,clothingprice, ROUND(COUNT(clothing_id)*clothingprice,2) as totalprice'))
        ->groupBy('clothing_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit($top)
        ->get();

        $response = [];

        if(count($find)){
            $response = ResponseBuilderServiceProvider::buildResponse(true,"The top ten sold products",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Not products sold yet",false);

        }

        return response()->json($response);
    }
}
