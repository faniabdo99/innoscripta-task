<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetApiIndexTest extends TestCase {
    /**
     * Test the API index endpoint.
     *
     * This test ensures that the API index endpoint returns a successful response
     * with the expected JSON structure indicating that the API is ready for requests.
     */
    public function test_example(): void {
        $response = $this->get('/');
        $response->assertJson([
            'status' => 'success',
            'message' => 'Ready for requests',
        ]);
        $response->assertStatus(200);
    }
}
