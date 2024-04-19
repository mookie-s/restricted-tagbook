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
</head>
<body>
    <main class="wrapper">
        <div class="note-tag">
            <select class="note-tag-select" name="tag-select">
                @foreach ($tags as $tag)
                <option value="tag-no">タグを選択　▼</option>
                <!-- <option value="tag-1">🔖信頼人脈力</option>
                <option value="tag-2">🔖オフライン活動</option>
                <option value="tag-3">🔖短編小説</option>
                <option value="tag-4">🔖挿絵力</option>
                <option value="tag-5">🔖IT系メモ</option>
                <option value="tag-5">タグなし</option> -->
                <option value="{{ $tag->id }}">{{ $tag->tagname }}</option>
                @endforeach
            </select>
        </div>
        @if (empty($tag->id == 5))
        <div>
            @csrf
            <form action="post">
                <input class="create-tag" type="text" name="tagname" placeholder="新しいタグ名">
                <input class="create-tag-button" type="submit" value="タグを作成">
                <p><small>※タグを追加する場合はノートの内容を作成する前にタグを作成してください。</small></p>
            </form>
        </div>
        @endif
        @csrf
        <form name="note-post" method="post" >
            <div class="note-image-up">
                <img class="camera-icon" src="{{ asset('/images/camera-icon.png') }}" alt="camera">
                <input class="file-input" type="file" accept=".jpg, .jpeg, .png, .gif, .pdf" name="upload-image" value="画像を選択"/>
            </div>
            <div>
                <img class="image-display" src="{{ asset('/images/no-image.png') }}" alt="no-image">
            </div>
                <input class="note-title" type="text" placeholder="タイトル（20文字以内）" />
            </div>
            <div class="note-detail">
                <textarea name="note-detail" rows="10" placeholder="内容（200文字以上～400文字以内）"></textarea>
            </div>
            <div class="note-buttons">
                <div>
                    <input class="note-submit-button" type="submit" value="完成">
                    <input class="note-break-button" type="submit" value="中断保存">
                </div>
                <div>
                    <a class="note-before-button" href="#">前のページへ戻る</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
