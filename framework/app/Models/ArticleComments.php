<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComments extends Model
{
    use HasFactory;

    protected $table = 'article_comments';

    protected $fillable = [
        'title',
        'body',
        'id_article',
        'user_tredium_session'
    ];
}
