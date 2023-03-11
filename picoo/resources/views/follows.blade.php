@extends('layouts.default')

@section('main')
<div class = "container">
    <div>
        @foreach ($follows as $follow)
        <a href="/user/{{$follow -> id}}">{{$follow -> name}}</a>
        @endforeach
    </div>
    {{ $follows->links('pagination::bootstrap-4') }}
</div>
@endsection