<?php

/** @var \App\Doctrination\Entities\Article $article */
?>
@extends('app')

@section('content')
    <div class="content">
        @if(isset($article))
            <h1>Edit Article #{{ $article->getId() }}</h1>
        @else
            <h1>Write a New Article</h1>
        @endif
        <hr/>

        {!! Form::open(['url'=>'articles']) !!}

        @if(isset($article))
            <div class="form-group">
                {!! Form::hidden('id', $article->getId()) !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', $article ? $article->getTitle() : null,['class'=>'form-control','foo'=>'bar']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('body','Body:') !!}
            {!! Form::textarea('body', $article ? $article->getBody() : null,['class'=>'form-control','foo'=>'bar']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit($article ? 'Save Article' : 'Add Article', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

        <a href="{{ url('articles') }}">&leftarrow; Back to List</a>

    </div>
@endsection