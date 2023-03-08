@extends('layouts.default')

@section('main')
    <div class="container">
        <div>
            <p>{{$search_tags}}での検索結果</p>
        </div>
        <div>
        @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}"><img src="{{$picture->file_path}}" alt=""></a>
        @endforeach
        </div>
        {{ $pictures->links('pagination::bootstrap-4') }}
    </div>
@endsection