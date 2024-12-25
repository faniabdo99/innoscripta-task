<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;
use App\Models\Article;
use Illuminate\Support\Str;

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Ready for requests'
    ]);
});
