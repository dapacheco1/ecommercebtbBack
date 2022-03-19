<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Rol;
use Illuminate\Http\Request;

//import user model to create controller
use App\Models\User;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

private $person;

    public function __construct(){
        $this->person = new PersonController();
    }

   public function createUser(Request $request){
    $user = $request;
    $validEmail = validateExistanceServiceProvider::validateExistanceData($user->email,User::class,"email");
    $validUsername = validateExistanceServiceProvider::validateExistanceData($user->username,User::class,"username");
    $validRol = validateExistanceServiceProvider::validateExistanceData($user->rol_id,Rol::class,"id");

    $msg = 'See this others: ';

    $response = [];
    if(!$validEmail["success"] && !$validUsername["success"] && $validRol["success"]){
        
        //creates user or verify if it exists
        $auxRes = $this->person->createPerson($user->person);


        if($auxRes["success"]){
            //get id from registered user
            $id = $this->person->getIdPersonByCI($user->person["identifierDocument"]);
            
            if($id["success"]){
                $us = new User();
                $us->person_id = $id["data"];
                $us->rol_id = $user->rol_id;
                $us->username = $user->username;
                $us->email = $user->email;
                $us->password = Hash::make($user->password);
                $us->status = $user->status;
                $us->save();
    
                $response = ResponseBuilderServiceProvider::buildResponse(true,"User Saved",$us);
            }else{
                $msg = "-> Error when searching created user id";
                $response = ResponseBuilderServiceProvider::buildResponse(false,"$msg",false);
            }
           
        }else{
            $msg="->Error occurs when creating person";
            $response = ResponseBuilderServiceProvider::buildResponse(false,"$msg",false);
        }
        
    }else{
        //ONLY FOR DEBUG
        //$response = [$validEmail,$validUsername,$validPerson,$validRol];

        $response = ResponseBuilderServiceProvider::buildResponse(false,"Error when trying to create user",false);
    }
    return response()->json($response);
   }



   public function authenticateUser(Request $request){
        $user = $request;
        $response =[];

        $validUs = validateExistanceServiceProvider::validateExistanceData($user->username,User::class,"username");

        if($validUs["success"]){
            if(Hash::check($user->password,$validUs["data"]->password)){
                $response = ResponseBuilderServiceProvider::buildResponse(true,"Welcome to the app",$validUs["data"]);
            }else{
                $response = ResponseBuilderServiceProvider::buildResponse(false,"Access denied, wrong password",false);
            }
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Access denied, wrong username",false);
        }

        return response()->json($response);
   }


}