@extends('layouts.default')

@section('main')
    <div class="container">
        <div>
            <img src="../../{{$picture->file_path}}" alt="{{$picture->file_path}}">
        </div>

        <div class="post_comment">
            <p>{{$picture->post_comment}}</p>
        </div>

        <div>
            @foreach($tags as $tag)
                @if($picture->user->id === $login_user->id)
                    @if($picture->tag_count > 1)
                        <form action="/pictures/{{$picture->id}}/tag/{{$tag->id}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-delete">×</button>
                        </form>
                    @endif
                @endif
                <a href="/pictures?contents={{$tag->name}}">{{$tag->name}}</a>
                
            @endforeach
            <!-- ここは後で投稿者しか編集できないようにする -->
            @if($picture->user->id === $login_user->id)
                @if($picture->tag_count < 10)
                    <form action="/pictures/{{$picture->id}}/tag" method="post">
                        @csrf
                        <input type="text" placeholder="タグの追加" name="tags">
                        <input type="submit" value="追加">
                    </form>
                @endif
            @endif
        </div>

        <div>
            <a href="/user/{{$picture->user->id}}">{{$picture->user->name}}</a>
        </div>
    </div>
@endsection