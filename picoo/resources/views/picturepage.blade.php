@extends('layouts.default')

@section('main')
    <div class = "container">
        <div>
            <img src = "../../{{$picture -> file_path}}" alt = "{{$picture->file_path}}">
        </div>

        <div>
            @if ($picture -> usersWhoLike() -> where('user_id', Auth::id()) -> exists())
                <a href="/pictures/{{$picture -> id}}/delete_like">いいね</a>
            @else
                <a href="/pictures/{{$picture -> id}}/add_like">いいね</a>
            @endif
            <p>{{$picture->usersWhoLike->count()}}</p>
        </div>

        <div>
            @if($picture -> user -> id === $login_user -> id)
                <form action = "/pictures/{{$picture -> id}}/title" method = "post">
                    @csrf
                    <input type = "text" name = "title" value = "{{$picture -> title}}" placeholder = "タイトル編集">
                    <input type = "hidden" name = "_method" value = "PUT">
                    <input type = "submit" value = "更新">
                </form>
            @else
                <p>{{$picture->title}}</p>
            @endif
        </div>

        <div class = "post_comment">
            @if($picture->user->id === $login_user->id)
                <form action = "/pictures/{{$picture -> id}}/post_comment" method = "post">
                    @csrf
                    <input type = "text" name = "post_comment" value = "{{$picture -> post_comment}}" placeholder = "投稿者コメント編集">
                    <input type = "hidden" name = "_method" value = "PUT">
                    <input type = "submit" value = "更新">
                </form>
            @else
                <p>{{$picture->post_comment}}</p>
            @endif
        </div>

        <div>
            @foreach($tags as $tag)
                @if($picture->user->id === $login_user->id)
                    @if($picture->tag_count > 1)
                        <form action = "/pictures/{{$picture -> id}}/tag/{{$tag -> id}}" method = "post">
                            @csrf
                            <input type = "hidden" name = "_method" value = "DELETE">
                            <button class = "btn btn-delete">×</button>
                        </form>
                    @endif
                @endif
                <a href = "/pictures?contents={{$tag -> name}}">{{$tag -> name}}</a>
                
            @endforeach
            <!-- ここは後で投稿者しか編集できないようにする -->
            @if($picture->user->id === $login_user->id)
                @if($picture->tag_count < 10)
                    <form action = "/pictures/{{$picture -> id}}/tag" method = "post">
                        @csrf
                        <input type = "text" placeholder = "タグの追加" name = "tags">
                        <input type = "submit" value = "追加">
                    </form>
                @endif
            @endif
        </div>

        <div>
            <a href = "/user/{{$picture -> user -> id}}">{{$picture->user->name}}</a>
            
        </div>

        <div>
            <form action = "/pictures/{{$picture -> id}}/comment" method = "post">
                @csrf
                <input type = "text" placeholder = "コメント追加" name = "comment">
                <input type = "submit" value = "追加">
            </form>
        </div>

        <div>
            @foreach ($comments as $comment)
                <a href = "/user/{{$comment -> user -> id}}">{{$comment -> user -> name}}</a>
                @if ($picture -> user -> id === $login_user -> id)
                    <form action="/pictures/{{$picture -> id}}/comment/{{$comment -> id}}" method = "post">
                        @csrf
                        <input type = "hidden" name = "_method" value = "PUT">
                        <input type = "text" value = "{{$comment -> content}}" name = "content">
                        <input type = "submit" value = "編集">
                    </form>
                    <form action = "/pictures/{{$picture -> id}}/comment/{{$comment -> id}}" method = "post">
                        @csrf
                        <input type = "hidden" name = "_method" value = "DELETE">
                        <button class = "btn btn-delete">×</button>
                    </form>
                @else
                    <p>{{$comment -> content}}</p>
                @endif
                <p>{{$comment -> updated_at}}</p>
            @endforeach
        </div>
        {{ $comments -> links('pagination::bootstrap-4') }}
    </div>
@endsection