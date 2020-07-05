<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessListings extends Model
{

    protected $fillable = ['name', 'address', 'phone', 'email', 'description', 'url', 'published'];

    protected $with = ['categories'];

    protected $hidden = ['images'];

    protected $casts = [
        'published' => 'boolean',
        'approved' => 'boolean'

    ];

    protected $appends = ['default_image'];

    public function categories()
    {
        return $this->belongsToMany('App\Model\Categories')->withPivot('categories_id', 'business_listings_id');
    }

    public function addImage(ListingImages $images)
    {
        return $this->images()->save($images);
    }

    public function images()
    {
        return $this->hasMany(ListingImages::class);
    }

    public function getDefaultImageAttribute()
    {
        $image_url  = $this->images->first()->image_path;

        return env('APP_URL')."/$image_url";
    }

    public function scopeQuerySearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('address', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('url', 'LIKE', "%$search%");
    }

    public function scopeApproved($query)
    {
        return $query->where('published', 1);
    }
}
