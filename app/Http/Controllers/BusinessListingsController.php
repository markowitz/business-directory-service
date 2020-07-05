<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CreateListing, EditListing};
use App\Model\BusinessListings;
use App\Model\ListingImages;
use Illuminate\Http\Request;
use App\Repositories\ListingsRepository;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\DB;

class BusinessListingsController extends Controller
{
    private $listingsRepo;

    public function __construct(ListingsRepository $listingsRepo)
    {
        $this->listingsRepo = $listingsRepo;
    }

    public function create(CreateListing $request)
    {
        $request = $request->validated();
        $categories = $request['categories'];
        $image = $request['images'];
        DB::transaction(function () use ($request, $categories, $image) {
            $listing = $this->listingsRepo->persist($request);

            $listing->categories()->attach(explode(",", $categories));

            $imagesUrl = FileUpload::multipleUpload($image, 'listings');
            foreach($imagesUrl as $key => $url) {
                $images = new ListingImages();
                if($key == 0) {
                    $images->is_default = 1;
                }
                $images->image_path = $url;
                $listing->addImage($images);
            }

            return $this->respondWithSuccess($listing, 'listing added successfully', 201);
        });

    }

    public function listings()
    {

        $listings = BusinessListings::all();

        return $this->respondWithSuccess($listings, '', 201);
    }

    public function editListing(BusinessListings $listing, EditListing $request)
    {
        $request = $request->validated();

        if(isset($request['published'])) {
            $update = $this->listingsRepo->update($request, $listing->id);
            return $this->respondWithSuccess("", "listing updated successfully", 201);
        }

        $categories = $request['categories'];

        DB::transaction(function () use ($request, $categories) {
            $listing = $this->listingsRepo->update($request);

            $listing->categories()->attach($categories);

            return $this->respondWithSuccess($listing, 'listing edited successfully', 201);
        });

    }

    public function search(Request $request)
    {
        $search = $request->search;

        $results = $this->listingsRepo->search($search);

        return $this->respondWithSuccess($results, "data fetched successfully", 201);
    }

    public function delete(BusinessListings $listing)
    {
        $listing->categories()->detach();

        $delete  = $this->listingsRepo->delete($listing->id);

        return $this->respondWithSuccess("", "listing deleted successfully", 204);
    }

    public function listing(BusinessListings $listing)
    {
        $listing = $this->listingsRepo->findById($listing->id);

        if($listing) $listing->increment('views_count', 1);

        return $this->respondWithSuccess($listing, 'listing retrived', 201);
    }
}
