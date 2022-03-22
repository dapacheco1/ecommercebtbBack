<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    //TABLE NAME OF DATABASE
    protected $table = "users";

    //data columns can manipulate
    protected $fillable = ["person_id","rol_id","email","username","password","status"];

    //hidden data when request with HTTP methods
    protected $hidden = ["password"];


     #DIRECT RELATIONSHIPS
     public function person(){
        return $this->hasOne(Person::class);
    }

    public function rol(){
        return $this->hasOne(Rol::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

}
