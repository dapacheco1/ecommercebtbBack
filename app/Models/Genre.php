<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    //TABLE NAME OF DATABASE
    protected $table = "genres";

    //data columns can manipulate
    protected $fillable = ["genre","status"];
}