@extends('app')

@section('content')

    <h1>About Me: {!! $name !!}</h1>

    @if($first == 'ARk')
        <h2>Hi {{ $first }}</h2>
    @else
        <h2>Hello {{ $first }} {{ $last }}</h2>
    @endif

    <p>{{ $first }} {{ $last }}</p>

    @if (count($people))
        <h3>People:</h3>
        <ul>
            @foreach($people as $person)
                <li>{{ $person }}</li>
            @endforeach
        </ul>
    @endif

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad at et iusto magni sapiente similique, ullam veritatis.
    Ab accusamus amet animi fuga illum, ipsum modi molestiae reprehenderit unde voluptatum! Quibusdam!</p>
    <h3>Phones:</h3>
    <ol>
        <li>{{ $phone1 }}</li>
        <li>{{ $phone2 }}</li>
        <li>{{ $phone3 }}</li>
    </ol>

@stop