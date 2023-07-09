<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    use HasFactory;
    protected $fillable = ['user_id','page_id'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function page(){
        return $this->belongsTo(Page::class,'page_id','id');
    }

}
