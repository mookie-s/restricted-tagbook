<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TagPostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;
use App\Models\Book;

class StackController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->where('mastered', 0)->get();
        $mastered_tags = Tag::where('user_id', $user_id)->where('mastered', 1)->get();
        $books = Book::where('user_id', $user_id)->get();

        $notes = Note::where('user_id', $user_id)->where('break', 0)->where('promoted', 0)->get();

        $promoted_notes = Note::where('user_id', $user_id)->where('break', 0)->where('promoted', 1)->get();

        $books = Book::where('user_id', $user_id)->get();

        return view('/stack', compact('tags', 'mastered_tags', 'books', 'notes', 'promoted_notes'));
    }

    public function store_tag(TagPostRequest $request): RedirectResponse
    {
        $tag = new Tag();
        $tag->user_id = Auth::id();
        $tag->tagname = $request->tagname;
        $tag->abbreviation = $request->abbreviation;
        $tag->save();

        return redirect('/stack');
    }

    public function promoted_to_book(Request $request): View
    {
        $user_id = Auth::id();
        $tag_id = $request->tag_id;
        $tag = Tag::where('user_id', $user_id)->find($tag_id);

        $notes = Note::where('user_id', $user_id)->where('tag_id', $tag_id)->where('promoted', 0)->orderBY('id', 'desc')->get();

        $same_cover_book = Book::where('user_id', $user_id)->where('cover', $tag->tagname)->first();

        return view('/promoted-to-book', compact('tag', 'notes', 'same_cover_book'));
    }

    public function store_book(Request $request): RedirectResponse
    {
        $user_id = Auth::id();
        $tag_id = $request->tag_id;
        $tagname = $request->tagname;
        $book_id = $request->same_cover_book_id;

        // TODO 5つ以上のタグを増やさない仕様上、tag_idではなくtagnameで判別
        // （削除したタグの復活が不可のため、同名タグは再度作成する必要があるため）
        $book = Book::where('user_id', $user_id)->find($book_id);
        if ($book) {
            $book_id = $book->id;
        } else {
            $book = new Book();
            $book->user_id = $user_id;
            $book->cover = $request->tagname;
            $book->save();
            $book_id = $book->id;
        }

        // 現時点での昇格済みノート数を取得
        $promoted_notes_count = Note::where('user_id', $user_id)->where('tag_id', $tag_id)->where('promoted', 1)->count();

        // 今回昇格するノート（=100件）
        $notes = Note::where('user_id', $user_id)->where('tag_id', $tag_id)->where('promoted', 0)->orderBy('id', 'desc')->get();

        // 今回達人達成か、それ以外（まだ未達成or過去に達成済み）で分岐
        if ($promoted_notes_count == 900) {
            // 現時点での昇格ノートが900件の場合は今回でタグが達人達成なので、
            // 今回昇格のノートにbook_idの紐づけ＆promoted=1を付与し、
            // 紐づけタグに達人フラグmastered=1を付与する。
            foreach ($notes as $note) {
                $note->book_id = $book_id;
                $note->promoted = 1;
                $note->save();
            }
            $tag = Tag::where('user_id', $user_id)->find($tag_id);
            $tag->mastered = 1;
            $tag->save();
        } else {
            // それ以外は今回昇格のノートにbook_idの紐づけ＆
            // 昇格フラグpromoted=1のみを付与
            foreach ($notes as $note) {
                $note->book_id = $book_id;
                $note->promoted = 1;
                $note->save();
            }
        }

        return redirect('/stack');
    }

    public function delete_confirm(Request $request): View
    {
        $user_id = Auth::id();
        $delete_tag_id = $request->delete_tag_id;
        $delete_tag = Tag::where('user_id', $user_id)->find($delete_tag_id);
        $notes = Note::where('user_id', $user_id)->where('tag_id', $delete_tag_id)->where('promoted', 0)->orderBY('id', 'desc')->get();

        return view('/delete-confirm', compact('delete_tag', 'notes'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user_id = Auth::id();
        $destroy_tag_id = $request->destroy_tag;
        $destroy_tag = Tag::where('user_id', $user_id)->find($destroy_tag_id);
        $destroy_tag->delete();

        return redirect('/stack');
    }
}
