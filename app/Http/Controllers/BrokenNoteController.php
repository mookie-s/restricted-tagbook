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
        $tags = Tag::all();
        $broken_note = Note::where('break', 1)->first();

        return view('/broken-note', compact('tags', 'broken_note'));
    }

    public function update(NotePostRequest $request): RedirectResponse
    {
        $broken_note = Note::where('break', 1)->first();

        if ($request->file('image')) {
            $image_path = $request->file('image')->store('images');
            $broken_note->image = $image_path;
        }
        $broken_note->title = $request->title;
        $broken_note->story = $request->story;
        if ($request->has('to_break')) {
            $broken_note->break = 1;
        } else {
            $broken_note->break = 0;
        }
        $broken_note->save();

        return redirect('/note');
    }
}
