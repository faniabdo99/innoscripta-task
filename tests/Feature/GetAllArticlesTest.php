<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllArticlesTest extends TestCase {
    use RefreshDatabase;

    /**
     * Test that all articles are fetched.
     *
     * This test ensures that the API endpoint for fetching all articles
     * returns a successful response and contains the expected number of articles.
     */
    public function test_all_articles_are_fetched(): void {
        // Create 10 articles using the factory
        \App\Models\Article::factory()->count(10)->create();

        // Send a GET request to the articles index route
        $response = $this->get(route('articles.index'));
        // Assert that the response status is 200 OK
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'title',
                    'snippet',
                    'image',
                    'content',
                    'source',
                    'author',
                    'category',
                ],
            ],
        ]);
        // Assert that the JSON response contains 10 articles in the 'data' key
        $response->assertJsonCount(10, 'data');
    }
}
