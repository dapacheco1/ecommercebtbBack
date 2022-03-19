<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    //TABLE NAME OF DATABASE
    protected $table = "persons";

    //data columns can manipulate
    protected $fillable = ["identifierDocument","names","lastnames","genre_id","status"];

    #inverse relationships
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}