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
        $tags = Tag::where('user_id', $user_id)->where('inactive', 0)->take(5)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->get();

        return view('/stack', compact('tags', 'notes'));
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

    public function delete_confirm(Request $request): View
    {
        $user_id = Auth::id();
        $delete_tag_id = $request['delete_tag_id'];
        $delete_tag = Tag::where('user_id', $user_id)->where('id', $delete_tag_id)->first();
        $other_tags = Tag::where('user_id', $user_id)->where('id', '!=', $delete_tag_id)->get();
        $notes = Note::where('user_id', $user_id)->where('tag_id', $delete_tag_id)->orderBY('id', 'desc')->get();
        // \Log::debug('■■■■■■■■■■■■■■■■■■■■■■■■');
        // \Log::debug($other_tags);

        return view('/delete-confirm', compact('delete_tag', 'other_tags', 'notes'));
    }

    public function destroy(Request $request)
    {
        $user_id = Auth::id();
        $destroy_tag_id = $request->destroy_tag;
        $destroy_tag = Tag::where('user_id', $user_id)->find($destroy_tag_id);

        \Log::debug('■■■■■■■■■■■■■■■■■■■■■■■■');
        \Log::debug($destroy_tag);

        $destroy_tag->delete();

        return redirect('/stack');
    }
}
