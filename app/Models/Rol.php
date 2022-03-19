<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    //TABLE NAME OF DATABASE
    protected $table = "rols";

    //data columns can manipulate
    protected $fillable = ["detail","status"];

     #inverse relationships
     public function relationWithUsers(){
        return $this->belongsTo(User::class);
    }
}