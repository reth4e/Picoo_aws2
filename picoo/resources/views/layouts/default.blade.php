<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picoo</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<body>
    <header class = "header">
        <p class="header-logo">Picoo</p>
        
        <form action="/pictures?contents={{$search_tags}}" method="get" class="header-form">
            <input class="search" type="text" name="contents" placeholder="タグ名検索"  />
            <input class="btn search-btn" type="submit" value="検索">
        </form>

        @if (auth()->user())
            <!-- ここにイメージ画像 ログイン時のみ表示 -->
            <a href="/user/{{auth()->user()->id}}">マイページ</a>

        
        
        
        @endif
        
        <div class="header-menu"  id="menu">
            <span class="menu_line-top"></span>
            <span class="menu_line-middle"></span>
            <span class="menu_line-bottom"></span>
        </div>

        <div class="dropdown" id = "dropdown">
            <!-- 以下はクリックで表示 -->
            <!-- ログイン時のみ表示 -->
            @if (auth()->user())
            <div>
                <button class="btn-notification btn" id="btn-notification">通知</button>

                @if ($notifications -> count() > 0)
                    <span>{{$notifications -> count()}}</span>
                @endif

                <div class="notifications" id="notifications">

                    @if ($notifications -> count() > 0)
                        <a href="/user/{{auth()->user()->id}}/notification">すべて既読にする</a>
                    @endif

                    @forelse ($notifications as $notification)
                        <p>{{$notification->data['message']}}</p>
                        <p>{{$notification->created_at}}</p>
                        <a href="/user/{{auth()->user()->id}}/notification/{{$notification -> id}}">既読にする</a>
                    @empty
                        <p>お知らせはありません</p>
                    @endforelse

                    {{ $notifications->links('pagination::bootstrap-4') }}
                </div>
                
            </div>
            <ul>
                <li class="header-link"><a href="/">画像投稿</a></li>
                <li class="header-link"><a href="/user/follows">フォローユーザー</a></li>
                <li class="header-link"><a href="/user/favorites">お気に入り画像</a></li>
                <li class="header-link"><a href="/popular">人気ユーザー・画像</a></li>
                <li class="header-link">
                    <form action="/logout" method="post" class="form-logout">
                    @csrf
                    <input class="btn btn-logout" type="submit" value="ログアウト">
                    </form>
                </li>
                
            </ul>
            <!-- 非ログイン時のみ表示 -->
            @else
            <ul>
                <li class="header-link"><a href="/register">新規登録</a></li>
                <li class="header-link"><a href="/login">ログイン</a></li>
            </ul>
            @endif
        </div>
    </header>

    <main>
        @yield('main')
    </main>

    <footer class = "footer">
        <small class="footer-logo">2023. Picoo</small>
    </footer>
</body>

</html>

<script>
    const target = document.getElementById("menu");
    target.addEventListener('click', () => {
        target.classList.toggle('open');
        const dropdown = document.getElementById("dropdown");
        dropdown.classList.toggle('appear');
    });

    const btn_notification = document.getElementById("btn-notification");
    btn_notification.addEventListener('click', () => {
        const notifications = document.getElementById("notifications");
        notifications.classList.toggle('appear');
    });
</script>

<style>

    .header-menu {
        display: inline-block;
        width: 36px;
        height: 32px;
        cursor: pointer;
        position: relative;
        left: 20px;
        top: 20px;
        margin-right: 5vw;
    }

    .menu_line-top,
    .menu_line-middle,
    .menu_line-bottom {
        display: inline-block;
        width: 100%;
        height: 4px;
        background-color: #000;
        position: absolute;
        transition: 0.5s;
    }

    .menu_line-top {
        top: 0;
    }

    .menu_line-middle {
        top: 14px;
    }

    .menu_line-bottom {
        bottom: 0;
    }

    .header-menu.open span:nth-of-type(1) {
        top: 14px;
        transform: rotate(45deg);
    }

    .header-menu.open span:nth-of-type(2) {
        opacity: 0;
    }

    .header-menu.open span:nth-of-type(3) {
        top: 14px;
        transform: rotate(-45deg);
    }

    .dropdown {
        display: none;
        width: 20vw;
        padding: 0;
        list-style-type: none;
        background-color: #eee;
    }

    .notifications {
        display: none;
    }

    .appear {
        display: block;
    }

</style>