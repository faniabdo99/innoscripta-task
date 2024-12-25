<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use App\Models\Article;
use Illuminate\Support\Str;

Route::get('/', function () {

    $client = new Client();
    $response = $client->request('GET', 'https://newsapi.org/v2/everything?q=tesla&from=2024-12-22&sortBy=publishedAt&apiKey='.env('NEWSAPI_API_KEY'));
    $data = json_decode($response->getBody(), true);
    foreach ($data['articles'] as $article) {
        Article::updateOrCreate([
            'title' => $article['title'],
            'source' => 'news-api',
        ],[
            'title' => $article['title'],
            'snippet' => Str::limit($article['description'], 252, '...'),
            'image' => is_null($article['urlToImage']) || strlen($article['urlToImage']) > 255 ? 'https://picsum.photos/600/250' : $article['urlToImage'],
            'content' => $article['content'] ?? 'no content', 
            'source' => 'news-api',
            'author' => $article['author'],
            'category' => null
        ]);
    }


    return view('welcome');
});
