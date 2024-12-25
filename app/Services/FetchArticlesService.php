<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
class FetchArticlesService
{
    public function execute()
    {
        $this->fetchNewsApiArticles();
        $this->fetchTheGuardianArticles();
        $this->fetchTheNewYorkTimesArticles();
    }

    private function fetchNewsApiArticles()
    {
        Log::info('Fetching articles from NewsAPI');
    }

    private function fetchTheGuardianArticles()
    {
        Log::info('Fetching articles from The Guardian API');
    }

    private function fetchTheNewYorkTimesArticles()
    {
        Log::info('Fetching articles from The New York Times API');
    }
}

