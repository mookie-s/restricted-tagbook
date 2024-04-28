<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
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
        $tags = Tag::where('user_id', $user_id)->where('inactive', 0)->take(5)->get();
        \Log::debug($tags);

        return view('/stack', compact('tags'));
    }

    public function store_tag(TagPostRequest $request): RedirectResponse
    {
        $tag = new Tag();
        $tag->tagname = $request->tagname;
        $tag->abbreviation = $request->abbreviation;
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect('/stack');
    }
}
