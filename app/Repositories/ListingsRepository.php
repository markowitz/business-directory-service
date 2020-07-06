<?php

namespace App\Repositories;

use App\Model\BusinessListings;
use App\Model\ListingImages;

class ListingsRepository extends BaseRepository
{
    private $listings;
    private $images;

    public function __construct(BusinessListings $listings, ListingImages $images)
    {
        $this->listings = $listings;
        $this->images = $images;
        parent::__construct($listings);
    }

    public function search(string $search = null)
    {

        return $this->listings->ratings()->approved()->querySearch($search)->groupBy('business_listings.id')->get();
    }

    public function sortByRating()
    {
        return $this->listings->ratings()->groupBy('business_listings.id')->get();
    }

}