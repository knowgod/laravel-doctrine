@extends('app')

@section('content')
    <h1>{{ $contact->title }}</h1>

    <p>{{ $contact->body }}</p>
    <a href="{{ url('contacts') }}">Back to Index</a>
@stop