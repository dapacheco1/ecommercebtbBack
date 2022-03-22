<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "cart";
    protected $fillable = ["user_id","clothing_id","amount","total","status"];

    #inverse relationship
    public function clothing(){
        return $this->belongsTo(Clothing::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
