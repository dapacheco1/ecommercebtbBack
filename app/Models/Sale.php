<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = "sales";
    protected $fillable = ["user_id","saleDate","saleHour","taxIVA","total","status"];

    #direct relationship
    public function saleDetail(){
        return $this->hasMany(saleDetail::class);
    }
}
