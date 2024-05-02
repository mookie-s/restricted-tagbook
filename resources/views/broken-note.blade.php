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
            <div class="preview-back">
                <div class="file">
                    <label class="file__label02">
                        @csrf
                        <input type="file" name="image" accept=".jpg, .jpeg, .png, .gif, .pdf" value="{{ old('image', $broken_note->image) }}">
                    </label>
                    <small class="file__none">イメージが選択されていません</small>
                </div>
            </div>
            <div>
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
                <input class="note-title" type="text" name="title" value="{{ old('title', $broken_note->title) }}" placeholder="タイトル（20文字以内）" />
            </div>
            <div class="note-story">
                <textarea name="story" rows="30" placeholder="内容（200文字以上～800文字以内）">{{ old('story', $broken_note->story) }}</textarea>
                <input type="hidden" name="break" value="{{ $broken_note->break }}">
            </div>
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
    </main>

    <script>
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
    </script>
</body>
</html>
