<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'added_by', 'published'];

    protected $with = ['user'];

    protected $casts = ['published' => 'boolean'];

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by', 'id')->select(['id', 'name']);
    }

    public function scopeApproved($query)
    {
        return $query->where('published', 1);
    }
}
