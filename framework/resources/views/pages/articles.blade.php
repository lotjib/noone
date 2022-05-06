@extends('layouts.app')
@include('includes.ceo_meta')

@section('main')
    <section class="bg-light-2 w-100">
        <div class="container">
            <h1 class="title-header-text">Каталог статей</h1>
        </div>
    </section>
    @if(isset($articles) && $articles)
        <section class="bg-white w-100">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <form method="get">
                            @foreach($articlesTags as $articlesTag)
                                <span class="badge bg-secondary">{{$articlesTag->label}}</span>
                            @endforeach
                        </form>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            @foreach($articles as $article)
                                <div class="col-12 py-2">
                                    <x-article-card :article="$article"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            {!! $articles->links() !!}
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
