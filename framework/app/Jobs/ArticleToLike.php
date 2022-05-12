<?php

namespace App\Jobs;

use App\Models\ArticleToUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ArticleToLike implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reqData;

    public function __construct(object $reqData)
    {
        $this->reqData = $reqData;
    }

    private function searchAndRecord()
    {
        /*$articleToUser = ArticleToUser::where('id_article', $this->reqData->id_article)
            ->where('user_tredium_session', $this->reqData->user_tredium_session)
            ->get();
        if (count($articleToUser) === 0) {
            ArticleToUser::create([
                'id_article' => $this->reqData->id_article,
                'user_tredium_session' => $this->reqData->user_tredium_session
            ]);
        }
        Cache::forever('article_comments', ArticleToUser::all());*/
    }

    public function handle()
    {
        if ($this->reqData) {
            if ($this->reqData->id_article && $this->reqData->user_tredium_session) {
                $this->searchAndRecord();
            }
        }
    }
}
