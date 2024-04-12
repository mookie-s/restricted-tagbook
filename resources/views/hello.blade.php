<x-layouts.base-layout>
    <x-slot:title>
        制限タグ帳
    </x-slot:title>

    <x-slot:meta_description>
        制限タグ帳へようこそ！
    </x-slot:meta_description>

    <h2>どんなアプリ？</h2>
    <div class="home-about">
        <div class="home-img">
            <img src="{{ asset('/images/five.png') }}" alt="five">
        </div>
        <div>
            <p>作成できるタグは５つまで！選択肢が自由すぎると逆に手が止まってしまう人や、活動を絞って尖らせたい人に最適。</p>
        </div>
    </div>
    <div class="home-about">
        <div>
            <p>料理、イラスト、読書、英語、絶景、幸せ時間など、自分の “好き” をタグ名にして、活動を深めよう。</p>
        </div>
        <div class="home-img">
            <img src="{{ asset('/images/tag.png') }}" alt="tag">
        </div>
    </div>
    <div class="home-about">
        <div class="home-img">
            <img src="{{ asset('/images/top-books.png') }}" alt="books">
        </div>
        <div class="home-about">
            <div>
                <p>たくさんの"経験ノート"がたまったら、"積み上げブック"に変換して、新たなタグ名で経験をはじめることも可能。</p>
            </div>
        </div>
    </div>
    <div class="home-button">
        <p><a class="button" href="/register">はじめる</a></p>
    </div>
</x-layouts.base-layout>
