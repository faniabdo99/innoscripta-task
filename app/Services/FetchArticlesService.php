<?php

namespace App\Services;

use App\Models\Article;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FetchArticlesService {
    /**
     * Note: I've intentionally ignored error handling and logging in this service following the KISS principle and giving that this is a background job
     * we do have the luxury of having it failing silently and not affecting the user while the schedule will retry the job every 5 minutes
     * There could be error handler, Error logging using the Log facade and a retry mechanism could be implemented to handle errors more gracefully
     */

    /**
     * Execute the service to fetch articles from various sources.
     *
     * This method orchestrates the fetching of articles from NewsAPI,
     * The Guardian, and The New York Times.
     */
    public function execute() {
        $this->fetchNewsApiArticles();
        $this->fetchTheGuardianArticles();
        $this->fetchTheNewYorkTimesArticles();
    }

    /**
     * Fetch articles from NewsAPI and store them in the database.
     *
     * This method constructs the API request URL, fetches data from NewsAPI,
     * and processes each article to update or create a record in the database.
     */
    private function fetchNewsApiArticles() {
        $url = 'https://newsapi.org/v2/everything?q=tesla&from=2024-12-22&sortBy=publishedAt&apiKey='.env('NEWSAPI_API_KEY');
        $data = $this->fetchDataFromApi($url);
        foreach ($data['articles'] as $article) {
            $this->updateOrCreateArticle([
                'title' => $article['title'],
                'source' => 'news-api',
            ], [
                'title' => $article['title'],
                'snippet' => Str::limit($article['description'], 252, '...'),
                'image' => is_null($article['urlToImage']) || strlen($article['urlToImage']) > 255 ? 'https://picsum.photos/600/250' : $article['urlToImage'],
                'content' => $article['content'] ?? 'no content',
                'source' => 'news-api',
                'author' => $article['author'],
                'category' => null,
            ]);
        }
        Log::info('Data fetched from NewsAPI');
    }

    /**
     * Fetch articles from The Guardian API and store them in the database.
     *
     * This method constructs the API request URL, fetches data from The Guardian,
     * and processes each article to update or create a record in the database.
     */
    private function fetchTheGuardianArticles() {
        $url = 'https://content.guardianapis.com/search?q=tesla&page-size=100&show-fields=body,thumbnail,headline&show-tags=contributor&api-key='.env('THE_GUARDIAN_API_KEY');
        $data = $this->fetchDataFromApi($url);
        foreach ($data['response']['results'] as $article) {
            $this->updateOrCreateArticle([
                'title' => $article['webTitle'],
                'source' => 'the-guardian',
            ], [
                'title' => $article['webTitle'],
                'snippet' => Str::limit($article['fields']['headline'], 252, '...'),
                'image' => ! isset($article['fields']['thumbnail']) || is_null($article['fields']['thumbnail']) || strlen($article['fields']['thumbnail']) > 255 ? 'https://picsum.photos/600/250' : $article['fields']['thumbnail'],
                'content' => $article['fields']['body'] ?? 'no content',
                'source' => 'the-guardian',
                'author' => $article['tags'][0]['webTitle'] ?? 'no author',
                'category' => $article['sectionName'],
            ]);
        }
        Log::info('Data fetched from The Guardian API');
    }

    /**
     * Fetch articles from The New York Times API and store them in the database.
     *
     * This method constructs the API request URL, fetches data from The New York Times,
     * and processes each article to update or create a record in the database.
     */
    private function fetchTheNewYorkTimesArticles() {
        $url = 'https://api.nytimes.com/svc/search/v2/articlesearch.json?q=tesla&fl=headline,snippet,multimedia,byline,section_name,lead_paragraph&api-key='.env('NEW_YORK_TIMES_API_KEY');
        $data = $this->fetchDataFromApi($url);
        foreach ($data['response']['docs'] as $article) {
            $this->updateOrCreateArticle([
                'title' => $article['headline']['main'],
                'source' => 'new-york-times',
            ], [
                'title' => $article['headline']['main'],
                'snippet' => Str::limit($article['snippet'], 252, '...'),
                'image' => ! isset($article['multimedia']) || is_null($article['multimedia']) || strlen($article['multimedia'][0]['url']) > 255 ? 'https://picsum.photos/600/250' : $article['multimedia'][0]['url'],
                'content' => $article['lead_paragraph'] ?? 'no content',
                'source' => 'new-york-times',
                'author' => $article['byline']['original'] ?? 'no author',
                'category' => $article['section_name'],
            ]);
        }
        Log::info('Data fetched from The New York Times API');
    }

    /**
     * Fetch data from a given API URL.
     *
     * @param  string  $url  The API endpoint URL.
     * @return array The decoded JSON response from the API.
     */
    private function fetchDataFromApi($url) {
        $client = new Client;
        $response = $client->request('GET', $url);

        return json_decode($response->getBody(), true);
    }

    /**
     * Update or create an article record in the database.
     *
     * @param  array  $identifiers  The unique identifiers for the article.
     * @param  array  $data  The data to update or create the article with.
     */
    private function updateOrCreateArticle($identifiers, $data) {
        Article::updateOrCreate($identifiers, $data);
    }
}
