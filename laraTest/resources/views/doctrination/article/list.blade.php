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
        {!! Form::open(['url'=>'articles/filter']) !!}
        <table>
            <colgroup>
                <col width="5%">
                <col width="10%">
                <col width="60%">
                <col width="15%">
            </colgroup>

            <thead>
            <tr>
                <th>#</th>
                <th>{!! Form::label('title','Title:') !!}</th>
                <th>Body...</th>
                <th>Dates</th>
            </tr>
            <tr>
                <th></th>
                <th>
                    {!! Form::text('title',  (isset($filter['title']) ? $filter['title'] : '') , ['class'=>'form-control']) !!}
                </th>
                <th>
                    {!! Form::text('body',  (isset($filter['body']) ? $filter['body'] : '') , ['class'=>'form-control']) !!}
                </th>
                <th>
                    {!! Form::submit('Filter', ['class'=>'btn btn-primary form-control']) !!}
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($articles as $_article)
                <tr>
                    <td>
                        <a href="{{ action('Doctrination\ArticlesController@show', [$_article->getId()]) }}">{{ $_article->getId() }}</a>
                    </td>
                    <td>
                        <a href="{{ action('Doctrination\ArticlesController@show', [$_article->getId()]) }}">{{ $_article->getTitle() }}</a>
                    </td>
                    <td>{{ $_article->getBody() }}</td>
                    <td>
                        <div>
                            create: {{ $_article->getCreatedAt() ? $_article->getCreatedAt()->format('Y-m-d H:i:s') : '' }}
                        </div>
                        <div>
                            update: {{ $_article->getUpdatedAt() ? $_article->getUpdatedAt()->format('Y-m-d H:i:s') : '' }}
                        </div>
                        <div>
                            change: {{ $_article->getContentChangedAt() ? $_article->getContentChangedAt()->format('Y-m-d H:i:s') : '' }}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! Form::close() !!}
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
@endsection