<?php

/** @var \App\Models\Tries\Article $article */
?>
@extends('app')

@section('content')
    @if($article)
        <div class="content">
            <h1>{{ $article->getId() }}. {{ $article->getTitle() }}</h1>

            <p>{{ $article->getBody() }}</p>

            @include('tries.tag.list')

            <address>
                <ul>
                    <li>create: {{ $article->getCreatedAt() ? $article->getCreatedAt()->format('Y-m-d H:i:s') : '' }}</li>
                    <li>update: {{ $article->getUpdatedAt() ? $article->getUpdatedAt()->format('Y-m-d H:i:s') : '' }}</li>
                    <li>change: {{ $article->getContentChangedAt() ? $article->getContentChangedAt()->format('Y-m-d H:i:s') : '' }}</li>
                </ul>
            </address>

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
    <a href="{{ url('articles') }}">&leftarrow;&nbsp;back to list</a>
@endsection