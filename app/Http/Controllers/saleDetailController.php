<?php

namespace App\Http\Controllers;

use App\Models\saleDetail;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class saleDetailController extends Controller
{
    public function getMostSell(){
        $find = saleDetail::select('clothing_id','amount','clothing_price','totalprice')
        ->groupBy('clothing_id')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(10)
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
