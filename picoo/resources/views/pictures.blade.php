@extends('layouts.default')

@section('main')
    <div class="container">
        <p class="search-result">{{$search_tags}} での検索結果</p>
        <div class="searched-pictures pictures">
            @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}">
                <div class="searched-picture-card card">
                    <div class="searched-picture picture">
                        <img src="{{$picture->file_path}}" alt="" class="searched-picture-img img"/>
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