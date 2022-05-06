<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleToUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_article',
        'user_tredium_session'
    ];
}
