<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewsRequest;
use App\Repositories\ReviewsRepository;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    private $reviewRepo;

    public function __construct(ReviewsRepository $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }
    public function add(ReviewsRequest $request)
    {
        $request = $request->validated();

        $review = $this->reviewRepo->persist($request);

        return $this->respondWithSuccess($review, "review added successfully", 201);
    }
}
