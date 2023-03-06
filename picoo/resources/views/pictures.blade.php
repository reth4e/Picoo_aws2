@extends('layouts.default')

@section('main')
    <div class="container">
        @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}"><img src="{{$picture->file_path}}" alt=""></a>
        @endforeach
    </div>
@endsection