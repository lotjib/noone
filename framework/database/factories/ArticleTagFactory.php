<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = $this->faker->unique()->word;
        return [
            'label' => $title,
            'url' => $this->faker->url,
            'orderz' => 0,
            'slug' => Str::slug($title),
        ];
    }
}
