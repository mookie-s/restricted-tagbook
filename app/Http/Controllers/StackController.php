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
        $notes = Note::where('user_id', $user_id)->where('break', 0)->where('promoted', 0)->get();
        $books = Book::where('user_id', $user_id)->get();

        return view('/stack', compact('tags', 'notes', 'books'));
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

        // 昇格ノートに、book_idの紐づけと昇格フラグのpromoted=1を付与
        $notes = Note::where('user_id', $user_id)->where('tag_id', $tag_id)->where('promoted', 0)->orderBy('id', 'desc')->get();
        foreach ($notes as $note) {
            $note->book_id = $book_id;
            $note->promoted = 1;
            $note->save();
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
