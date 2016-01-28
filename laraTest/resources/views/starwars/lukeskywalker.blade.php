@extends('app')

@section('content')

    <div>
        @for($i=0; $i<7; ++$i)
            "Tie Fighter"&nbsp;
        @endfor
    </div>

    <div>
        @for($i=0; $i<5; ++$i)
            "X-Wing"&nbsp;
        @endfor
    </div>

    <h1>Luke Skywalker wins!</h1>

@endsection