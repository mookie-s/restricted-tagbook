<x-layouts.base-layout>
    <x-slot:title>
        全ノート検索
    </x-slot:title>

    <x-slot:meta_description>
        すべてのノートから検索
    </x-slot:meta_description>

    <h2>ノート検索</h2>
    <form action="/search" method="post">
        @csrf
        <div class="search-tab">
            <div>
                <select class="search-key" name="tag_id">
                        <option value="">▼ タグを選択</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if($tag->id == $search_tag_id) selected @endif>🔖{{ $tag->tagname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="search-key" name="year">
                    <option value="">▼ 年指定</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" @if($year == $search_year) selected @endif>{{ $year }}年</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="search-key" name="month">
                    <option value="">▼ 月指定</option>
                    @foreach($months as $month)
                        <option value="{{ $month }}" @if($month == $search_month) selected @endif>{{ $month }}月</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="search-tab">
            <div>
                <input class="search-key" type="text" name="keyword" value="{{ $search_keyword }}" placeholder="キーワード" autofocus>
                <input class="search-button" type="submit" value="検索">
                <a href="/search">リセット</a>
            </div>
        </div>
    </form>
    @if($search_tag_id || $search_year || $search_month || $search_keyword)
        <p class="promoted-message">📝 検索 >@if($search_tag_id) 🔖{{ $search_tag->tagname }}@endif　@if($search_tag_id) @endif {{ $search_year }}@if($search_year)年@endif {{ $search_month }}@if($search_month)月@endif　@if($search_keyword)"{{ $search_keyword }} "@endif</p>
    @endif

    <!-- この$iはモーダルに各ノート内容を表示するために使用 -->
    <?php $i = 0; ?>
    @foreach($searched_notes as $searched_note)
    <?php $i++; ?>
    <div class="link-box">
        <div class="note-list">
            <div class="note-list-image">
                @if($searched_note->image)
                <img src="{{ Storage::url($searched_note->image) }}" alt="{{ $searched_note->title }}">
                @else
                <img src="{{ asset('/images/note-image-tag5.png') }}" alt="no-image">
                @endif
            </div>
            <div class="note-list-data">
                <div class="note-list-headline">
                    <div>{{ $searched_note->created_at->isoFormat('YYYY/MM/DD (ddd)') }}</div>
                    <div>🔖{{ $searched_note->tag->tagname }}</div>
                </div>
                <div class="note-list-title">
                    <div>「 {{ $searched_note->title }} 」</div>
                </div>
                <div class="note-list-detail">
                    <div>{{ Str::limit($searched_note->story, '100', '...')}}</div>
                </div>
                <button type="button" data-toggle="modal" data-target="#modal-screen<?= $i ?>" data-backdrop="true"></button>
            </div>
        </div>
    </div>

    <!-- ここからモーダル -->
    <div class="modal fade" id="modal-screen<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h4 class="modal-title" id="myModalLabel">削除確認画面</h4> -->
                    <p class="modal-title" id="myModalLabel">{{ $searched_note->created_at->isoFormat('YYYY/MM/DD(ddd)') }} 🔖{{ $searched_note->tag->tagname }}</p>
                </div>
                <div class="modal-body">
                    @if($searched_note->image)
                    <img src="{{ Storage::url($searched_note->image) }}" alt="{{ $searched_note->title }}">
                    @else
                    <!-- <img src="{{ asset('/images/note-image-tag5.png') }}" alt="no-image"> -->
                    @endif
                </div>
                <div class="modal-detail">
                    <h3 class="modal-title" id="myModalLabel">📝 {{ $searched_note->title }}</h3>
                    <p>{{ $searched_note->story }}</p>
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
    @if(!empty($searched_notes))
        {{ $searched_notes->appends(request()->query())->links() }}
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</x-layouts.base-layout>
