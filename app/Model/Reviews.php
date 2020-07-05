<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = ['name', 'email', 'title', 'review', 'rate', 'listing_id'];
}
