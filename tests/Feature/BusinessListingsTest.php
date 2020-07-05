<?php

namespace Tests\Feature;

use App\Model\BusinessListings;
use App\Model\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BusinessListingsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_add_business_listings()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->make();

        //login user
        Auth::login($user);

        $attributes = [
            'name' => 'Inits Limited',
            'description' => 'We are a technology company',
            'url' => 'https://www.initsng.com/v2/',
            'email' => 'info@initsng.com',
            'phone' => '081222222222',
            'address' => 'No 1 Yaba, Lagos',
            'images' => 'file.png',
            'approved' => 0,
            'published' => 0,
            'categories' => [1, 2]
        ];

        $attribute = [
            'business_listings_id' => 1,
            'categories_id' => 1
        ];

        $response = $this->json('POST', '/api/admin/listings/add', $attributes);

        unset($attributes['categories']);
        $this->assertDatabaseHas('business_listings', $attributes);

        $this->assertDatabaseHas('business_listings_categories', $attribute);

        $response->assertStatus(201);
    }
}
