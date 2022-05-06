@php
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Facades\Cookie;
    $menu_items = collect();
    $menu_items->push((object)['title' => 'На главную', 'url' => route('index')]);
    $menu_items->push((object)['title' => 'Каталог статей', 'url' => route('articles')]);
    $user = Cookie::get('tredium_session');
    $path = url('/').'/'.Request::path();
    if (Request::path() === '/') {
        $path = url('/');
    }

@endphp
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{route('index')}}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @if(isset($menu_items) && $menu_items)
                    <li class="nav-item d-flex">
                        <span class="my-auto">User: {{$user}}</span>
                    </li>
                    @foreach($menu_items as $menu_item)
                        <li class="nav-item">
                            <a class="nav-link {{ $path === $menu_item->url ? 'active' : ''}}"
                               aria-current="{{ $path === $menu_item->url ? 'page' : ''}}"
                               href="{{$menu_item->url}}">{{$menu_item->title}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</nav>
