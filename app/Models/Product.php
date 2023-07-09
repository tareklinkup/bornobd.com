<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =['id'];
    protected $appends = ['currency_amount'];
     
    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function SubCategory(){
        return $this->belongsTo(SubCategory::class);
    }
    public function SubsubCategory(){
        return $this->belongsTo(Subsubcategory::class, 'subsubcategory_id', 'id');
    }
    public function anotherCategory(){
        return $this->belongsTo(AnotherCategory::class, 'another_category_id', 'id');
    }
    public function inventory(){
        return $this->hasOne(Inventory::class);
    }
    public function features(){
        return $this->hasMany(ProductFeature::class);
    }
    public function features_4(){
        return $this->hasMany(ProductFeature::class)->take(4);
    }
    
    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }
    
    public function review(){
        return $this->belongsTo(Review::class);
    }

    public function getCurrencyAmountAttribute()
    {
        return currency_amount($this->price);  
    }
    
}
