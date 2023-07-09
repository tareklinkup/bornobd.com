<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    use HasFactory;
    protected $fillable = ['district_id','charge'];

    public function district(){
        return $this->belongsTo(District::class);
    }
}
