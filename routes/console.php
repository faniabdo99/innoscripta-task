<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\FetchArticlesJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Fetch articles every 5 minutes, this ensures the data are up to date with minimal impact on the server
Schedule::job(new FetchArticlesJob('newsapi'))->everyFiveMinutes();
Schedule::job(new FetchArticlesJob('theguardian'))->everyFiveMinutes();
Schedule::job(new FetchArticlesJob('thenewyorktimes'))->everyFiveMinutes();

