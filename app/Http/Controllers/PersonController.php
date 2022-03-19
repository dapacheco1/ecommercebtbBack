<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Person;
use App\Providers\ResponseBuilderServiceProvider;
use App\Providers\validateExistanceServiceProvider;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function createPerson($request){
        $prs = $request;
        $validCI = validateExistanceServiceProvider::validateExistanceData($prs["identifierDocument"],Person::class,"identifierDocument");
        $validGen = validateExistanceServiceProvider::validateExistanceData($prs["genre_id"],Genre::class,"id");
        $response = [];

        if(!$validCI["success"] && $validGen["success"]){
            
            $person = new Person();
            $person->identifierDocument = $prs["identifierDocument"];
            $person->names = $prs["names"];
            $person->lastnames = $prs["lastnames"];
            $person->genre_id = $prs["genre_id"];
            $person->status = $prs["status"];
            
            $person->save();

            $response = ResponseBuilderServiceProvider::buildResponse(true,"Person Saved",$prs);
        }else{
            $response = ResponseBuilderServiceProvider::buildResponse(false,"Error when try to save person",false);
        }
        return $response;

    }

    public function getPersons(){
        $allPrs = Person::all();

        $responseAll = [];

        if(count($allPrs)!=0){
            foreach($allPrs as $per){
                $per->genre;
            }

            $responseAll = ResponseBuilderServiceProvider::buildResponse(true,"This is all persons in database",$allPrs);
        }else{
            $responseAll = ResponseBuilderServiceProvider::buildResponse(false,"No data found of persons",false);
        }

        return response()->json($responseAll);
    }


    public function getIdPersonByCI($ci){
        $find = Person::where("identifierDocument",$ci)->first();
        $response = [];

        if($find){
            $response = ResponseBuilderServiceProvider::buildResponse(true,"id find",$find->id);
        }else{
           $response  = ResponseBuilderServiceProvider::buildResponse(false,"id not found",false);
        }

        return $response;
    }

}
