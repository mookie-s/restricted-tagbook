<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tag;
use App\Models\Book;

class StackController extends Controller
{
    public function index(): View
    {
        $tags = Tag::all();

        return view('/stack', compact('tags'));
    }
}
