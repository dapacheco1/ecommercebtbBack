<?php

namespace App\Http\Controllers;

use App\Models\saleDetail;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class saleDetailController extends Controller
{
    public function getMostSell($top){
        $find = saleDetail::select(DB::raw('clothing_id,COUNT(clothing_id) as amount,clothingprice, ROUND(COUNT(clothing_id)*clothingprice,2) as totalprice'))
        ->groupBy('clothing_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit($top)
        ->get();

        $response = [];

        if(count($find)){
            foreach($find as $f){
                $f->clothing;
            }
            $response = ResponseBuilderServiceProvider::buildResponse(true,"The top sold products",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Not products sold yet",false);

        }

        return response()->json($response);
    }
}
