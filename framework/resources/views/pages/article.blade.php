@extends('layouts.app')
@include('includes.ceo_meta')

@section('main')
    @if(isset($article) && $article)
        <section class="bg-light-2">
            <div class="container">
                <div class="row">
                    <nav class="bread divider my-auto" aria-label="breadcrumb">
                        <ol class="breadcrumb my-auto py-2">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Главная страница</a></li>
                            <li class="breadcrumb-item"><a href="{{route('articles')}}">Каталог статей</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>
        <section class="bg-white w-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 py-2">
                                <h1>{{ $article->title }}</h1>
                            </div>
                            <div class="col-12 py-2">
                                <x-counters-component :article="$article"/>
                            </div>
                            <div class="col-12 py-2">
                                @foreach($article->articlesTags as $articlesTag)
                                    <span class="badge bg-secondary">{{$articlesTag->label}}</span>
                                @endforeach
                            </div>
                            <div class="col-12 py-2">
                                {!! $article->body !!}
                            </div>
                            <x-article-form-msg-send :article="$article"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')

@endsection

@section('styles')

@endsection
