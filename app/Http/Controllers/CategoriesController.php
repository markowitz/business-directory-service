<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Model\Categories;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    private $categoriesRepo;

    public function __construct(CategoriesRepository $categoriesRepo)
    {
        $this->categoriesRepo = $categoriesRepo;
    }

    public function create(CreateCategory $request)
    {
        $user    =  $request->user()->id;
        $request =  $request->validated();
        $request['added_by'] = $user;

        $category = $this->categoriesRepo->persist($request);

        return $this->respondWithSuccess($category, 'category created successfully', 201);
    }

    public function fetchCategories()
    {
        $category = $this->categoriesRepo->getApproved();

        return $this->respondWithSuccess($category, '', 201);
    }

    public function fetchAllCategories()
    {
        $category = $this->categoriesRepo->get();

        return $this->respondWithSuccess($category, '', 201);
    }

    public function delete(Categories $category)
    {
        $delete  = $this->categoriesRepo->delete($category->id);

        return $this->respondWithSuccess("", "category deleted successfully", 204);
    }

    public function update(Categories $category, CreateCategory $request)
    {
        $user    = $request->user();
        $request = $request->validated();

        if(isset($request['name']) && $user->user_type == 'admin' && isset($request['published']) == 1) {
            return $this->respondWithError("", "you can't update published category");
        }

        $update = $this->categoriesRepo->update($request, $category->id);

        return $this->respondWithSuccess("", "category updated successfully", 201);
    }

}
