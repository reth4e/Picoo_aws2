@extends('layouts.default')

@section('main')
    <div class="container">
        <p class="search-result">{{$search_tags}} での検索結果</p>
        <div class="searched-pictures">
            @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}">
                <div class="searched-picture-card">
                    <div class="searched-picture">
                        <img src="{{$picture->file_path}}" alt="" class="searched-picture-img"/>
                    </div>
                    <div>
                        <p>{{$picture->title}}</p>
                    </div>
                    <div>
                        <a href="/user/{{$picture -> user -> id}}">{{$picture -> user -> name}}</a>
                    </div>
                </div>
            </a>
            @endforeach
        
        </div>
        {{ $pictures->links('pagination::bootstrap-4') }}
    </div>
@endsection