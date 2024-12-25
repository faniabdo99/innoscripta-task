<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * This method retrieves all articles from the cache if available,
     * otherwise it fetches them from the database and caches the result for 60 seconds.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $articles = Article::query();
        if ($request->title) {
            $articles->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->category) {
            $articles->where('category', $request->category);
        }
        if ($request->source) {
            $articles->where('source', $request->source);
        }
        if ($request->author) {
            $articles->where('author', $request->author);
        }
        if ($request->date) {
            $articles->whereDate('created_at', Carbon::parse($request->date));
        }
        
        $cacheKey = 'articles_page_' . $page . '_per_page_' . $perPage . '_title_' . $request->title . '_category_' . $request->category . '_source_' . $request->source . '_author_' . $request->author . '_date_' . $request->date;
        return Cache::remember($cacheKey, 240, function () use ($articles, $perPage, $page) {
            return $articles->paginate($perPage, ['*'], 'page', $page);
        });
    }

    /**
     * Display the specified article.
     *
     * This method retrieves a specific article from the cache if available,
     * otherwise it fetches it from the database and caches the result for 180 seconds.
     *
     * @param \App\Models\Article $article The article instance to be displayed.
     * @return \App\Models\Article The article instance.
     */
    public function show(Article $article)
    {
        return Cache::remember('article_' . $article->id, 300, function () use ($article) {
            return $article;
        });
    }
}
