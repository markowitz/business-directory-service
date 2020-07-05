<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_create_a_category()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->make();

        //login user
        Auth::login($user);

        $attributes = [
            'name' => 'Hospitality',
            'added_by' => $user->id
        ];



        $response = $this->json('POST', '/api/admin/categories/add', $attributes);

        $this->assertDatabaseHas('categories', $attributes);

        $response->assertStatus(201);
    }
}
