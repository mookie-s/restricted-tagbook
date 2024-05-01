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
            <!-- <li><a href="/home/none">タグなし</a></li> -->
        </ul>
    </div>
    <div class="mastered-tags-tab">
        <ul>
            @foreach($mastered_tags as $mastered_tag)
            |<li><a href="/home/{{ $mastered_tag->id }}">♾️ {{ $mastered_tag->abbreviation }}</a></li>|
            @endforeach
        </ul>
    <p class="promoted-message">📝{{ $get_tag->tagname ?? 'すべて' }}</p>
    </div>
    @if($tags->count() == 0)
        <div>
            <a class="create-tag-button" href="/stack">最初のタグを登録する</a>
        </div>
    @elseif($tags->count() != 0 && $notes->count() == 0)
        <div>
            <a class="first-note-button" href="/note">最初のノートを書く</a>
        </div>
    @endif
    @foreach($notes as $note)
    <div class="note-list">
        <div class="note-list-image">
            @if($note->image)
            <img src="{{ Storage::url($note->image) }}" alt="{{ $note->title }}">
            @else
            <img src="{{ asset('/images/note-image-tag5.png') }}" alt="{{ $note->title }}">
            @endif
        </div>
        <div class="note-list-data">
            <div class="note-list-headline">
                <div>{{ $note->created_at->isoFormat('YYYY/MM/DD (ddd)') }}</div>
                <div>🔖{{ $note->tag->tagname }}</div>
            </div>
            <div class="note-list-title">
                <p>「 {{ $note->title }} 」</p>
            </div>
            <div class="note-list-detail">
                <p>{{ Str::limit($note->story, '100', '...')}}</p>
            </div>
        </div>
    </div>
    @endforeach
</x-layouts.base-layout>
