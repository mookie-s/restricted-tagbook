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
        @if(!empty($break_note))
            <div class="broken-note-button">
                <a href="/broken-note">中断ノートを再開</a>
            </div>
        @endif
        <div class="note-message">
            <div><small class="promoted-message">※１タグにつき１日１投稿までです。</small></div>
            <div><small class="promoted-message">※すでに本日ノートを投稿したタグや、中断保存分含めたノート数100件かつブック化していないタグは選択できません。</small></div>
        </div>
        @if($tags->count() == 0)
        <div>
            <a class="create-tag-button" href="/stack">最初のタグを登録する</a>
        </div>
        @else
        <form action="/note" method="post" enctype="multipart/form-data">
            @csrf
            画像：<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/gif" onchange="previewFile(this);">
            <img class="note-image" id="preview" src="{{ Storage::url(old('image')) }}" alt="{{ old('title') }}" />

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
                    @foreach($tags as $tag)
                        @foreach($selectable_tag_ids as $selectable_tag_id)
                            @if($selectable_tag_id == $tag->id)
                                <option value="{{ $tag->id }}"
                                @if(old('tag_id') == $tag->id)
                                    selected
                                @endif
                                >🔖{{ $tag->tagname }}</option>
                            @endif
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div>
                @csrf
                タイトル：<input class="note-title" type="text" name="title" value="{{ old('title') }}" placeholder="（20文字以内）" />
            </div>
            <div class="note-story">
                <textarea name="story" rows="30" placeholder="内容（200文字以上～800文字以内）" onkeyup="ShowLength(value);">{{ old('story') }}</textarea>
            </div>
            <div class="note-under-textarea">
                <p id="input-length">0/800文字</p>
                <a class="to-home-button" href="/home">ホームへ</a>
            </div>
            <div class="note-buttons">
                <div>
                    <input class="note-submit-button" type="submit" value="投稿">
                    @if(empty($break_note))
                    <input class="note-break-button" type="submit" name="to_break" value="中断保存"><small>＊中断ノート再開時、イメージは再選択となります。</small>
                    @endif
                </div>
            </div>
        </form>
        @endif
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
    // textareaの文字数をカウント（改行コード：LF、CR、CRLFを0文字としてカウント）
    function countGrapheme( str ) {
        let str_step1 = str.replace(/\n/g, '');
        let str_step2 = str_step1.replace(/\r/g, '');
        let str_all = str_step2.replace(/\r\n/g, '');
        const segmenter = new Intl.Segmenter("ja", { granularity: "grapheme" });
        return [...segmenter.segment(str_all)].length;
    }
    function ShowLength(str) {
        document.getElementById("input-length").innerHTML = countGrapheme(str) + "/800文字";
    }
    </script>
</body>
</html>
