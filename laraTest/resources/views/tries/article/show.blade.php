<?php

/** @var \App\Models\Tries\Article $article */
?>
@extends('app')

@section('content')
    @if($article)
        <div class="content">
            <h1>{{ $article->getTitle() }}</h1>

            <p>{{ $article->getBody() }}</p>
            {{--<h3>Tags:</h3>--}}
            {{--    <p> {{ $article-> }}</p>--}}
            <address>at: {{ $article->getCreatedAt() }}</address>
        </div>
    @else
        <div class="warning">
            <h1>Article not found</h1>
        </div>
    @endif
    <a href="{{ url('articles') }}">&leftarrow;&nbsp;back</a>
@stop