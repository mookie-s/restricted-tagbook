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
                <small class="change-message">以下のタグ名と関連ノートの紐づけが変更されます。<br>すでに昇格化された同名ブック名とノートの紐づけは変更されません。</small>
                <div class="change-tagname">
                    <div>
                    @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    </div>
                    <p>変更前のタグ名： 🔖{{ $before_tag->tagname }}</p>
                    <p>変更前の略称：{{ $before_tag->abbreviation }}</p>
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
                <p>変更後のタグ名： 🔖{{ $after_tagname }}</p>
                <p>変更後の略称：{{ $after_abbreviation }}</p>
                <form id="form" action="/update" method="post">
                    @csrf
                    <input type="hidden" name="before_tag_id" value="{{ $before_tag->id }}">
                    <input type="hidden" name="before_tagname" value="{{ $before_tag->tagname }}">
                    <input type="hidden" name="after_tagname" value="{{ $after_tagname }}">
                    <input type="hidden" name="after_abbreviation" value="{{ $after_abbreviation }}">
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
