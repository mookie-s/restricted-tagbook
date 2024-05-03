<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Note;
use App\Models\Book;

class NoteController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->get();
        $break_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        // TODO 以下、１タグ１日１投稿縛りの仕様による、
        // 本日投稿済みタグ除外のためのアルゴリズム生成(もっと良い方法あるかも？)
        $today = Carbon::today();
        $today_notes = Note::whereDate('created_at', $today)->orderBy('tag_id', 'asc')->get();

        $tag_ids = [];
        foreach ($tags as $tag) {
            array_push($tag_ids, $tag->id);
        }

        $finished_tag_ids = [];
        foreach ($today_notes as $today_note) {
            array_push($finished_tag_ids, $today_note->tag_id);
        }

        $unfinished_tag_ids = array_diff($tag_ids, $finished_tag_ids);

        return view('/note', compact('tags', 'unfinished_tag_ids', 'break_note'));
    }

    public function store(NotePostRequest $request): RedirectResponse
    {
        $user_id = Auth::id();
        $tag_id = $request->tag_id;
        $tag = Tag::where('user_id', $user_id)->find($tag_id);
        $book = Book::where('user_id', $user_id)->where('cover', $tag->tagname)->first();

        $note = new Note();
        $note->user_id = $user_id;
        $note->tag_id = $tag_id;
        // 該当タグがすでに達人達成している場合は同名のブックへの紐づけを行う
        if ($tag->mastered == 1) {
            $note->book_id = $book->id;
        }
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('public/images');
            $note->image = $image_path;
        }
        $note->title = $request->title;
        $note->story = $request->story;
        if ($request->has('to_break')) {
            $note->break = 1;
        }
        // 該当タグがすでに達人達成している場合は作成ノートを最初から昇格させる
        if ($tag->mastered == 1) {
            $note->promoted = 1;
        }
        $note->save();

        return redirect('/home');
    }
}
