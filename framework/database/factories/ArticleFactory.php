<?php

namespace Database\Factories;

use App\Http\Controllers\Helper;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Article::class;

    public function definition()
    {
        $helper = new Helper();
        $title = $this->faker->unique()->words(3, true);

        return [
            'title' => $title,
            'image_src' => $helper->generateImgUrl(Str::random(10), Str::random(3), Str::random(3)),
            'body' => $this->faker->paragraph(),
            'slug' => Str::slug($title)
        ];
    }
}
