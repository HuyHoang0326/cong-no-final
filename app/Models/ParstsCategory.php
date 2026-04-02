<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParstsCategory extends Model
{
    use HasFactory;
    protected $table = 'parsts_category';

    public function parst()
    {
        return $this->hasMany(Parst::class, 'parst_category_id');
    }
}
