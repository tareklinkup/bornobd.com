<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsubcategory extends Model
{
    use HasFactory;

    public function Category(){
        return  $this->belongsTo(Category::class);
    }

    public function SubCategory(){
        return  $this->belongsTo(SubCategory::class);
    }

    public function anotherCategory(){
        return $this->hasMany(AnotherCategory::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}
