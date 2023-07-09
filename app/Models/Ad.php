<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['title','position','save_by','updated_by','ip_address','image','status'];
}
