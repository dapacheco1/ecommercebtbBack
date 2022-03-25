<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = ["slug", "detail","status"];

    #direct relationship
    public function sizes(){
        return $this->hasMany(Size::class);
    }

    public function clothing(){
        return $this->hasMany(Clothing::class);
    }
    
}
