<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;
    protected $table = 'car_brands';
    protected $fillable = [
        'id',
        'name'
    ];

    public function car (){
        return $this->hasMany(Car::class,'brand_id');
    }
}
