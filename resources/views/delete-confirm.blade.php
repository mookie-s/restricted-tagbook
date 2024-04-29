<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タグの削除</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">

    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
</head>
<body>
    <main class="wrapper">
        <div class="delete-confirm">
            <div>
                <h2>タグの削除</h2>
                <div class="delete-tagname">
                    <small class="delete-message">以下のタグと関連ノートが削除されます。</small>
                    <p>タグ名： 🔖{{ $delete_tag->tagname }}</p>
                    <p>略称： {{ $delete_tag->abbreviation }}</p>
                    <p>ノート数： {{ $notes->count() }}（下記）</p>
                </div>
                <div class="delete-note-list">
                    <form action="/export-csv" method="get">
                        @csrf
                        <input type="hidden" name="delete_tag_id" value="{{ $delete_tag->id }}">
                    @foreach($notes as $note)
                        <ul>
                            <li>> {{ $note->created_at->isoFormat('Y/MM/DD (ddd)') }}「 {{ $note->title }} 」</li>
                        </ul>
                        <hr>
                    @endforeach
                        <div>
                        <p class="move-note">上記ノートのデータを<input type="submit" value="ダウンロード"></p>
                        </div>
                    </form>
                    <div class="delete-message">
                        <p><small>※画像データはダウンロードできません。</small></p>
                        <p><small>※ダウンロードしたファイルは、メモ帳などの簡易テキストアプリで開くことをおすすめします。</small></p>
                        <p><small>※ダウンロードする場合は、次の「タグを削除」実行前に必ず行ってください。</small></p>
                    </div>
                </div>
                <hr>
                <form action="/destroy" method="post">
                    @csrf
                    <input type="hidden" name="delete_tag" value="{{ $delete_tag->id }}">
                    <div class="confirm-buttons">
                        <input class="delete-submit-button" type="submit" value="！タグを削除">
                        <a class="cancel-button" href="/stack">キャンセル</a>
                    </div>
                    <p><small class="delete-message">※タグ削除後も、ノート検索ページでは検索可能です。</small></p>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
