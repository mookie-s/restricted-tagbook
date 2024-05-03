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
        $tags = Tag::where('user_id', $user_id)->where('mastered', 0)->take(5)->get();
        $mastered_tags = Tag::where('user_id', $user_id)->where('mastered', 1)->take(5)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('tags', 'notes', 'mastered_tags'));
    }

    public function show(string $tag_id): View
    {
        $user_id = Auth::id();
        $get_tag = Tag::where('user_id', $user_id)->find($tag_id);
        $tags = Tag::where('user_id', $user_id)->where('mastered', 0)->take(5)->get();
        $mastered_tags = Tag::where('user_id', $user_id)->where('mastered', 1)->take(5)->get();
        $notes = Note::where('user_id', $user_id)->where('break', 0)->where('tag_id', $tag_id)->orderBy('id', 'desc')->take(100)->get();

        return view('/home', compact('get_tag', 'tags', 'notes', 'mastered_tags'));
    }
}
