<?php

namespace App\Http\Controllers;
use App\Providers\validateExistanceServiceProvider;
use App\Providers\ResponseBuilderServiceProvider;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
     #inverse relationships
     public function relationWithUsers(){
        return $this->belongsTo(User::class);
    }

    //CREATES ROL
    public function createRol(Request $request){
        $rol = $request;

        $valid = validateExistanceServiceProvider::validateExistanceData($rol->detail,Rol::class,"detail");
        $response = [];

        if($valid["success"]){

            $rols = new Rol();
            $rols->detail = $rol->detail;
            $rols->status = $rol->status;
            $rols->save();

            $response = ResponseBuilderServiceProvider::buildResponse(true,"Rol Saved",$rols);
        }else{
            $response = $valid;
        }
        return response()->json($response);
    }

    public function getRols(){
        $allRols = Rol::all();

        $responseAll = [];

        if(count($allRols)!=0){
            $responseAll = ResponseBuilderServiceProvider::buildResponse(true,"This is all rols database",$allRols);
        }else{
            $responseAll = ResponseBuilderServiceProvider::buildResponse(false,"No data found of rols",false);
        }

        return response()->json($responseAll);
    }

}