<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
use App\Http\Requests\TagPostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Book;

class StackController extends Controller
{
    public function index(): View
    {
        $tags = Tag::take(5)->get();

        return view('/stack', compact('tags'));
    }

    public function store_tag(TagPostRequest $request): RedirectResponse
    {
        $tag = new Tag();
        $tag->tagname = $request->tagname;
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect('/stack');
    }
}
