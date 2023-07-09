<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','designation','facebook','twitter','linkedin','instagram','image','status','save_by','updated_by','ip_address'];
}
