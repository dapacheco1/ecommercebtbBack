<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Clothing;
use App\Models\User;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = $request;
        $response = [];

        $validUs = validateExistanceServiceProvider::validateExistanceData($cart->user_id,User::class,"id");
        $validCloth = validateExistanceServiceProvider::validateExistanceData($cart->clothing_id,Clothing::class,"id");

        if($validUs["success"] && $validCloth["success"]){
            $cr = new Cart();
            //build cart
            $cr->user_id = $cart->user_id;

            $cr->clothing_id = $cart->clothing_id;

            $cr->amount = $cart->amount;
            $cr->total = $cart->total;
            $cr->total = $cart->total;
            $cr->status = $cart->status;
            $cr->save();
            $response = ResponseBuilderServiceProvider::buildResponse(true, "Product saved on cart", $cr);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false, "Invalid Product or user", false);
        }

        return response()->json($response);
    }

    // private function updateStock($clothing_id,$amount){
    //     $compare = Clothing::find($clothing_id);
    //     if($amount <= $compare->stock){
    //         //update stock
    //         $compare->stock -= $amount;
    //         $compare->save();
    //         return true;
    //     }else{
    //         return false;
    //     }

    // }
}
