@extends('layouts.default')

@section('main')
    <div class="container">
        <div class="notifications">
            @if ($notifications -> count() > 0)
                <a href="/user/readall" style="display: block; color: red;" class="mg-b-10">すべて既読にする</a>
            @endif
            @forelse ($notifications as $notification)
            <div class="notification mg-b-10">
                <a>{{$notification->data['message']}}</a>
                <p>{{$notification->created_at}}</p>
                <a href="/user/read/{{$notification -> id}}">既読にする</a>
            </div>
            @empty
                <p>お知らせはありません</p>
            @endforelse
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection