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

        return $this->listings->approved()->querySearch($search)->get();
    }

}