<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タグ名の変更</title>
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
        <div class="change-confirm">
            <div>
                <h2>タグ名の変更</h2>
                <small class="change-message">以下のタグ名と関連ノートの紐づけが変更されます。</small>
                @if($errors->any())
                    <div></div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="change-tagname">
                    <p>タグ名： 🔖{{ $change_tag->tagname }}</p>
                    <p>略称：{{ $change_tag->abbreviation }}</p>
                    <p>ノート数： {{ $notes->count() }}</p>
                </div>
                @if($notes->count() != 0)
                <div class="change-note-list">
                    @foreach($notes as $note)
                    <ul>
                        <li>📝 {{ $note->created_at->isoFormat('Y/MM/DD (ddd)') }}「 {{ $note->title }} 」</li>
                    </ul>
                    @endforeach
                    <hr>
                </div>
                @endif
                <!-- <hr> -->
                <p>現在のタグ名： 🔖{{ $change_tag->tagname }}</p>
                    <p>現在の略称：{{ $change_tag->abbreviation }}</p>
                    <p>　↓↓</p>
                <form action="/update" method="post">
                    @csrf
                    <input type="hidden" name="current_tag_id" value="{{ $change_tag->id }}">
                    <input type="hidden" name="current_tagname" value="{{ $change_tag->tagname }}">
                    <p>新しいタグ名：🔖<input class="change-tag" type="text" name="tagname" placeholder="10文字以内" value="{{ old('tagname') }}"></p>
                    <p>新しい略称：<input class="change-tag-abbreviation" type="text" name="abbreviation" placeholder="4文字以内" value="{{ old('abbreviation') }}"></p>
                    <small class="change-message">タグ名変更にともない、関連ノートも新しいタグに紐づけ変更されます。<br>ブック化されているブック名と昇格済みノートの紐づけは変更されません。</small>
                    <div class="change-confirm-buttons">
                        <input class="change-submit-button" type="submit" value="！タグ名を変更">
                        <a class="cancel-button" href="/stack">キャンセル</a>
                    </div>
                    <!-- <p class="change-message">
                        <small >※タグ削除後も、検索ページでのノート検索は可能です。</small>
                    </p> -->
                </form>
            </div>
        </div>
    </main>
</body>
</html>
