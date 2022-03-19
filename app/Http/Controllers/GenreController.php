<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Person;
use App\Providers\validateExistanceServiceProvider;
use App\Providers\ResponseBuilderServiceProvider;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    #inverse relationships
    public function relationWithPersons(){
        return $this->belongsTo(Person::class);
    }

    //create genre
    public function createGenre(Request $request){
        $genre = $request;

        $valid = validateExistanceServiceProvider::validateExistanceData($genre->genre,Genre::class,"genre");
        $response = [];

        if($valid["success"]){

            $gen = new Genre();
            $gen->genre = $genre->genre;
            $gen->status = $genre->status;
            $gen->save();

            $response = ResponseBuilderServiceProvider::buildResponse(true,"Genre Saved",$gen);
        }else{
            $response = $valid;
        }
        return response()->json($response);
    }

    //get all database genres

    public function getGenres(){
        $allGen = Genre::all();

        $responseAll = [];

        if(count($allGen)!=0){
            $responseAll = ResponseBuilderServiceProvider::buildResponse(true,"This is all genres database",$allGen);
        }else{
            $responseAll = ResponseBuilderServiceProvider::buildResponse(false,"No data found of genres",false);
        }

        return response()->json($responseAll);
    }




}