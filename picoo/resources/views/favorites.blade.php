@extends('layouts.default')

@section('main')
    <div class = "container">
        <div>
            @foreach ($favorites as $favorite)
            <a href="/pictures/{{$favorite -> id}}"><img src="../../{{$favorite -> file_path}}" alt=""></a>
            @endforeach
        </div>
        {{ $favorites->links('pagination::bootstrap-4') }}
    </div>
@endsection