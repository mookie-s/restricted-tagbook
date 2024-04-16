<x-layouts.base-layout>
    <x-slot:title>
        キーワード検索
    </x-slot:title>

    <x-slot:meta_description>
        キーワード検索
    </x-slot:meta_description>

    <h2>ノート検索</h2>
    
        @csrf
        <form name="search-keyword" action="post">
            <div class="search-tab">
                <div>
                    <input class="search-input" type="text" placeholder="キーワード">
                </div>
                <div>
                    <select class="search-select" name="year-select">
                        <option value="year">年指定 ▼</option>
                        <option value="2025">2024年</option>
                        <option value="2024">2023年</option>
                    </select>
                </div>
                <div>
                    <select class="search-select" name="month-select">
                        <option value="month">月指定 ▼</option>
                        <option value="01">1月</option>
                        <option value="02">2月</option>
                        <option value="03">3月</option>
                        <option value="04">4月</option>
                        <option value="05">5月</option>
                        <option value="06">6月</option>
                        <option value="07">7月</option>
                        <option value="08">8月</option>
                        <option value="09">9月</option>
                        <option value="10">10月</option>
                        <option value="11">11月</option>
                        <option value="12">12月</option>
                    </select>
                </div>
                <div>
                    <input class="search-button" type="submit" value="検索">
                </div>
            </div>
        </form>
    <!-- 以下、検索ノートリスト -->
    <div class="note-list">
        <div class="note-list-image">
            <img src="{{ asset('/images/no-image.png') }}" alt="">
        </div>
        <div class="note-list-data">
            <div class="note-list-headline">
                <div>2024-04-06（日）</div>
                <div>🔖オフライン活動</div>
            </div>
            <div class="note-list-title">
                <p>ノートのタイトル</p>
            </div>
            <div class="note-list-detail">
                <p>ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容</p>
            </div>
        </div>
    </div>
    <!-- 検索ノートリスト２つめ -->
    <div class="note-list">
        <div class="note-list-image">
            <img src="{{ asset('/images/no-image.png') }}" alt="">
        </div>
        <div class="note-list-data">
            <div class="note-list-headline">
                <div>2024-04-06（日）</div>
                <div>🔖IT系メモ</div>
            </div>
            <div class="note-list-title">
                <p>ノートのタイトル</p>
            </div>
            <div class="note-list-detail">
                <p>ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容ノートの内容</p>
            </div>
        </div>
    </div>
</x-layouts.base-layout>
