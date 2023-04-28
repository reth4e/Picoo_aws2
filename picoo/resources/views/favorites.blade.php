@extends('layouts.default')

@section('main')
    <div class = "container">
        <div class="favorite-title">
            <p>お気に入り画像</p>
        </div>
        <div class="pictures favorite-pictures">
            @foreach ($favorites as $favorite)
            <a href="/pictures/{{$favorite -> id}}">
                <div class="favorite-picture-card card">
                    <div class="favorite-picture picture">
                        <img src="https://picoo-s3.s3.ap-northeast-1.amazonaws.com/pictures/{{$favorite -> file_name}}" alt="" class="favorite-picture-img img">
                    </div>
                    <div>
                        <p>{{$favorite->title}}</p>
                    </div>
                    <div>
                        <a href="/user/{{$favorite -> user -> id}}">{{$favorite -> user -> name}}</a>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        {{ $favorites->links('pagination::bootstrap-4') }}
    </div>
@endsection
