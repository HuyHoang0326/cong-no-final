<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function parsts()
    {
        return $this->hasMany(Parst::class);
    }
}
