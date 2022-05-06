@php
    use \Illuminate\Support\Facades\Cookie;
    $user = Cookie::get('tredium_session');

    /* Так нельзя делать, но без усилий фастом юзер */
    if (empty($user)) {
        echo '<script>parent.window.location.reload(true);</script>';
    }
@endphp
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('ceo_title')</title>
    <meta name="description" content="@yield('ceo_description')">
    <meta name="keywords" content="@yield('ceo_keywords')">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"
            integrity="sha512-odNmoc1XJy5x1TMVMdC7EMs3IVdItLPlCeL5vSUPN2llYKMJ2eByTTAIiiuqLg+GdNr9hF6z81p27DArRFKT7A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    @yield('styles')
</head>
<body class="d-flex flex-column">
<script>
    let user = '{{$user}}'
    let like = (id_art, element) => {
        let server = '{{url('/api')}}';
        let promise = new Promise((resolve, reject) => {
            let data = new FormData()
            data.append('id_article', id_art)
            data.append('user_tredium_session', user)
            axios.post(server + '/likeToArticle', data).then(res => {
                resolve(res.data)
            })
        })
        promise.then(res => {
            if (res.type === 'like') {
                element.children[0].classList.remove('fa-regular')
                element.children[0].classList.add('fa-solid')
            }
            if (res.type === 'unlike') {
                element.children[0].classList.remove('fa-solid')
                element.children[0].classList.add('fa-regular')
            }
        })
    }
</script>
<header>
    @include('includes.navbar')
</header>
<main class="mb-5">
    @yield('main')
</main>
<footer class="mt-auto">
    @include('includes.footer')
</footer>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')
</body>
</html>
