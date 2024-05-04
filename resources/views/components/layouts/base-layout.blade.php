<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $meta_description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">
</head>
<body>
    <header class="wrapper">
        <nav class="header-nav">
            <ul>
                <!-- TODO nav画像はログイン状態によってif分岐させる -->
                <li><a href="/register"><img class="account-icon" src="{{ asset('/images/logout.png') }}" alt="ログアウト中"></a></li>
                <li><h1><img class="app-logo" src="{{ asset('/images/app-logo.png') }}" alt="ロゴ"></h1></li>
                <li><a class="copyright" href="#">&copy; 2024<br> Mookie</a></li>
            </ul>
        </nav>
        <hr>
    </header>
    <main class="wrapper">
        {{ $slot }}
    </main>
    <div class="bottom-blank"></div>
    <footer class="wrapper">
        <nav class="footer-nav">
            <a href="/note"><img class="footer-pen" src="{{ asset('/images/pen-icon.png') }}" alt="ノート作成" /></a>
            <ul>
                <li><a href="/note"><img src="{{ asset('/images/pen-ellipse.png') }}" alt="ペンサークル" /></a></li>
                <li><a href="/search"><img src="{{ asset('/images/search-icon.png') }}" alt="ノート検索" /></a></li>
                <li><a href="/home"><img src="{{ asset('/images/home-icon.png') }}" alt="ホーム" /></a></li>
                <li><a href="/stack"><img src="{{ asset('/images/books-icon.png') }}" alt="積み上げ" /></a></li>
                <li><a href="/help"><img src="{{ asset('/images/help-icon.png') }}" alt="ヘルプ" /></a></li>
            </ul>
        </nav>
    </footer>
</body>
</html>
