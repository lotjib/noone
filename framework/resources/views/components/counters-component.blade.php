<div class="d-flex mb-2">
    <span class="see_card me-auto">
        <i class="fa-solid fa-eye"></i>
        <span class="ms-1">{{ $article->see_counter }}</span>
    </span>
    <span class="like_card ms-auto">
        <button class="btn btn-link text-dark" onclick="like({{$article->id}}, this)">
            @if($article->like)
                <i class="fa-solid fa-heart"></i>
            @else
                <i class="fa-regular fa-heart"></i>
            @endif
        </button>
    </span>
</div>
