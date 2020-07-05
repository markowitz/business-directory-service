<?php

namespace App\Repositories;

use App\Model\Categories;

class CategoriesRepository extends BaseRepository
{
    protected $categories;

    public function __construct(Categories $categories)
    {
        $this->categories = $categories;

        parent::__construct($categories);
    }

    public function getApproved()
    {
       return $this->categories->approved()->get();
    }

}