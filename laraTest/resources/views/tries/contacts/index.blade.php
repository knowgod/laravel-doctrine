@extends('app')

@section('content')
    <h1>Contacts</h1>
    <ul>
        @foreach($contacts as $_contact)
            <li>
                <h3><a href="{{ action('Tries\ContactsController@show', [$_contact->id]) }}">{{ $_contact->title }}</a></h3>

                <p>{{ $_contact->body }}</p>
            </li>
        @endforeach
    </ul>
@stop