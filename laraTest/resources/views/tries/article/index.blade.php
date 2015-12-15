@extends('app')

@section('content')
    <h1>Contacts</h1>
    <ul>
        @foreach($articles as $_article)
            <li style="border: 1px #4cae4c solid;margin: 5px;">
                <h3>
                    <a href="{{ action('Tries\ArticlesController@show', [$_article->getId()]) }}">{{ $_article->getTitle() }}</a>
                </h3>

                <p>{{ $_article->getBody() }}</p>
            </li>
        @endforeach
    </ul>
@stop