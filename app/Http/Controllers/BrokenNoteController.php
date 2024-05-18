<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;

class BrokenNoteController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->get();
        $broken_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        return view('/broken-note', compact('tags', 'broken_note'));
    }

    public function update(NotePostRequest $request): RedirectResponse
    {
        $user_id = Auth::id();
        $broken_note = Note::where('user_id', $user_id)->where('break', 1)->first();

        if ($request->file('image')) {
            $image_path = $request->file('image')->store('public/images');
            $broken_note->image = $image_path;
        }
        $broken_note->title = $request->title;
        $broken_note->story = $request->story;

        $break_note_message = '';
        $new_note_message = '';
        if ($request->has('to_break')) {
            $broken_note->break = 1;
            $break_note_message = 'ノートを中断保存しました';
        } else {
            $broken_note->break = 0;
            $new_note_message = 'ノートを投稿しました';
        }
        $broken_note->save();

        return redirect('/home')->with('new_note_message', $new_note_message)->with('break_note_message', $break_note_message);
    }
}
