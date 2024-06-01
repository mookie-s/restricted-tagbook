<x-layouts.base-layout>
    <x-slot:title>
        アプリの使い方
    </x-slot:title>

    <x-slot:meta_description>
        アプリの使い方
    </x-slot:meta_description>

    <h2>制限タグ帳の使い方</h2>
    <div class="how-to-use">
        <h3>１．コンセプト</h3>
        <p>「制限タグ帳」では、<font class="emphasis">活動範囲を制限して突き抜ける</font>を主なコンセプトとしています。</p>
        <p>これまでの仕事や活動など様々な人生経験を通して、強み/興味関心/情熱など、自分の特性や人生の方向性がある程度見えてきた人、若いころに大きく広げた風呂敷を、小さくしていくフェーズに入った人、強制的な制限のある環境の方が頭が働く人、習慣化してコツコツと継続的に活動していきたい人、自由/多機能なツールが苦手な人などにおすすめしたいアプリです。</p>
        <br>
        <h3>２．様々な制限とそのねらい</h3>
        <p>「制限タグ帳」では以下のような制限環境を設け、様々な力を養うことをねらっています。</p>
        <ul>
            <li>タグの作成は５つまで：<font class="emphasis">深めたい活動ジャンルを決める＝突き抜け力、覚悟</font></li>
            <li>ノートの投稿は１タグにつき１日１投稿まで：<font class="emphasis">継続力＝良習慣</font></li>
            <li>ノートの本文は 200文字以上 800文字以内：<font class="emphasis">執筆力、推敲力</font></li>
            <li>ノートの中断保存は一度に１つのみ可能：<font class="emphasis">先延ばしにせず完結させる力</font></li>
            <li>ズルしにくい仕様：<font class="emphasis">自分自身や外部に対しての証明力</font></li>
        </ul>
        <br>
        <h3>３．ページ構成と機能</h3>
        <p>制限タグ帳のページ構成はシンプルです。</p>
        <h4>【トップ】ページ</h4>
        <ul>
            <li><font class="emphasis">制限タグ帳に初めてアクセスする場合</font>は、トップページ（「どんなアプリ？」ページ）が表示されます。ユーザー登録を行っていない状態では、このトップページと当ページ（【help / ヘルプ】ページ）のみにアクセスが限定されます。</li>
            <li>アプリをご利用の場合は、<font class="emphasis">はじめにユーザー登録</font>を行ってください。</li>
        </ul>
        <br>
        <h4>【note / ノート】ページ</h4>
        <ul>
            <li>[ <img class="help-pen-icon" src="{{ asset('/images/pen-icon.png') }}" alt="ペンアイコン" />] アイコンをクリックすると、ノート執筆ページに入ります。</li>
            <li>イメージ添付（任意）、タグ選択、タイトル、本文を記入し <font class="emphasis">ノートの「投稿」または「中断保存」</font>をします。</li>
            <li>執筆中は、本文記入欄外左下の<font class="emphasis">文字数カウンターでリアルタイムに文字数を確認</font>できます。改行は２文字としてカウントされます。</li>
            <li><font class="emphasis">ノートの執筆に集中できるように、画面上下のリンクやメニューアイコンは非表示</font>にしています。執筆中にページを戻る場合は、使用端末やブラウザの戻るボタン、または右下の「ホームへ」ボタンで離脱できますが、<font class="emphasis">中断保存をしていないノートの内容は失われますので注意</font>してください。</li>
        </ul>
        <br>
        <h4>【search / 全ノート検索】ページ</h4>
        <ul>
            <li>[ <img src="{{ asset('/images/search-icon.png') }}" alt="ノート検索" /> ] アイコンをクリックすると、全ノート検索ページに入ります。</li>
            <li>検索フォームに<font class="emphasis">条件の選択やキーワードを入力</font>し、「検索」ボタンで該当のノートを検索します。また、「リセット」ボタンで検索フォームの全項目を空欄にできます。</li>
        </ul>
        <br>
        <h4>【home / ホーム】ページ</h4>
        <ul>
            <li>[ <img src="{{ asset('/images/home-icon.png') }}" alt="ホーム" /> ] アイコンをクリックすると、ホーム（ノート最新100）のページに入ります。また、アプリにログイン後、最初に表示されるページです。</li>
            <li>投稿した<font class="emphasis">最新のノート100件分が表示</font>されます。また、各タグ名（略称）クリックで、タグ別一覧表示できます。</li>
            <li>各ノートのカードをクリックすると、内容の詳細が確認できます。ここで<font class="emphasis">ノートの編集（ブラッシュアップ）もできます。</font></li>
        </ul>
        <br>
        <h4>【stack / 積み上げ】ページ</h4>
        <ul>
            <li>[ <img class="help-stack-icon" src="{{ asset('/images/books-icon.png') }}" alt="積み上げ" /> ] アイコンをクリックすると、積み上げページに入ります。</li>
            <li><font class="emphasis">最初のタグ作成</font>をここで行います。その後も<font class="emphasis">追加のタグ作成や名称変更、削除</font>が行えます。</li>
            <li>各タグやブックに関する<font class="emphasis">ノート投稿数の積み上げ状況</font>を確認できます。</li>
            <li>タグ別に<font class="emphasis">ノートが100件積み上がると、ブック化</font>となり、紐づけノートが昇格化されます。</li>
            <li>さらに<font class="emphasis">ブックを10冊積み上げると、達人達成</font>となり、以降は達人化したタグのノート投稿は即昇格化ノートとして積み上がります。また、<font class="emphasis">６つ目の新しいタグが作成できる</font>ようになります。</li>
        </ul>
        <br>
        <h4>【help / ヘルプ】ページ</h4>
        <ul>
            <li>[ <img src="{{ asset('/images/help-icon.png') }}" alt="ヘルプ" /> ] アイコンをクリックすると、当ヘルプページに入ります。</li>
            <li>制限タグ帳の使い方や利用規約、プライバシーポリシーが確認できます。</li>
            <li>お問い合わせフォームへのリンクを設置しているので、制限タグ帳に関するお問い合わせの際はこちらからお願いします。（現在準備中）</li>
        </ul>
        <br>
        <h4>その他のページ</h4>
        <ul>
            <li>左上の[ <img class="account-icon" src="{{ asset('/images/logout.png') }}" alt="ログアウト中"> ] や [ <img class="account-icon" src="{{ asset('/images/login.png') }}" alt="ログアウト中"> ] アイコンをクリックするとログイン、またはアカウントページに入ります。前者（白色）はログアウト状態を表しており、アプリご利用時にはここからログインしてください。後者（グレー色）はログイン状態を表しており、アカウント情報やパスワードの更新、ログアウト、アカウント削除が行えます。</li>
            <!-- TODO -->
            <li>右上の著作権表示テキスト <font class="emphasis">[© 2024 Mookie] は当社サイトへのリンク</font>になっており、当社のコンテンツや制作アプリ情報などがご確認いただけます（現在サイト準備中）。</li>
        </ul>
        <br>
    </div>
    <br>

    <h2>アプリのご利用にあたって</h2>
    <div class="help-links">
        <ul>
            <li><a href="/terms">利用規約</a></li>
            <li><a href="/privacy">プライバシーポリシー</a></li>
            <!-- TODO -->
            <li><a href="#">お問い合わせ（準備中...当社サイト内予定）</a></li>
        </ul>
    </div>
</x-layouts.base-layout>
