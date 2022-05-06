<div class="card h-100">
    <img
        src="{{ $article->image_src }}"
        class="card-img-top"
        alt="{{ $article->title }}"
    >
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $article->title }}</h5>
        @if($smallTextCount > 0)
            <p class="card-text">{{ substr($article->body, 0, 100).'...' }}</p>
        @else
            <p class="card-text">{{ $article->body }}</p>
        @endif
        <div class="mt-auto">
            <x-counters-component :article="$article"/>
            <a href="{{url('/articles/'.$article->slug)}}" class="btn btn-primary">
                Перейти
            </a>
        </div>
    </div>
</div>
