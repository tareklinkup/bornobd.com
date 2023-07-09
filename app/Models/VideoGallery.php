<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoGallery extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['title','youtube_link','save_by','updated_by'];
}
