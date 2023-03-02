@extends('layouts.default')

@section('main')
    <div class="container">
        <form action="/" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="file">
                <input type="file" id="file" name="image" />
            </label>
            
            <label for="title">
                画像タイトル
                <input type="text" placeholder="画像タイトル" id="title" name="title">
            </label>

            <textarea name="post_comment" id="" cols="30" rows="11" placeholder="投稿コメント"></textarea>
            <label for="tag">
                タグ名
                <input type="text" placeholder="タグ名" id="tag" name="tag">
            </label>
            <button>投稿する</button>
        </form>
    </div>
@endsection