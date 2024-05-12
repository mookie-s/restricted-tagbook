<x-layouts.base-layout>
    <x-slot:title>
        制限タグ帳
    </x-slot:title>

    <x-slot:meta_description>
        制限タグ帳へようこそ！
    </x-slot:meta_description>

    <h2>どんなアプリ？</h2>
    <div class="hello-about">
        <div class="hello-img">
            <img src="{{ asset('/images/five.png') }}" alt="five">
        </div>
        <div>
            <p>作成できるタグは５つまで！特定の活動に絞って突き抜けたい人や、多機能で自由すぎるツールが苦手な人に最適。</p>
        </div>
    </div>
    <div class="hello-about">
        <div>
            <p>仕事スキル、料理、イラスト、読書、英語、絶景、幸せ時間など、自分の “好き” をタグ名にして、活動を尖らせよう。</p>
        </div>
        <div class="hello-img">
            <img src="{{ asset('/images/tag.png') }}" alt="tag">
        </div>
    </div>
    <div class="hello-about">
        <div class="hello-img">
            <img src="{{ asset('/images/hello-books.png') }}" alt="books">
        </div>
        <div class="hello-about">
            <div>
                <p>たくさんの "ノート" がたまったら、"ブック" 化で昇格させて、果ては達人レベルに。突き抜けた好きや得意を掛け算して、希少性を獲得しよう！</p>
            </div>
        </div>
    </div>
    <div class="hello-button">
        <p><a class="button" href="/register">はじめる</a></p>
    </div>
</x-layouts.base-layout>
