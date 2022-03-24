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
            $hasUsProd = Cart::where('user_id',$cart->user_id)->where("clothing_id",$cart->clothing_id)->get();

            $cr = new Cart();
            //build cart
            $cr->user_id = $cart->user_id;

            $cr->clothing_id = $cart->clothing_id;

            $cr->amount = $cart->amount;
            $cr->total = $cart->total;
            $cr->total = $cart->total;
            $cr->status = $cart->status;
            if(count($hasUsProd)==0){
                $cr->save();
                $response = ResponseBuilderServiceProvider::buildResponse(true, "Product saved on cart", $cr);
            }else{
                //update if client tries to add more items on cart
                $cr = $hasUsProd[0];
                $cr->amount +=$cart->amount;
                $cr->total += $cart->total;
                $cr->save();
                $response = ResponseBuilderServiceProvider::buildResponse(true, "Product updated on cart", $cr);
            }

        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false, "Invalid Product or user", false);
        }

        return response()->json($response);
    }

    public function getCartByUserId($id){
        $find = Cart::where("user_id",$id)->get();
        $response = [];

        if(count($find)!=0){
            foreach($find as $f){
                $f->clothing;
            }
            $response = ResponseBuilderServiceProvider::buildResponse(true,"All your cart",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"You dont have any products in your cart",false);
        }
        return $response;

    }

    public function updateCart(Request $request){
        $find = Cart::find($request->id);
        $response = [];
        if($find){
            $find->amount = $request->amount;

            if($find->amount == 0){
                $find->delete();
            }else{
                $find->total = $request->total;
                $find->save();
            }


            $response = ResponseBuilderServiceProvider::buildResponse(true,"All your cart",$find);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Cannot update your cart",false);
        }
        return response()->json($response);
    }


    public function deleteCartByUserId($id){
        $find = Cart::where("user_id",$id)->get();
        $response = [];
        if(count($find)!=0){
            foreach($find as $f){
                $f->delete();
            }
            $response =  ResponseBuilderServiceProvider::buildResponse(true,"cart deleted",$find);
        }else{
            $response =  ResponseBuilderServiceProvider::buildResponse(false,"cannot delete the cart",false);
        }

        return $response;
    }





}
