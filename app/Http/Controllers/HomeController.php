<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Note;

class HomeController extends Controller
{
    public function index(): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->where('inactive', 0)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('tags', 'notes'));
    }

    public function show(string $tag): View
    {
        $user_id = Auth::id();
        $tags = Tag::where('user_id', $user_id)->where('inactive', 0)->get();
        $notes = Note::withTrashed()->where('user_id', $user_id)->where('break', 0)->where('tag_id', $tag)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('tags', 'notes'));
    }
}
