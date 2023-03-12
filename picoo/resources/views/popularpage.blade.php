@extends('layouts.default')

@section('main')
    <div class = "container">
        <div>
            @foreach ($popular_pictures as $popular_picture)
            <a href="/pictures/{{$popular_picture -> id}}">
                <img src="../../{{$popular_picture -> file_path}}" alt="">
            </a>
            @endforeach
        </div>
        <div>
            @foreach ($popular_users as $popular_user)
            <a href="/user/{{$popular_user -> id}}">{{$popular_user -> name}}</a>
            @endforeach
        </div>
    </div>
@endsection