<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Models\Sale;
use App\Models\saleDetail;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function registerSale(Request $request)
    {

        //build sale
        $save = new Sale();
        $save->user_id = $request->user_id;
        $save->saleDate = $request->saleDate;
        $save->saleHour = $request->saleHour;
        $save->taxIVA = $request->taxIVA;
        $save->subtotal = $request->subtotal;
        $save->total = $save->subtotal + $save->taxIVA;
        $save->status = $request->status;

        $response = [];

        if (strtoupper($save->status) == 'S') {
            //get cart info
            $cart = new CartController();
            $res = $cart->getCartByUserId($save->user_id);

            if ($res["success"]) {

                foreach ($res["data"] as $re) {
                    //save detail
                    $details = new saleDetail();
                    $details->sale_id = $save->id;
                    $details->clothing_id = $re->clothing_id;
                    $details->amount = $re->amount;

                    //get clothing price
                    $aux = new ClothingController();

                    $expect = $aux->getClotheById($details->clothing_id);

                    if ($expect["success"]) {
                        $details->clothingprice = $expect["data"]->price;
                        $details->totalprice = $re->total;
                        $resAux = $this->updateStock($details->clothing_id, $details->amount);

                        if ($resAux == 0) {

                            $save->save();
                            $details->sale_id = $save->id;
                            $details->save();
                            //delete cart
                            $cartO = new CartController();
                            $crRes = $cartO->deleteCartByUserId($save->user_id);
                            $response = ResponseBuilderServiceProvider::buildResponse(true, "sale saved succesfully", array($save, $details));
                        } else {
                            $response = ResponseBuilderServiceProvider::buildResponse(false, "One or more products are out stock", false);
                            break;
                        }
                    }
                }
            } else {
                $response = ResponseBuilderServiceProvider::buildResponse(false, "cart doesnt have data with this user", false);
            }
        } else {
            $response = ResponseBuilderServiceProvider::buildResponse(false, "status doesnt permit this action", false);
        }



        return response()->json($response);
    }


    public function updateStock($clothing_id, $amount)
    {
        $compare = Clothing::find($clothing_id);
        //update stock

        if (($amount <= $compare->stock) && ($compare->stock > 0)) {
            $compare->stock -= $amount;
            $compare->save();
            return 0;
        } else {
            return 1;
        }
    }

    public function historySaleByUserId($id)
    {
        $find = Sale::where("user_id", $id)->get();
        $response = [];

        if (count($find) != 0) {
            $response = ResponseBuilderServiceProvider::buildResponse(true, "your history data", $find);
        } else {
            $response = ResponseBuilderServiceProvider::buildResponse(false, "no data found in history sale", false);
        }

        return response()->json($response);
    }
}
