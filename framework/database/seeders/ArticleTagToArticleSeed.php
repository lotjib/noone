<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\ArticleTagToArticle;
use Illuminate\Database\Seeder;

class ArticleTagToArticleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleTagToArticle::truncate();
        $tags = new ArticleTag();
        $articles = Article::all();
        foreach ($articles as $article) {
            $tags_for_this = $tags->inRandomOrder()
                ->limit(5)
                ->get();
            foreach ($tags_for_this as $tag){
                ArticleTagToArticle::create([
                   'id_article_tag' => $tag->id,
                   'id_article' => $article->id,
                ]);
            }
        }
    }
}
