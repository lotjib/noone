<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleSee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Helper extends Controller
{
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

    public function generateImgUrl($txt = 'Simple Text', $txtcolor = 'fff', $bgcolor = '09ff', $img_size = '1366x768', $img_ext = 'png')
    {
        return 'https://via.placeholder.com/' . $img_size . '.' . $img_ext . '/' . $bgcolor . '/' . $txtcolor . '?text=' . $txt;
    }
}
