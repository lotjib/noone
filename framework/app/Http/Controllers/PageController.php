<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleSee;
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

    private function generateArticlesData($articles)
    {
        foreach ($articles as $article) {
            $article = $this->generateArticleData($article);
        }
        return $articles;
    }

    private function generateArticleData($article)
    {
        $see_counters = Cache::get(Helper::ArticleToUser);
        $likes = Cache::get(Helper::ArticleToLikeUser);
        $article->articlesTags = $this->getArticleTags($article);
        $article->see_counter = collect($see_counters->where('id_article', $article->id)->all())->count();
        $article->like = false;
        if ($searchMyLike = $likes->where('id_article', $article->id)->where('user_tredium_session', $this->helper->getUser())->first()) {
            $article->like = true;
        }
        return $article;
    }

    private function getTagsFromArticleId($article_id = null)
    {
        $articleTagToArticle_cache = Cache::get(Helper::ArticleTagToArticle);
        $articleTag_cache = Cache::get(Helper::ArticleTag);
        if ($articleTagToArticle_cache) {
            $articleTagToArticle = collect($articleTagToArticle_cache->all());
        }
        if ($articleTag_cache) {
            $articleTag = collect($articleTag_cache->all());
        }
        if (isset($articleTagToArticle) && isset($articleTag)) {
            if (!empty($article_id)) {
                $articleTagToArticle = collect($articleTagToArticle->where('id_article', $article_id)->all());
            }
            $used_art_to_tags = $articleTagToArticle->pluck('id_article_tag');
            return collect($articleTag->whereIn('id', $used_art_to_tags)->all());
        }
        return [];
    }

    private function getAllArticleTags()
    {
        return $this->getTagsFromArticleId();
    }

    private function getArticleTags($article)
    {
        return $this->getTagsFromArticleId($article->id);
    }

    private function addArticleCounter($id_article)
    {
        $user_tredium_session = '';
        if (
        $user = $this->helper->getUser()
        ) {
            $user_tredium_session = $user;
        }
        $this->helper->addArticleCounters($id_article, $user_tredium_session);
    }

    public function index()
    {
        $articles = [];
        $articles_cache = Cache::get(Helper::Article);
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

    public function articles()
    {
        $articles = [];
        $articles_cache = Cache::get(Helper::Article);
        if ($articles_cache) {
            $articles = $this->helper->paginate($articles_cache->all(), 10, \Illuminate\Support\Facades\Request::path());
        }
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

    public function article($slug)
    {
        $article = '';
        if ($slug) {
            $articles_cache = Cache::get(Helper::Article);
            if ($articles_cache) {
                $article = collect($articles_cache->all())->firstWhere('slug', $slug);
            }
        }
        if (isset($article) && $article) {
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
