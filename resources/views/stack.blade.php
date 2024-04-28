<x-layouts.base-layout>
    <x-slot:title>
        積み上げ
    </x-slot:title>

    <x-slot:meta_description>
        積み上げ
    </x-slot:meta_description>

    <h2>積み上げ</h2>
    <!-- {{$tags}} -->
    @if ($tags->count() < 5)
        <div class="create-tag-form">
            <p>タグを登録する</p>
            <form action="/tag" method="post">
                @csrf
                <input class="create-tag" type="text" name="tagname" placeholder="新しいタグ名">
                <input class="create-tag-abbreviation" type="text" name="abbreviation" placeholder="略称(4字以内)">
                <input class="create-tag-button" type="submit" value="登録">
                <small>※タグ登録は５つまで</small>
            </form>
        </div>
    @endif
    @if ($tags->count() != 0)
        @csrf
        <form>
            <table class="stack-table">
                <tr>
                    <th>タグ名</th>
                    <th class="stack-days-th">積み上げノート数（ /100日）</th>
                    <th class="stack-create-th">タグ作成日</th>
                </tr>
                @foreach ($tags as $tag)
                <tr>
                    <td><input type="text" tabindex="-1" value="🔖{{ $tag->tagname }}"></td>
                    @if($tag->notes->count() == 100)
                        <td><a style="width: {{ $tag->notes->count() + 1}}%">{{ $tag->notes->count() }}</a></td>
                    @elseif($tag->notes->count() > 0)
                        <td><p style="width: {{ $tag->notes->count() + 1}}%">{{ $tag->notes->count() }}</p></td>
                    @else
                        <td><p style="width: {{ $tag->notes->count() }}%">{{ $tag->notes->count() }}</p></td>
                    @endif
                    <td>{{ $tag->created_at->format('Y/m/d') }}</td>
                </tr>
                @endforeach
            </table>
        </form>
    @endif
    @csrf
    <form>
        <table class="stack-table">
            <tr>
                <th>ブック名</th>
                <th class="stack-days-th">積み上げブック数（1冊 = 100ノート）</th>
                <th class="stack-create-th">達人到達日</th>
            </tr>
            <tr>
                <td><input type="text" tabindex="-1" value="📘オフライン活動"></td>
                <td><img src="{{ asset('/images/table-book.png') }}" alt="book"></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" tabindex="-1" value="📘短編小説"></td>
                <td><img src="{{ asset('/images/table-book.png') }}" alt="book"><img src="{{ asset('/images/table-book.png') }}" alt="book"></td>
                <td></td>
            </tr>
            <tr>
                <td><div>♾️達人の 挿絵</div></td>
                <td><div>10000 + 12</div></td>
                <td><div>2027/04/02</div></td>
            </tr>
        </table>
    </form>
</x-layouts.base-layout>
