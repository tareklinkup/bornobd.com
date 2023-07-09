<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','slug','image','save_by'];
     
    public function SubCategory(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    public function subSubCategory(){
        return $this->hasMany(Subsubcategory::class);
    }
    public function anotherCategory(){
        return $this->hasMany(AnotherCategory::class);
    }

    public function product(){
        return $this->hasMany(Product::class, 'category_id');
    }

}
