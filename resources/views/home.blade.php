<x-layouts.base-layout>
    <x-slot:title>
        ホーム
    </x-slot:title>

    <x-slot:meta_description>
        ホーム
    </x-slot:meta_description>

    <h2>ノート最新100</h2>
    <div class="tags-tab">
        <ul>
            |<li><a href="/home">すべて</a></li>|
            @foreach($tags as $tag)
            <li><a href="/home/{{ $tag->id }}">🔖{{ $tag->abbreviation }}</a></li>|
            @endforeach
        </ul>
    </div>
    <div class="mastered-tags-tab">
        <ul>|
            @foreach($mastered_tags as $mastered_tag)
            <li><a href="/home/{{ $mastered_tag->id }}">🔖{{ $mastered_tag->abbreviation }}</a></li>|
            @endforeach
        </ul>
    </div>
    <p class="promoted-message">📝{{ $get_tag->tagname ?? 'すべて' }}</p>
    @if($tags->count() == 0)
        <div>
            <a class="create-tag-button" href="/stack">最初のタグを登録する</a>
        </div>
    @elseif($tags->count() != 0 && $notes->count() == 0)
        <div>
            <a class="first-note-button" href="/note">最初のノートを書く</a>
        </div>
    @endif

    <!-- この$iはモーダルに各ノート内容を表示するために使用 -->
    <?php $i = 0; ?>
    @foreach($notes as $note)
    <?php $i++; ?>
    <div class="link-box">
        <div class="note-list">
            <div class="note-list-image">
                @if($note->image)
                <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}">
                @else
                <img src="{{ asset('/images/note-image-tag5.png') }}" alt="no-image">
                @endif
            </div>
            <div class="note-list-data">
                <div class="note-list-headline">
                    <div>{{ $note->created_at->isoFormat('YYYY/MM/DD(ddd)') }}</div>
                    <div>🔖{{ $note->tag->tagname }}</div>
                </div>
                <div class="note-list-title">
                    <p>「 {{ $note->title }} 」</p>
                </div>
                <div class="note-list-detail">
                    <p>{{ Str::limit($note->story, '100', '...')}}</p>
                </div>
            </div>
            <button type="button" data-toggle="modal" data-target="#modal-screen<?= $i ?>" data-backdrop="true"></button>
        </div>
    </div>

    <!-- ここからモーダル -->
    <div class="modal fade" id="modal-screen<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4 class="modal-title" id="myModalLabel">削除確認画面</h4> -->
                    <p class="modal-title" id="myModalLabel">{{ $note->created_at->isoFormat('YYYY/MM/DD(ddd)') }}🔖{{ $note->tag->tagname }}</p>
                </div>
                <div class="modal-body">
                    @if($note->image)
                    <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}">
                    @else
                    <!-- <img src="{{ asset('/images/note-image-tag5.png') }}" alt="no-image"> -->
                    @endif
                </div>
                <div class="modal-detail">
                    <h3 class="modal-title" id="myModalLabel">📝 {{ $note->title }}</h3>
                    <p>{{ $note->story }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <!-- <button type="button" class="btn btn-danger">削除</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- ここまでモーダル -->
    @endforeach

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</x-layouts.base-layout>
