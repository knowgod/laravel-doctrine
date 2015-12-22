<?php

/** @var \App\Models\Tries\Article $article */
?>
@extends('app')

@section('content')
    @if($article)
        <div class="content">
            <h1>{{ $article->getId() }}. {{ $article->getTitle() }}</h1>

            <p>{{ $article->getBody() }}</p>
            {{--<h3>Tags:</h3>--}}
            {{--    <p> {{ $article-> }}</p>--}}
            <address>at: {{ $article->getCreatedAt() }}</address>

            <div class="action-container">
                <ul>
                    <li>
                        <a href="{{ url('articles/edit',['id' => $article->getId()]) }}">Edit</a>
                    </li>
                    <li>
                        <a href="{{ url('articles/delete',['id' => $article->getId()]) }}">Delete</a>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div class="warning">
            <h1>Article not found</h1>
        </div>
    @endif
    <a href="{{ url('articles') }}">&leftarrow;&nbsp;back</a>
@endsection