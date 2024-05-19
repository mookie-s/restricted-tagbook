<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ノート編集</title>
    <meta name="description" content="ノートの編集">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">

    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
    <main class="wrapper">
        <h2>ノートの編集</h2>
        @if($break_note)
            <div class="note-message">
                <div><small class="break-note-message">※中断保存しているノートがあるため「中断保存」ボタンは表示されません。</small></div>
            </div>
        @endif
        <form action="/update-searched-note" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="note_id" value="{{ $note->id }}">
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewFile(this);">
            <img class="note-image" id="preview" @if($note->image) src="{{ Storage::url($note->image) }}" alt="{{ old('title', $note->title) }}" @endif ></img>

            @if($errors->any())
                <div></div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($search_tag_id)
                <input type="hidden" name="search_tag_id" value="{{ $search_tag_id }}">
            @endif
            @if($search_year)
                <input type="hidden" name="search_year" value="{{ $search_year }}">
            @endif
            @if($search_month)
                <input type="hidden" name="search_month" value="{{ $search_month }}">
            @endif
            @if($search_keyword)
                <input type="hidden" name="search_keyword" value="{{ $search_keyword }}">
            @endif
            <div>
                <input type="hidden" name="tag_id" value="{{ $note->tag_id }}">
                タグ名：<input class="note-tag" type="text" name="tagname" value="🔖{{ $note->tag->tagname }}" disabled />
            </div>
            <div>
                タイトル：<input class="note-title" type="text" name="title" value="{{ old('title', $note->title) }}" placeholder="タイトル（20文字以内）" />
            </div>
            <div class="note-story">
                <textarea name="story" rows="30" placeholder="執筆内容（200文字以上～800文字以内）" onkeyup="ShowLength(value);">{{ old('story', $note->story) }}</textarea>
            </div>
            <div class="note-under-textarea">
                <p id="input-length">0/800文字</p>
                <a class="to-home-button" href="/search">ノート検索へ戻る</a>
            </div>
            <div class="note-buttons">
                <div>
                    <input class="note-submit-button" type="submit" value="更新">
                    @if(empty($break_note))
                        <input class="note-break-button" type="submit" name="to_break" value="中断保存">
                    @endif
                </div>
            </div>
        </form>
        <div class="bottom-blank"></div>
    </main>

    <script>
    // アップロード画像のプレビュー
    function previewFile(img){
        const fileData = new FileReader();
        fileData.onload = (function() {
        //id属性が付与されているimgタグのsrc属性に、fileReaderで取得した値の結果を入力することで
        //プレビュー表示している
        document.getElementById('preview').src = fileData.result;
        });
        fileData.readAsDataURL(img.files[0]);
    }
    // textareaの文字数をカウント（改行コード：LF、CR、CRLFをすべて2文字としてカウント）
    function countGrapheme( str ) {
        const str_step1 = str.replace(/\n/g, 'ああ');
        const str_step2 = str_step1.replace(/\r/g, 'いい');
        const str_all = str_step2.replace(/\r\n/g, 'うう');
        const segmenter = new Intl.Segmenter("ja", { granularity: "grapheme" });
        return [...segmenter.segment(str_all)].length;
    }
    function ShowLength(str) {
        document.getElementById("input-length").innerHTML = countGrapheme(str) + "/800文字";
    }
    </script>
</body>
</html>
