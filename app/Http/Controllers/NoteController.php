<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
use App\Http\Requests\NotePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;

class NoteController extends Controller
{
    public function index(): View
    {
        $tags = Tag::all();
        $break_note = Note::where('break', 1)->first();
        return view('/note', compact('tags', 'break_note'));
    }

    public function store(NotePostRequest $request): RedirectResponse
    {
        $note = new Note();
        $note->user_id = Auth::id();
        $note->tag_id = $request->tag_id;
        if ($request->file('image')) {
            $image_path = $request->file('image')->store('images');
            $note->image = $image_path;
        }
        $note->title = $request->title;
        $note->story = $request->story;
        if ($request->has('to_break')) {
            $note->break = 1;
        }
        $note->save();

        return redirect('/home');
    }
}
