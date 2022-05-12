<?php

namespace App\Jobs;

use App\Models\ArticleComments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ArticleComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reqData;

    public function __construct(object $reqData)
    {
        $this->reqData = $reqData;
    }

    private function record()
    {
        /* СИМУЛЯЦИЯ ДОЛГОЙ ЗАПИСИ */
        /* sleep(600); */
        ArticleComments::create([
            'id_article' => $this->reqData->id_article,
            'user_tredium_session' => $this->reqData->user_tredium_session,
            'title' => $this->reqData->title,
            'body' => $this->reqData->body
        ]);
        Cache::forever('article_comments', ArticleComments::all());
    }

    public function handle()
    {
        if ($this->reqData) {
            if (
                $this->reqData->id_article &&
                $this->reqData->user_tredium_session &&
                $this->reqData->title &&
                $this->reqData->body
            ) {
                $this->record();
            }
        }
    }
}
