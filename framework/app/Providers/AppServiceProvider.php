<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\ArticleComments;
use App\Models\ArticleToUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::forever('articles', Article::all());
        Cache::forever('article_to_see', ArticleToUser::all());
        Cache::forever('article_comments', ArticleComments::all());
        Paginator::useBootstrap();
    }
}
