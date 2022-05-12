<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleSee;
use App\Models\Article;
use App\Models\ArticleComments;
use App\Models\ArticleTag;
use App\Models\ArticleTagToArticle;
use App\Models\ArticleToLikeUser;
use App\Models\ArticleToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Helper extends Controller
{
    const Article = 'Article';
    const ArticleComments = 'ArticleComments';
    const ArticleTag = 'ArticleTag';
    const ArticleTagToArticle = 'ArticleTagToArticle';
    const ArticleToLikeUser = 'ArticleToLikeUser';
    const ArticleToUser = 'ArticleToUser';


    public static function loadArticle()
    {
        Cache::forever(Helper::Article, Article::all());
    }

    public static function loadArticleComments()
    {
        Cache::forever(Helper::ArticleComments, ArticleComments::all());
    }

    public static function loadArticleTag()
    {
        Cache::forever(Helper::ArticleTag, ArticleTag::all());
    }

    public static function loadArticleTagToArticle()
    {
        Cache::forever(Helper::ArticleTagToArticle, ArticleTagToArticle::all());
    }

    public static function loadArticleToLikeUser()
    {
        Cache::forever(Helper::ArticleToLikeUser, ArticleToLikeUser::all());
    }

    public static function loadArticleToUser()
    {
        Cache::forever(Helper::ArticleToUser, ArticleToUser::all());
    }

    public function addArticleCounters($id_article = '', $user_tredium_session = '')
    {
        if ($user_tredium_session && $id_article) {
            ArticleSee::dispatch((object)[
                'user_tredium_session' => $user_tredium_session,
                'id_article' => $id_article
            ]);
        }
    }

    public function getUser()
    {
        return Cookie::get('tredium_session');
    }

    public function paginate($items, $perPage = 15, $baseUrl = null,
                             $page = null,
                             $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ?
            $items : Collection::make($items);

        $lap = new LengthAwarePaginator($items->forPage($page, $perPage),
            $items->count(),
            $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        return $lap;
    }


    public function generateImgUrl($txt = 'Simple Text', $txtcolor = 'fff', $bgcolor = '09ff', $img_size = '1366x768', $img_ext = 'png')
    {
        return 'https://via.placeholder.com/' . $img_size . '.' . $img_ext . '/' . $bgcolor . '/' . $txtcolor . '?text=' . $txt;
    }
}
