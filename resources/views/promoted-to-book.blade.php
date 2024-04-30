<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックへの昇格</title>
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
        <div class="promoted-to-book">
            <div>
                <h2>ブックへの昇格</h2>
                <div class="promoted-tagname">
                    <p><small class="promoted-message">「 {{ $tag->abbreviation }} 」100日達成おめでとうございます！</small></P>
                    <p><small class="promoted-message">これからも活動を継続させてどんどん突き抜けていきましょう！</small></P>
                    <p>タグ名： 🔖{{ $tag->tagname }}</p>
                    <p>略称： {{ $tag->abbreviation }}</p>
                    <p>ノート数： {{ $notes->count() }}</p>
                </div>
                @if($notes->count() != 0)
                    <div class="promoted-note-list">
                    @foreach($notes as $note)
                        <ul>
                            <li>📝 {{ $note->created_at->isoFormat('Y/MM/DD (ddd)') }}「 {{ $note->title }} 」</li>
                        </ul>
                    @endforeach
                    <hr>
                    </div>
                    @endif
                <form action="/store-book" method="post">
                    <div>
                        @if($same_cover_book)
                            <p>上記のノートが、<br>同名ブック「📘{{ $same_cover_book->cover }}」へ昇格されます。</p>
                        @else
                            <p>上記のノートが、<br>新規ブック「📘{{ $tag->tagname }}」へ昇格されます。</p>
                        @endif
                    </div>
                    <p class="promoted-message"><small>※同名ブックがすでに存在するにもかかわらず "新規ブック" が表示される場合は、<br>タグ名が正しくない恐れがあります。その際は下記のキャンセルボタンから<br>ページを戻り、正しいタグ名に修正してから再度ブック化してください。</small></p>
                    <div class="confirm-buttons">
                        @csrf
                        <input type="hidden" name="same_cover_book_id" value="{{ $same_cover_book->id ?? '' }}">
                        <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                        <input type="hidden" name="tagname" value="{{ $tag->tagname }}">
                        <input class="promoted-submit-button" type="submit" value="ブックへ昇格">
                        <a class="promoted-cancel-button" href="/stack">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
