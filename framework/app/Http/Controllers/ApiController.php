<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleComment;
use App\Jobs\ArticleSee;
use App\Models\ArticleToLikeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ApiController extends Controller
{
    private $helper;

    public function __construct()
    {
        $this->helper = new Helper();
    }

    public function addArticleCounters(Request $request)
    {
        if ($request->id_article && $request->user_tredium_session) {
            $this->helper->addArticleCounters($request->id_article, $request->user_tredium_session);
        }
        return response()->json(['success' => 'success', 200]);
    }

    public function likeToArticle(Request $request)
    {
        $type = 'error';
        if ($request->id_article && $request->user_tredium_session) {
            if (
            $search = ArticleToLikeUser::where('id_article', $request->id_article)
                ->where('user_tredium_session', $request->user_tredium_session)
                ->first()
            ) {
                $search->delete();
                $type = 'unlike';
            } else {
                ArticleToLikeUser::create([
                    'id_article' => $request->id_article,
                    'user_tredium_session' => $request->user_tredium_session
                ]);
                $type = 'like';
            }
        }
        return response()->json(['success' => 'success', 'type' => $type], 200);
    }

    public function sendMsgToArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'id_article' => 'required',
            'user_tredium_session' => 'required'
        ]);
        ArticleComment::dispatch((object)[
            'user_tredium_session' => $request->user_tredium_session,
            'id_article' => $request->id_article,
            'body' => $request->body,
            'title' => $request->title,
        ]);
        return $request;
    }

}
