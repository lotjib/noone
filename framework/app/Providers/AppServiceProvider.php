<?php

namespace App\Providers;

use App\Http\Controllers\Helper;
use App\Models\Article;
use App\Models\ArticleComments;
use App\Models\ArticleTag;
use App\Models\ArticleTagToArticle;
use App\Models\ArticleToLikeUser;
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
        Helper::loadArticle();
        Helper::loadArticleComments();
        Helper::loadArticleTag();
        Helper::loadArticleTagToArticle();
        Helper::loadArticleToLikeUser();
        Helper::loadArticleToUser();
        Paginator::useBootstrap();
    }
}
