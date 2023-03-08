@extends('layouts.default')

@section('main')
    <div class="container">
        <div>
            <p>{{$user->name}}</p>
        <!-- ここにフォロー・フォロワー数 -->
        </div>
        <div>
        @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}"><img src="../../{{$picture->file_path}}" alt=""></a>
            @if($user->id === $login_user->id)
                <form action="/user/{{$picture->user->id}}/picture/{{$picture->id}}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="btn btn-delete">×</button>
                </form>
            @endif
        @endforeach
        </div>
        {{ $pictures->links('pagination::bootstrap-4') }}

    </div>
@endsection