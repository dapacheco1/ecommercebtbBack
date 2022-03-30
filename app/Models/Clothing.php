<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    protected $table  = "clothing";

    protected $fillable = ["category_id","size_id","price","stock","image","name","detail","genre_id","status"];

    #direct relationship
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function saleDetail(){
        return $this->hasMany(saleDetail::class);
    }

    #inverse relationship
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

}
