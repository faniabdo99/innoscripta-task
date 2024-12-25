<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory {
    /**
     * Generate fake data for an Article model.
     *
     * @return array<string, mixed> Fake data attributes:
     *                              - 'title': Random sentence for the title.
     *                              - 'snippet': Random sentence for the snippet.
     *                              - 'content': Random paragraph for content.
     *                              - 'image': Random image URL.
     *                              - 'source': Random source ('news-api', 'the-guardian', 'new-york-times').
     *                              - 'author': Random author name.
     *                              - 'category': Random category (e.g., 'politics', 'sports', 'entertainment').
     */
    public function definition(): array {
        return [
            'title' => fake()->sentence(),
            'snippet' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
            'source' => fake()->randomElement(['news-api', 'the-guardian', 'new-york-times']),
            'author' => fake()->name(),
            'category' => fake()->randomElement(['politics', 'sports', 'entertainment', 'technology', 'science', 'health', 'business', 'education', 'environment', 'arts', 'music', 'travel', 'food', 'fashion', 'lifestyle', 'science', 'health', 'business', 'education', 'environment', 'arts', 'music', 'travel', 'food', 'fashion', 'lifestyle']),
        ];
    }
}
