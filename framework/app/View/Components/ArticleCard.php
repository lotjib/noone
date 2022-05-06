<?php

namespace App\View\Components;

use Illuminate\View\Component;
use function Symfony\Component\Translation\t;

class ArticleCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $article;
    public $smallTextCount;

    public function __construct($smallTextCount = '0', $article)
    {
        $this->article = $article;
        $this->smallTextCount = $smallTextCount;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.article-card');
    }
}
