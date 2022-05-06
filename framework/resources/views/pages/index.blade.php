@extends('layouts.app')
@include('includes.ceo_meta')

@section('main')
    <section class="bg-light-2 w-100">
        <div class="container">
            <h1 class="title-header-text">Успех</h1>
            <p class="title-header-text-under small pb-5">Для молодых и успешных</p>
        </div>
    </section>
    @if(isset($articles) && $articles)
        <section class="bg-white w-100">
            <div class="container">
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-12 col-md-4 py-2">
                            <x-article-card smallTextCount="100" :article="$article"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('scripts')

@endsection

@section('styles')

@endsection
