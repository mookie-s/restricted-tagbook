<x-layouts.base-layout>
    <x-slot:title>
        積み上げ
    </x-slot:title>

    <x-slot:meta_description>
        積み上げ
    </x-slot:meta_description>

    <h2>積み上げ</h2>
    <!-- フラッシュメッセージここから -->
    @if(session('new_tag_message'))
        <small><div class="alert alert-success mx-auto">！{{session('new_tag_message')}}</div></small>
    @endif
    @if(session('change_tag_message'))
        <small><div class="alert alert-secondary mx-auto">！{{session('change_tag_message')}}</div></small>
    @endif
    @if(session('delete_tag_message'))
        <small><div class="alert alert-danger mx-auto">！{{session('delete_tag_message')}}</div></small>
    @endif
    @if(session('new_book_message'))
        <small><div class="alert alert-success mx-auto">🎉 {{session('new_book_message')}} 🎉</div></small>
    @endif
    @if(session('new_mastered_message'))
        <small><div class="alert alert-warning mx-auto"><b>🎉🎉🎉 {{ session('new_mastered_tagname') }} が {{ session('new_mastered_message') }} 🎉🎉🎉</b></div></small>
    @endif
    <!-- フラッシュメッセージここまで -->

    @if($tags->count() != 0 && $notes->count() == 0)
        <div>
            <a class="first-note-button" href="/note">最初のノートを書く</a>
        </div>
        <div class="tag-form">
            <div>タグを登録する<small> ※５つまで</small></div>
            <form action="/store-tag" method="post">
                @csrf
                <input class="create-tag" type="text" name="tagname" placeholder="新しいタグ名(10文字以内)" value="{{ old('tagname') }}">
                <input class="create-tag-abbreviation" type="text" name="abbreviation" placeholder="略称(4字以内)" value="{{ old('abbreviation') }}">
                <input class="create-tag-button" type="submit" value="登録">
            </form>
        </div>
        @if($errors->any())
            <div></div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif
    @elseif($tags->count() < 5)
        <div class="tag-form">
            <div>タグを登録する<small> ※５つまで</small></div>
            <form action="/store-tag" method="post">
                @csrf
                <input class="create-tag" type="text" name="tagname" placeholder="新しいタグ名(10字以内)" value="{{ old('tagname') }}">
                <input class="create-tag-abbreviation" type="text" name="abbreviation" placeholder="略称(4字以内)" value="{{ old('abbreviation') }}">
                <input class="create-tag-button" type="submit" value="登録">
            </form>
        </div>
        @if($errors->any())
            <div></div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li><small class="delete-message" style="font-weight:bold">※ {{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
    @if($tags->count() != 0)
        <!-- @csrf -->
        <!-- <form action="/store_book" method="post"> -->
            <table class="stack-table">
                <tr>
                    <th class="stack-tagname">タグ名(略称)</th>
                    <th class="stack-days-th">積み上げノート(/100日)</th>
                    <th class="stack-create-th">タグ作成日</th>
                </tr>
                @foreach ($tags as $tag)
                <tr>
                    <td>
                        <a style="background: #737373" href="/home/{{ $tag->id }}" tabindex="-1">🔖{{ $tag->abbreviation }}</a>
                    </td>
                    @php
                        $count = 0;
                        foreach ($notes as $note) {
                            if ($tag->id == $note->tag_id) {
                                $count++;
                            }
                        }
                    @endphp

                    @if($count == 100)
                        <form action="/promoted-to-book" method="post">
                            @csrf
                            <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                            <td class="stack-to-book"><input value="100！" style="text-align: center"></input></td>
                            <td class="stack-to-book"><input type="submit" value="👆ブック化" style="border: 1px solid #f6701d" /></td>
                        </form>
                    @elseif($count > 0)
                        <td><a style="width: {{ $count }}%">{{ $count }}</a></td>
                        <td>{{ $tag->created_at->isoFormat('Y/MM/DD') }}</td>
                    @else
                        <td><a style="width: {{ $count }}%; background: #737373">{{ $count }}</a></td>
                        <td>{{ $tag->created_at->isoFormat('Y/MM/DD') }}</td>
                    @endif
                    <!-- <td><input type="submit" value="{{ $tag->created_at->format('Y/m/d') }}" /></td> -->
                </tr>
                @endforeach
            </table>
        <!-- </form> -->
    @endif

    @if($books->count() != 0)
        <table class="stack-table">
            <tr>
                <th class="stack-tagname">ブック名(略称)</th>
                <th class="stack-days-th">積み上げブック(1冊=100ノート)</th>
                <th class="stack-create-th">達人到達日</th>
            </tr>
            @foreach($books as $book)
                <tr>
                    @php
                        $promoted_note_count = 0;
                        foreach ($promoted_notes as $promoted_note) {
                            if ($book->id == $promoted_note->book_id) {
                                $promoted_note_count++;
                            }
                        }
                    @endphp

                    @if($promoted_note_count >= 1000)
                        <td>
                        @foreach($mastered_tags as $mastered_tag)
                            @if($mastered_tag->tagname == $book->cover)
                                <div tabindex="-1">達人の{{ $mastered_tag->abbreviation }}</div>
                            @endif
                        @endforeach
                        </td>
                        <td><div>📝1000 + {{ $promoted_note_count - 1000 }}</div></td>
                        <td>
                        @foreach($mastered_tags as $mastered_tag)
                            @if($mastered_tag->tagname == $book->cover)
                                <div>{{ $mastered_tag->updated_at->isoFormat('Y/MM/DD') }}</div>
                            @endif
                        @endforeach
                        </td>
                    @elseif($promoted_note_count >= 900)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り１冊</td>
                    @elseif($promoted_note_count >= 800)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り２冊</td>
                    @elseif($promoted_note_count >= 700)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り３冊</td>
                    @elseif($promoted_note_count >= 600)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り４冊</td>
                    @elseif($promoted_note_count >= 500)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り５冊</td>
                    @elseif($promoted_note_count >= 400)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り６冊</td>
                    @elseif($promoted_note_count >= 300)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り７冊</td>
                    @elseif($promoted_note_count >= 200)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}">
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り８冊</td>
                    @elseif($promoted_note_count >= 100)
                        <td><a href="/search?tagname={{ $book->cover }}" style="background: #737373" tabindex="-1">📘{{ $book->cover }}</a></td>
                        <td>
                            <img src="{{ asset('/images/table-book.png') }}" alt="{{ $book->cover }}">
                        </td>
                        <td>残り９冊</td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endif

    @if($tags->count() != 0)
    <div class="stack-tagname-change">
        <div>タグ名を変更する</div>
        <form id="change_form" class="change-tag-select" action="/change-confirm" method="post">
            @csrf
            <select  name="before_tag_id">
                    <!-- <option value="">▼ タグを選択</option> -->
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">🔖{{ $tag->tagname }}</option>
                @endforeach
            </select>
            タグを🔖<input id="change_tagname" class="change-tag-tagname" type="text" name="after_tagname" placeholder="タグ名(10字以内)" value="{{ old('after_tagname') }}" maxlength="10" required><input id="change_abbreviation" class="change-tag-abbreviation" type="text" name="after_abbreviation" placeholder="略称(4字以内)" value="{{ old('after_abbreviation') }}" maxlength="4" required>に<input id="change_button" type="submit" value="変更する" disabled>
        </form>
    </div>

    <div class="stack-tag-delete">
        <div>タグを削除する</div>
        <form class="delete-tag-select" action="/delete-confirm" method="post">
            @csrf
            <select  name="delete_tag_id">
                    <!-- <option value="">▼ タグを選択</option> -->
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">🔖{{ $tag->tagname }}</option>
                @endforeach
            </select>
            タグと紐づけノートを<input type="submit" value="削除する" />
        </form>
    </div>
    @endif
    <script>
        // タグ名変更
        const change_form = document.getElementById("change_form");
        const change_tagname = document.getElementById("change_tagname");
        const change_abbreviation = document.getElementById("change_abbreviation");
        const change_button = document.getElementById("change_button");

        change_form.addEventListener("input", update);
        function update() {
            const isRequired = change_form.checkValidity();
            let count_tagname = change_tagname.value.length;
            let count_abbreviation = change_abbreviation.value.length;

            if (isRequired && count_tagname <= 10 && count_abbreviation <= 4) {
                change_button.disabled = false;
                change_button.style.opacity = 1;
                change_button.style.cursor = "pointer";
                return;
            }
        }
    </script>
</x-layouts.base-layout>
