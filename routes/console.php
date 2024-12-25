<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\FetchArticlesJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Fetch articles every 15 secondsc
Schedule::job(new FetchArticlesJob('newsapi'))->everyFifteenSeconds();
Schedule::job(new FetchArticlesJob('theguardian'))->everyFifteenSeconds();
Schedule::job(new FetchArticlesJob('thenewyorktimes'))->everyFifteenSeconds();

