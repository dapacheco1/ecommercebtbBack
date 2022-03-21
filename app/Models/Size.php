<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = "sizes";

    protected $fillable = ["category_id","size","status"];

    #direct relationship
    public function clothing(){
        return $this->hasMany(Clothing::class);
    }

    #inverse relationship
    public function category(){
        return $this->belongsTo(Category::class);
    }




}
