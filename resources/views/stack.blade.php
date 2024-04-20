<x-layouts.base-layout>
    <x-slot:title>
        積み上げ
    </x-slot:title>

    <x-slot:meta_description>
        積み上げ
    </x-slot:meta_description>

    <h2>積み上げ</h2>
    {{$tags}}
    <form>
        <table class="build-table">
            <tr><th>タグ名</th><th class="build-days-th">積み上げノート数（ /100日）</th><th class="build-create-th">タグ作成日</th></tr>
            @foreach ($tags as $tag)
            <tr><td><input type="text" tabindex="-1" value="🔖{{ $tag->tagname }}"></td><td><p style="width: 2%">2</p></td><td>2024/06/20</td></tr>
            @endforeach
            <!-- <tr><td><input type="text" tabindex="-1" value="🔖信頼人脈力"></td><td><p style="width: 2%">2</p></td><td>2024/06/20</td></tr>
            <tr><td><input type="text" tabindex="-1" value="🔖オフライン活動"></td><td><p style="width: 66%">66</p></td><td>2024/04/02</td></tr>
            <tr><td><input type="text" tabindex="-1" value="🔖短編小説"></td><td><p style="width: 32%">32</p></td><td>2024/04/18</td></tr>
            <tr><td><input type="text" tabindex="-1" value="🔖挿絵"></td><td><a href="#" style="width: 100%">100</a></td><td>2024/05/01</td></tr>
            <tr><td><input type="text" tabindex="-1" value="🔖IT系メモ"></td><td><p style="width: 74%">74</p></td><td>2024/06/10</td></tr> -->
        </table>
        <table class="build-table">
            <tr><th>ブック名</th><th class="build-days-th">積み上げブック数（1冊 = 100ノート）</th><th class="build-create-th">達人到達日</th></tr>
            <tr><td><input type="text" tabindex="-1" value="📘オフライン活動"></td><td><img src="{{ asset('/images/table-book.png') }}" alt="book"></td><td></td></tr>
            <tr><td><input type="text" tabindex="-1" value="📘短編小説"></td><td><img src="{{ asset('/images/table-book.png') }}" alt="book"><img src="{{ asset('/images/table-book.png') }}" alt="book"></td><td></td></tr>
            <tr><td><div>♾️達人の 挿絵</div></td><td><div>10000 + 12</div></td><td><div>2027/04/02</div></td></tr>
        </table>
    </form>
</x-layouts.base-layout>
