<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>中断ノート再開</title>
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
        <h2>中断ノートの再開</h2>
        <form action="/broken-note" method="post" enctype="multipart/form-data">
            @csrf
            画像：<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewFile(this);">
            <!-- imageのパス指定方法が本番・検証環境と異なるので注意 -->
            <img class="note-image" id="preview" @if($broken_note->image) src="{{ Storage::url($broken_note->image) }}" alt="{{ old('title', $broken_note->title) }}" @endif />

            @if($errors->any())
                <div></div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>タグ名：
                <select class="note-tag-select" name="tag_id">
                    <option value="">▼ タグを選択</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                        @if($broken_note->tag_id == $tag->id)
                            selected
                        @endif
                        >🔖{{ $tag->tagname }}</option>
                    @endforeach
                </select>
                @csrf
                タイトル：<input class="note-title" type="text" name="title" value="{{ old('title', $broken_note->title) }}" placeholder="（20文字以内）" />
            </div>
            <div class="note-story">
                <textarea name="story" rows="30" placeholder="内容（200文字以上～800文字以内）" onkeyup="ShowLength(value);">{{ old('story', $broken_note->story) }}</textarea>
                <input type="hidden" name="break" value="{{ $broken_note->break }}">
            </div>
            <div class="note-under-textarea">
                <p id="input-length">0/800文字</p>
                <a class="to-home-button" href="/home">ホームへ</a>
            </div>
            <div class="note-buttons">
                <div>
                    <input class="note-submit-button" type="submit" value="投稿">
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
        let fileData = new FileReader();
        fileData.onload = (function() {
        //id属性が付与されているimgタグのsrc属性に、fileReaderで取得した値の結果を入力することで
        //プレビュー表示している
        document.getElementById('preview').src = fileData.result;
        });
        fileData.readAsDataURL(img.files[0]);
    }
    // textareaの文字数カウンター（改行コード：LF、CR、CRLFをすべて２文字としてカウント）
    function countGrapheme( str ) {
        let str_step1 = str.replace(/\n/g, 'ああ');
        let str_step2 = str_step1.replace(/\r/g, 'いい');
        let str_all = str_step2.replace(/\r\n/g, 'うう');
        const segmenter = new Intl.Segmenter("ja", { granularity: "grapheme" });
        return [...segmenter.segment(str_all)].length;
    }
    function ShowLength(str) {
        document.getElementById("input-length").innerHTML = countGrapheme(str) + "/800文字";
    }
    </script>
</body>
</html>
