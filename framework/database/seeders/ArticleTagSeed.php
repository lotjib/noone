<?php

namespace Database\Seeders;

use App\Models\ArticleTag;
use Illuminate\Database\Seeder;

class ArticleTagSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleTag::truncate();
        ArticleTag::factory()->count(10)->create();
    }
}
