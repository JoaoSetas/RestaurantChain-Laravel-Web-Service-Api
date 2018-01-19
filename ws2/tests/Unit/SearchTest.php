<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker as Faker;

class SearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearchTest()
    {
        $faker = Faker\Factory::create();
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->json('GET', '/search');

        $response
            ->assertStatus(200);
    }
}
