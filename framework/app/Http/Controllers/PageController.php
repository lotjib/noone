<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleSee;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\ArticleTagToArticle;
use App\Models\ArticleToLikeUser;
use App\Models\ArticleToUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
    }

    private function generateArticlesData($articles) {
        $see_counters = ArticleToUser::all();
        $likes = ArticleToLikeUser::all();
        foreach ($articles as $article) {
            $article->see_counter = collect($see_counters->where('id_article', $article->id)->all())->count();
            $article->like = false;
            if ($searchMyLike = $likes->where('id_article', $article->id)->where('user_tredium_session', $this->helper->getUser())->first()){
                $article->like = true;
            }
        }
        return $articles;
    }

    private function generateArticleData($article) {
        $see_counters = ArticleToUser::all();
        $likes = ArticleToLikeUser::all();
        $article->see_counter = collect($see_counters->where('id_article', $article->id)->all())->count();
        $article->like = false;
        if ($searchMyLike = $likes->where('id_article', $article->id)->where('user_tredium_session', $this->helper->getUser())->first()){
            $article->like = true;
        }
        return $article;
    }

    private function getAllArticleTags () {
        $used_art_to_tags = ArticleTagToArticle::all()->pluck('id_article_tag');
        return ArticleTag::whereIn('id', $used_art_to_tags)->get();
    }

    private function getArticleTags($article) {
        $art_to_tags = ArticleTagToArticle::where('id_article', $article->id)->get()->pluck('id_article_tag');
        $article->articlesTags = ArticleTag::whereIn('id', $art_to_tags)->get();
        return $article;
    }

    private function addArticleCounter($id_article){
        $user_tredium_session = '';
        if (
            $user = $this->helper->getUser()
        ) {
            $user_tredium_session = $user;
        }
        $this->helper->addArticleCounters($id_article, $user_tredium_session);
    }

    public function index() {
        $articles = [];
        $articles_cache = Cache::get('articles');
        if ($articles_cache) {
            $articles = collect($articles_cache->take(6)->all());
            $articles = $this->generateArticlesData($articles);
        }
        $data = [
            'ceo_title' => 'ceo_title - index',
            'ceo_description' => 'ceo_description - index',
            // 'ceo_keywords' => 'ceo_keywords - index',
            'articles' => $articles
        ];
        return view('pages.index', $data);
    }

    public function articles() {
        $articles = Article::orderBy('created_at', 'asc')->paginate(10);
        $articles = $this->generateArticlesData($articles);
        $articlesTags = $this->getAllArticleTags();
        $data = [
            'ceo_title' => 'ceo_title - index',
            'ceo_description' => 'ceo_description - index',
            // 'ceo_keywords' => 'ceo_keywords - index',
            'articles' => $articles,
            'articlesTags' => $articlesTags
        ];
        return view('pages.articles', $data);
    }

    public function article($slug) {
        if ($slug){
            $article = Article::where('slug', $slug)->get()->first();
        }
        if (isset($article) && $article) {
            $article = $this->getArticleTags($article);
            $article = $this->generateArticleData($article);
            $this->addArticleCounter($article->id);
            $data = [
                'ceo_title' => 'ceo_title - index',
                'ceo_description' => 'ceo_description - index',
                // 'ceo_keywords' => 'ceo_keywords - index',
                'article' => $article
            ];
            return view('pages.article', $data);
        }
        abort(404);
    }
}
