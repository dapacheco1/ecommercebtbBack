<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    #direct relationships
    public function relationWithGenres(){
        return $this->hasOne(Genre::class);
    }

    #inverse relationships
    public function relationWithUsers(){
        return $this->belongsTo(User::class);
    }

}