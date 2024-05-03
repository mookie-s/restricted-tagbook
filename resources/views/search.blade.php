<x-layouts.base-layout>
    <x-slot:title>
        全ノート検索
    </x-slot:title>

    <x-slot:meta_description>
        すべてのノートから検索
    </x-slot:meta_description>

    <h2>全ノート検索</h2>
    <form action="/search" method="get">
        <!-- @csrf -->
        <div class="search-tab">
            <div>
                <select class="search-key" name="tagname">
                        <option value="">▼ タグを選択</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->tagname }}" @if($tag->tagname == $search_tagname) selected @endif>🔖{{ $tag->tagname }}</option>
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
                <input class="search-key" type="search" name="keyword" value="{{ $search_keyword }}" placeholder="キーワード" autofocus>
                <input class="search-button" type="submit" value="検索">
                <a href="/search">リセット</a>
            </div>
        </div>
    </form>
    @if($search_tagname || $search_year || $search_month || $search_keyword)
        <p class="promoted-message">📝 検索 >@if($search_tagname) 🔖@endif{{ $search_tagname }}@if($search_tagname) @endif {{ $search_year }}@if($search_year)年@endif {{ $search_month }}@if($search_month)月@endif @if($search_keyword)"{{ $search_keyword }} "@endif</p>
    @endif

    @foreach($searched_notes as $searched_note)
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
                <p>「 {{ $searched_note->title }} 」</p>
            </div>
            <div class="note-list-detail">
                <p>{{ Str::limit($searched_note->story, '100', '...')}}</p>
            </div>
        </div>
    </div>
    @endforeach
    @if(!empty($searched_notes))
        {{ $searched_notes->appends(request()->query())->links() }}
    @endif
</x-layouts.base-layout>
