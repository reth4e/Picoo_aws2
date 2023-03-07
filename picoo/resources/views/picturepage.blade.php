@extends('layouts.default')

@section('main')
    <div class="container">
        <div>
            <img src="../../{{$picture->file_path}}" alt="{{$picture->file_path}}">
        </div>
        <div>
            @foreach($tags as $tag)
                @if($picture->tag_count > 1)
                    <form action="/pictures/{{$picture->id}}/tag/{{$tag->id}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-delete">×</button>
                    </form>
                @endif
                <a href="/pictures?contents={{$tag->name}}">{{$tag->name}}</a>
                <!-- 3/7次回、ユーザーページ関連-->
                
            @endforeach
            <!-- ここは後で投稿者しか編集できないようにする -->
            @if($picture->tag_count < 10)
                <form action="/pictures/{{$picture->id}}/tag" method="post">
                    @csrf
                    <input type="text" placeholder="タグの追加" name="tag">
                    <input type="submit" value="追加">
                </form>
            @endif
        </div>
    </div>
@endsection