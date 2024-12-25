<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSingleArticleTest extends TestCase {
    use RefreshDatabase;

    /**
     * Test that a single article is fetched.
     *
     * This test ensures that the API endpoint for fetching a single article
     * returns a successful response and contains the expected number of articles.
     */
    public function test_example(): void {
        // Create an article using the factory
        $article = \App\Models\Article::factory()->create();

        // Send a GET request to the articles show route
        $response = $this->get(route('articles.show', $article->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'title',
            'snippet',
            'image',
            'content',
            'source',
            'author',
            'category',
        ]);
    }
}
