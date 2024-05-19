<x-layouts.base-layout>
    <x-slot:title>
        全ノート検索
    </x-slot:title>

    <x-slot:meta_description>
        すべてのノートから検索
    </x-slot:meta_description>

    <h2>全ノート検索</h2>
    @if(session('update_note_message'))
        <small><div class="alert alert-primary mx-auto">！{{session('update_note_message')}}</div></small>
    @endif
    @if(session('break_note_message'))
        <small><div class="alert alert-light mx-auto">！{{session('break_note_message')}}</div></small>
    @endif
    <form action="/search" method="get">
        <!-- @csrf -->
        <div class="search-tab">
            <div>
                <select class="search-key" name="tag_id">
                        <option value="">▼ タグを選択</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            @if($tag->id == session('search_tag_id'))
                                selected
                            @elseif($tag->id == $search_tag_id)
                                selected
                            @endif
                        >🔖{{ $tag->tagname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="search-key" name="year">
                    <option value="">▼ 年指定</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}"
                            @if($year == session('search_year'))
                                selected
                            @elseif($year == $search_year)
                                selected
                            @endif
                        >{{ $year }}年</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="search-key" name="month">
                    <option value="">▼ 月指定</option>
                    @foreach($months as $month)
                        <option value="{{ $month }}"
                            @if($month == session('search_month'))
                                selected
                            @elseif($month == $search_month)
                                selected
                            @endif
                        >{{ $month }}月</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="search-tab">
            <div>
                <input class="search-key" type="text" name="keyword"
                @if(session('search_keyword'))
                    value="{{ session('search_keyword') }}"
                @else
                    value="{{ $search_keyword }}"
                @endif
                placeholder="キーワード" autofocus>
                <input id="submit-button" class="search-button" type="submit" value="検索">
                <a href="/search">リセット</a>
            </div>
        </div>
    </form>
    @if($search_tag_id || $search_year || $search_month || $search_keyword)
        <p class="promoted-message">📝 検索 >@if($search_tag_id) 🔖{{ $search_tag->tagname }},@endif @if($search_tag_id) @endif {{ $search_year }}@if($search_year)年,@endif {{ $search_month }}@if($search_month)月,@endif @if($search_keyword)"{{ $search_keyword }} "@endif</p>
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
                    <div class="modal-title" id="myModalLabel">🔖{{ $searched_note->tag->tagname }}</div>
                </div>
                <div class="modal-body">
                    @if($searched_note->image)
                    <img src="{{ Storage::url($searched_note->image) }}" alt="{{ $searched_note->title }}">
                    @else
                    <!-- <img src="{{ asset('/images/note-image-tag5.png') }}" alt="no-image"> -->
                    @endif
                </div>
                <div class="modal-note-data">📝{{ $searched_note->created_at->isoFormat('YYYY/MM/DD(ddd)') }}
                    @if($searched_note->created_at != $searched_note->updated_at)
                        🔄️{{ $searched_note->updated_at->isoFormat('YYYY/MM/DD(ddd)') }}
                    @endif
                </div>
                <div class="modal-detail">
                    <h3 class="modal-title" id="myModalLabel">「 {{ $searched_note->title }} 」</h3>
                    <p>{{ $searched_note->story }}</p>
                </div>
                <div class="modal-footer">
                    <form action="/edit-searched-note" method="post" style="margin-right: 30px;">
                        @csrf
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
                        <input type="hidden" name="note_id" value="{{ $searched_note->id }}">
                        @if($searched_note->image)
                            <input type="hidden" name="image" value="{{ $searched_note->image }}">
                        @endif
                        <input type="hidden" name="title" value="{{ $searched_note->title }}">
                        <input type="hidden" name="story" value="{{ $searched_note->story }}">
                        <button type="submit" class="btn btn-default">編集</button>
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    <!-- <button type="button" class="btn btn-danger">削除</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- ここまでモーダル -->
    @endforeach
    @if(!empty($searched_notes))
        {{ $searched_notes->appends(request()->query())->links('vendor.pagination.custom-simple') }}
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- <script>
        // searchページのノート編集後リダイレクト時に、
        // 直前の検索条件で検索ボタンを押した状態の結果にするため、
        // searchページ描画後に自動的に検索ボタンを１回だけクリックする設定
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('autoSubmit'))
                document.getElementById('submit-button').click();
            @endif

            @if (session('update_note_message'))
                setTimeout(() => {
                    document.getElementById('flash-message').style.display = 'block';
                }, 1000); // 1秒後にフラッシュメッセージを表示
            @endif
        });
    </script> -->
</x-layouts.base-layout>
