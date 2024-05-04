<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ノート作成</title>
    <meta name="description" content="ノートを作る">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">

    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <main class="wrapper">
        <h2>ノートの作成</h2>
        <div class="note-message">
            <small class="promoted-message">※１タグにつき１日１投稿まで可能です</small>
        </div>
        @if($tags->count() == 0)
        <div>
            <a class="create-tag-button" href="/stack">最初のタグを登録する</a>
        </div>
        @else
        <form action="/note" method="post" enctype="multipart/form-data">
            <div class="preview-back">
                <div class="file">
                    <label class="file__label02">
                        @csrf
                        <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif, .pdf" value="{{ old('image') }}">
                    </label>
                    <small class="file__none">イメージが選択されていません</small>
                </div>
            </div>
            <div>
                <select class="note-tag-select" name="tag_id">
                    <option value="">▼ タグを選択</option>
                    @foreach($tags as $tag)
                        @foreach($unfinished_tag_ids as $unfinished_tag_id)
                            @if($unfinished_tag_id == $tag->id)
                                <option value="{{ $tag->id }}"
                                @if(old('tag_id') == $tag->id)
                                    selected
                                @endif
                                >🔖{{ $tag->tagname }}</option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
                @csrf
                <input class="note-title" type="text" name="title" value="{{ old('title') }}" placeholder="タイトル（20文字以内）" />
                @if(!empty($break_note))
                    <a class="broken-note-button" href="/broken-note">中断ノートを再開</a>
                @endif
            </div>
            <div class="note-story">
                <textarea name="story" rows="30" placeholder="内容（200文字以上～800文字以内）" onkeyup="ShowLength(value);">{{ old('story') }}</textarea>
            </div>
            <p id="input-length">0/800文字</p>
            <div class="note-buttons">
                <div>
                    <input class="note-submit-button" type="submit" value="完成">
                    @if(empty($break_note))
                    <input class="note-break-button" type="submit" name="to_break" value="中断保存"><small>＊中断ノート再開時、イメージは再選択となります。</small>
                    @endif
                </div>
                <div>
                    <a class="to-home-button" href="/home">ホームへ</a>
                </div>
            </div>
        </form>
        @endif
        <div class="bottom-blank"></div>
    </main>

    <script>
    // アップロード画像のプレビュー
    $(function () {
        $('.preview-back input[type=file]').on('change', function () {
            let elem = this;
            let fileReader = new FileReader();
            fileReader.readAsDataURL(elem.files[0]);
            fileReader.onload = function () {
                let imgUrl = fileReader.result;
                let fileNames = Array.from(elem.files).map(file => file.name);
                $(elem).closest(".preview-back").find(".file__label02").css("background-image", `url('${imgUrl}')`);
                $(elem).closest(".preview-back").find(".file__none").text(fileNames.join());
            };
        });
    });
    // textareaの文字数カウンター
    function ShowLength( str ) {
        document.getElementById("input-length").innerHTML = str.length + "/800文字";
    }
    </script>
</body>
</html>
