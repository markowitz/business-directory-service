<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BusinessListings extends Model
{

    protected $fillable = ['name', 'address', 'phone', 'email', 'description', 'url', 'published', 'views_count'];

    protected $with = ['categories'];

    protected $hidden = ['images'];

    protected $casts = [
        'published' => 'boolean',
        'approved' => 'boolean'

    ];

    protected $appends = ['default_image', 'images_url', 'review_avg'];

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

    public function getImagesUrlAttribute()
    {
        $images = $this->images;
        $newImages = [];
        foreach($images as $image) {
            $newImages[] =  env('APP_URL')."/{$image->image_path}";
        }

        return $newImages;
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'listing_id');
    }

    public function getReviewAvgAttribute()
    {
        $avg = collect($this->reviews->pluck('rate'))->avg();

        return $avg ?? 0;
    }

    public function getDefaultImageAttribute()
    {
        $image_url  = $this->images->first()->image_path;

        return env('APP_URL')."/$image_url";
    }

    public function scopeQuerySearch($query, $search)
    {
        return $query->where('business_listings.name', 'LIKE', "%$search%")
                        ->orWhere('business_listings.email', 'LIKE', "%$search%")
                        ->orWhere('business_listings.address', 'LIKE', "%$search%")
                        ->orWhere('business_listings.phone', 'LIKE', "%$search%")
                        ->orWhere('business_listings.description', 'LIKE', "%$search%")
                        ->orWhere('business_listings.url', 'LIKE', "%$search%");
    }

    public function scopeApproved($query)
    {
        return $query->where('published', 1);
    }

    public function scopeRatings($query)
    {
        return $query->leftJoin('reviews', 'reviews.listing_id', '=', 'business_listings.id')
                        ->select('business_listings.*', DB::raw("IF(AVG(reviews.rate), AVG(reviews.rate), 0) as avg_rating"))
                        ->groupBy('business_listings.id', 'business_listings.name')->orderBy('avg_rating', 'DESC');
    }
}
