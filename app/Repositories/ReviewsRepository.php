<?php

namespace App\Repositories;

use App\Model\Reviews;

class ReviewsRepository extends BaseRepository
{
    private $reviews;

    public function __construct(Reviews $reviews)
    {
        $this->reviews = $reviews;

        parent::__construct($reviews);
    }
}