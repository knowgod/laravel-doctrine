@extends('app')

@section('content')
    <h1>Articles</h1>
    <div class="action-container">
        <ul>
            <li>
                <a href="{{ url('articles/create') }}">create new</a>
            </li>
        </ul>
    </div>

    <div class="list-container">
        <ul>
            @foreach($articles as $_article)
                <li style="border: 1px #4cae4c solid;margin: 5px;">
                    <h3>
                        <span>{{ $_article->getId() }}.</span>
                        <a href="{{ action('Tries\ArticlesController@show', [$_article->getId()]) }}">{{ $_article->getTitle() }}</a>
                    </h3>

                    <p>{{ $_article->getBody() }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <table>
        <tr>
            <td>pages:&nbsp;</td>
            <td>
                @if($articles->currentPage() > 1)
                    <a href="{{ $articles->previousPageUrl() }}">&lt;&lt;</a>
                @else
                    <span>&nbsp;&nbsp;&nbsp;</span>
                @endif
            </td>
            <td>&nbsp;&nbsp;<strong>{{ $articles->currentPage() }}</strong>&nbsp;&nbsp;</td>
            <td>
                @if($articles->currentPage() < $articles->lastPage())
                    <a href="{{ $articles->nextPageUrl() }}">&gt;&gt;</a>
                @endif
            </td>
        </tr>
    </table>
@stop