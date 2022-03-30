<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saleDetail extends Model
{
    use HasFactory;

    protected $table = "salesdetail";
    protected $fillable = ["sale_id","clothing_id","amount","clothingprice","totalprice"];

    #inverse relationship
    public function sale(){
        return $this->belongsTo(Sale::class);
    }

    public function clothing(){
        return $this->belongsTo(Clothing::class);
    }
}
