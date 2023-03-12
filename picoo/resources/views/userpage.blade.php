@extends('layouts.default')

@section('main')
    <div class="container">
        <div>
            <div>
                <p>{{$user->name}}</p>
            </div>
            <img src = "../../{{$user -> icon_path}}" alt = "{{$user -> icon_path}}">
            @if ($login_user -> id === $user -> id)
            <div>
                <form action="/user/{{$user -> id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="file" name="image"  required accept="image/jpeg, image/png, .jpeg, .png"/>
                    <input type="hidden" name="_method" value="PUT">
                    <button>アイコン変更</button>
                </form>
            </div>
            @endif
            <div>
                <p>フォロー: {{$user -> follows -> count()}}</p>
                <p>フォロワー: {{$user -> followers -> count()}}</p>
            </div>
        </div>
        
        <div>
        @foreach($pictures as $picture)
            <a href="/pictures/{{$picture->id}}"><img src="../../{{$picture->file_path}}" alt=""></a>
            @if($login_user -> id === $user -> id)
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