<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['category_id','name','slug','image','status','save_by','updated_by','ip_address'];

    public function Category(){
        return  $this->belongsTo(Category::class)->withTrashed();
    }
    
    public function subSubCategory(){
        return $this->hasMany(Subsubcategory::class);
    }
 
    public function product(){
        return $this->hasMany(Product::class, 'sub_category_id');
    }

  
}
