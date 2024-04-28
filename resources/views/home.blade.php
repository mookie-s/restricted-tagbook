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
            <li><a href="/home/{{ $tag->id }}">{{ $tag->abbreviation }}</a></li>|
            @endforeach
            <!-- <li><a href="/home/none">タグなし</a></li> -->
        </ul>
    </div>
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
                <div>{{ $note->created_at->isoFormat('YYYY/M/D(ddd)') }}</div>
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
