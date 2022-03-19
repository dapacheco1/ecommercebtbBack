<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Rol;
use Illuminate\Http\Request;

//import user model to create controller
use App\Models\User;

class UserController extends Controller
{

    #DIRECT RELATIONSHIPS
    public function relationWithPerson(){
        return $this->hasOne(Person::class);
    }

    public function relationWithRol(){
        return $this->hasOne(Rol::class);
    }

    // public function relationWithCart(){
    //     returh $this->hasMany(Cart::class);
    // }


}