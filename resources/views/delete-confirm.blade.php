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
                <hr>
                <div class="delete-note-list">
                    <form action="/move_note" method="post">
                    @foreach($notes as $note)
                        <div>
                            @csrf
                            <input type="checkbox" name="move-note[]" id="{{ $note->id }}" value="{{ $note->id }}" />
                            <label for="{{ $note->id }}">{{ $note->created_at->isoFormat('Y/MM/DD (ddd)') }}「 {{ $note->title }} 」</label>
                        </div>
                    @endforeach
                        <div>
                        <p class="move-note">チェックしたノートを
                            <select>
                            @foreach($other_tags as $other_tag)
                                <option name="move-tag" value="{{ $other_tag->id }}">🔖{{ $other_tag->tagname }}</option>
                            @endforeach
                            </select>
                            タグに<button type="submit">移動</button>
                        </p>
                        </div>
                    </form>
                    <div class="delete-message">
                        <small>※上記ノートの紐づけタグを変更する場合は、該当ノートにチェックを入れ、<br>「タグを削除」実行前に必ずノートの「移動」を行ってください。</small>
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
                </form>
            </div>
        </div>
    </main>
</body>
</html>
