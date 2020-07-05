<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ListingImages extends Model
{
    protected $fillable = ['image_path',  'is_default'];
}
