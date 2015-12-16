<?php

/** @var \App\Models\Tries\Article $article */
?>
@extends('app')

@section('content')
    <div class="content">
        <h1>Write a New Article</h1>
        <hr/>

        {!! Form::open(['url'=>'articles']) !!}

        <div class="form-group">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', null,['class'=>'form-control','foo'=>'bar']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('body','Body:') !!}
            {!! Form::textarea('body', null,['class'=>'form-control','foo'=>'bar']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Add Article', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}


    </div>
@stop