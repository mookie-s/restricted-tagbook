<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tag;

class NoteController extends Controller
{
    public function index(): View
    {
        $tags = Tag::all();
        echo $tags;
        return view('/note', compact('tags'));
    }

    // public function create_tag()
}
