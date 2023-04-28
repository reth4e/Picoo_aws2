@extends('layouts.default')

@section('main')
<div class = "container">
    <div class="follow-users">
        @foreach ($follows as $follow)
        <div class="follow-user">
            <a href="/user/{{$follow -> id}}" class="follow-user-name">{{$follow -> name}}</a>
            <div class="follow-icon">
                <img src="../../{{$follow -> icon_path}}" alt="" class="follow-icon-img">
            </div>
            
            <div class="follow-user-pictures pictures jc-sb">
            @foreach ($follow -> pictures() -> orderBy('created_at','DESC') -> take(5) -> get() as $picture)
                <div class="follow-user-picture picture">
                    <a href="/pictures/{{$picture -> id}}">
                        <img src="../../{{$picture -> file_path}}" alt="" class="follow-user-picture-img img">
                    </a>
                </div>
            @endforeach
            </div>
            
        </div>
        @endforeach
    </div>
    {{ $follows->links('pagination::bootstrap-4') }}
</div>
@endsection